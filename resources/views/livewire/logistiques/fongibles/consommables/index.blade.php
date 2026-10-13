@php
    use Carbon\Carbon;

        $heads =[
            ['label'=>'#', 'width'=>5],
            'CODE',
            'CONSOMMABLE',

            'MINIMUM',
            'QUANTITÉ',
            ['label'=>'NIVEAU', 'width'=>5],
            ['label'=>'', 'no-export'=>true, 'width'=>5]
    ];
       $datas =[];
       foreach ($consommables as $i=>$consommable){
            $datas[] =[
                $i+1,
                $consommable->code,
                $consommable->nom,

                $consommable->stock_minimum.' '.$consommable->unit->code,
                $consommable->quantite.' '.$consommable->unit->code,
                $consommable->alertText,
                $consommable,
    ];
       }

        $config =[
      'data'=>$datas,
      'order'=>[[1, 'asc']],
      'columns'=>[null, null, null, null, null, null, ['orderable'=>false]],
      'destroy'=>false,

    ];
@endphp

@section('title')
    Consommables de patrimoine
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Liste de consommables</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('logistique') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Consommables</li>
            </ol>
        </div>
    </div>

@stop
<div wire:ignore.self class="">
    @include('livewire.logistiques.fongibles.consommables.modals.crud')

    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">

                            </div>
                            <div class="card-tools d-flex my-auto">
                                {{-- <livewire:scolarite.section.section-create-component/>--}}
                                @can('consommables.create')
                                    <button type="button"
                                            class="btn btn-primary  ml-2" data-toggle="modal"
                                            data-target="#add-consommable-modal"><span
                                            class="fa fa-plus"></span></button>
                                @endcan
                            </div>
                        </div>

                        <div class="card-body m-b-40 table-responsive">
                            <x-adminlte-datatable
                                wire:ignore.self theme="light" id="table1" :heads="$heads" striped
                                hoverable
                                with-buttons>
                                @foreach($config['data'] as $row)
                                    <tr class="table-{{$row[6]->alertColor}}">
                                        <td>{!! $row[0] !!}</td>
                                        <td>{!! $row[1] !!}</td>
                                        <td>{!! $row[2] !!}</td>
                                        <td>{!! $row[3] !!}</td>
                                        <td>{!! $row[4] !!}</td>
                                        <td>{!! $row[5] !!}</td>
                                        <td>
                                            <div class="d-flex float-right">
                                                @can('consommables.view', $row[6])
                                                    <a href="{{route('logistique.consommables.show',[$row[6]->id])}}"
                                                       title="Voir"
                                                       class="btn btn-warning">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endcan
                                                @can('consommables.update', $row[6])
                                                    <button wire:click="getSelectedConsommable({{$row[6]}})"
                                                            type="button"
                                                            title="Modifier" class="btn btn-info  ml-2"
                                                            data-toggle="modal"
                                                            data-target="#update-consommable-modal">
                                                        <span class="fa fa-pen"></span>
                                                    </button>
                                                @endcan
                                                @can('consommables.delete', $row[6])
                                                    <button wire:click="getSelectedConsommable({{$row[6]}})"
                                                            type="button"
                                                            title="supprimer" class="btn btn-danger  ml-2"
                                                            data-toggle="modal"
                                                            data-target="#delete-consommable-modal">
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

