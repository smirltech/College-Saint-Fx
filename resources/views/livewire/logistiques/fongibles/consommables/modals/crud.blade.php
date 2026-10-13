{{--add category--}}
<x-adminlte-modal wire:ignore.self id="add-consommable-modal" icon="fa fa-wrench"
                  title="Ajout de Consommable">
    <form id="f1a" wire:submit.prevent="addConsommable">
        <div class="row">
            <div class="form-group col-md-12">
                <x-form::input
                    type="text"
                    label="Nom"
                    wire:model.defer="consommable.nom"
                    :is-valid="$errors->has('consommable.nom')?false:null"
                    :error="$errors->first('consommable.nom')">
                </x-form::input>
            </div>
            <div class="form-group col-md-12">
                <label for="">Unité de mesure </label>
                <x-form::select :select-placeholder='false' wire:model.defer="consommable.unit_id"
                                class="form-control">
                    @foreach ($units as $es )
                        <option value="{{$es->id}}">{{$es->nom}}</option>
                    @endforeach
                </x-form::select>
            </div>

            <div class="form-group col-md-12 col-sm-12">
                <x-form::textarea
                    rows="3"
                    type="text"
                    label="Description"
                    wire:model.defer="consommable.description">
                </x-form::textarea>
            </div>
        </div>
    </form>
    <x-slot name="footerSlot">
        <div class="d-flex">
            <button form="f1a" type="submit" class="btn btn-outline-primary mr-3">Soumettre</button>
        </div>
    </x-slot>
</x-adminlte-modal>

{{--update category--}}
<x-adminlte-modal wire:ignore.self id="update-consommable-modal" icon="fa fa-wrench"
                  title="Modification de Consommable">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <form id="f2a" wire:submit.prevent="updateConsommable">
        <div class="row">
            <div class="form-group col-md-8 col-sm-12">
                <x-form::input
                    type="text"
                    label="Nom"
                    wire:model.defer="consommable.nom"
                    :is-valid="$errors->has('consommable.nom')?false:null"
                    :error="$errors->first('consommable.nom')">
                </x-form::input>
            </div>
            <div class="form-group col-md-4 col-sm-12">
                <label for="">Unité de mesure </label>
                <x-form::select :select-placeholder='false' wire:model.defer="consommable.unit_id"
                                class="form-control">
                    @foreach ($units as $es )
                        <option value="{{$es->id}}">{{$es->nom}}</option>
                    @endforeach
                </x-form::select>
            </div>

            <div class="form-group col-md-12 col-sm-12">
                <x-form::input
                    type="text"
                    label="Description"
                    wire:model.defer="consommable.description">
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
<x-adminlte-modal wire:ignore.self id="delete-consommable-modal" icon="fa fa-wrench"
                  title="Suppression de Consommable">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <div>Êtes-vous sûr de vouloir supprimer ce consommable</div>
    <x-slot name="footerSlot">
        <x-adminlte-button wire:click="deleteConsommable" type="button" theme="primary"
                           label="Supprimer"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>
