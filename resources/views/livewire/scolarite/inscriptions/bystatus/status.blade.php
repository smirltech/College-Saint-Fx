@php
    use App\Enums\InscriptionStatus;
    use App\Enums\Sexe;use App\Helpers\Helpers;use App\Models\Annee;
    $heads = [
            'NO.',
            '',
            'ELEVE',
            'SEXE',
            'CLASSE',
            'DEPUIS LE',
            ['Actions', 'no-export' => true, 'width' => 5],
        ];


$data=[];
    foreach ($inscriptions->sortBy(fn ($q) => $q->eleve->fullName) as $inscription){

            $btn1 = '<a href="' . "/scolarite/eleves/{$inscription->eleve_id}" . '" class="btn btn-success btn-sm m-1" title="Voir Élève"><i class="fa fa-eye"></i></a>';
            $btn2 = '<a hidden href="' . "/scolarite/eleves/{$inscription->eleve_id}/edit" . '" class="btn btn-warning btn-sm m-1" title="EditModal"><i class="fa fa-edit"></i></a>';
            $btn3 = '<button hidden wire:click="deleteInscription('.$inscription->id.')"
                                                    title="supprimer" class="btn btn-danger  btn-sm m-1">
                                                <i class="fas fa-trash"></i>
                                            </button>';

            $badgeColor = Helpers::admissionStatusColor($inscription->status);

            $data[] = [
                 $inscription->code,
                 '<img class="img-circle" style="width:50px; height:50px" src="'.$inscription->eleve->profile_url.'"></img>',

                $inscription->eleve->fullName,
               $inscription->eleve->sexe->value??'',

                $inscription->classe->code,
                $inscription->created_at->format('d/m/Y'),
                '<nobr>' . $btn1 . $btn2. $btn3 . '</nobr>',
            ];

        }

        $config = [
            'data' => $data ?? [],
            'order' => [[1, 'asc']],
            'columns' => [['orderable' => true],null, null, null, null, null,['orderable' => false]],
        ];
@endphp
@section('title')
    - inscriptions {{strtolower($status->pluralLabel(Sexe::F))}} {{date('d-m-Y')}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Liste d'inscriptions {{strtolower($status->pluralLabel(Sexe::F))}}</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('scolarite.inscriptions') }}">Inscriptions</a></li>
                <li class="breadcrumb-item active">{{$status->pluralLabel(Sexe::F)}}</li>
            </ol>
        </div>
    </div>

@stop
<div class="content mt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title d-flex">
                            <a href="{{ route('scolarite.inscriptions.create') }}" title="ajouter"
                               class="btn btn-primary mr-2"><span class="fa fa-plus"></span></a>
                        </div>
                        <div class="card-tools d-flex my-auto">

                            <a href="{{ route('scolarite.inscriptions.create') }}" title="ajouter"
                               class="btn btn-primary mr-2"><span class="fa fa-plus"></span></a>


                        </div>
                    </div>

                    <div class="mb-3 card-body">
                        <div class="table-responsive m-b-40">
                            <x-adminlte-datatable id="table7" :heads="$heads" theme="light" :config="$config" striped
                                                  hoverable with-buttons/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

