@php use App\Enums\ClasseNiveau;use App\Enums\Sexe; @endphp
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">{{$title}}</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('scolarite.enseignants.index') }}">Enseignants</a></li>
                <li class="breadcrumb-item active">{{$enseignant->nom}}</li>
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
                                <x-form::input wire:model="enseignant.nom"
                                               label="Nom"
                                               :isValid="$errors->has('enseignant.nom') ? false : null"
                                               error="{{$errors->first('enseignant.nom')}}"/>
                            </div>

                            <div class="form-group col-md-4">
                                <x-form::input wire:model="enseignant.telephone"
                                               label="Téléphone"
                                               :isValid="$errors->has('enseignant.telephone') ? false : null"
                                               error="{{$errors->first('enseignant.telephone')}}"/>
                            </div>

                            <div class="form-group col-md-4">
                                <x-form::input wire:model="enseignant.email"
                                               label="E-mail"
                                               type="email"
                                               :isValid="$errors->has('enseignant.email') ? false : null"
                                               error="{{$errors->first('enseignant.email')}}"/>
                            </div>


                            <div class="form-group col-md-4">
                                <x-form::select wire:model="enseignant.sexe"
                                                label="Sexe"
                                                :isValid="$errors->has('enseignant.sexe') ? false : null"
                                                error="{{$errors->first('enseignant.sexe')}}">
                                    @foreach(Sexe::cases() as $sexe)
                                        <option value="{{ $sexe }}">{{ $sexe }}</option>
                                    @endforeach
                                </x-form::select>
                            </div>
                            <div class="form-group col-md-4">
                                <x-form::input wire:model="enseignant.date_naissance"
                                               label="Date de naissance"
                                               type="date"
                                               :isValid="$errors->has('enseignant.date_naissance') ? false : null"
                                               error="{{$errors->first('enseignant.date_naissance')}}"/>
                            </div>
                            <div class="form-group col-md-4">
                                <x-form::input wire:model="enseignant.lieu_naissance"
                                               label="Lieu de naissance"
                                               :isValid="$errors->has('enseignant.lieu_naissance') ? false : null"
                                               error="{{$errors->first('enseignant.lieu_naissance')}}"/>
                            </div>
                            <div class="form-group col-md-4">
                                <x-form::input wire:model="enseignant.adresse"
                                               label="Adresse"
                                               :isValid="$errors->has('enseignant.adresse') ? false : null"
                                               error="{{$errors->first('enseignant.adresse')}}"/>
                            </div>

                            <div class="form-group col-md-4">
                                <x-form::select wire:model="enseignant.section_id"
                                                label="Section"
                                                :isValid="$errors->has('enseignant.section_id') ? false : null"
                                                error="{{$errors->first('enseignant.section_id')}}">
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
