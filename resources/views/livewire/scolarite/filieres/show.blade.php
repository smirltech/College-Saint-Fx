@section('title')
    - filière - {{$filiere->nom}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3"><span class="fas fa-fw fa-university mr-1"></span>Filière</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('scolarite.filieres') }}">Filières</a></li>
                <li class="breadcrumb-item active">{{$filiere->nom}}</li>
            </ol>
        </div>
    </div>

@stop
<div class="">
    @include('livewire.scolarite.filieres.modals.crud')

    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 col-sm-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="card-title">
                                <h4 class="m-0">{{$filiere->nom}}</h4>
                            </div>
                            <div class="card-tools">
                                @can('filieres.update', $filiere)
                                    <span
                                        title="Modifier" role="button" class="ml-2 mr-2" data-toggle="modal"
                                        data-target="#edit-filiere-modal">
                                    <span class="fa fa-pen"></span>
                                </span>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Code : </b> <span class="float-right">{{ $filiere->code }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Filière : </b> <span class="float-right">{{ $filiere->nom }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Option : </b> <span class="float-right">  <a
                                            href="/scolarite/options/{{ $filiere->option->id }}">{{ $filiere->option->nom }}</a></span>
                                </li>
                                <li class="list-group-item">
                                    <b>Section : </b> <span class="float-right">  <a
                                            href="/scolarite/sections/{{ $filiere->option->section->id }}">{{ $filiere->option->section->nom }}</a></span>
                                </li>
                            </ul>
                            <div class="mt-4">
                                <label>Description : </label>
                                {{ $filiere->description }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="m-0">Classes</h3>
                            </div>
                            <div class="card-tools d-flex my-auto">
                                @can('classes.create')
                                    <button type="button"
                                            class="btn btn-primary  ml-2" data-toggle="modal"
                                            data-target="#add-classe-modal"><span
                                            class="fa fa-plus"></span></button>
                                @endcan
                            </div>
                        </div>

                        <div class="card-body table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th style="width: 200px">CODE</th>
                                    <th>CLASSE</th>
                                    <th style="width: 100px"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($filiere->classes as $classe)
                                    <tr>
                                        <td>{{ $classe->code }}</td>
                                        <td>{{ $classe->niveau->label() }}</td>
                                        <td>
                                            @can('classes.view', $classe)
                                                <div class="d-flex float-right">
                                                    <a href="/scolarite/classes/{{ $classe->id }}" title="Voir"
                                                       class="btn btn-warning">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
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
