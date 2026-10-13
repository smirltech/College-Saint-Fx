<div>
    @isset($jsPath)
        <script>{!! file_get_contents($jsPath) !!}</script>
    @endisset
    @isset($cssPath)
        <style>{!! file_get_contents($cssPath) !!}</style>
    @endisset

    <div
        x-data="LivewireUIModal()"
        x-init="init()"
        x-on:close.stop="setShowPropertyTo(false)"
        x-on:keydown.escape.window="closeModalOnEscape()"
        x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()"
        x-on:keydown.shift.tab.prevent="prevFocusable().focus()"
        x-show="show"
        class="fixed inset-0 z-10 overflow-y-auto"
        style="display: none;"
    >
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-10 text-center sm:block sm:p-0">
            <div
                x-show="show"
                x-on:click="closeModalOnClickAway()"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 transition-all transform"
            >
                <div class="absolute inset-0 bg-gray-500 opacity-75">
                    Hello
                </div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div
                x-show="show && showActiveComponent"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-bind:class="modalWidth"
                class="inline-block w-full align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full"
                id="modal-container"
            >
                @forelse($components as $id => $component)
                    <div x-show.immediate="activeComponent == '{{ $id }}'" x-ref="{{ $id }}" wire:key="{{ $id }}">
                        @livewire($component['name'], $component['attributes'], key($id))
                    </div>
                @empty
                @endforelse
            </div>
        </div>
    </div>

</div>
<div class="modal fade"
     id="modal-default"
     x-show="show"
     style="display: block; padding-right: 17px;"
     aria-modal="true"
     role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Default Modal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>One fine body…</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>

    </div>

</div>
<div wire:ignore.self class="modal fade show" tabindex="-1" id="attach-responsable-modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Attacher un responsable</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                My Modal Body
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">
                    Fermer
                </button>
                <button form="f1a" type="submit" class="btn btn-warning">Soumettre</button>
            </div>
        </div>

    </div>

</div>

