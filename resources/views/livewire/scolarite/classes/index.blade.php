@php use App\Models\Option; @endphp
@php use App\Models\Section; @endphp
@section('title')
    - classes
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3"><span class="fas fa-fw fa-people-roof"></span> Liste de classes</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Classes</li>
            </ol>
        </div>
    </div>

@stop
<div class="">
    @include('livewire.scolarite.classes.modals.delete')
    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">

                            <div class="card-title">
                            </div>
                            <div class="card-tools d-flex my-auto">
                                @can('classes.create')
                                    <button onclick="showModal('scolarite.classe.classe-edit-component')" title="ajouter"
                                       class="btn mr-2" style="background-color: #0c84ff; color: white"><span
                                                class="fa fa-plus"></span></button>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body p-0 table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>NO.</th>
                                    <th>CODE</th>
                                    <th>OPTION</th>
                                    <th>ELEVES</th>
                                    <th>PRESENCES</th>
                                    <th>ENSEIGNANTS</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($classes as $classe)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $classe->code }}</td>
                                        <td>

                                            <a href="{{$classe->parent_url}}">{{ $classe->parent->nom }}</a>
                                        </td>
                                        <td>
                                            {{$classe->inscriptions->count()}}
                                        </td>
                                       <td>
                                            {{$classe->presences()->sum('total')}}
                                        </td>
                                        <td>
                                            {{$classe->enseignants->count()}}
                                        </td>
                                        <td>
                                            <div class="d-flex float-right">
                                                @can('classes.view',$classe)
                                                    <a href="/scolarite/classes/{{ $classe->id }}" title="Voir"
                                                       class="btn btn-warning btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endcan
                                                @can('classes.update',$classe)
                                                    <a href="/scolarite/classes/{{ $classe->id }}/edit" title="modifier"
                                                       class="btn btn-info  btn-sm ml-2">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                @endcan
                                                @can('classes.delete',$classe)
                                                    <button wire:click="getSelectedClasse({{$classe->id }})"
                                                            type="button"
                                                            title="supprimer" class="btn btn-danger btn-sm  ml-2"
                                                            data-toggle="modal"
                                                            data-target="#delete-classe">
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
