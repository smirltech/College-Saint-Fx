@php  @endphp
@section('title')
    Matériel - {{$materiel->nom}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3"><span class="fas fa-fw fa-university mr-1"></span>Matériel</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('logistique') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('logistique.materiels') }}">Matériels</a></li>
                <li class="breadcrumb-item active">{{$materiel->nom}}</li>
            </ol>
        </div>
    </div>

@stop
<div class="">
    @include('livewire.logistiques.non_fongibles.materiels.modals.crud')
    @include('livewire.logistiques.non_fongibles.materiels.modals.mouvement')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="card-title">
                                <h4 class="m-0">{{$materiel->nom}}</h4>
                            </div>
                            <div class="card-tools">
                                @can('materiels.view', $materiel)
                                    <span
                                        title="Modifier" role="button" class="ml-2 mr-2" data-toggle="modal"
                                        data-target="#update-materiel-modal">
                                    <span class="fa fa-pen"></span>
                                </span>
                                @endcan

                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Catégorie : </b> <span class="float-right">
                                        <a href="{{route('logistique.categories.show',[$materiel->categoryId])}}">{!! $materiel->categoryNom !!}</a>
                                    </span>
                                </li>
                                <li class="list-group-item">
                                    <b>Description : </b> <span class="float-right">{{ $materiel->description }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>État : </b> <span class="float-right">{{$materiel->status->label()}}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Direction : </b> <span
                                        class="float-right badge badge-{{$materiel->direction?->color()}}">{{$materiel->direction?->label()}}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="card-title">
                                <h5 class="">Résumé Financier</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Valeur Initiale : </b> <span class="float-right">{{number_format($materiel->montant, 2)}} Fc</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Année Mise en Service : </b> <span
                                        class="float-right">{{$materiel->dateFormatted}}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Durée de Vie : </b> <span class="float-right">{{$materiel->vie}} ans</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Vie Consommée : </b> <span
                                        class="float-right">{{$materiel->vieConsommee}} ans</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Vie Restante : </b> <span
                                        class="float-right">{{$materiel->vieRestante}} ans</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Methode d'Amortissement : </b> <span class="float-right">Linéaire</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Taux d'Amortissement : </b> <span class="float-right">{{number_format($materiel->amortissementTaux, 2)}} %</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Amortissement Annuelle : </b> <span class="float-right">{{number_format($materiel->amortissement, 2)}} Fc</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Amortissement Cumulé : </b> <span class="float-right">{{number_format($materiel->amortissementCumule, 2)}} Fc</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Valeur Résiduelle : </b> <span class="float-right">{{number_format($materiel->valeurResiduelle, 2)}} Fc</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-one-mouvements-tab" data-toggle="pill"
                                       href="#custom-tabs-one-mouvements" role="tab"
                                       aria-controls="custom-tabs-one-mouvements"
                                       aria-selected="true">Mouvements</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-amortissement-tab" data-toggle="pill"
                                       href="#custom-tabs-one-amortissement" role="tab"
                                       aria-controls="custom-tabs-one-amortissement"
                                       aria-selected="false">Amortissement</a>
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
                                                <h4 class="m-0">Mouvements du matériel</h4>
                                            </div>
                                            <div class="card-tools">
                                                @can('mouvements.create')
                                                    <button
                                                        title="Ajouter" role="button"
                                                        class="btn btn-outline-primary ml-2 mr-2" data-toggle="modal"
                                                        data-target="#add-mouvement-modal">
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
                                                        <th>DIRECTION</th>
                                                        <th>ÉTAT</th>
                                                        <th style="width: 50px"></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($materiel->mouvements as $i=>$mouvement)
                                                        <tr>
                                                            <td>{{$i+1}}</td>
                                                            <td>{{$mouvement->dateFormatted}}</td>
                                                            <td>{{$mouvement->beneficiaire}}</td>
                                                            <td>{{$mouvement->facilitateur->name}}</td>
                                                            <td><span
                                                                    class="badge badge-{{$mouvement->direction->color()}}">{{$mouvement->direction->label()}}</span>
                                                            </td>
                                                            <td>{{$mouvement->materiel_status->label()}}</td>
                                                            <td>
                                                                <div class="d-flex float-right">
                                                                    @can('mouvements.update', $mouvement)
                                                                        <button
                                                                            wire:click="getSelectedMouvement({{$mouvement}})"
                                                                            type="button"
                                                                            title="Modifier"
                                                                            class="btn btn-warning  ml-4"
                                                                            data-toggle="modal"
                                                                            data-target="#update-mouvement-modal">
                                                                            <span class="fa fa-edit"></span>
                                                                        </button>
                                                                    @endcan
                                                                    @can('mouvements.delete', $mouvement)
                                                                        <button
                                                                            wire:click="getSelectedMouvement({{$mouvement}})"
                                                                            type="button"
                                                                            title="Supprimer"
                                                                            class="btn btn-danger  ml-4"
                                                                            data-toggle="modal"
                                                                            data-target="#delete-mouvement-modal">
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
                                <div class="tab-pane fade" id="custom-tabs-one-amortissement" role="tabpanel"
                                     aria-labelledby="custom-tabs-one-amortissement-tab">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th style="width: 50px">#</th>
                                                <th>ANNÉE</th>
                                                <th>AMORTISSEMENT</th>
                                                <th>CUMULÉ</th>
                                                <th>RÉSIDU</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($materiel->genererTableAmortissements() as $i=>$amo)
                                                <tr class="@if(!$amo->atteint) table-secondary text-info @endif">
                                                    <td>{{$i+1}}</td>
                                                    <td>{{$amo->annee}}</td>
                                                    <td>{{number_format($amo->amortissement, 2)}} Fc</td>
                                                    <td>{{number_format($amo->amortissementCumul, 2)}} Fc</td>
                                                    <td>{{number_format($amo->residu, 2)}} Fc</td>

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
