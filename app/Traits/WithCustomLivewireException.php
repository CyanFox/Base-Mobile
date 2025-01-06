<?php

namespace App\Traits;

use Exception;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;

trait WithCustomLivewireException
{
    public function exception($e, $stopPropagation)
    {
        if ($e instanceof Exception) {
            $this->log($e->getMessage(), 'error');
        } else {
            $this->log($e, 'error');
        }

        if (!$e instanceof ValidationException) {
            Notification::make()
                ->title(__('messages.notifications.something_went_wrong'))
                ->danger()
                ->send();
        }

        $stopPropagation();
    }
}
