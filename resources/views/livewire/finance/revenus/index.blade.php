@php
    use App\Helpers\Helpers;$heads =[
        ['label'=>'DATE', 'width'=>10],
        'LIBELLE',
        'TYPE',
        'MONTANT',
        'DESCRIPTION',
        ['label'=>'', 'no-export'=>true, 'width'=>5]
];
   $data =[];
   foreach ($revenus as $revenu){
        $data[] =[
            $revenu->created_at->format('Y-m-d H:i'),
            $revenu->nom,
            $revenu->type->label(),
            $revenu->montant(),
            $revenu->description,
            $revenu->id,
];
   }

    $config =[
  'data'=>$data,
  'order'=>[[0, 'desc'],[2, 'asc']],
  'columns'=>[null, null, null, null, ['orderable'=>false]],
];
@endphp

@section('title')
    CENK - Revenus auxiliaires {{date('d-m-Y')}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Liste de revenus auxiliaires</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('finance') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Revenus Auxiliaires</li>
            </ol>
        </div>
    </div>

@stop
<div class="card">
    <div class="card-header">
        <div class="card-title">

        </div>
        <div class="card-tools d-flex my-auto">
            @can('revenus.create')
                <button type="button"
                        onclick="showModal('finance.revenu.revenu-create-component')"
                        class="btn btn-primary  ml-2"><span
                        class="fa fa-plus"></span></button>
            @endcan
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
                            @can('revenus.update',$row[5])
                                <button type="button"
                                        onclick="showModal('finance.revenu.revenu-create-component','{{$row[5]}}')"
                                        title="Modifier" class="btn btn-info m-1 btn-sm">
                                    <span class="fa fa-pen"></span>
                                </button>
                            @endcan
                            @can('revenus.delete',$row[5])
                                <button type="button"
                                        onclick="showDeleteModal('Revenu','{{$row[5]}}')"
                                        title="supprimer" class="btn btn-danger m-1 btn-sm">
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

