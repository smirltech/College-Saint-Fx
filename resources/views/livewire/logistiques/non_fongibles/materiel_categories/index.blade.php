@php
    $heads =[
        ['label'=>'#', 'width'=>5],
        'CATÉGORIE',
        'GROUPE',
        'DESCRIPTION',
        'MATÉRIELS',
        ['label'=>'', 'no-export'=>true, 'width'=>5]
];
   $datas =[];
   foreach ($categories as $i=>$categorie){
        $datas[] =[
            $i+1,
            $categorie->nom,
            $categorie->groupe,
            Str::limit($categorie->description, 50),
            $categorie->materielsCount,
            $categorie,
];
   }

    $config =[
  'data'=>$datas,
  'order'=>[[1, 'asc']],
  'columns'=>[null,null,null, null, null, ['orderable'=>false]],
  'destroy'=>false,

];
@endphp

@section('title')
    - catégories de patrimoine
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Liste de catégories</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('logistique') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Catégories</li>
            </ol>
        </div>
    </div>

@stop
<div wire:ignore.self class="">
    @include('livewire.logistiques.non_fongibles.materiel_categories.modals.crud')

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
                                @can('materiel-categories.create')
                                    <button type="button"
                                            class="btn btn-primary  ml-2" data-toggle="modal"
                                            data-target="#add-category-modal"><span
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
                                        <td>
                                            <div class="d-flex float-right">
                                                @can('materiel-categories.view', $row[5])
                                                    <a href="{{route('logistique.categories.show',[$row[5]->id])}}"
                                                       title="Voir"
                                                       class="btn btn-warning">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endcan
                                                @can('materiel-categories.update', $row[5])
                                                    <button wire:click="getSelectedCategory({{$row[5]}})" type="button"
                                                            title="Modifier" class="btn btn-info  ml-2"
                                                            data-toggle="modal"
                                                            data-target="#update-category-modal">
                                                        <span class="fa fa-pen"></span>
                                                    </button>
                                                @endcan
                                                @can('materiel-categories.delete', $row[5])
                                                    <button wire:click="getSelectedCategory({{$row[5]}})" type="button"
                                                            title="supprimer" class="btn btn-danger  ml-2"
                                                            data-toggle="modal"
                                                            data-target="#delete-category-modal">
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

