<?php

namespace App\Traits;

use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait WithCustomLivewireException
{
    public function exception($e, $stopPropagation)
    {
        if (config('app.env') === 'local' || config('app.debug')) {
            once(function () use ($e) {
                Log::error($e->getMessage(), [
                    'exception' => $e,
                    'trace' => $e->getTraceAsString(),
                ]);
            });
            throw $e; // @phpstan-ignore-line
        }

        if ($e instanceof HttpException) {
            return;
        }

        if ($e instanceof Exception) {
            $this->log($e->getMessage(), 'error'); // @phpstan-ignore-line
        } else {
            $this->log($e, 'error'); // @phpstan-ignore-line
        }

        if (! $e instanceof ValidationException) {
            Notification::make()
                ->title(__('messages.notifications.something_went_wrong'))
                ->danger()
                ->send();
        }

        $stopPropagation();
    }
}
