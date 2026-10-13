@php use Carbon\Carbon; @endphp
@section('title')
    - Catégorie - {{$category->nom}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3"><span class="fas fa-fw fa-university mr-1"></span>Catégorie d'ouvrages</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('bibliotheque.rayons') }}">Catégories</a></li>
                <li class="breadcrumb-item active">{{$category->nom}}</li>
            </ol>
        </div>
    </div>

@stop
<div class="">
    @include('livewire.bibliotheque.rayons.modals.crud')

    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 col-sm-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="card-title">
                                <h4 class="m-0">{{$category->nom}}</h4>
                            </div>
                            <div class="card-tools">
                                @can('rayons.update',$category)
                                    <span
                                        title="Modifier" role="button" class="ml-2 mr-2" data-toggle="modal"
                                        data-target="#update-category-modal">
                                    <span class="fa fa-pen"></span>
                                </span>
                                @endcan

                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Groupe : </b> <span class="float-right">
                                        <a href="{{$category->groupe==null?'#':route('bibliotheque.rayons.show',[$category->groupe?->id])}}">{!! $category->groupe?->nom !!}</a>
                                    </span>
                                </li>
                                <li class="list-group-item">
                                    <b>Description : </b> <span class="float-right">{{ $category->description }}</span>
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
                                {{--  <li class="list-group-item">
                                      <b>Lecteurs : </b> <span class="float-right">0</span>
                                  </li>
                                  <li class="list-group-item">
                                      <b>Visites : </b> <span class="float-right">0</span>
                                  </li>
                                  <li class="list-group-item">
                                      <b>Dernière Visite : </b> <span class="float-right">date ici !(human read)</span>
                                  </li>--}}
                                <li class="list-group-item">
                                    <b>Ouvrages : </b> <span class="float-right">{{ $category->ouvragesCount }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Ouvrages Aggrégat : </b> <span
                                        class="float-right">{{ $category->ouvragesCountAggregate }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Sous Catégories : </b> <span
                                        class="float-right">{{$category->categories->count()}}</span>
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
                                       aria-selected="true">Ouvrages</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-categories-tab" data-toggle="pill"
                                       href="#custom-tabs-one-categories" role="tab"
                                       aria-controls="custom-tabs-one-categories" aria-selected="false">Sous
                                        Catégories</a>
                                </li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                <div class="tab-pane fade active show" id="custom-tabs-one-materiels" role="tabpanel"
                                     aria-labelledby="custom-tabs-one-materiels-tab">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead class="bg-primary">
                                            <tr>
                                                <th style="width: 50px">#</th>
                                                <th>TITRE</th>
                                                <th>SOUS TITRE</th>
                                                <th>RÉSUMÉ</th>
                                                <th style="width: 50px"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($category->ouvrages as $i=>$ouvrage)
                                                <tr>
                                                    <td>{{$i+1}}</td>
                                                    <td>{{$ouvrage->titre}}</td>
                                                    <td>{{$ouvrage->sous_titre}}</td>
                                                    <td>{{$ouvrage->resume}}</td>
                                                    <td>
                                                        <div class="d-flex float-right">
                                                            @can('ouvrages.view',$ouvrage)
                                                                <a href="{{$ouvrage->url}}"
                                                                   target=“_blank”
                                                                   title="Aller au lien"
                                                                   class="btn btn-default  mr-2">
                                                                    <i class="fas fa-globe"></i>
                                                                </a>
                                                            @endcan
                                                            @can('ouvrages.view',$ouvrage)
                                                                <a href="{{route('bibliotheque.ouvrages.show',[$ouvrage->id])}}"
                                                                   title="Voir"
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
                                <div class="tab-pane fade" id="custom-tabs-one-categories" role="tabpanel"
                                     aria-labelledby="custom-tabs-one-categories-tab">
                                    <div class="table-responsive">
                                        <table class="table">
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
                                            @foreach ($category->categories as $i=>$categ)
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
                                                            @can('rayons.delete',$categ)
                                                                <button title="Supprimer"
                                                                        class="btn btn-danger">
                                                                    <i class="fas fa-trash"></i>
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
