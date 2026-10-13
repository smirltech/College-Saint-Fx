{{--add category--}}
<x-adminlte-modal wire:ignore.self id="add-auteur-modal" icon="fa fa-user-tie"
                  title="Ajout d'auteur">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <form id="faut1a" wire:submit.prevent="addAuteur">
        <div class="row">
            <div class="form-group col-md-12 col-sm-12">
                <label for="">Auteur</label>
                <x-form::select wire:model="ouvrage_auteur.auteur_id"
                                class="form-control">
                    <option value=null>Choisir auteur...</option>
                    @foreach ($auteurs as $es )
                        <option value="{{$es->id}}">{{ $es->nom }}</option>
                    @endforeach
                </x-form::select>
            </div>
        </div>
    </form>
    <x-slot name="footerSlot">
        <div class="d-flex">
            <button form="faut1a" type="submit" class="btn btn-outline-primary mr-3">Soumettre</button>
        </div>
    </x-slot>
</x-adminlte-modal>

