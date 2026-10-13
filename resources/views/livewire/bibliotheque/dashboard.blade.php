@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3"><span class="fas fa-fw fa-book mr-1"></span>Bibliothèque</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Bibliothèque</li>
            </ol>
        </div>
    </div>

@stop
<div class="">

    <div class="content mt-3">
        <div class="row">
            <div class="col-12">
                <div class="mb-5">
                    <div class="row g-2">
                        @foreach ($boxes as $box)
                            <div class="col-md-4 col-12">
                                <a href="{{ $box['url'] }}">
                                    <div class="info-box bg-{{ $box['theme'] }}">
                                        <span class="info-box-icon"><i
                                                class="{{ $box['icon'] }}{{--far fa-bookmark--}}"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">{{ $box['text'] }}</span>
                                            <span class="info-box-number">{{ $box['title'] }}</span>

                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <h3 class="mb-3"><span class="fas fa-fw fa-book-open-reader mr-1"></span>5 Ouvrages les plus lus</h3>
            <hr/>
            <table class="table table-hover">
                <thead class="bg-primary">
                <tr>
                    <th style="width: 50px">#</th>
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
                @foreach($ouvrages as $i=>$ouvrage)
                    <tr>
                        <td>{{$i+1}}</td>
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
