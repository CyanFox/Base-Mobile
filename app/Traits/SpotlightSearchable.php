<?php

namespace App\Traits;

trait SpotlightSearchable
{
    public static function bootSpotlightSearchable()
    {
        app('spotlight')->registerModel(static::class);
    }

    public function toSpotlightResult(): array
    {
        $module = $this->spotlightModuleName();
        if (is_string($module) && $this->isTranslationKey($module)) {
            $module = __($module);
        }

        return [
            'id' => $this->getKey(),
            'title' => $this->spotlightTitle(),
            'description' => $this->spotlightDescription(),
            'url' => $this->spotlightUrl(),
            'model_type' => static::class,
            'module' => $module,
            'icon' => $this->spotlightIcon(),
            'permissions' => $this->spotlightPermissions(),
        ];
    }

    public function spotlightTitle(): string
    {
        return $this->title ?? $this->name ?? $this->getKey();
    }

    public function spotlightDescription(): string
    {
        return $this->description ?? $this->excerpt ?? '';
    }

    public function spotlightUrl(): string
    {
        return url('/');
    }

    public function spotlightIcon(): string
    {
        return 'icon-search';
    }

    public function spotlightSearchableFields(): array
    {
        return ['title', 'name', 'description', 'excerpt'];
    }

    public function spotlightModuleName(): ?string
    {
        return null;
    }

    public function spotlightPermissions(): ?array
    {
        return null;
    }

    protected function isTranslationKey(string $text): bool
    {
        return str_contains($text, '::') ||
            preg_match('/^[a-z0-9_]+\.[a-z0-9_.]+$/i', $text);
    }

    public function userCanViewInSpotlight(): bool
    {
        $permissions = $this->spotlightPermissions();

        if (empty($permissions)) {
            return true;
        }

        $user = auth()->user();
        if (!$user) {
            return false;
        }

        if (method_exists($user, 'hasAnyPermission')) {
            return $user->hasAnyPermission($permissions);
        }

        foreach ($permissions as $permission) {
            if ($user->can($permission)) {
                return true;
            }
        }

        return false;
    }

    public function scopeSpotlightSearch($query, string $term)
    {
        if (empty($term)) {
            return $query->whereRaw('1=0');
        }

        $fields = $this->spotlightSearchableFields();
        $searchTerm = "%{$term}%";

        return $query->where(function ($query) use ($searchTerm, $fields, $term) {
            foreach ($fields as $field) {
                $query->orWhere($field, 'LIKE', $searchTerm);
            }

            $moduleName = $this->spotlightModuleName();
            if ($moduleName) {
                if ($this->isTranslationKey($moduleName)) {
                    $translatedModule = __($moduleName);
                    if (stripos($translatedModule, $term) !== false) {
                        $query->orWhereNotNull($this->getKeyName());
                    }
                } else if (stripos($moduleName, $term) !== false) {
                    $query->orWhereNotNull($this->getKeyName());
                }
            }
        });
    }
}
