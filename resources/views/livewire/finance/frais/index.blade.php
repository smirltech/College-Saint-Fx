@php
    use App\Helpers\Helpers;$heads =[
       'NO.',
        'NOM',
        'TYPE',
        'MONTANT',
        'PERCEPTIONS',
        ['label'=>'', 'no-export'=>true, 'width'=>5]
];
   $data =[];
   foreach ($frais as $key=>$fee){
        $data[] =[
            $key+1,
            $fee->nom,

           $fee->type->label(),
              $fee->montant . ' ' . $fee->devise?->symbol(),
                 $fee->perceptions()->cdf()->sum('montant') . ' CDF / ' . $fee->perceptions()->usd()->sum('montant') . ' USD - ' . $fee->perceptions()->count(),

             $fee,
];
   }

    $config =[
  'data'=>$data,
  'order'=>[[2, 'asc'], [2, 'asc']],
  'columns'=>[null,null, null, null, ['orderable'=>false]],
  'destroy'=>true,

];
@endphp

@section('title')
    Liste de frais  {{date('d-m-Y')}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Plans de frais</h1>
        </div>
        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('finance') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Frais</li>
            </ol>
        </div>
    </div>

@stop
<div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            {{--<div class="card-title">
                                <span class="ml-2">Section {{$section_id}}</span>
                                <span class="ml-2">Option {{$option_id}}</span>
                                <span class="ml-2">Option {{$filiere_id}}</span>
                                <span class="ml-2">Classe {{$classe_id}}</span>
                            </div>--}}
                            <div class="card-tools d-flex my-auto">
                                @can('frais.create')
                                    <button type="button"
                                            onclick="showModal('finance.frais.frais-create-component')"
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
                                                @can('frais.update',$row[5])
                                                    <button
                                                        onclick="showModal('finance.frais.frais-create-component','{{$row[5]->id}}')"
                                                        type="button"
                                                        title="Modifier" class="btn btn-info  ml-2 btn-sm">
                                                        <span class="fa fa-pen"></span>
                                                    </button>
                                                @endcan
                                                @can('frais.delete',$row[5])
                                                    <button onclick="showDeleteModal('Frais','{{$row[5]->id}}')"
                                                            type="button"
                                                            title="supprimer" class="btn btn-danger ml-2 btn-sm">
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

