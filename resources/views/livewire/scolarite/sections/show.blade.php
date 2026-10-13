@section('title')
     - section - {{$section->nom}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3"><span class="fas fa-fw fa-university mr-1"></span>Section</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('scolarite.sections') }}">Sections</a></li>
                <li class="breadcrumb-item active">{{$section->nom}}</li>
            </ol>
        </div>
    </div>

@stop
<div class="">
    @include('livewire.scolarite.sections.modals.crud')

    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 col-sm-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="card-title">
                                <h4 class="m-0">{{$section->nom}}</h4>
                            </div>
                            <div class="card-tools">
                                @can('sections.update', $section)
                                <span
                                    title="Modifier" role="button" class="ml-2 mr-2" data-toggle="modal"
                                    data-target="#edit-section-modal">
                                    <span class="fa fa-pen"></span>
                                </span>
                                @endcan

                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Code : </b> <span class="float-right">{{ $section->code }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Section : </b> <span class="float-right">{{ $section->nom }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Elèves : </b> <span class="float-right">{{ $section->inscriptions->count() }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 col-sm-12">
                    @if(count($section->options??[]) > 0)
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">
                                    <h4 class="m-0">Options</h4>
                                </div>
                                <div class="card-tools d-flex my-auto">
                                    @can('options.create')
                                    <button type="button"
                                            class="btn btn-primary  ml-2" data-toggle="modal"
                                            data-target="#add-option-modal"><span
                                            class="fa fa-plus"></span></button>
                                    @endcan
                                </div>
                            </div>

                            <div class="card-body table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th style="width: 200px">CODE</th>
                                        <th>OPTION</th>
                                        <th style="width: 50px"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($section->options as $option)
                                        <tr>
                                            <td>{{ $option->code }}</td>
                                            <td>{{ $option->nom }}</td>
                                            <td>
                                                <div class="d-flex float-right">
                                                    @can('options.view', $option)
                                                    <a href="/scolarite/options/{{ $option->id }}" title="Voir"
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
                    @endif
                    @if(count($classes) > 0)
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
                                        <th>ELEVES</th>
                                        {{-- <th></th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($classes as $classe)
                                        <tr>
                                            <td>{{ $classe->code }}</td>
                                            <td>{{ $classe->niveau->label() }}</td>
                                            <td>{{$classe->inscriptions->count()}}</td>
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
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
