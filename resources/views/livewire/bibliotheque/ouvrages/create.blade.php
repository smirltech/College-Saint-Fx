@section('title', $title)
@section('content_header')
    <div class="row mr-2 ml-2">
        <div class="col-6">
            <h1 class="ms-3">{{$title}}</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('bibliotheque') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('bibliotheque.ouvrages.index') }}">Ouvrages</a></li>
                <li class="breadcrumb-item active">{{$title}}</li>
            </ol>
        </div>
    </div>

@stop
<div class="content mt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body m-b-40">
                        <form wire:submit.prevent="submit">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <x-form::input
                                        required
                                        type="text"
                                        label="Titre"
                                        wire:model="ouvrage.titre">
                                    </x-form::input>
                                </div>

                                <div class="form-group col-md-6">
                                    <x-form::input.image
                                        label="Couverture"
                                        height="70"
                                        :cover="$cover"
                                        wire:model="cover"/>
                                </div>

                                <div class="form-group col-md-12">
                                    <x-form::input
                                        type="text"
                                        label="Sous Titre"
                                        wire:model="ouvrage.sous_titre">
                                    </x-form::input>
                                </div>

                                <div class="form-group col-md-6">
                                    <x-form::select
                                        label="Groupe"
                                        required
                                        placeholder="Choisir groupe"
                                        wire:model="ouvrage.rayon_id">
                                        @foreach ($categories as $es )
                                            <option value="{{$es->id}}">{{ $es->nom }}</option>
                                        @endforeach
                                    </x-form::select>
                                </div>

                                <div class="form-group col-md-6">
                                    <x-form::select
                                        label="Etiquettes"
                                        multiple
                                        placeholder="Choisir étiquettes"
                                        wire:model="ouvrage_tags">
                                        @foreach ($tags as $tag )
                                            <option value="{{$tag->id}}">{{ $tag->name }}</option>
                                        @endforeach
                                    </x-form::select>
                                </div>

                                <div class="form-group col-md-6">
                                    <x-form::select
                                        label="Auteurs"
                                        multiple
                                        placeholder="Choisir auteurs"
                                        wire:model="ouvrage_auteurs">
                                        @foreach ($auteurs as $auteur )
                                            <option value="{{$auteur->id}}">{{ $auteur->nom }}</option>
                                        @endforeach
                                    </x-form::select>
                                </div>

                                <div class="form-group col-md-6">
                                    <x-form::input
                                        type="date"
                                        label="Date"
                                        placeholder="Date d'édition">
                                    </x-form::input>
                                </div>

                                <div class="form-group col-md-4">
                                    <x-form::input
                                        label="Edition"
                                        placeholder="Tome 2"
                                        wire:model="ouvrage.edition">
                                    </x-form::input>
                                </div>
                                <div class="form-group col-md-4">
                                    <x-form::input
                                        label="Editeur"
                                        placeholder="Maison d'édition"
                                        wire:model="ouvrage.editeur">
                                    </x-form::input>
                                </div>
                                <div class="form-group col-md-4">
                                    <x-form::input
                                        label="Lieu"
                                        placeholder="Ville d'édition"
                                        wire:model="ouvrage.lieu">
                                    </x-form::input>
                                </div>

                                <div class="form-group col-md-12">
                                    <x-form::ckeditor
                                        label="Description"
                                        wire:model="ouvrage.resume"/>

                                </div>
                                <div class="form-group col-md-12">
                                    <x-form::input
                                        label="Lien URL"
                                        placeholder="Lien url du site"
                                        wire:model="ouvrage.url">
                                    </x-form::input>
                                </div>
                                <div class="form-group col-md-12">
                                    <x-form::input.pdf
                                        label="Fichier PDF"
                                        :media="$ouvrage->media"
                                        wire:model="ouvrage_pdf">
                                    </x-form::input.pdf>
                                </div>

                            </div>
                            <x-form::button.primary class="float-right mt-3" type="submit">
                                Soumettre
                            </x-form::button.primary>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
