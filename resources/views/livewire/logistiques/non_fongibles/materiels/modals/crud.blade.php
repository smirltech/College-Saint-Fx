{{--add category--}}
@php use App\Enums\MaterialStatus; @endphp
<x-adminlte-modal wire:ignore.self id="add-materiel-modal" icon="fa fa-wrench"
                  title="Ajout de Matériel">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <form id="f1a" wire:submit.prevent="addMateriel">
        <div class="row">
            <div class="form-group col-md-6 col-sm-12">
                <label for="">Catégorie </label>
                <x-form::select :select-placeholder='false' wire:model="materiel.materiel_category_id"
                                class="form-control">
                    @foreach ($categories as $es )
                        <option value="{{$es->id}}">{{$es->nom}}</option>
                    @endforeach
                </x-form::select>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <x-form::input
                    type="text"
                    label="Nom"
                    wire:model="materiel.nom"
                    :is-valid="$errors->has('materiel.nom')?false:null"
                    :error="$errors->first('materiel.nom')">
                </x-form::input>
            </div>
            <div class="form-group col-md-6">
                <x-form::input
                    type="number"
                    label="Montant"
                    wire:model="materiel.montant"
                    :is-valid="$errors->has('materiel.montant')?false:null"
                    :error="$errors->first('materiel.montant')">
                </x-form::input>
            </div>
            <div class="form-group col-md-6">
                <x-form::input
                    type="date"
                    label="Date"
                    wire:model="materiel.date">
                </x-form::input>
            </div>
            <div class="form-group col-md-12">
                <x-form::input
                    type="number"
                    label="Durée de vie (en année)"
                    wire:model="materiel.vie">
                </x-form::input>
            </div>
            <div class="form-group col-md-12 col-sm-12">
                <x-form::input
                    type="text"
                    label="Description"
                    wire:model="materiel.description">
                </x-form::input>
            </div>
            {{--  <div class="form-group col-md-12 col-sm-12">
                  <label for="">État </label>
                  <x-form::select wire:model="presence.status"
                                 class="form-control">
                      @foreach (\App\Enums\PresenceStatus::cases() as $es )
                              <option value="{{$es->name}}">{{$es->label()}}</option>
                      @endforeach
                  </x-form::select>

              </div>--}}
            {{--<div class="form-group col-md-12 col-sm-12">
                <x-form::input
                    type="text"
                    label="Observation"
                    wire:model="presence.observation">
                </x-form::input>
            </div>--}}
        </div>
    </form>
    <x-slot name="footerSlot">
        <div class="d-flex">
            <button form="f1a" type="submit" class="btn btn-outline-primary mr-3">Soumettre</button>
        </div>
    </x-slot>
</x-adminlte-modal>

{{--update category--}}
<x-adminlte-modal wire:ignore.self id="update-materiel-modal" icon="fa fa-wrench"
                  title="Modification de Matériel">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <form id="f2a" wire:submit.prevent="updateMateriel">
        <div class="row">
            <div class="form-group col-md-6 col-sm-12">
                <label for="">Catégorie </label>
                <x-form::select :select-placeholder='false' wire:model.defer="materiel.materiel_category_id"
                                class="form-control">
                    @foreach ($categories as $es )
                        <option value="{{$es->id}}">{{$es->nom}}</option>
                    @endforeach
                </x-form::select>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <x-form::input
                    type="text"
                    label="Nom"
                    wire:model.defer="materiel.nom"
                    :is-valid="$errors->has('materiel.nom')?false:null"
                    :error="$errors->first('materiel.nom')">
                </x-form::input>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <x-form::input
                    type="number"
                    label="Montant"
                    wire:model.defer="materiel.montant"
                    :is-valid="$errors->has('materiel.montant')?false:null"
                    :error="$errors->first('materiel.montant')">
                </x-form::input>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <x-form::input
                    type="date"
                    label="Date"
                    wire:model.defer="materiel.date">
                </x-form::input>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <x-form::input
                    type="number"
                    label="Vie"
                    wire:model.defer="materiel.vie">
                </x-form::input>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label for="">État </label>
                <x-form::select :select-placeholder='false' wire:model.defer="materiel.status"
                                class="form-control">
                    @foreach (MaterialStatus::cases() as $es )
                        <option value="{{$es->name}}">{{$es->label()}}</option>
                    @endforeach
                </x-form::select>
            </div>
            <div class="form-group col-md-12 col-sm-12">
                <x-form::input
                    type="text"
                    label="Description"
                    wire:model.defer="materiel.description">
                </x-form::input>
            </div>
        </div>
    </form>
    <x-slot name="footerSlot">
        <div class="d-flex">
            <button form="f2a" type="submit" class="btn btn-outline-primary mr-3">Soumettre</button>
        </div>
    </x-slot>
</x-adminlte-modal>

{{--delete category--}}
<x-adminlte-modal wire:ignore.self id="delete-materiel-modal" icon="fa fa-wrench"
                  title="Suppression de Matériel">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <div>Êtes-vous sûr de vouloir supprimer ce matériel</div>
    <x-slot name="footerSlot">
        <x-adminlte-button wire:click="deleteMateriel" type="button" theme="primary"
                           label="Supprimer"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>
