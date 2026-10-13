@php
    use App\Enums\InscriptionStatus;
    use App\Helpers\Helpers;use App\Models\Annee;
    $heads = [
            'NO.',
            'RESPONSABLE',
            'SEXE',
            'TELEPHONE',
            'EMAIL',
            'ADRESSE',
            'ENFANTS',
            ['Actions', 'no-export' => true, 'width' => 5],
        ];


$data=[];
    foreach ($responsables as $key=>$responsable){

            $btn1 = '<a href="' . "/scolarite/responsables/{$responsable->id}" . '" class="btn btn-success btn-sm m-1" title="Voir Responsable"><i class="fa fa-eye"></i></a>';
            $btn2 = '<a hidden href="' . "/scolarite/responsables/{$responsable->id}/edit" . '" class="btn btn-warning btn-sm m-1" title="EditModal"><i class="fa fa-edit"></i></a>';
            $btn3 = '<button hidden wire:click="deleteResponsable('.$responsable->id.')"
                                                    title="supprimer" class="btn btn-danger  btn-sm m-1">
                                                <i class="fas fa-trash"></i>
                                            </button>';

        //    $badgeColor = Helpers::admissionStatusColor($inscription->status);

            $data[] = [
                $key+1,
                $responsable->nom,
                $responsable->sexe->value??'',
                '<a href="tel:'.$responsable->telephone.'">'.$responsable->telephone.'</a>',
                '<a href = "mailto:'.$responsable->email.'">'.$responsable->email.'</a>',
                $responsable->adresse,
                count($responsable->responsable_eleves),
                '<nobr>' . $btn1 . $btn2. $btn3 . '</nobr>',
            ];

        }

        $config = [
            'data' => $data ?? [],
            'order' => [[1, 'asc']],
            'columns' => [['orderable' => true], null,null, null, null, null, null,['orderable' => false]],
        ];
@endphp
@section('title')
    - responsables
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Liste de responsables</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Responsables</li>
            </ol>
        </div>
    </div>

@stop
<div>
    @include('livewire.scolarite.responsables.modals.crud')
    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div hidden class="card-header">
                            <div class="card-title d-flex">
                                {{--<a href="{{ route('scolarite.responsables.create') }}" title="ajouter"
                                   class="btn btn-primary mr-2"><span class="fa fa-plus"></span></a>--}}
                            </div>
                            <div class="card-tools d-flex my-auto">

                                <button hidden type="button"
                                        title="Ajouter" class="btn btn-primary" data-toggle="modal"
                                        data-target="#add-responsable-modal">
                                    <span class="fa fa-plus"></span>
                                </button>
                            </div>
                        </div>

                        <div class="mb-3 card-body">
                            <div class="table-responsive m-b-40">
                                <x-adminlte-datatable id="table7" :heads="$heads" theme="light" :config="$config"
                                                      striped
                                                      hoverable with-buttons/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


