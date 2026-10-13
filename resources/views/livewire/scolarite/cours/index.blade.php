@php use App\Models\Option; @endphp
@php use App\Models\Section; @endphp
@section('title')
    - Cours
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Liste de cours</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Cours</li>
            </ol>
        </div>
    </div>

@stop
<div class="">
    @include('livewire.scolarite.cours.modals.delete')
    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                            </div>
                            <div class="card-tools d-flex my-auto">
                                @can('cours.create')
                                    <a href="{{ route('scolarite.cours.create') }}" title="ajouter"
                                       class="btn btn-primary mr-2"><span
                                                class="fa fa-plus"></span></a>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body p-0 table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>NO.</th>
                                    <th>NOM</th>
                                    <th>SECTION</th>
                                    <th>DESCRIPTION</th>

                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($cours as $k=>$c)
                                    <tr>
                                        <td>{{ $k+1 }}</td>
                                        <td>{{ $c->nom }}</td>
                                        <td>
                                            {{ $c->section->nom }}
                                        </td>
                                        <td>
                                            {{ Str::limit($c->description, 50) }}
                                        </td>

                                        <td>
                                            <div class="d-flex float-right">
                                                @can('cours.update',$c)
                                                    <a href="/scolarite/cours/{{ $c->id }}/edit" title="modifier"
                                                       class="btn btn-outline-info  ml-2">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                @endcan
                                                @can('cours.delete',$c)
                                                    <button wire:click="getSelectedCours({{$c->id }})" type="button"
                                                            title="supprimer" class="btn btn-outline-danger  ml-2"
                                                            data-toggle="modal"
                                                            data-target="#delete-cours">
                                                        <span class="fa fa-trash"></span>
                                                    </button>
                                                @endcan
                                                {{-- <button wire:click="deleteCours({{ $c->id }})"
                                                         title="supprimer" class="btn btn-outline-danger ml-2">
                                                     <i class="fas fa-trash"></i>
                                                 </button>--}}
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
