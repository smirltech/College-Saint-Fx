{{--add category--}}
<x-adminlte-modal wire:ignore.self id="add-category-modal" icon="fa fa-tag"
                  title="Ajout de Catégorie">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <form id="f1a" wire:submit.prevent="addCategory">
        <div class="row">

            <div class="form-group col-md-12 col-sm-12">
                <x-form::input
                    type="text"
                    label="Nom"
                    wire:model="category.nom"
                    :is-valid="$errors->has('category.nom')?false:null"
                    :error="$errors->first('category.nom')">
                </x-form::input>
            </div>
            <div class="form-group col-md-12 col-sm-12">
                <label for="">Groupe</label>
                <x-form::select wire:model="category.rayon_id"
                                class="form-control">
                    <option value=null>Choisir groupe...</option>
                    @foreach ($categories as $es )
                        <option value="{{$es->id}}">{{ $es->nom }}</option>
                    @endforeach
                </x-form::select>
            </div>
            <div class="form-group col-md-12 col-sm-12">
                <label for="">Description</label>
                <textarea rows="2" wire:model="category.description" class="form-control"></textarea>

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
<x-adminlte-modal wire:ignore.self id="update-category-modal" icon="fa fa-tag"
                  title="Modification de Catégorie">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <form id="f2a" wire:submit.prevent="updateCategory">
        <div class="row">

            <div class="form-group col-md-12 col-sm-12">
                <x-form::input
                    type="text"
                    label="Nom"
                    wire:model="category.nom"
                    :is-valid="$errors->has('category.nom')?false:null"
                    :error="$errors->first('category.nom')">
                </x-form::input>
            </div>
            <div class="form-group col-md-12 col-sm-12">
                <label for="">Groupe</label>
                <x-form::select wire:model="category.rayon_id"
                                class="form-control">
                    <option value=null>Choisir groupe...</option>
                    @foreach ($categories as $es )
                        @if($es->id != $category->id)
                            <option value="{{$es->id}}">{{ $es->nom }}</option>
                        @endif

                    @endforeach
                </x-form::select>
            </div>
            <div class="form-group col-md-12 col-sm-12">
                <label for="">Description</label>
                <textarea rows="2" wire:model="category.description" class="form-control"></textarea>

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
<x-adminlte-modal wire:ignore.self id="delete-category-modal" icon="fa fa-tag"
                  title="Suppression de catégorie">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <div>Êtes-vous sûr de vouloir supprimer cette catégorie d'ouvrage ?</div>
    <x-slot name="footerSlot">
        <x-adminlte-button wire:click="deleteCategory" type="button" theme="primary"
                           label="Supprimer"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>
