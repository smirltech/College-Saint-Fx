{{--add category--}}
<x-adminlte-modal wire:ignore.self id="add-category-modal" icon="fa fa-people-group"
                  title="Ajout de Catégorie de Matériel">
    <form id="f1a" wire:submit.prevent="addCategory">
        <div class="row">
            <div class="form-group col-md-6 col-sm-12">
                <label for="">Groupe </label>
                <x-form::select :select-placeholder='true' wire:model="category.materiel_category_id"
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
                    required
                    wire:model="category.nom">
                </x-form::input>
            </div>
            <div class="form-group col-md-12 col-sm-12">
                <x-form::input
                    type="text"
                    label="Description"
                    wire:model="category.description">
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
<x-adminlte-modal wire:ignore.self id="update-category-modal" icon="fa fa-people-group"
                  title="Modification de Catégorie de Matériel">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <form id="f2a" wire:submit.prevent="updateCategory">
        <div class="row">
            <div class="form-group col-md-6 col-sm-12">
                <label for="">Groupe </label>
                <x-form::select :select-placeholder='true' wire:model.defer="category.materiel_category_id"
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
                    wire:model.defer="category.nom"
                    :is-valid="$errors->has('category.nom')?false:null"
                    :error="$errors->first('category.nom')">
                </x-form::input>
            </div>
            <div class="form-group col-md-12 col-sm-12">
                <x-form::input
                    type="text"
                    label="Description"
                    wire:model.defer="category.description">
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
<x-adminlte-modal wire:ignore.self id="delete-category-modal" icon="fa fa-cubes"
                  title="Suppression de Catégorie de Matériel">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <div>Êtes-vous sûr de vouloir supprimer cette catégorie</div>
    <x-slot name="footerSlot">
        <x-adminlte-button wire:click="deleteCategory" type="button" theme="primary"
                           label="Supprimer"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>
