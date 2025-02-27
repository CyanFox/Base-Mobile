@php
    use Filament\Notifications\Livewire\Notifications;
    use Filament\Support\Enums\Alignment;
    use Filament\Support\Enums\VerticalAlignment;
    use Illuminate\Support\Arr;

    $color = $getColor() ?? 'gray';
    $isInline = $isInline();
    $status = $getStatus();
    $title = $getTitle();
    $hasTitle = filled($title);
    $date = $getDate();
    $hasDate = filled($date);
    $body = $getBody();
    $hasBody = filled($body);
    $duration = $getDuration();
@endphp

<x-filament-notifications::notification
    :notification="$notification"
    :x-transition:enter-start="
        Arr::toCssClasses([
            'opacity-0',
            ($this instanceof Notifications)
                ? match (static::$alignment) {
                    Alignment::Start, Alignment::Left => '-translate-x-12',
                    Alignment::End, Alignment::Right => 'translate-x-12',
                    Alignment::Center => match (static::$verticalAlignment) {
                        VerticalAlignment::Start => '-translate-y-12',
                        VerticalAlignment::End => 'translate-y-12',
                        default => null,
                    },
                    default => null,
                }
                : null,
        ])
    "
    :x-transition:leave-end="
        Arr::toCssClasses([
            'opacity-0',
            'scale-95' => ! $isInline,
        ])
    "
    x-init="
        (() => {
            let animationStartTime = Date.now();
            let hoverStartTime;
            let initialDelay = 50;
            const totalDuration = {{ $duration }};
            const speedAdjustment = 210;

            const startProgress = (remainingWidth) => {
                const currentTime = Date.now();
                const elapsedWithoutHover = currentTime - animationStartTime;
                const remainingDuration = totalDuration - elapsedWithoutHover;

                if (remainingDuration <= 0) return;

                // Berechne die neue schnellere Duration basierend auf dem verbleibenden Fortschritt
                const speedUpFactor = remainingWidth / 100;
                const newDuration = Math.max(0, (remainingDuration * speedUpFactor) + speedAdjustment);

                $refs.progressBar.style.transition = `width ${newDuration}ms linear`;
                $refs.progressBar.style.width = '0%';
            };

            const pauseProgress = () => {
                hoverStartTime = Date.now();

                // Aktuelle Breite der Progressbar speichern
                const currentWidth = $refs.progressBar.getBoundingClientRect().width;
                const containerWidth = $refs.progressContainer.getBoundingClientRect().width;
                const widthPercentage = (currentWidth / containerWidth) * 100;

                $refs.progressBar.style.transition = 'none';
                $refs.progressBar.style.width = `${widthPercentage}%`;

                return widthPercentage;
            };

            // Initial setup
            $refs.progressBar.style.width = '100%';

            setTimeout(() => {
                // Starte die initiale Animation
                $refs.progressBar.style.transition = `width ${totalDuration}ms linear`;
                $refs.progressBar.style.width = '0%';
                animationStartTime = Date.now();

                $el.addEventListener('mouseenter', () => {
                    pauseProgress();
                });

                $el.addEventListener('mouseleave', () => {
                    if (hoverStartTime) {
                        const currentWidth = pauseProgress();
                        startProgress(currentWidth);
                        hoverStartTime = null;
                    }
                });
            }, initialDelay);
        })()
    "
    @class([
        'fi-no-notification w-full overflow-hidden transition duration-300 relative',
        ...match ($isInline) {
            true => [
                'fi-inline',
            ],
            false => [
                'max-w-sm rounded-xl bg-white shadow-lg ring-1 dark:bg-gray-900',
                match ($color) {
                    'gray' => 'ring-gray-950/5 dark:ring-white/10',
                    default => 'fi-color-custom ring-custom-600/20 dark:ring-custom-400/30',
                },
                is_string($color) ? 'fi-color-' . $color : null,
                'fi-status-' . $status => $status,
            ],
        },
    ])
    @style([
        \Filament\Support\get_color_css_variables(
            $color,
            shades: [50, 400, 600],
            alias: 'notifications::notification',
        ) => ! ($isInline || $color === 'gray'),
    ])
>
    <!-- Rest des Templates bleibt unverändert -->
    <div
        @class([
            'flex w-full gap-3 p-4',
            match ($color) {
                'gray' => null,
                default => 'bg-custom-50 dark:bg-custom-400/10',
            },
        ])
    >
        @if ($icon = $getIcon())
            <x-filament-notifications::icon
                :color="$getIconColor()"
                :icon="$icon"
                :size="$getIconSize()"
            />
        @endif

        <div class="mt-0.5 grid flex-1">
            @if ($hasTitle)
                <x-filament-notifications::title>
                    {{ str($title)->sanitizeHtml()->toHtmlString() }}
                </x-filament-notifications::title>
            @endif

            @if ($hasDate)
                <x-filament-notifications::date @class(['mt-1' => $hasTitle])>
                    {{ $date }}
                </x-filament-notifications::date>
            @endif

            @if ($hasBody)
                <x-filament-notifications::body
                    @class(['mt-1' => $hasTitle || $hasDate])
                >
                    {{ str($body)->sanitizeHtml()->toHtmlString() }}
                </x-filament-notifications::body>
            @endif

            @if ($actions = $getActions())
                <x-filament-notifications::actions
                    :actions="$actions"
                    @class(['mt-3' => $hasTitle || $hasDate || $hasBody])
                />
            @endif
        </div>

        <span class="cursor-pointer"
              x-on:click="close">
            <i class="icon-x text-gray-400"></i>
        </span>
    </div>

    <div class="h-0.5 w-full bg-gray-200 dark:bg-gray-700" x-ref="progressContainer">
        <div class="h-0.5"
             x-ref="progressBar"
             x-bind:class="{
                'bg-success-600 dark:bg-success-500': '{{ $status }}' === 'success',
                'bg-danger-600 dark:bg-danger-500': '{{ $status }}' === 'danger',
                'bg-warning-600 dark:bg-warning-500': '{{ $status }}' === 'warning',
                'bg-info-600 dark:bg-info-500': '{{ $status }}' === 'info'
             }">
        </div>
    </div>
</x-filament-notifications::notification>
