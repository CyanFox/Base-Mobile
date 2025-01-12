@props([
    'title' => null,
    'viewIntegration' => null,
])
<x-card>
    <x-card.title>
        <span>{{ __($title) }}</span>
        <x-view-integration name="{{ $viewIntegration }}.header"/>
    </x-card.title>

    <x-view-integration name="{{ $viewIntegration }}.top"/>

    {{ $slot }}

    <x-view-integration name="{{ $viewIntegration }}.end"/>
</x-card>
