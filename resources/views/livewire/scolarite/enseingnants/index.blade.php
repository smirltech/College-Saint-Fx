@php use App\Models\Option; @endphp
@php use App\Models\Section; @endphp
@php
    $heads =[
        ['label'=>'#', 'width'=>5],
        '',
        'NOM',
        'SECTION',
        'COURS',
        ['label'=>'', 'no-export'=>true, 'width'=>5]
];
   $data =[];
   foreach ($enseignants as $i=>$enseignant){
        $data[] =[
            $i+1,
            $enseignant->avatar,
            $enseignant->nom,
            $enseignant->section->nom,
            !$enseignant->primaire()?$enseignant->cours->count()??'-':$enseignant->classe->code??'-',
            $enseignant,
];
   }

    $config =[
  'data'=>$data,
  'order'=>[[1, 'asc']],
  'columns'=>[null, null,null, null,null, ['orderable'=>false]],
  'destroy'=>true,

];
@endphp

@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">{{$title}}</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Enseignants</li>
            </ol>
        </div>
    </div>

@stop
<div class="">
    @include('livewire.scolarite.enseingnants.modals.delete')
    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                            </div>
                            <div class="card-tools d-flex my-auto">
                                @can('enseignants.create')
                                    <a href="{{ route('scolarite.enseignants.create') }}" title="ajouter"
                                       class="btn btn-primary mr-2"><span
                                                class="fa fa-plus"></span></a>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            <x-adminlte-datatable wire:ignore.self head-theme="light" theme="light" id="tableens1"
                                                  :heads="$heads" striped
                                                  hoverable with-buttons>
                                @foreach($config['data'] as $row)
                                    <tr>
                                        <td>{!! $row[0] !!}</td>
                                        <td><img class="img-circle" style="width:50px; height:50px"
                                                 src="{{$row[1]}}"></td>
                                        <td>{!! $row[2] !!}</td>
                                        <td>{!! $row[3] !!}</td>
                                        <td>{!! $row[4] !!}</td>
                                        <td>
                                            <div class="d-flex float-right">
                                                @can('enseignants.view',$row[5])
                                                    <a href="/scolarite/enseignants/{{ $row[5]->id }}" title="Voir"
                                                       class="btn btn-outline-primary ml-2">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endcan
                                                @can('enseignants.update',$row[5])
                                                    <a href="/scolarite/enseignants/{{ $row[5]->id }}/edit"
                                                       title="modifier"
                                                       class="btn btn-outline-info  ml-2">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                @endcan
                                                @can('enseignants.delete',$row[5])
                                                    <button wire:click="getSelectedEnseignant('{{$row[5]->id }}')"
                                                            type="button"
                                                            title="supprimer" class="btn btn-outline-danger  ml-2"
                                                            data-toggle="modal"
                                                            data-target="#delete-enseignant">
                                                        <span class="fa fa-trash"></span>
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
