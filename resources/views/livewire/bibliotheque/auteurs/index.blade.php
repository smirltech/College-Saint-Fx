@section('title')
    - auteurs
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Liste d'auteurs</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Auteurs</li>
            </ol>
        </div>
    </div>

@stop
<div wire:ignore.self class="">
    @include('livewire.bibliotheque.auteurs.modals.crud')
    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">

                            </div>
                            <div class="card-tools d-flex my-auto">
                                @can('auteurs.create')
                                    <button type="button"
                                            class="btn btn-primary  ml-2" data-toggle="modal"
                                            data-target="#add-auteur-modal"><span
                                            class="fa fa-plus"></span></button>
                                @endcan
                            </div>
                        </div>

                        <div class="card-body m-b-40">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="bg-primary">
                                    <tr>
                                        <th style="width: 50px">#</th>
                                        <th>NOM</th>
                                        <th>PRENOM</th>
                                        <th>SEXE</th>
                                        <th>OUVRAGES</th>
                                        <th style="width: 50px"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($auteurs as $i=>$auteur)
                                        <tr>
                                            <td>{{$i+1}}</td>
                                            <td>{{$auteur->nom}}</td>
                                            <td>{{$auteur->prenom}}</td>
                                            <td>{{$auteur->sexe->label()}}</td>
                                            <td>{{$auteur->ouvragesCount}}</td>
                                            <td>
                                                <div class="d-flex float-right">
                                                    @can('auteurs.view',$auteur)
                                                        <a href="{{route('bibliotheque.auteurs.show',$auteur->id)}}"
                                                           title="Voir"
                                                           class="btn btn-outline-warning">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    @endcan
                                                    @can('auteurs.update',$auteur)
                                                        <button wire:click="getSelectedAuteur({{$auteur}})"
                                                                type="button"
                                                                title="Modifier" class="btn btn-info  ml-2"
                                                                data-toggle="modal"
                                                                data-target="#update-auteur-modal">
                                                            <span class="fa fa-pen"></span>
                                                        </button>
                                                    @endcan
                                                    @can('auteurs.delete',$auteur)
                                                        <button wire:click="getSelectedAuteur({{$auteur}})"
                                                                type="button"
                                                                title="supprimer" class="btn btn-danger  ml-2"
                                                                data-toggle="modal"
                                                                data-target="#delete-auteur-modal">
                                                            <span class="fa fa-trash"></span>
                                                        </button>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

