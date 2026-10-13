{{-- Add Section --}}
@php use App\Enums\FraisType; @endphp
@php use App\Enums\MinervalMonth; @endphp
<div wire:ignore.self class="modal fade" tabindex="-1" id="add-frais-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ajouter Frais</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-form::validation-errors class="mb-4" :errors="$errors"/>
                <form id="f1" wire:submit.prevent="addFrais">
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="">Nom <i class="text-red">*</i></label>
                            <input type="text" wire:model="nom"
                                   class="form-control @error('nom') is-invalid @enderror">
                            @error('nom')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
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

{{-- EditModal Revenu --}}
<div wire:ignore.self class="modal fade" tabindex="2" id="edit-frais-modal">
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
                <form id="f2" wire:submit.prevent="updateFrais">
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="">Nom <i class="text-red">*</i></label>
                            <input type="text" wire:model="nom"
                                   class="form-control @error('nom') is-invalid @enderror">
                            @error('nom')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="">Montant <i class="text-red">*</i></label>
                            <input type="number" wire:model="montant"
                                   class="form-control @error('montant') is-invalid @enderror">
                            @error('montant')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-3">
                            <label for="">Section <i class="text-red">*</i></label>
                            <x-form::select wire:model="section_id" wire:change="changeSection">
                                <option value=null>Choisir section</option>
                                @foreach ($sections as $section )
                                    <option value="{{ $section->id }}">{{ $section->nom }}</option>
                                @endforeach
                            </x-form::select>
                            @error('section_id')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-3">
                            <label for="">Option</label>
                            <x-form::select refresh wire:model="option_id" wire:change="changeOption"
                                            class="form-control">
                                @foreach ($options as $option )
                                    <option value="{{ $option->id }}">{{ $option->nom }}</option>
                                @endforeach
                            </x-form::select>

                        </div>
                        <div class="form-group col-3">
                            <label for="">Filière</label>
                            <x-form::select refresh wire:model="filiere_id"
                                            wire:change="changeFiliere" class="form-control">
                                @foreach ($filieres as $filiere)
                                    <option value="{{ $filiere->id }}">{{ $filiere->nom }}</option>
                                @endforeach
                            </x-form::select>
                        </div>
                        <div class="form-group col-3">
                            <label for="">Classe <i class="text-red">*</i></label>
                            <x-form::select refresh wire:model="classe_id" wire:change="onClasseSelected"
                                            class="form-control">
                                @foreach ($classes as $classe )
                                    <option value="{{ $classe->id }}">{{ $classe->code }}</option>
                                @endforeach
                            </x-form::select>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="">Description</label>
                        <textarea rows="2" wire:model="description" class="form-control"></textarea>

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
<div wire:ignore.self class="modal fade" tabindex="-1" id="delete-frais-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Suppression de Frais</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer ce frais ?</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">
                    Fermer
                </button>
                <button wire:click="deleteFrais" class="btn btn-primary">Supprimer</button>
            </div>
        </div>

    </div>

</div>
