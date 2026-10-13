@php
    $heads =[
        ['label'=>'#', 'width'=>5],
        'TYPE',
        'DESCRIPTION',
        ['label'=>'', 'no-export'=>true, 'width'=>5]
];
   $datas =[];
   foreach ($depenseTypes as $i=>$depenseType){
        $datas[] =[
            $i+1,
            $depenseType->nom,
            $depenseType->description,
            $depenseType,
];
   }

    $config =[
  'data'=>$datas,
  'order'=>[[1, 'asc']],
  'columns'=>[null,null, null, ['orderable'=>false]],
  'destroy'=>false,

];
@endphp

@section('title')
    - Types de Dépenses
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Liste de types de dépenses</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Types de Dépenses</li>
            </ol>
        </div>
    </div>

@stop
<div wire:ignore.self class="">
    @include('livewire.finance.depenses_types.modals.crud')

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
                                @can('depense-types.create')
                                    <button type="button"
                                            class="btn btn-primary  ml-2" data-toggle="modal"
                                            data-target="#add-type-modal"><span
                                            class="fa fa-plus"></span></button>
                                @endcan
                            </div>
                        </div>

                        <div class="card-body m-b-40 table-responsive">
                            <x-adminlte-datatable wire:ignore.self theme="light" id="table1" :heads="$heads" striped
                                                  hoverable
                                                  with-buttons>
                                @foreach($config['data'] as $row)
                                    <tr>
                                        <td>{!! $row[0] !!}</td>
                                        <td>{!! $row[1] !!}</td>
                                        <td>{!! $row[2] !!}</td>
                                        <td>
                                            <div class="d-flex float-right">
                                                @can('depense-types.view',$row[3])
                                                    <a href="{{route('finance.depense-types.show', [$row[3]])}}"
                                                       title="voir"
                                                       class="btn btn-success  ml-2">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endcan
                                                @can('depense-types.update',$row[3])
                                                    <button wire:click="getSelectedTypeDepense({{$row[3]}})"
                                                            type="button"
                                                            title="Modifier" class="btn btn-info  ml-2"
                                                            data-toggle="modal"
                                                            data-target="#edit-type-modal">
                                                        <span class="fa fa-pen"></span>
                                                    </button>
                                                @endcan
                                                @can('depense-types.delete',$row[3])
                                                    <button wire:click="getSelectedTypeDepense({{$row[3]}})"
                                                            type="button"
                                                            title="supprimer" class="btn btn-danger  ml-2"
                                                            data-toggle="modal"
                                                            data-target="#delete-type-modal">
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

