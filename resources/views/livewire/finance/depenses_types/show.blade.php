@php
    $heads =[
        ['label'=>'DATE'],
        'MONTANT',
        'NOTE',
        'REFERENCE',
        'PAR',
        ['label'=>'', 'no-export'=>true, 'width'=>5]
];
   $data =[];
   foreach ($depenseType->depenses as $depense){
        $data[] =[
            $depense->created_at->format('d-m-Y'),
            \App\Helpers\Helpers::currencyFormat($depense->montant, symbol: 'Fc'),
            $depense->note,
            $depense->reference,
            $depense->user->name,
            $depense,
];
   }

    $config =[
  'data'=>$data,
  'order'=>[[1, 'asc']],
  'columns'=>[null, null,null,null, null, ['orderable'=>false]],
  'destroy'=>true,

];
@endphp


@section('title')
    - Type de Dépenses - {{$depenseType->nom}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3"><span class="fas fa-fw fa-university mr-1"></span>Type de Dépenses</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('finance') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('finance.depense-types') }}">Types de Dépenses</a></li>
                <li class="breadcrumb-item active">{{$depenseType->nom}}</li>
            </ol>
        </div>
    </div>

@stop
<div class="">
    @include('livewire.finance.depenses_types.modals.crud')

    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2 col-sm-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="card-title">
                                <h4 class="m-0">{{$depenseType->nom}}</h4>
                            </div>
                            <div class="card-tools">
                                @can('depense-types.update',$depenseType)
                                    <span
                                        title="Modifier" role="button" class="ml-2 mr-2" data-toggle="modal"
                                        data-target="#edit-type-modal">
                                    <span class="fa fa-pen"></span>
                                </span>
                                @endcan

                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Total : </b> <span
                                        class="float-right">{{\App\Helpers\Helpers::currencyFormat($depenseType->total(), symbol: 'Fc')}}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Description : </b> <span class="float-right">{{$depenseType->description}}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-10 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h4 class="m-0">Dépenses</h4>
                            </div>
                            <div class="card-tools d-flex my-auto">
                                <button hidden="" type="button"
                                        class="btn btn-primary  ml-2" data-toggle="modal"
                                        data-target="#add-option-modal"><span
                                        class="fa fa-plus"></span></button>
                            </div>
                        </div>

                        <div class="card-body m-b-40 table-responsive">
                            <x-adminlte-datatable wire:ignore.self theme="light" id="table1" :heads="$heads" striped
                                                  hoverable with-buttons>
                                @foreach($config['data'] as $row)
                                    <tr>
                                        <td>{!! $row[0] !!}</td>
                                        <td>{!! $row[1] !!}</td>
                                        <td>{!! $row[2] !!}</td>
                                        <td>{!! $row[3] !!}</td>
                                        <td>{!! $row[4] !!}</td>
                                        <td>
                                            <div class="d-flex float-right">
                                                @can('depenses.update',$row[5])
                                                    <button hidden="" wire:click="getSelectedDepense({{$row[5]}})"
                                                            type="button"
                                                            title="Modifier" class="btn btn-info  ml-2"
                                                            data-toggle="modal"
                                                            data-target="#edit-depense-modal">
                                                        <span class="fa fa-pen"></span>
                                                    </button>
                                                @endcan
                                                @can('depenses.delete',$row[5])
                                                    <button hidden="" wire:click="getSelectedDepense({{$row[5]}})"
                                                            type="button"
                                                            title="supprimer" class="btn btn-danger  ml-2"
                                                            data-toggle="modal"
                                                            data-target="#delete-depense-modal">
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
