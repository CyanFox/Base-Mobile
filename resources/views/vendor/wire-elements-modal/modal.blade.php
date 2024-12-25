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
        x-on:keydown.escape.window="show && closeModalOnEscape()"
        x-show="show"
        class="fixed inset-0 z-10 overflow-y-auto"
        style="display: none;"
    >
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-10 text-center sm:block sm:p-0">
            <x-modal :default-open="true">
                <div
                    x-show="show"
                    x-on:click="closeModalOnClickAway()"
                    class="fixed inset-0 transition-all transform z-10"
                >
                </div>


                <x-modal.content class="z-20">

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
                </x-modal.content>
            </x-modal>
        </div>
    </div>
</div>
