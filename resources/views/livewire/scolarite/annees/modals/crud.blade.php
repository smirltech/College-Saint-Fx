<x-adminlte-modal wire:ignore.self id="add-annee-modal" icon="fa-regular fa-calendar-plus"
                  title="Ajout d'année scolaire">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <form id="f1a" wire:submit.prevent="addAnnee">
        <div class="row">
            <div class="form-group col-md-6 col-sm-12">
                <x-form::input
                    type="date"
                    label="Date debut"
                    wire:model="annee.date_debut"
                    :is-valid="$errors->has('annee.date_debut')?false:null"
                    :error="$errors->first('annee.date_debut')">>
                </x-form::input>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <x-form::input
                    type="date"
                    label="Date fin"
                    wire:model="annee.date_fin"
                    :is-valid="$errors->has('annee.date_fin')?false:null"
                    :error="$errors->first('annee.date_fin')">>
                </x-form::input>
            </div>
        </div>
    </form>
    <x-slot name="footerSlot">
        <div class="d-flex">
            <button form="f1a" type="submit" class="btn mr-3" style="background-color: #0c84ff; color: white">Soumettre</button>
        </div>
    </x-slot>
</x-adminlte-modal>

<x-adminlte-modal wire:ignore.self id="edit-annee-modal" icon="fa-regular fa-calendar"
                  title="Modification d'année scolaire  {{$annee->code}}">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <form id="f1b" wire:submit.prevent="updateAnnee">
        <div class="row">
            <div class="form-group col-md-6 col-sm-12">
                <x-form::input
                    type="date"
                    label="Date debut"
                    wire:model="annee.date_debut"
                    :is-valid="$errors->has('annee.date_debut')?false:null"
                    :error="$errors->first('annee.date_debut')">>
                </x-form::input>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <x-form::input
                    type="date"
                    label="Date fin"
                    wire:model="annee.date_fin"
                    :is-valid="$errors->has('annee.date_fin')?false:null"
                    :error="$errors->first('annee.date_fin')">>
                </x-form::input>
            </div>
        </div>
    </form>
    <x-slot name="footerSlot">
        <div class="d-flex">
            <button form="f1b" type="submit" class="btn btn-outline-primary mr-3">Soumettre</button>
        </div>
    </x-slot>
</x-adminlte-modal>

<x-adminlte-modal wire:ignore.self id="delete-annee-modal" icon="fa-regular fa-calendar-xmark"
                  title="Suppression d'année scolaire">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <div>Êtes-vous sûr de vouloir supprimer cette année scolaire {{$annee->code}} ?</div>
    <x-slot name="footerSlot">
        <x-adminlte-button wire:click="deleteAnnee" type="button" theme="primary"
                           label="Supprimer"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>
