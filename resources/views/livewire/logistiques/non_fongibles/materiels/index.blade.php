@php
    use Carbon\Carbon;

        $heads =[
            ['label'=>'#', 'width'=>5],
            'MATÉRIEL',
            'CATÉGORIE',
            ['label'=>'DATE', 'width'=>10],
            'VIE',
            'RESTE',
            'STATUS',
            'DIRECTION',
            ['label'=>'', 'no-export'=>true, 'width'=>5]
    ];
       $datas =[];
       foreach ($materiels as $i=>$materiel){
            $datas[] =[
                $i+1,
                $materiel->nom,
                $materiel->category,

               $materiel->date == null?'': Carbon::parse($materiel->date)->format('d-m-Y'),
                $materiel->vie,
                $materiel->vieRestante,
                $materiel->status,
                $materiel->direction,
                $materiel,
    ];
       }

        $config =[
      'data'=>$datas,
      'order'=>[[1, 'asc']],
      'columns'=>[null,null,null, null, null, null, null, null, ['orderable'=>false]],
      'destroy'=>false,

    ];
@endphp

@section('title')
    Liste de matériels
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Liste de matériels</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('logistique') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Matériels</li>
            </ol>
        </div>
    </div>

@stop
<div wire:ignore.self class="">
    @include('livewire.logistiques.non_fongibles.materiels.modals.crud')

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
                                @can('materiels.create')
                                    <button type="button"
                                            class="btn btn-primary  ml-2" data-toggle="modal"
                                            data-target="#add-materiel-modal"><span
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
                                        <td>
                                            <a href="{{$row[2]==null?'#':route('logistique.categories.show',[$row[2]?->id])}}">{!! $row[2]?->nom !!}</a>
                                        </td>
                                        <td>{!! $row[3] !!}</td>
                                        <td>{!! $row[4] !!}</td>
                                        <td>{!! $row[5] !!}</td>
                                        <td><span
                                                class="badge badge-{!! $row[6]?->color() !!}">{!! $row[6]?->label() !!}</span>
                                        </td>
                                        <td><span
                                                class="badge badge-{!! $row[7]?->color() !!}">{!! $row[7]?->label() !!}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex float-right">
                                                @can('materiels.view', $row[8])
                                                    <a href="{{route('logistique.materiels.show',[$row[8]->id])}}"
                                                       title="Voir"
                                                       class="btn btn-warning">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endcan
                                                @can('materiels.update', $row[8])
                                                    <button wire:click="getSelectedMateriel({{$row[8]}})" type="button"
                                                            title="Modifier" class="btn btn-info  ml-2"
                                                            data-toggle="modal"
                                                            data-target="#update-materiel-modal">
                                                        <span class="fa fa-pen"></span>
                                                    </button>
                                                @endcan
                                                @can('materiels.delete', $row[8])
                                                    <button wire:click="getSelectedMateriel({{$row[8]}})" type="button"
                                                            title="supprimer" class="btn btn-danger  ml-2"
                                                            data-toggle="modal"
                                                            data-target="#delete-materiel-modal">
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

