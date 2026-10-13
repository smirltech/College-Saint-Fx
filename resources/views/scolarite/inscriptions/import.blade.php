@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">{{$title}}</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{route('scolarite.eleves.index')}}">Déliberations</a></li>
                <li class="breadcrumb-item active">{{$title}}</li>
            </ol>
        </div>
    </div>

@stop
<x-admin-layout>
    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="mb-3 card-body">
                            <form enctype="multipart/form-data" method="post"
                                  action="{{ route('scolarite.inscriptions.store') }}" class="container">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <x-form::select label="Année" required placeholder="Choisir année scolaire"
                                                        name="annee">
                                            @foreach($annees as $annee)
                                                <option value="{{$annee->nom}}">{{$annee->nom}}
                                                </option>
                                            @endforeach
                                        </x-form::select>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <x-form::select label="Section" required placeholder="Choisir section"
                                                        name="section">
                                            @foreach($annees as $annee)
                                                <option value="{{$annee->nom}}">{{$annee->nom}}
                                                </option>
                                            @endforeach
                                        </x-form::select>
                                    </div>


                                    <div class="form-group col-md-12">
                                        <x-form::input.xlsx required label="Fiche d identification"
                                                            name="fiche"/>
                                        <div class="mt-2">
                                            Veuillez télécharger le modèle <a
                                                href="{{asset("models/MATERNELLE-Table 1.xlsx")}}">ici</a>
                                        </div>
                                    </div>
                                </div>
                                <x-form::button type="submit" class="btn btn-primary float-end">Soumettre
                                </x-form::button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
