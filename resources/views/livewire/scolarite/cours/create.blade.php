@php use App\Enums\ClasseNiveau; @endphp
@section('title')
    - ajouter cours
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Ajouter un cours</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('scolarite.cours.index') }}">Cours</a></li>
                <li class="breadcrumb-item active">Nouvelle Classe</li>
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
                            <div class="form-group col-md-6">
                                <x-form::input placeholder="Saisir le nom du cours"
                                               wire:model="cours.nom"
                                               label="Nom du cours"
                                               :isValid="$errors->has('cours.nom') ? false : null"
                                               error="{{$errors->first('cours.nom')}}"/>
                            </div>
                            <div class="form-group col-md-6">
                                <x-form::select wire:model="cours.section_id"
                                                label="Section"
                                                :isValid="$errors->has('cours.section_id') ? false : null"
                                                error="{{$errors->first('cours.section_id')}}">
                                    <option value="">Selectionner une section</option>
                                    @foreach($sections as $section)
                                        <option value="{{$section->id}}">{{$section->nom}}</option>
                                    @endforeach
                                </x-form::select>
                            </div>


                            <div class="form-group col-md-12">
                                <x-form::textarea rows="5"
                                                  placeholder="Saisir la description du cours"
                                                  wire:model="cours.description"
                                                  label="Description du cours"
                                                  :isValid="$errors->has('cours.description') ? false : null"
                                                  error="{{$errors->first('cours.description')}}"/>


                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Soumettre</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
