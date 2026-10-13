{{-- Add Section --}}
<div wire:ignore.self class="modal fade" tabindex="-1" id="add-revenu-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ajouter Revenu</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-form::validation-errors class="mb-4" :errors="$errors"/>
                <form id="f1" wire:submit.prevent="addRevenu">
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="">Nom <i class="text-red">*</i></label>
                            <input type="text" wire:model="nom" class="form-control @error('nom') is-invalid @enderror">
                            @error('nom')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="">Montant <i class="text-red">*</i></label>
                            <input type="number" wire:model="montant"
                                   class="form-control @error('montant') is-invalid @enderror">
                            @error('montant')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="">Description</label>
                            <textarea rows="2" wire:model="description" class="form-control"></textarea>

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">
                    Fermer
                </button>
                <button form="f1" type="submit" class="btn btn-primary">Ajouter</button>
            </div>
        </div>

    </div>

</div>

{{-- EditModal Section --}}
<div wire:ignore.self class="modal fade" tabindex="2" id="edit-revenu-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modifier Revenu</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-form::validation-errors class="mb-4" :errors="$errors"/>
                <form id="f2" wire:submit.prevent="updateRevenu">
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="">Nom <i class="text-red">*</i></label>
                            <input type="text" wire:model="nom" class="form-control @error('nom') is-invalid @enderror">
                            @error('nom')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="">Montant <i class="text-red">*</i></label>
                            <input type="number" wire:model="montant"
                                   class="form-control @error('montant') is-invalid @enderror">
                            @error('montant')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="">Description</label>
                            <textarea rows="2" wire:model="description" class="form-control"></textarea>

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">
                    Fermer
                </button>
                <button form="f2" type="submit" class="btn btn-primary">Modifier</button>
            </div>
        </div>

    </div>

</div>

{{-- Delete Section --}}
<div wire:ignore.self class="modal fade" tabindex="-1" id="delete-revenu-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Suppression de Revenu</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer ce revenu ?</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">
                    Fermer
                </button>
                <button wire:click="deleteRevenu" class="btn btn-primary">Supprimer</button>
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

