@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Liste d'ouvrages </h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('bibliotheque') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Ouvrages</li>
            </ol>
        </div>
    </div>

@stop
<div wire:ignore.self class="">
    @include('livewire.bibliotheque.ouvrages.modals.crud')
    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">

                            </div>
                            <div class="card-tools d-flex my-auto">
                                @can('ouvrages.create')
                                    <a href="{{ route('bibliotheque.ouvrages.create') }}"
                                       {{--   wire:click="$emit('showModal', 'bibliotheque.ouvrage.ouvrage-create-component')"--}}
                                       class="btn btn-primary  ml-2"><span
                                            class="fa fa-plus"></span></a>
                                @endcan
                            </div>
                        </div>

                        <div class="card-body m-b-40">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="bg-primary">
                                    <tr>
                                        <th style="width: 50px">#</th>
                                        <th></th>
                                        <th>TITRE</th>
                                        <th>SOUS TITRE</th>
                                        <th>CATÉGORIE</th>
                                        <th>LECTEURS</th>
                                        <th>VISITES</th>
                                        <th>DERNIÈRE</th>
                                        <th style="width: 50px"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($ouvrages as $ouvrage)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td><img width="50" src="{{$ouvrage->imageUrl}}"></td>
                                            <td>{{$ouvrage->titre}}</td>
                                            <td>{{$ouvrage->sous_titre}}</td>
                                            <td>
                                                <a href="{{route('bibliotheque.rayons.show',[$ouvrage->rayon_id])}}">{{$ouvrage->categoryNom}}</a>
                                            </td>
                                            <td>{{number_format($ouvrage->uniqueLecturesCount)}}</td>
                                            <td>{{number_format($ouvrage->lecturesCount)}}</td>
                                            <td>{{$ouvrage->latestVisit?->whenRead}}</td>
                                            <td>
                                                <div class="d-flex float-right">
                                                    @if($ouvrage->url)
                                                        <a wire:click.debounce="addLecture('{{$ouvrage->id}}')"
                                                           href="{{$ouvrage->url}}"
                                                           target=“_blank”
                                                           title="Aller au lien"
                                                           class="btn btn-default  mr-2">
                                                            <i class="fas fa-globe"></i>
                                                        </a>
                                                    @endif

                                                    @if($ouvrage->hasPdf())
                                                        <a wire:click.debounce="addLecture('{{$ouvrage->id}}')"
                                                           href="{{ route('bibliotheque.ouvrages.read',$ouvrage) }}"
                                                           target=“_blank”
                                                           title="Aller au lien"
                                                           class="btn btn-outline-primary  mr-2">
                                                            <i class="fas fa-file-pdf"></i>
                                                        </a>
                                                    @endif

                                                    @can('ouvrages.view',$ouvrage)
                                                        <a href="{{route('bibliotheque.ouvrages.show',$ouvrage->id)}}"
                                                           title="Voir"
                                                           class="btn btn-outline-warning">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    @endcan
                                                    @can('ouvrages.update',$ouvrage)
                                                        <a href="{{ route('bibliotheque.ouvrages.edit',$ouvrage) }}"
                                                           type="button"
                                                           title="Modifier" class="btn btn-outline-info  ml-2">
                                                            <span class="fa fa-pen"></span>
                                                        </a>
                                                    @endcan
                                                    {{--  @can('ouvrages.delete',$ouvrage)
                                                      <button wire:click="getSelectedOuvrage({{$ouvrage}})"
                                                              type="button"
                                                              title="supprimer" class="btn btn-outline-danger  ml-2"
                                                              data-toggle="modal"
                                                              data-target="#delete-ouvrage-modal">
                                                          <span class="fa fa-trash"></span>
                                                      </button>
                                                  @endcan--}}

                                                        @can('ouvrages.delete', $ouvrage)
                                                            <button wire:click="getSelectedOuvrage('{{ $ouvrage->id }}')"
                                                                    type="button"
                                                                    class="btn btn-outline-danger ml-2"
                                                                    data-toggle="modal"
                                                                    data-target="#delete-ouvrage-modal">
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

