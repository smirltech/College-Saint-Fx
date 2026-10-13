@section('title')
     - option - {{$option->nom}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3"><span class="fas fa-fw fa-university mr-1"></span>Option</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('scolarite.options') }}">Options</a></li>
                <li class="breadcrumb-item active">{{$option->nom}}</li>
            </ol>
        </div>
    </div>

@stop
<div class="">
    @include('livewire.scolarite.options.modals.crud')

    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 col-sm-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="card-title">
                                <h4 class="m-0">{{$option->nom}}</h4>
                            </div>
                            <div class="card-tools">
                                @can('options.update', $option)
                                    <span
                                        title="Modifier" role="button" class="ml-2 mr-2" data-toggle="modal"
                                        data-target="#edit-option-modal">
                                        <span class="fa fa-pen"></span>
                                    </span>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Code : </b> <span class="float-right">{{ $option->code }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Option : </b> <span class="float-right">{{ $option->nom }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Section : </b> <span class="float-right"><a
                                            href="/scolarite/sections/{{ $option->section->id }}">{{ $option->section->nom }}</a></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">
                                    <h4 class="m-0">Classes</h4>
                                </div>
                                <div class="card-tools d-flex my-auto">
                                    {{-- <a href="{{ route('scolarite.classes.create') }}" title="ajouter"
                                        class="btn btn-primary mr-2"><span
                                             class="fa fa-plus"></span></a>--}}
                                </div>
                            </div>
                            <div class="card-body p-0 table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th style="width: 100px">CODE</th>
                                        <th>CLASSE</th>
                                        {{-- <th></th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($classes as $classe)
                                        <tr>
                                            <td>{{ $classe->code }}</td>
                                            <td>{{ $classe->niveau->label() }}</td>
                                            {{-- <td>
                                                 <div class="d-flex float-right">
                                                     <a href="/scolarite/classes/{{ $classe->id }}" title="Voir"
                                                        class="btn btn-warning">
                                                         <i class="fas fa-eye"></i>
                                                     </a>
                                                     <a href="/scolarite/classes/{{ $classe->id }}/edit" title="modifier"
                                                        class="btn btn-info  ml-2">
                                                         <i class="fas fa-pen"></i>
                                                     </a>
                                                     <button wire:click="deleteClasse({{ $classe->id }})"
                                                             title="supprimer" class="btn btn-danger ml-2">
                                                         <i class="fas fa-trash"></i>
                                                     </button>
                                                 </div>
                                             </td>--}}
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
