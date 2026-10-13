{{--add auteur--}}
@php use App\Enums\Sexe; @endphp
<x-adminlte-modal wire:ignore.self id="add-auteur-modal" icon="fa fa-tag"
                  title="Ajout de Auteur">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <form id="f1a" wire:submit.prevent="addAuteur">
        <div class="row">

            <div class="form-group col-md-12 col-sm-12">
                <x-form::input
                    type="text"
                    label="Nom"
                    wire:model="auteur.nom"
                    :is-valid="$errors->has('auteur.nom')?false:null"
                    :error="$errors->first('auteur.nom')">
                </x-form::input>
            </div>
            <div class="form-group col-md-12 col-sm-12">
                <x-form::input
                    type="text"
                    label="Prénom"
                    wire:model="auteur.prenom"
                >
                </x-form::input>
            </div>
            <div class="form-group col-md-12 col-sm-12">
                <label for="">Sexe</label>
                <x-form::select wire:model="auteur.sexe"
                                class="form-control">
                    <option value=null>Choisir sexe...</option>
                    @foreach (Sexe::cases() as $es )
                        <option value="{{$es}}">{{ $es->label() }}</option>
                    @endforeach
                </x-form::select>
            </div>
        </div>
    </form>
    <x-slot name="footerSlot">
        <div class="d-flex">
            <button form="f1a" type="submit" class="btn btn-outline-primary mr-3">Soumettre</button>
        </div>
    </x-slot>
</x-adminlte-modal>

{{--update auteur--}}
<x-adminlte-modal wire:ignore.self id="update-auteur-modal" icon="fa fa-tag"
                  title="Modification d'Étiquette">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <form id="f2a" wire:submit.prevent="updateAuteur">
        <div class="row">

            <div class="form-group col-md-12 col-sm-12">
                <x-form::input
                    type="text"
                    label="Nom"
                    wire:model="auteur.nom"
                    :is-valid="$errors->has('auteur.nom')?false:null"
                    :error="$errors->first('auteur.nom')">
                </x-form::input>
            </div>
            <div class="form-group col-md-12 col-sm-12">
                <x-form::input
                    type="text"
                    label="Prénom"
                    wire:model="auteur.prenom"
                >
                </x-form::input>
            </div>
            <div class="form-group col-md-12 col-sm-12">
                <label for="">Sexe</label>
                <x-form::select wire:model="auteur.sexe"
                                class="form-control">
                    <option value=null>Choisir sexe...</option>
                    @foreach (Sexe::cases() as $es )
                        <option value="{{$es}}">{{ $es->label() }}</option>
                    @endforeach
                </x-form::select>
            </div>
        </div>
    </form>
    <x-slot name="footerSlot">
        <div class="d-flex">
            <button form="f2a" type="submit" class="btn btn-outline-primary mr-3">Soumettre</button>
        </div>
    </x-slot>
</x-adminlte-modal>

{{--delete auteur--}}
<x-adminlte-modal wire:ignore.self id="delete-auteur-modal" icon="fa fa-tag"
                  title="Suppression d'Auteur">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <div>Êtes-vous sûr de vouloir supprimer cet auteur</div>
    <x-slot name="footerSlot">
        <x-adminlte-button wire:click="deleteAuteur" type="button" theme="primary"
                           label="Supprimer"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>
