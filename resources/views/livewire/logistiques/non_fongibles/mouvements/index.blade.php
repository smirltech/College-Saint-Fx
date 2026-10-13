@php
    use Carbon\Carbon;

        $heads =[
            ['label'=>'#', 'width'=>5],
            'DATE',
            'MATÉRIEL',
            'BÉNÉFICIAIRE',
            'FACILITATEUR',
            'DIRECTION',
            'ÉTAT',
            'OBSERVATION',
    ];
       $datas =[];
       foreach ($mouvements as $i=>$mouvement){
            $datas[] =[
                $i+1,
                $mouvement->dateFormatted,
                $mouvement->materiel->nom,
                $mouvement->beneficiaire,
                $mouvement->facilitateur->name,
                $mouvement->direction,
                $mouvement->materiel_status,
                $mouvement->shortObservation,

    ];
       }

        $config =[
      'data'=>$datas,
      'order'=>[[1, 'asc']],
      'columns'=>[null, null, null, null, null, null, null, ['orderable'=>false]],
      'destroy'=>false,

    ];
@endphp

@section('title')
    - mouvements de matériels
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Liste de mouvements</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('logistique') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Mouvements</li>
            </ol>
        </div>
    </div>

@stop
<div wire:ignore.self class="">

    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        {{--<div class="card-header">
                            <div class="card-title">

                            </div>
                            <div class="card-tools d-flex my-auto">
                                --}}{{-- <livewire:scolarite.section.section-create-component/>--}}{{--
                                --}}{{--<button type="button"
                                        class="btn btn-primary  ml-2" data-toggle="modal"
                                        data-target="#add-materiel-modal"><span
                                        class="fa fa-plus"></span></button>--}}{{--
                            </div>
                        </div>--}}

                        <div class="card-body m-b-40 table-responsive">
                            <x-adminlte-datatable wire:ignore.self theme="light" id="table1" :heads="$heads" striped
                                                  hoverable
                                                  with-buttons>
                                @foreach($config['data'] as $row)
                                    <tr>
                                        <td>{!! $row[0] !!}</td>
                                        <td>{!! $row[1] !!}</td>
                                        <td>{!! $row[2] !!}</td>
                                        <td>{!! $row[3] !!}</td>
                                        <td>{!! $row[4] !!}</td>
                                        <td><span
                                                class="badge badge-{!! $row[5]->color() !!}">{!! $row[5]->label() !!}</span>
                                        </td>
                                        <td><span
                                                class="badge badge-{!! $row[6]->color() !!}">{!! $row[6]->label() !!}</span>
                                        </td>
                                        <td>{!! $row[7] !!}</td>
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

