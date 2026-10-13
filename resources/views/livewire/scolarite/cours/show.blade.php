@php
    use App\Enums\InscriptionStatus;use App\Helpers\Helpers;
@endphp

@section('title')
    - classe - {{$classe->code}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3"><span class="fas fa-fw fa-chalkboard-teacher mr-1"></span>Classe</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ $parent_url }}">{{$classe->parent->nom}}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('scolarite.classes.index') }}">Classes</a></li>
                <li class="breadcrumb-item active">{{$classe->niveau->label()}}</li>
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
                                <h4 class="m-0">{{$classe->niveau->label()}}</h4>
                            </div>
                            <div class="card-tools">
                                <a href="/scolarite/classes/{{ $classe->id }}/edit" title="modifier"
                                   class="ml-2">
                                    <i class="fas fa-pen"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Niveau : </b> <span class="float-right">{{ $classe->niveau->label() }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Code : </b> <span class="float-right">{{ $classe->code }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Élèves : </b> <span class="float-right">{{ $inscriptions->count() }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>{{ $parent }} : </b> <span class="float-right"> <a
                                            href="{{ $parent_url }}">{{  $classe->parent->nom }}</a>
         </span>
                                </li>
                            </ul>

                            {{-- <div hidden class="row d-flex mt-2">

                                 <div class="col-md-3 col-sm-6 col-6">
                                     <div class="d-flex align-items-center">
                                         <div class="bg-info rounded p-2"><i
                                                 class="fa fa-users align-middle"></i></div>
                                         <div class="ml-1 d-flex flex-column">
                                             <span class=""></span>
                                             <span class=""><strong></strong></span>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="col-md-3 col-sm-6 col-6">
                                     <div class="d-flex align-items-center">
                                         <div class="bg-success rounded p-2"><i
                                                 class="fa fa-users align-middle"></i></div>
                                         <div class="ml-1 d-flex flex-column">
                                             <span class=""></span>
                                             <span class=""><strong></strong></span>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="col-md-3 col-sm-6 col-6">
                                     <div class="d-flex align-items-center">
                                         <div class="bg-danger rounded p-2"><i
                                                 class="fa fa-users align-middle"></i></div>
                                         <div class="ml-1 d-flex flex-column">
                                             <span class=""></span>
                                             <span class=""><strong></strong></span>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="col-md-3 col-sm-6 col-6">
                                     <div class="d-flex align-items-center">
                                         <div class="bg-warning rounded p-2"><i
                                                 class="fa fa-users align-middle"></i></div>
                                         <div class="ml-1 d-flex flex-column">
                                             <span class=""></span>
                                             <span class=""><strong></strong></span>
                                         </div>
                                     </div>
                                 </div>

                             </div>--}}
                        </div>
                    </div>
                </div>
                <div class="col-md-9 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h4 class="m-0">Liste d'inscriptions</h4>
                            </div>
                            <div class="card-tools d-flex my-auto">

                                {{-- <a href="{{ route('scolarite.admissions.create') }}" title="ajouter"
                                    class="btn btn-primary mr-2"><span class="fa fa-plus"></span></a>--}}


                            </div>
                        </div>

                        <div class="card-body p-0 table-responsive">
                            <div class="table-responsive m-b-40">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th style="width: 100px">CODE</th>
                                        <th>ELEVE</th>
                                        <th>SEXE</th>
                                        <th style="width: 100px"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($inscriptions->sortBy(fn ($q) => $q->eleve->fullName) as $inscription)
                                        <tr>
                                            <td>{{ $inscription->code }}</td>
                                            <td>{{ $inscription->eleve->fullName }}</td>
                                            <td>{{ $inscription->eleve->sexe }}</td>
                                            <td>
                                                <div class="d-flex float-right">
                                                    {{--<a href="/scolarite/eleves/{{ $responsable_eleve->eleve->id }}" title="Voir"
                                                       class="btn btn-warning">
                                                        <i class="fas fa-eye"></i>
                                                    </a>--}}

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{-- <x-adminlte-datatable id="table7" :heads="$heads" theme="light" :config="$config" striped
                                                   hoverable with-buttons/>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
