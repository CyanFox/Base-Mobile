@props([
    'target' => '',
    'backUrl' => null,
    'showCreate' => true,
    'showCancel' => true,
    'createText' => __('messages.buttons.save'),
    'cancelText' => __('messages.buttons.cancel'),
])

<x-divider/>

<div {{ $attributes->merge(['class' => 'flex sm:flex-row flex-col sm:w-fit w-full gap-2']) }}>
    @if ($showCreate)
        <x-button loading="{{ $target }}"
                  type="submit">{{ $createText }}</x-button>
    @endif

    {{ $slot }}

    @if ($showCancel)
        <x-button type="button" href="{{ $backUrl ?? url()->previous() }}" variant="outline"
                  wire:navigate>{{ $cancelText }}</x-button>
    @endif
</div>
