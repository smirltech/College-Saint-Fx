@php use Carbon\Carbon; @endphp
@section('title')
    - Auteur - {{$auteur->nom}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3"><span class="fas fa-fw fa-book-open-reader mr-1"></span>auteur</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('bibliotheque.auteurs') }}">Auteurs</a></li>
                <li class="breadcrumb-item active">{{$auteur->nom}}</li>
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
                                <h4 class="m-0">{{$auteur->fullName}}</h4>
                            </div>
                            <div class="card-tools">

                                {{--  @can('ouvrages.update',$ouvrage)
                                      <span
                                          title="Modifier" role="button" class="ml-2 mr-2" data-toggle="modal"
                                          data-target="#update-category-modal">
                                      <span class="fa fa-pen"></span>
                                  </span>
                                  @endcan
  --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Nom : </b> <span class="float-right">{{ $auteur->nom }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Prénom : </b> <span class="float-right">{{ $auteur->prenom }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Sexe : </b>
                                    <span class="float-right">{{ $auteur->sexe->label()}}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Ouvrages : </b>
                                    <span class="float-right">{{ $auteur->ouvragesCount}}</span>
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
                                                <th>TITRE</th>
                                                <th>SOUS TITRE</th>
                                                <th>CATEGORIE</th>
                                                <th>CO-AUTEURS</th>
                                                <th></th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($auteur->ouvrages as $i=>$ouvrage)
                                                <tr>
                                                    <td>{{ $i+1 }}</td>
                                                    <td>{{ $ouvrage->titre }}</td>
                                                    <td>{{ $ouvrage->sous_titre }}</td>
                                                    <td>
                                                        <a href="{{route('bibliotheque.rayons.show',[$ouvrage->rayon_id])}}">{{$ouvrage->categoryNom}}</a>
                                                    </td>
                                                    <td>
                                                        <div class="">
                                                            @foreach($ouvrage->auteurs->where('id', '!=', $auteur->id) as $author)
                                                                <a href="{{ route('bibliotheque.auteurs.show',$author->id) }}">
                                                                    <span
                                                                        class="badge badge-primary">{{ $author->fullName }}</span>
                                                                </a>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex float-right">
                                                            @can('ouvrages.view',$ouvrage)
                                                                <a href="{{route('bibliotheque.ouvrages.show',$ouvrage->id)}}"
                                                                   title="Voir"
                                                                   class="btn btn-outline-warning">
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
        </div>
    </div>
</div>
