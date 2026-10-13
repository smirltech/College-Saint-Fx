@php use Carbon\Carbon; @endphp
@section('title')
    - Ouvrage - {{$ouvrage->titre}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3"><span class="fas fa-fw fa-university mr-1"></span>ouvrage</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('bibliotheque') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('bibliotheque.ouvrages.index') }}">Ouvrages</a></li>
                <li class="breadcrumb-item active">{{$ouvrage->titre}}</li>
            </ol>
        </div>
    </div>

@stop
<div class="">
    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 col-sm-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="card-title">
                                <h4 class="m-0">{{$ouvrage->titre}}</h4>
                            </div>
                            <div class="card-tools">
                                @can('ouvrages.update',$ouvrage)
                                    <a href="{{ route('bibliotheque.ouvrages.edit',$ouvrage) }}">
                                        <span class="fa fa-pen"></span>
                                    </a>
                                @endcan

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <img style="max-height: 200px" class="img-fluid"
                                     src="{{asset('storage/images/ouvrages/'.$ouvrage->id.'.png')}}"
                                     alt="couverture ouvrage"
                                     data-toggle="modal"
                                     data-target="#view-image"
                                >
                            </div>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Sous Titre : </b> <span class="float-right">{{ $ouvrage->sous_titre }}</span>
                                </li>
                                <li class="list-group-item container">
                                    <b>Catégorie : </b> <span class="float-right">
                                        <a href="{{$ouvrage->category==null?'#':route('bibliotheque.rayons.show',[$ouvrage->rayon_id])}}">{!! $ouvrage->categoryNom !!}</a>
                                    </span>
                                </li>
                                <li class="list-group-item">
                                    <b>Lien : </b> <span class="float-right">
                                        <a wire:click.debounce="addLecture" href="{{$ouvrage->url}}"
                                           target=“_blank”
                                           title="Aller au lien">
                                                        <i>Lire ici</i>
                                                    </a>
                                    </span>
                                </li>
                                <li class="list-group-item">
                                    <b>Résumé : </b>
                                    <div>{!! $ouvrage->resume !!}</div>
                                </li>
                                <li class="list-group-item">
                                    <b>Édition : </b> <span class="float-right">{{ $ouvrage->edition }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Lieu : </b> <span class="float-right">{{ $ouvrage->lieu }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Éditeur : </b> <span class="float-right">{{ $ouvrage->editeur }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Date : </b> <span
                                        class="float-right">{{ Carbon::parse($ouvrage->date)->format('d-m-Y') }}</span>
                                </li>
                                <li class="list-group-item">
                                    <div>
                                        <b>Auteurs : </b>
                                    </div>
                                    <div class=" wrapper p-2">
                                        @foreach($ouvrage->auteurs as $auteur)
                                            <span class="badge badge-warning m-1 text-xs">
                                            {{$auteur->nom}}
                                            </span>
                                        @endforeach
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div>
                                        <b>Étiquettes : </b>
                                    </div>
                                    <div class=" wrapper p-2">
                                        @foreach($ouvrage->tags as $ouvrage_etiquette)
                                            <span class="badge badge-info m-1 text-xs">
                                        {{$ouvrage_etiquette->nom}}
                                        </span>
                                        @endforeach
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="card-title">
                                <h5 class="">Statistiques</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Lecteurs : </b> <span
                                        class="float-right">{{number_format($ouvrage->uniqueLecturesCount)}}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Visites : </b> <span
                                        class="float-right">{{number_format($ouvrage->lecturesCount)}}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Dernière Visite : </b> <span
                                        class="float-right">{{$ouvrage->latestVisit?->whenRead}}</span>
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
                                    <a class="nav-link active" id="custom-tabs-one-materiels-tab" data-toggle="pill"
                                       href="#custom-tabs-one-materiels" role="tab"
                                       aria-controls="custom-tabs-one-materiels"
                                       aria-selected="true">Visites</a>
                                </li>
                                {{-- <li class="nav-item">
                                     <a class="nav-link" id="custom-tabs-one-rayons-tab" data-toggle="pill"
                                        href="#custom-tabs-one-rayons" role="tab"
                                        aria-controls="custom-tabs-one-rayons" aria-selected="false">Auteurs</a>
                                 </li>--}}
                            </ul>
                        </div>

                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                <div class="tab-pane fade active show" id="custom-tabs-one-materiels" role="tabpanel"
                                     aria-labelledby="custom-tabs-one-materiels-tab">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th style="width: 50px">#</th>
                                                <th>VISITEUR</th>
                                                <th>ROLE</th>
                                                <th>DATE</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($ouvrage->lectures as $i=>$lecture)
                                                <tr>
                                                    <td>{{ $i+1 }}</td>
                                                    <td>{{ $lecture->user->name }}</td>
                                                    <td>{{ $lecture->user->roleName }}</td>
                                                    <td>{{ $lecture->whenRead }}</td>

                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{--  <div class="tab-pane fade" id="custom-tabs-one-rayons" role="tabpanel"
                                       aria-labelledby="custom-tabs-one-rayons-tab">
                                      <div class="table-responsive">
                                          --}}{{--<table class="table">
                                              <thead>
                                              <tr>
                                                  <th style="width: 50px">#</th>
                                                  <th>CATÉGORIE</th>
                                                  <th>DESCRIPTION</th>
                                                  <th>OUVRAGES</th>
                                                  <th>AGGRÉGAT</th>
                                                  <th style="width: 50px"></th>
                                              </tr>
                                              </thead>
                                              <tbody>
                                              @foreach ($category->rayons as $i=>$categ)
                                                  <tr>
                                                      <td>{{ $i+1 }}</td>
                                                      <td>
                                                          <a href="{{route('bibliotheque.rayons.show',[$categ->id])}}">{!! $categ->nom !!}</a>
                                                      </td>
                                                      <td>{{ $categ->description }}</td>
                                                      <td>{{ $categ->ouvragesCount }}</td>
                                                      <td>{{ $categ->ouvragesCountAggregate }}</td>
                                                      <td>
                                                          <div class="d-flex float-right">
                                                              <button title="Supprimer"
                                                                      class="btn btn-danger">
                                                                  <i class="fas fa-trash"></i>
                                                              </button>

                                                          </div>
                                                      </td>
                                                  </tr>
                                              @endforeach
                                              </tbody>
                                          </table>--}}{{--
                                      </div>
                                  </div>
                             --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
