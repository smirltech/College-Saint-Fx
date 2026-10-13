@php  @endphp
@section('title')
    - Consommable - {{$consommable->nom}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3"><span class="fas fa-fw fa-university mr-1"></span>Consommable</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('logistique') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('logistique.consommables') }}">Consommables</a></li>
                <li class="breadcrumb-item active">{{$consommable->nom}}</li>
            </ol>
        </div>
    </div>

@stop
<div class="">
    @include('livewire.logistiques.fongibles.consommables.modals.crud')
    @include('livewire.logistiques.fongibles.consommables.modals.operation')

    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 col-sm-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="card-title">
                                <h4 class="m-0">{{$consommable->nom}}</h4>
                            </div>
                            <div class="card-tools">
                                @can('consommables.update', $consommable)
                                    <span
                                        title="Modifier" role="button" class="ml-2 mr-2" data-toggle="modal"
                                        data-target="#update-consommable-modal">
                                    <span class="fa fa-pen"></span>
                                </span>
                                @endcan

                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Description : </b> <span
                                        class="float-right">{{ $consommable->description }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Unité : </b> <span class="float-right">{{$consommable->unit->nom}}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Minimum : </b> <span
                                        class="float-right">{{$consommable->stock_minimum}} {{$consommable->unit->code}}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Niveau : </b> <span
                                        class="float-right">{{$consommable->alertText}}</span>
                                    <div class="progress mt-1" role="progressbar" aria-label="Example with label"
                                         aria-valuenow="{{$consommable->alertRate}}" aria-valuemin="0"
                                         aria-valuemax="100">
                                        <div class="progress-bar bg-{{$consommable->alertColor}}"
                                             style="width: {{$consommable->alertRate<0?0:$consommable->alertRate}}%">{{$consommable->alertRate}}
                                            %
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card card-{{$consommable->alertColorWithDefaultPrimary}} card-outline">

                        <div class="card-header">
                            <div class="ribbon-wrapper">
                                <div class="ribbon bg-{{$consommable->alertColorWithDefaultPrimary}}">
                                    {{$consommable->alertRate}} %
                                </div>
                            </div>
                            <div class="card-title">
                                <h5 class="">Résumé de Quantité</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Quantité Acquise : </b> <span
                                        class="float-right">{{$consommable->quantiteIn}} {{$consommable->unit->code}}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Quantité Consommée : </b> <span
                                        class="float-right">{{$consommable->quantiteOut}} {{$consommable->unit->code}}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Quantité : </b> <span
                                        class="float-right">{{$consommable->quantite}} {{$consommable->unit->code}}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-9 col-sm-12">
                    <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-one-mouvements-tab" data-toggle="pill"
                                       href="#custom-tabs-one-mouvements" role="tab"
                                       aria-controls="custom-tabs-one-mouvements"
                                       aria-selected="true">Operations</a>
                                </li>

                            </ul>
                        </div>

                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                <div class="tab-pane fade active show" id="custom-tabs-one-mouvements" role="tabpanel"
                                     aria-labelledby="custom-tabs-one-mouvements-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h4 class="m-0">Operation du consommable</h4>
                                            </div>
                                            <div class="card-tools">
                                                @can('operations.create')
                                                    <button
                                                        title="Ajouter" role="button"
                                                        class="btn btn-outline-primary ml-2 mr-2" data-toggle="modal"
                                                        data-target="#add-operation-modal">
                                                        <span class="fa fa-plus"></span>
                                                    </button>
                                                @endcan

                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th style="width: 50px">#</th>
                                                        <th>DATE</th>
                                                        <th>BÉNÉFICIAIRE</th>
                                                        <th>FACILITATEUR</th>
                                                        <th>ENTRÉE</th>
                                                        <th>SORTIE</th>
                                                        <th style="width: 50px"></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($consommable->operations as $i=>$operation)
                                                        <tr>
                                                            <td>{{$i+1}}</td>
                                                            <td>{{$operation->dateFormatted}}</td>
                                                            <td>{{$operation->beneficiaire}}</td>
                                                            <td>{{$operation->facilitateur->name}}</td>
                                                            <td>{{$operation->direction==\App\Enums\MouvementStatus::in?$operation->quantite.' '. $consommable->unit->code:''}}
                                                            </td>
                                                            <td>{{$operation->direction==\App\Enums\MouvementStatus::out?$operation->quantite.' '. $consommable->unit->code:''}}
                                                            </td>
                                                            <td>
                                                                <div class="d-flex float-right">
                                                                    @can('operations.update', $operation)
                                                                        <button
                                                                            wire:click="getSelectedOperation({{$operation}})"
                                                                            type="button"
                                                                            title="Modifier"
                                                                            class="btn btn-warning  ml-4"
                                                                            data-toggle="modal"
                                                                            data-target="#update-operation-modal">
                                                                            <span class="fa fa-edit"></span>
                                                                        </button>
                                                                    @endcan
                                                                    @can('operations.delete', $operation)
                                                                        <button
                                                                            wire:click="getSelectedOperation({{$operation}})"
                                                                            type="button"
                                                                            title="Supprimer"
                                                                            class="btn btn-danger  ml-4"
                                                                            data-toggle="modal"
                                                                            data-target="#delete-operation-modal">
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
            </div>
        </div>
    </div>
</div>
