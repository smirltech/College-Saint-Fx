{{--add category--}}
<x-adminlte-modal wire:ignore.self id="add-etiquette-modal" icon="fa fa-tag"
                  title="Ajout d'étiquette">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <form id="feti1a" wire:submit.prevent="addEtiquette">
        <div class="row">
            <div class="form-group col-md-12 col-sm-12">
                <label for="">Etiquette</label>
                <x-form::select wire:model="ouvrage_etiquette.tag_id"
                                class="form-control">
                    <option value=null>Choisir étiquette...</option>
                    @foreach ($etiquettes as $es )
                        <option value="{{$es->id}}">{{ $es->nom }}</option>
                    @endforeach
                </x-form::select>
            </div>
        </div>
    </form>
    <x-slot name="footerSlot">
        <div class="d-flex">
            <button form="feti1a" type="submit" class="btn btn-outline-primary mr-3">Soumettre</button>
        </div>
    </x-slot>
</x-adminlte-modal>

