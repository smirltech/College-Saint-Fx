{{--add category--}}
<x-adminlte-modal wire:ignore.self id="add-unit-modal" icon="fa fa-people-group"
                  title="Ajout de Unité">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <form id="f1a" wire:submit.prevent="addUnit">
        <div class="row">

            <div class="form-group col-md-8 col-sm-12">
                <x-form::input
                    type="text"
                    label="Nom"
                    wire:model="unit.nom"
                    :is-valid="$errors->has('unit.nom')?false:null"
                    :error="$errors->first('unit.nom')">
                </x-form::input>
            </div>
            <div class="form-group col-md-4 col-sm-12">
                <x-form::input
                    type="text"
                    label="Abréviation"
                    wire:model="unit.code">
                </x-form::input>
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
<x-adminlte-modal wire:ignore.self id="update-unit-modal" icon="fa fa-people-group"
                  title="Modification de Unité">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <form id="f2a" wire:submit.prevent="updateUnit">
        <div class="row">

            <div class="form-group col-md-8 col-sm-12">
                <x-form::input
                    type="text"
                    label="Nom"
                    wire:model="unit.nom"
                    :is-valid="$errors->has('unit.nom')?false:null"
                    :error="$errors->first('unit.nom')">
                </x-form::input>
            </div>
            <div class="form-group col-md-4 col-sm-12">
                <x-form::input
                    type="text"
                    label="Abréviation"
                    wire:model="unit.code">
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
<x-adminlte-modal wire:ignore.self id="delete-unit-modal" icon="fa fa-cubes"
                  title="Suppression de Unité">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <div>Êtes-vous sûr de vouloir supprimer cette unité</div>
    <x-slot name="footerSlot">
        <x-adminlte-button wire:click="deleteUnit" type="button" theme="primary"
                           label="Supprimer"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>
