<div class="sm:w-96">
    @if(!$needsPasswordConfirmation || $this->hasPasswordConfirmedSession())
        @if($title)
            <x-modal.header>
                {{ $title }}
            </x-modal.header>
        @endif

        @if($icon)
            <div class="flex justify-center mt-4">
                <i class="{{ $icon }} text-6xl {{ $iconColor ? 'text-' . $iconColor : '' }}"></i>
            </div>
        @endif

        @if($description)
            <div class="px-4 mt-3 text-center">
                {{ $description }}
            </div>
        @endif

        <x-modal.footer>
            <x-button wire:click="closeModal" loading="closeModal" class="w-full lg:w-1/2" :color="$cancelColor">
                {{ $cancel }}
            </x-button>
            <x-button wire:click="confirmAction" loading="confirmAction" class="w-full lg:w-1/2" :color="$confirmColor">
                {{ $confirm }}
            </x-button>
        </x-modal.footer>
    @endif
</div>
