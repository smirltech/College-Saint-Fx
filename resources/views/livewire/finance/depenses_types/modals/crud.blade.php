{{-- Add Section --}}
<div wire:ignore.self class="modal fade" tabindex="-1" id="add-type-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ajouter Type Dépense</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-form::validation-errors class="mb-4" :errors="$errors"/>
                <form id="f1" wire:submit.prevent="addTypeDepense">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="">Nom <i class="text-red">*</i></label>
                            <input autotext type="text" wire:model="depenseType.nom"
                                   class="form-control @error('depenseType.nom') is-invalid @enderror">
                            @error('depenseType.nom')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <x-form::textarea rows="2"
                                              placeholder="Saisir la description du cours"
                                              wire:model="depenseType.description"
                                              label="Description du type"
                                              :isValid="$errors->has('depenseType.description') ? false : null"
                                              error="{{$errors->first('depenseType.description')}}"/>

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
<div wire:ignore.self class="modal fade" tabindex="2" id="edit-type-modal">
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
                <form id="f2" wire:submit.prevent="updateTypeDepense">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="">Nom <i class="text-red">*</i></label>
                            <input autotext type="text" wire:model="depenseType.nom"
                                   class="form-control @error('depenseType.nom') is-invalid @enderror">
                            @error('depenseType.nom')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <x-form::textarea rows="2"
                                              placeholder="Saisir la description du cours"
                                              wire:model="depenseType.description"
                                              label="Description du type"
                                              :isValid="$errors->has('depenseType.description') ? false : null"
                                              error="{{$errors->first('depenseType.description')}}"/>

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
<div wire:ignore.self class="modal fade" tabindex="-1" id="delete-type-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Suppression de Type Dépense</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer ce type de dépense ?</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">
                    Fermer
                </button>
                <button wire:click="deleteTypeDepense" class="btn btn-primary">Supprimer</button>
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

