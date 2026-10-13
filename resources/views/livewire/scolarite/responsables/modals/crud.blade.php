{{-- Add Responsable --}}
@php use App\Enums\Sexe; @endphp
@php use App\Enums\ResponsableRelation; @endphp
<div wire:ignore.self class="modal fade" tabindex="-1" id="add-responsable-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ajouter Responsable</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-form::validation-errors class="mb-4" :errors="$errors"/>
                <form id="f1" wire:submit.prevent="addThisResponsable">
                    <div class="row">
                        <div class="form-group col-md-9">
                            <x-form::input
                                label="Nom"
                                wire:model="responsable_nom"
                                required/>
                        </div>
                        <div class="form-group col-md-3">
                            <x-form::select
                                label="Sexe"
                                :options="Sexe::cases()"
                                wire:model="responsable_sexe">
                            </x-form::select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="">Téléphone</label>
                            <input placeholder="Saisir le numéro de téléphone"
                                   type="tel"
                                   wire:model="responsable_telephone"
                                   class="form-control">
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="">E-mail</label>
                            <input placeholder="Saisir l'adresse e-mail" type="text"
                                   wire:model="responsable_email"
                                   class="form-control">
                        </div>

                        <div class="form-group">
                            <x-form::input
                                required
                                placeholder="Saisir l'adresse du domicile"
                                wire:model="responsable_adresse"/>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">
                    Fermer
                </button>
                <button form="f1" type="submit" class="btn btn-primary">Soumettre</button>
            </div>
        </div>

    </div>

</div>

{{-- edit Responsable --}}
<div wire:ignore.self class="modal fade" tabindex="-1" id="edit-responsable-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modifier Responsable</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-form::validation-errors class="mb-4" :errors="$errors"/>
                <form id="f2" wire:submit.prevent="submitResponsable">
                    <div class="row">
                        <div class="form-group col-md-9 col-sm-12">
                            <label for="">Nom</label>
                            <input placeholder="Saisir le nom du responsable" type="text"
                                   wire:model="nom"
                                   class="form-control" required>
                        </div>
                        <div class="form-group col-md-3 col-sm-12">
                            <label for="">Sexe</label>
                            <x-form::select wire:model="sexe"
                                            class="form-control">
                                @foreach (Sexe::cases() as $es )
                                    <option value="{{$es}}">{{ $es->label() }}</option>
                                @endforeach
                            </x-form::select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="">Téléphone</label>
                            <input placeholder="Saisir le numéro de téléphone" type="tel"
                                   wire:model="telephone"
                                   class="form-control">
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="">E-mail</label>
                            <input placeholder="Saisir l'adresse e-mail" type="text"
                                   wire:model="email"
                                   class="form-control">
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="">Adresse </label>
                        <textarea placeholder="Saisir l'adresse du domicile"
                                  wire:model="adresse"
                                  rows="1"
                                  class="form-control"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">
                    Fermer
                </button>
                <button form="f2" type="submit" class="btn btn-primary">Soumettre</button>
            </div>
        </div>

    </div>

</div>

{{-- Delete Responsable --}}
<div wire:ignore.self class="modal fade" tabindex="-1" id="delete-responsable-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Suppression de Responsable</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer ce responsable ?</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">
                    Fermer
                </button>
                <button wire:click="deleteResponsable" class="btn btn-primary">Supprimer</button>
            </div>
        </div>

    </div>

</div>

{{-- EditModal Relation --}}
<div wire:ignore.self class="modal fade" tabindex="-1" id="edit-relation-modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modifier Relation</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-form::validation-errors class="mb-4" :errors="$errors"/>
                <form id="f5" wire:submit.prevent="editRelation">

                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="">Relation</label>
                            <x-form::select wire:model="responsable_relation"
                                            class="form-control">
                                @foreach (ResponsableRelation::cases() as $es )
                                    <option value="{{$es->value}}">{{ $es->label() }}</option>
                                @endforeach
                            </x-form::select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">
                    Fermer
                </button>
                <button wire:click="deleteRelation" type="button" class="btn btn-danger" data-dismiss="modal">
                    Supprimer
                </button>
                <button form="f5" type="submit" class="btn btn-warning">Soumettre</button>
            </div>
        </div>

    </div>

</div>


