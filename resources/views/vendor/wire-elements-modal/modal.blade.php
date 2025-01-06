<div>
    @isset($jsPath)
        <script>{!! file_get_contents($jsPath) !!}</script>
    @endisset
    @isset($cssPath)
        <style>{!! file_get_contents($cssPath) !!}</style>
    @endisset

    <div
        x-data="LivewireUIModal()"
        x-on:close.stop="setShowPropertyTo(false)"
        x-on:keydown.escape.window="show && closeModalOnEscape();"
        x-show="show"
        class="fixed inset-0 z-40 overflow-y-auto"
        style="display: none;"
    >
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-10 sm:block sm:p-0">
            <div x-transition.opacity.duration.200ms
                 class="fixed inset-0 z-30 flex items-end justify-center bg-black/20 p-4 pb-8 backdrop-blur-md sm:items-center lg:p-8"
                 role="dialog" aria-modal="true">
                <div
                    x-show="show"
                    x-on:click="closeModalOnClickAway();"
                    class="fixed inset-0 transition-all transform z-30"
                >
                </div>


                <div x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity"
                     x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100"
                     class="flex max-w-lg z-40 flex-col gap-4 overflow-hidden rounded-md bg-white text-neutral-600 dark:bg-neutral-900 dark:text-neutral-300">

                    <div
                        x-show="show && showActiveComponent"
                        id="modal-container"
                        x-trap.noscroll.inert="show && showActiveComponent"
                        aria-modal="true"
                    >
                        @forelse($components as $id => $component)
                            <div x-show.immediate="activeComponent == '{{ $id }}'" x-ref="{{ $id }}"
                                 wire:key="{{ $id }}">
                                @livewire($component['name'], $component['arguments'], key($id))
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
