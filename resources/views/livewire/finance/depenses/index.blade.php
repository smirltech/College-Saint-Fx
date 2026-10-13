@php
    use App\Helpers\Helpers;$heads =[
        ['label'=>'DATE', 'width'=>10],
        'MOTIF',
          'TYPE',
        'MONTANT',
        'BÉNÉFICIAIRE',
        'CONSIGNÉE PAR',
        'ETAT',
         ['label'=>'', 'no-export'=>true, 'width'=>5]
];
   $data =[];
   foreach ($depenses as $depense){
        $data[] =[
            $depense->date,
            $depense->motif,
            $depense->type->nom,
            Helpers::currencyFormat($depense->montant, symbol: $depense->devise->symbol()),
            $depense->beneficiaire,
            $depense?->status()?->user?->name,
            "<span class='badge badge-".($depense?->status()?->color)."'>".$depense?->status()?->label."</span>",
            $depense
            ];
   }

    $config =[
  'data'=>$data,
  'order'=>[[0, 'DESC'],[2, 'asc'],[1, 'asc']],
  'columns'=>[null, null, null,null,null, null, ['orderable'=>false]],
  'destroy'=>true,

];
@endphp

@section('title')
    CENK - Dépenses  {{date('d-m-Y H:i')}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Liste de dépenses</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('finance') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Dépenses</li>
            </ol>
        </div>
    </div>

@stop
<div>
    {{--  <form wire:submit.prevent="search" class="mt-1">
          <div class="row">
              <div class="col-md-9">
                  <div class="row">
                      <div class="col-md-3">
                          <x-form::select
                              placeholder="Type"
                              wire:model="type_id"
                              :options="$types"/>
                      </div>


                      <div class="col-md-6">
                          <div class="row">
                              <div class="col-md-6">
                                  <x-form::input
                                      type="date"
                                      wire:model="date_from"/>
                              </div>
                              <div class="col-md-6">
                                  <x-form::input
                                      type="date"
                                      wire:model="date_to"/>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-md-3">
                  <div class="row">
                      <div class="col-md-6">
                          <x-form::button wire:click="search" href="#">
                              <span class="fas fa-search"></span>
                          </x-form::button>
                      </div>
                  </div>
              </div>
          </div>

      </form>--}}

    <div class="row">
        @foreach ($this->boxes as $box)
            <div class="col-md-{{12/count($this->boxes)}}" bis_skin_checked="1">
                <div class="info-box" bis_skin_checked="1">
                                    <span class="info-box-icon  bg-{{ $box['theme'] }} elevation-1">
                                        <i class="{{ $box['icon'] }}"></i></span>
                    <div class="info-box-content" bis_skin_checked="1">
                        <span class="info-box-text">{{ $box['text'] }}</span>
                        <span class="info-box-number">
                                            {{ $box['title'] }}
                                        </span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="card-title">

                    </div>
                    <div class="card-tools d-flex my-auto">
                        @can('depenses.create')
                            <a href="{{ route('finance.depenses.create') }}"
                               type="button"
                               class="btn btn-outline-primary  ml-2"><span
                                    class="fa fa-plus"></span></a>
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
                                <td>
                                    @can('depense-types.view',$row[7]->depense_type)
                                        <a href="{{route('finance.depense-types.show', [$row[7]->depense_type_id])}}">{{$row[2]}}</a>
                                    @else
                                        {{$row[2]}}
                                    @endcan
                                </td>


                                <td>{!! $row[3] !!}</td>
                                <td>{!! $row[4] !!}</td>
                                <td>{!! $row[5] !!}</td>
                                <td>{!! $row[6] !!}</td>
                                <td>
                                    <div class="d-flex float-right">
                                        @can('depenses.view',$row[7])
                                            <a class="btn btn-sm btn-primary m-1"
                                               href="{{ route('finance.depenses.show',$row[7]->id)}}">
                                                <span class="fa fa-eye"></span>
                                            </a>
                                        @endcan
                                        @can('depenses.update',$row[7])
                                            <a class="btn btn-sm btn-warning m-1"
                                               href="{{ route('finance.depenses.edit',$row[7]->id)}}">
                                                <span class="fa fa-pen"></span>
                                            </a>
                                        @endcan
                                        @can('depenses.delete')
                                            <button onclick="showDeleteModal('Depense','{{$row[7]->id}}')"
                                                    type="button"
                                                    title="supprimer" class="btn btn-sm btn-danger m-1"
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
