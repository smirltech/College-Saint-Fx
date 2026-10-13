@section('title')
    Liste de filières
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Liste de filières</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Filières</li>
            </ol>
        </div>
    </div>

@stop
<div class="">


    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">

                            </div>
                            <div class="card-tools d-flex my-auto">
                                @can('filieres.create')
                                    <button type="button"
                                            class="btn btn-primary  ml-2" data-toggle="modal"
                                            data-target="#add-filiere-modal"><span
                                            class="fa fa-plus"></span></button>
                                @endcan
                            </div>
                        </div>

                        <div class="card-body p-0 table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th style="width: 100px">CODE</th>
                                    <th>FILIERE</th>
                                    <th>OPTION</th>
                                    <th>DESCRIPTION</th>
                                    <th style="width: 100px"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($filieres as $filiere)
                                    <tr>
                                        <td>{{ $filiere->code }}</td>
                                        <td>{{ $filiere->nom }}</td>
                                        <td>
                                            <a href="/scolarite/options/{{ $filiere->option->id }}">{{ $filiere->option->nom }}</a>
                                        </td>
                                        <td>{{ $filiere->description }}</td>
                                        <td>
                                            <div class="d-flex float-right">
                                                @can('filieres.view',$filieres)
                                                    <a href="/scolarite/filieres/{{ $filiere->id }}" title="Voir"
                                                       class="btn btn-warning">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endcan
                                                @can('filieres.update',$filieres)
                                                    <button wire:click="getSelectedFiliere({{$filiere}})" type="button"
                                                            title="Modifier" class="btn btn-info  ml-2"
                                                            data-toggle="modal"
                                                            data-target="#edit-filiere-modal">
                                                        <span class="fa fa-pen"></span>
                                                    </button>
                                                @endcan
                                                @can('filieres.delete',$filieres)
                                                    <button wire:click="getSelectedFiliere({{$filiere}})" type="button"
                                                            title="supprimer" class="btn btn-danger  ml-2"
                                                            data-toggle="modal"
                                                            data-target="#delete-filiere-modal">
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
