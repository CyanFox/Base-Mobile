@props([
    'target' => '',
    'backUrl' => null,
    'showUpdate' => true,
    'showCancel' => true,
    'updateText' => __('messages.buttons.update'),
    'cancelText' => __('messages.buttons.cancel'),
])
<x-divider/>

<div {{ $attributes->merge(['class' => 'flex sm:flex-row flex-col sm:w-fit w-full gap-2']) }}>
    @if ($showUpdate)
        <x-button loading="{{ $target }}"
                  type="submit">{{ $updateText }}</x-button>
    @endif

    {{ $slot }}

    @if ($showCancel)
        <x-button type="button" href="{{ $backUrl ?? url()->previous() }}" variant="outline"
                  wire:navigate>{{ $cancelText }}</x-button>
    @endif
</div>
