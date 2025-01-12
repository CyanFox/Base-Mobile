@props([
    'target' => '',
    'backUrl' => null,
    'showCreate' => true,
    'showCancel' => true,
    'createText' => __('messages.buttons.save'),
    'cancelText' => __('messages.buttons.cancel'),
])

<x-divider/>

<div {{ $attributes->merge(['class' => 'flex sm:flex-row flex-col sm:space-x-2 sm:space-y-0 space-y-2 mt-4']) }}>
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
