{{--@section('title')
     - années scolaires
@endsection--}}
{{--@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3"><span class="fas fa-fw fa-calendar-alt"></span>{{$title}}</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item active">{{$title}}</li>
            </ol>
        </div>
    </div>

@stop--}}
<x-slot name="contentHeaderToolSlot">
    <ol class="breadcrumb float-right">
        <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
        <li class="breadcrumb-item active">{{$title}}</li>
    </ol>
</x-slot>
<div class="">
    @include('livewire.scolarite.annees.modals.crud')
    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                            </div>
                            <div class="card-tools d-flex my-auto">
                                @can('annees.create')
                                    <button type="button" class="btn"
                                            style="background-color: #0c84ff; color: #ffffff;"
                                            data-toggle="modal"
                                            data-target="#add-annee-modal">
                                    <span
                                        class="fa fa-plus"></span></button>
                                @endcan
                            </div>
                        </div>

                        <div class="card-body p-0 table-responsive">
                            <table class="table table-striped-columns table-hover">
                                <thead class="bg-primary">
                                <tr>
                                    <th style="width: 50px">#</th>
                                    <th>Année Scolaire</th>
                                    <th>Date Debut</th>
                                    <th>Date Fin</th>
                                    <th style="width: 100px">État</th>
                                    <th style="width: 50px"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($annees as $i=>$annee)
                                    <tr>
                                        <td>{{ $i+1}}</td>
                                        <td>{{ $annee->nom}}</td>
                                        <td>{{ $annee->datedebut()->format('d-m-Y')}}</td>
                                        <td>{{  $annee->datefin()->format('d-m-Y')}}</td>
                                        <td>
                                            @if($annee->encours)
                                                <span class="badge badge-success p-1">EN COURS</span>
                                            @else
                                                @can('annees.encours')
                                                    <button title="Metter en cours"
                                                            wire:click="setAnneeEnCours({{ $annee->id }})"
                                                            class="btn btn-warning btn-sm mr-2">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                @endcan
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex float-right">
                                                @can('annees.update',$annee)
                                                    <button wire:click="getSelectedAnnee({{ $annee->id }})"
                                                            type="button"
                                                            title="Modifier"
                                                            class="btn btn-info btn-sm" data-toggle="modal"
                                                            data-target="#edit-annee-modal">
                                                        <i class="fas fa-pen"></i></button>
                                                @endcan
                                                @if (!$annee->encours)
                                                    @can('annees.delete',$annee)
                                                        <button title="Supprimer"
                                                                wire:click="getSelectedAnnee({{ $annee->id }})"
                                                                class="btn btn-danger btn-sm ml-1"
                                                                data-toggle="modal"
                                                                data-target="#delete-annee-modal">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    @endcan
                                                @endif

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



