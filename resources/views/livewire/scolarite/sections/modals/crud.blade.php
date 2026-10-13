{{-- Add Section --}}
<div wire:ignore.self class="modal fade" tabindex="-1" id="add-section-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ajouter Section</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-form::validation-errors class="mb-4" :errors="$errors"/>
                <form id="f1" wire:submit.prevent="addSection">
                    <div class="row">
                        <div class="form-group col-md-9 col-sm-6">
                            <label for="">Nom <i class="text-red">*</i></label>
                            <input autotext type="text" wire:keyup.debounce="genCode" wire:model="nom"
                                   class="form-control @error('nom') is-invalid @enderror">
                            @error('nom')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-3 col-sm-6">
                            <label for="">Code <i class="text-red">*</i></label>
                            <input required type="text" wire:model="code"
                                   class="form-control @error('code') is-invalid @enderror">
                            {{-- @error('code')
                             <span class="text-red">{{ $message }}</span>
                             @enderror--}}
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn " style="background-color: #000; color: white" data-dismiss="modal">
                    Fermer
                </button>
                <button form="f1" type="submit" class="btn" style="background-color: #0c84ff; color: white ">Ajouter</button>
            </div>
        </div>

    </div>

</div>

{{-- EditModal Section --}}
<div wire:ignore.self class="modal fade" tabindex="2" id="edit-section-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modifier Section</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-form::validation-errors class="mb-4" :errors="$errors"/>
                <form id="f2" wire:submit.prevent="updateSection">
                    <div class="row">
                        <div class="form-group col-md-9 col-sm-6">
                            <label for="">Nom <i class="text-red">*</i></label>
                            <input autofocus type="text" wire:keyup.debounce="genCode" wire:model="nom"
                                   class="form-control @error('nom') is-invalid @enderror">
                            @error('nom')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-3 col-sm-6">
                            <label for="">Code <i class="text-red">*</i></label>
                            <input required type="text" wire:model="code"
                                   class="form-control @error('code') is-invalid @enderror">
                            {{--@error('code')
                            <span class="text-red">{{ $message }}</span>
                            @enderror--}}
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">
                    Fermer
                </button>
                <button form="f2" type="updateSection" class="btn btn-primary">Modifier</button>
            </div>
        </div>

    </div>

</div>

{{-- Delete Section --}}
<div wire:ignore.self class="modal fade" tabindex="-1" id="delete-section-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Suppression de Section</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer cette section ?</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">
                    Fermer
                </button>
                <button wire:click="deleteSection" class="btn btn-primary">Supprimer</button>
            </div>
        </div>

    </div>

</div>


{{--------------------------------------------------------}}

{{-- Add Option --}}
<div wire:ignore.self class="modal fade" tabindex="-1" id="add-option-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ajouter Option</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-form::validation-errors class="mb-4" :errors="$errors"/>
                <form id="f4" wire:submit.prevent="addOption">

                    <div class="row">
                        <div class="form-group col-9">
                            <label for="">Nom <i class="text-red">*</i></label>
                            <input wire:keyup.debounce="genCode" type="text" wire:model="option_nom"
                                   class="form-control @error('option_nom') is-invalid @enderror">
                            @error('option_nom')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-3">
                            <label for="">Code <i class="text-red">*</i></label>
                            <input type="text" wire:model="option_code"
                                   class="form-control @error('option_code') is-invalid @enderror">
                            @error('option_code')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">
                    Fermer
                </button>
                <button form="f4" type="submit" class="btn btn-primary">Ajouter</button>
            </div>
        </div>

    </div>

</div>

