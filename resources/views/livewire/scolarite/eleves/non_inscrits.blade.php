@php
    use App\Enums\InscriptionStatus;
    use App\Helpers\Helpers;use App\Models\Annee;
    $heads = [
            ['', 'no-export' => false, 'width' => 5],
            'MATRICULE',
            'ELEVE',
            'SEXE',
            'AGE',
            'RESPONSABLE',
            'RELATION',
            ['Actions', 'no-export' => true, 'width' => 5],
        ];


 $data = [];
    foreach ($eleves as $eleve){

         /*   $btn1 = '';
           if(Auth::user()->can('eleves.view', $eleve)) { $btn1 = '<a href="' . route("scolarite.eleves.show",$eleve) . '" class="btn btn-success btn-sm m-1" title="Voir Élève"><i class="fa fa-eye"></i></a>';}
            $btn2 = '';
            if(Auth::user()->can('eleves.create', $eleve)) {
            $btn2 = '<a href="' . route("scolarite.eleves.show",$eleve) . '" class="btn btn-warning btn-sm m-1" title="Réinscrire Élève"><i class="fa fa-user-plus"></i></a>';
            }*/

            $data[] = [
                '<img class="img-circle" style="width:50px; height:50px" src="'.$eleve->profile_url.'"></img>',
                $eleve->matricule,
                $eleve->fullName,
                $eleve->sexe->value??'',
                $eleve->age??'',
                $eleve->responsable_eleve?->responsable?->nom??'',
                $eleve->responsable_eleve?->relation?->label()??'',
                $eleve,
            ];

        }

        $config = [
            'data' => $data ?? [],
            'order' => [[1, 'asc']],
            'columns' => [['orderable' => false],['orderable' => true], null, null, null, null, null,['orderable' => false]],
        ];
@endphp
@section('title')
    - élèves non encore inscrits
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Liste d'élèves non encore inscrits</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Élèves Non Inscrits</li>
            </ol>
        </div>
    </div>

@stop
<div class="content mt-3">
    @include('livewire.scolarite.eleves.modals.reinscription')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title d-flex">
                            {{--<a href="{{ route('scolarite.responsables.create') }}" title="ajouter"
                               class="btn btn-primary mr-2"><span class="fa fa-plus"></span></a>--}}
                        </div>
                        <div class="card-tools d-flex my-auto">

                            {{--  <a href="{{ route('scolarite.responsables.create') }}" title="ajouter"
                                 class="btn btn-primary mr-2"><span class="fa fa-plus"></span></a>
  --}}

                        </div>
                    </div>

                    <div class="mb-3 card-body">
                        <div class="table-responsive m-b-40">
                            <x-adminlte-datatable id="table7" :heads="$heads" theme="light" striped
                                                  hoverable with-buttons>
                                @foreach($config['data'] as $row)
                                    <tr>
                                        <td>{!! $row[0] !!}</td>
                                        <td>{!! $row[1] !!}</td>
                                        <td>{!! $row[2] !!}</td>
                                        <td>{!! $row[3] !!}</td>
                                        <td>{!! $row[4] !!}</td>
                                        <td>{!! $row[5] !!}</td>
                                        <td>{!! $row[6] !!}</td>
                                        <td>
                                            <div class="d-flex float-right">
                                                @can('eleves.view', $row[7])
                                                    <a href="{{route('scolarite.eleves.show',[$row[7]])}}"
                                                       title="Voir"
                                                       class="btn btn-success">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endcan
                                                @can('inscriptions.create')
                                                    <button wire:click="getSelectedEleve('{{$row[7]->id}}')"
                                                            type="button"
                                                            title="Réinscrire Élève" class="btn btn-warning  ml-2"
                                                            data-toggle="modal"
                                                            data-target="#reinscription-modal">
                                                        <span class="fa fa-user-plus"></span>
                                                    </button>
                                                @endcan

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </x-adminlte-datatable>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

