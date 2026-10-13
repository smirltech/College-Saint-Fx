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
                <form id="f1" wire:submit.prevent="submitResponsable">
                    <div class="row">
                        <div class="form-group col-md-4 col-sm-12">
                            <label for="">Nom</label>
                            <input placeholder="Saisir le nom du responsable" type="text"
                                   wire:model="responsable_nom"
                                   class="form-control" required>
                        </div>
                        <div class="form-group col-md-4 col-sm-12">
                            <label for="">Sexe</label>
                            <x-form::select wire:model="responsable_sexe"
                                            class="form-control">
                                @foreach (Sexe::cases() as $es )
                                    <option value="{{$es}}">{{ $es->label() }}</option>
                                @endforeach
                            </x-form::select>
                        </div>
                        <div class="form-group col-md-4 col-sm-12">
                            <label for="">Relation</label>
                            <x-form::select wire:model="responsable_relation"
                                            class="form-control">
                                @foreach (ResponsableRelation::cases() as $es )
                                    <option value="{{$es->value}}">{{ $es->label() }}</option>
                                @endforeach
                            </x-form::select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4 col-sm-12">
                            <label for="">Téléphone</label>
                            <input placeholder="Saisir le numéro de téléphone" type="tel"
                                   wire:model="responsable_telephone"
                                   class="form-control">
                        </div>
                        <div class="form-group col-md-4 col-sm-12">
                            <label for="">E-mail</label>
                            <input placeholder="Saisir l'adresse e-mail" type="text"
                                   wire:model="responsable_email"
                                   class="form-control">
                        </div>
                        <div class="form-group col-md-4 col-sm-12">
                            <label for="">Adresse </label>
                            <textarea placeholder="Saisir l'adresse du domicile"
                                      wire:model="responsable_adresse"
                                      rows="1"
                                      class="form-control"></textarea>
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

