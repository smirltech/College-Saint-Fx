{{--add category--}}
<x-adminlte-modal wire:ignore.self id="add-ouvrage-modal" icon="fa fa-book"
                  title="Ajout d'ouvrage">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <form id="f1a" wire:submit.prevent="addOuvrage">
        <div class="row">

            <div class="form-group col-md-12 col-sm-12">
                <x-form::input
                    type="text"
                    label="Titre"
                    wire:model="ouvrage.titre"
                    :is-valid="$errors->has('ouvrage.titre')?false:null"
                    :error="$errors->first('ouvrage.titre')">
                </x-form::input>
            </div>

            <div class="form-group col-md-12 col-sm-12">
                <x-form::input
                    type="text"
                    label="Sous Titre"
                    wire:model="ouvrage.sous_titre"
                    :is-valid="$errors->has('ouvrage.sous_titre')?false:null"
                    :error="$errors->first('ouvrage.sous_titre')">
                </x-form::input>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label for="">Groupe</label>
                <x-form::select wire:model="ouvrage.rayon_id"
                                class="form-control">
                    <option value=null>Choisir groupe...</option>
                    @foreach ($categories as $es )
                        <option value="{{$es->id}}">{{ $es->nom }}</option>
                    @endforeach
                </x-form::select>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <x-form::input
                    type="date"
                    label="Date"
                    placeholder="Date d'édition"
                    wire:model="ouvrage.date"
                    :is-valid="$errors->has('ouvrage.date')?false:null"
                    :error="$errors->first('ouvrage.date')">
                </x-form::input>
            </div>

            <div class="form-group col-md-4 col-sm-12">
                <x-form::input
                    type="text"
                    label="Edition"
                    placeholder="Tome 2"
                    wire:model="ouvrage.edition"
                    :is-valid="$errors->has('ouvrage.edition')?false:null"
                    :error="$errors->first('ouvrage.edition')">
                </x-form::input>
            </div>
            <div class="form-group col-md-4 col-sm-12">
                <x-form::input
                    type="text"
                    label="Editeur"
                    placeholder="Maison d'édition"
                    wire:model="ouvrage.editeur"
                    :is-valid="$errors->has('ouvrage.editeur')?false:null"
                    :error="$errors->first('ouvrage.editeur')">
                </x-form::input>
            </div>
            <div class="form-group col-md-4 col-sm-12">
                <x-form::input
                    type="text"
                    label="Lieu"
                    placeholder="Ville d'édition"
                    wire:model="ouvrage.lieu"
                    :is-valid="$errors->has('ouvrage.lieu')?false:null"
                    :error="$errors->first('ouvrage.lieu')">
                </x-form::input>
            </div>

            <div class="form-group col-md-12 col-sm-12">
                <x-form::input
                    type="text"
                    label="Lien URL"
                    placeholder="Lien url du site"
                    wire:model="ouvrage.url"
                    :is-valid="$errors->has('ouvrage.url')?false:null"
                    :error="$errors->first('ouvrage.url')">
                </x-form::input>
            </div>

            <div class="form-group col-md-12 col-sm-12">
                <label for="">Description</label>
                <textarea rows="2" wire:model="ouvrage.resume" class="form-control"></textarea>

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
<x-adminlte-modal wire:ignore.self id="update-ouvrage-modal" icon="fa fa-tag"
                  title="Modification d'ouvrage">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <form id="f2a" wire:submit.prevent="updateOuvrage">
        <div class="row">

            <div class="form-group col-md-12 col-sm-12">
                <x-form::input
                    type="text"
                    label="Titre"
                    wire:model="ouvrage.titre"
                    :is-valid="$errors->has('ouvrage.titre')?false:null"
                    :error="$errors->first('ouvrage.titre')">
                </x-form::input>
            </div>

            <div class="form-group col-md-12 col-sm-12">
                <x-form::input
                    type="text"
                    label="Sous Titre"
                    wire:model="ouvrage.sous_titre"
                    :is-valid="$errors->has('ouvrage.sous_titre')?false:null"
                    :error="$errors->first('ouvrage.sous_titre')">
                </x-form::input>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label for="">Groupe</label>
                <x-form::select wire:model="ouvrage.rayon_id"
                                class="form-control">
                    <option value=null>Choisir groupe...</option>
                    @foreach ($categories as $es )
                        <option value="{{$es->id}}">{{ $es->nom }}</option>
                    @endforeach
                </x-form::select>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <x-form::input
                    type="date"
                    label="Date"
                    placeholder="Date d'édition"
                    wire:model="ouvrage.date"
                    :is-valid="$errors->has('ouvrage.date')?false:null"
                    :error="$errors->first('ouvrage.date')">
                </x-form::input>
            </div>

            <div class="form-group col-md-4 col-sm-12">
                <x-form::input
                    type="text"
                    label="Edition"
                    placeholder="Tome 2"
                    wire:model="ouvrage.edition"
                    :is-valid="$errors->has('ouvrage.edition')?false:null"
                    :error="$errors->first('ouvrage.edition')">
                </x-form::input>
            </div>
            <div class="form-group col-md-4 col-sm-12">
                <x-form::input
                    type="text"
                    label="Editeur"
                    placeholder="Maison d'édition"
                    wire:model="ouvrage.editeur"
                    :is-valid="$errors->has('ouvrage.editeur')?false:null"
                    :error="$errors->first('ouvrage.editeur')">
                </x-form::input>
            </div>
            <div class="form-group col-md-4 col-sm-12">
                <x-form::input
                    type="text"
                    label="Lieu"
                    placeholder="Ville d'édition"
                    wire:model="ouvrage.lieu"
                    :is-valid="$errors->has('ouvrage.lieu')?false:null"
                    :error="$errors->first('ouvrage.lieu')">
                </x-form::input>
            </div>

            <div class="form-group col-md-12 col-sm-12">
                <x-form::input
                    type="text"
                    label="Lien URL"
                    placeholder="Lien url du site"
                    wire:model="ouvrage.url"
                    :is-valid="$errors->has('ouvrage.url')?false:null"
                    :error="$errors->first('ouvrage.url')">
                </x-form::input>
            </div>

            <div class="form-group col-md-12 col-sm-12">
                <label for="">Description</label>
                <textarea rows="2" wire:model="ouvrage.resume" class="form-control"></textarea>

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
<x-adminlte-modal wire:ignore.self id="delete-ouvrage-modal" icon="fa fa-tag"
                  title="Suppression d'ouvrage">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <div>Êtes-vous sûr de vouloir supprimer cet ouvrage ?</div>
    <x-slot name="footerSlot">
        <x-adminlte-button wire:click="deleteOuvrage" type="button" theme="primary"
                           label="Supprimer"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>
