@php use App\Enums\ClasseNiveau;use App\Enums\Sexe; @endphp
@section('title',$title)
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">{{$title}}</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('scolarite.enseignants.index') }}">Enseignants</a></li>
                <li class="breadcrumb-item active">Nouvel enseignant</li>
            </ol>
        </div>
    </div>

@stop
<div class="">
    <div class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    {{--  <x-form::validation-errors class="mb-4" :errors="$errors"/>--}}
                    <form wire:submit.prevent="submit">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <x-form::input
                                        required
                                        wire:model="enseignant.nom"
                                        label="Nom"/>
                            </div>

                            <div class="form-group col-md-4">
                                <x-form::input
                                        wire:model="enseignant.telephone"
                                        label="Téléphone"/>
                            </div>

                            <div class="form-group col-md-4">
                                <x-form::input
                                        wire:model="enseignant.email"
                                        label="E-mail"
                                        type="email"/>
                            </div>


                            <div class="form-group col-md-4">
                                <x-form::select
                                        wire:model="enseignant.sexe"
                                        label="Sexe">
                                    @foreach(Sexe::cases() as $sexe)
                                        <option value="{{ $sexe }}">{{ $sexe->label() }}</option>
                                    @endforeach
                                </x-form::select>
                            </div>
                            <div class="form-group col-md-4">
                                <x-form::input
                                        wire:model="enseignant.date_naissance"
                                        label="Date de naissance"
                                        type="date"/>
                            </div>
                            <div class="form-group col-md-4">
                                <x-form::input
                                        wire:model="enseignant.lieu_naissance"
                                        label="Lieu de naissance"/>
                            </div>
                            <div class="form-group col-md-4">
                                <x-form::input
                                        wire:model="enseignant.adresse"
                                        label="Adresse"/>
                            </div>

                            <div class="form-group col-md-4">
                                <x-form::select
                                        required
                                        wire:model="enseignant.section_id"
                                        label="Section">
                                    @foreach($sections as $section)
                                        <option value="{{ $section->id }}">{{ $section->nom }}</option>
                                    @endforeach
                                </x-form::select>
                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary">Soumettre</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
