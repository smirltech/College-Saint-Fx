{{-- Add Section --}}
<div wire:ignore.self class="modal fade" tabindex="-1" id="add-depense-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Initier une dépense</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-form::validation-errors class="mb-4" :errors="$errors"/>
                <form id="f1" wire:submit.prevent="addDepense">
                    <div class="row">
                        <div class="form-group col-md-4 col-sm-12">
                            <label for="">Type</label>
                            <x-form::select
                                wire:model="type.id"
                                class="form-control">
                                <option value=null>Choisir type...</option>
                                @foreach ($types as $es )
                                    <option value="{{$es->id}}">{{ $es->nom }}</option>
                                @endforeach
                            </x-form::select>
                        </div>
                        <div class="form-group col-md-4 col-sm-12">
                            <label for="">Montant <i class="text-red">*</i></label>
                            <input type="number" wire:model="montant"
                                   class="form-control @error('montant') is-invalid @enderror">
                            @error('montant')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4 col-sm-12">
                            <label for="">Référence</label>
                            <input type="text" wire:model="reference" class="form-control">

                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="">Note</label>
                        <textarea rows="2" wire:model="note" class="form-control"></textarea>

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
<div wire:ignore.self class="modal fade" tabindex="2" id="edit-depense-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modifier Dépense</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-form::validation-errors class="mb-4" :errors="$errors"/>
                <form id="f2" wire:submit.prevent="updateDepense">
                    <div class="row">
                        <div class="form-group col-md-4 col-sm-12">
                            <label for="">Type</label>
                            <x-form::select wire:model="type.id"
                                            class="form-control">
                                @foreach ($types as $es )
                                    <option value="{{$es->id}}">{{ $es->nom }}</option>
                                @endforeach
                            </x-form::select>
                        </div>
                        <div class="form-group col-md-4 col-sm-12">
                            <label for="">Montant <i class="text-red">*</i></label>
                            <input type="number" wire:model="montant"
                                   class="form-control @error('montant') is-invalid @enderror">
                            @error('montant')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4 col-sm-12">
                            <label for="">Référence</label>
                            <input type="text" wire:model="reference" class="form-control">

                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="">Note</label>
                        <textarea rows="2" wire:model="note" class="form-control"></textarea>

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
<div wire:ignore.self class="modal fade" tabindex="-1" id="delete-depense-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Suppression de Dépense</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer cette dépense ?</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">
                    Fermer
                </button>
                <button wire:click="deleteDepense" class="btn btn-primary">Supprimer</button>
            </div>
        </div>

    </div>

</div>
