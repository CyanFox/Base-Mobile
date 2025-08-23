<?php

namespace App\Traits;

use Exception;
use Illuminate\Validation\ValidationException;
use Masmerise\Toaster\Toaster;
use Symfony\Component\HttpKernel\Exception\HttpException;

use function Sentry\captureException;

trait WithCustomLivewireException
{
    public function exception($e, $stopPropagation)
    {
        captureException($e);

        if ($e instanceof HttpException) {
            return;
        }

        if ($e instanceof Exception) {
            $this->log($e->getMessage(), 'error'); // @phpstan-ignore-line
        } else {
            $this->log($e, 'error'); // @phpstan-ignore-line
        }

        if (! $e instanceof ValidationException) {
            Toaster::error(__('messages.notifications.something_went_wrong'));
        }

        $stopPropagation();
    }
}
