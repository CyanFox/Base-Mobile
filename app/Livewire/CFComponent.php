<?php

namespace App\Livewire;

use Exception;
use Livewire\Component;

class CFComponent extends Component
{
    public function log($message, $level = 'info')
    {
        if ($message instanceof Exception) {
            $message = $message->getMessage();
        }
        $this->dispatch('logger', ['type' => $level, 'message' => $message]);
    }

    public function renderView($view, $title, $layout = 'components.layouts.guest', $params = [])
    {
        $params = array_merge($params, ['title' => $title]);

        return view($view)->layout($layout, $params);
    }
}
