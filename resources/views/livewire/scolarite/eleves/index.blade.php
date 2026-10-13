@php
    use App\Enums\InscriptionStatus;
    use App\Enums\Sexe;use App\Helpers\Helpers;use App\Models\Annee;
    $heads = [
            ['', 'no-export' => false, 'width' => 5],
            'MATRICULE',
            'NOM',
            'SEXE',
            'AGE',
            'CLASSE',
//            'RESPONSABLE',
          /*  'STATUS',*/
            'DATE',
            ['Actions', 'no-export' => true, 'width' => 5],
        ];


$data=[];
    foreach ($eleves as $eleve){

            $btn1 = '<a href="' . route("scolarite.eleves.show",$eleve) . '" class="btn btn-success btn-sm m-1" title="Voir Élève"><i class="fa fa-eye"></i></a>';
            $btn2 = '<a href="' . route("scolarite.inscriptions.edit",$eleve->inscription) . '" class="btn btn-warning btn-sm m-1" title="Edit Élève"><i class="fa fa-edit"></i></a>';

            $data[] = [
                '<a href="' . route("scolarite.eleves.show",$eleve) . '" title="Voir Élève"><img class="img-circle" style="width:50px; height:50px" src="'.$eleve->profile_url.'"></img></a>',
                $eleve->matricule,
                $eleve->full_name,
                $eleve->sexe?->label(),
                $eleve->age > 0 ? $eleve->age : '',
                $eleve->inscription?$eleve->inscription->annee?->id==Annee::id() ? $eleve->classe?->code: $eleve->classe?->code.' ('.$eleve->inscription?->annee->name.')':'',
                  '<a href="' . route("scolarite.responsables.show",$eleve->responsable_eleve->responsable??'0').'">' .$eleve->responsable_eleve?->responsable?->nom. '</a>',
             /*   $eleve->inscription?->status? '<a href="'.route('scolarite.inscriptions.status',['status'=>$eleve->inscription?->status->name]).'"><span class="badge bg-gradient-'.$eleve->inscription?->status->variant().'">'. $eleve->inscription?->status->label(Sexe::f).'</span></a>':'',*/
               $eleve->created_at->format('Y-m-d H:i'),
                '<nobr>' . $btn1.$btn2. '</nobr>',
            ];

        }

        $config = [
            'data' => $data ?? [],
            'order' => [[7, 'desc'],[2, 'asc']],
            'columns' => [['orderable' => false],['orderable' => true], null, null, null, null, null,null,['orderable' => false]],
        ];
@endphp
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Liste d'élèves</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Élèves</li>
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
                            @can('inscriptions.create')
                                <button
                                    onclick="showModal('scolarite.eleve.eleve-import-component')"
                                    title="ajouter"
                                    class="btn btn-success mr-2"><span class="fa fa-file-excel">
                                    </span>
                                </button>
                            @endcan
                        </div>
                        <div class="card-tools d-flex my-auto">
                            @can('inscriptions.create')
                                <a href="{{ route('scolarite.inscriptions.create') }}" title="ajouter"
                                   class="btn btn-primary mr-2"><span class="fa fa-plus"></span></a>
                            @endcan

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

