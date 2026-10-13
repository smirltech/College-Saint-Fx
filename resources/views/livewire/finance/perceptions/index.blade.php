@php
    use App\Models\Perception;use Carbon\Carbon;
    use App\Enums\GraviteRetard;
    use App\Enums\FraisType;
    use App\Helpers\Helpers;

    $heads =[
        ['label'=>'DATE', 'width'=>10],
        'LIBELLE',
          'TYPE',
        'ELEVE',
        'CLASSE',
        'DU',
        'PAYE',
        'RESTE',
        'CAISSIER',
        'ACTION'
    ];
   $data =[];
   foreach ($perceptions as $key=>$perception){
      $reste =  $perception->reste;
      $resteColor = Helpers::balanceColor($reste);

        $btns = '';

           $btns .= '<a href="'.route('finance.perceptions.print',$perception->id).'" class="btn btn-info btn-sm m-1"><i class="fas fa-print"></i></a>';

        if(auth()->user()->can('perceptions.update')){
            $btns .=                    '<button onclick="showModal(\'finance.perception.perception-create-component\',\''.$perception->inscription->id.'\',\''.$perception->id.'\')" class="btn btn-warning btn-sm m-1"><i class="fas fa-edit"></i></button>';
}
        if(auth()->user()->can('perceptions.delete')){

            $btns .= '<button onclick="showDeleteModal(\'Perception\',\''.$perception->id.'\')" class="btn btn-danger btn-sm m-1"><i class="fas fa-trash"></i></button>';

}

        $data[] =[
            $perception->created_at->format('Y-m-d H:i'),
            $perception->label,
            $perception->frais->type,
            $perception->inscription?->eleve->fullName,
            $perception->inscription?->classe->code,
             Helpers::currencyFormat($perception->frais_montant) .' '.$perception->frais->devise->value,
             Helpers::currencyFormat($perception->montant) .' '. $perception->devise->value,
            '<span class="badge badge-'.$resteColor.'">'.Helpers::currencyFormat($reste) .' '. $perception->devise->value.'</span>',
            $perception->user?->name,

            $btns,
          ];
       }

    $config =[
  'data'=>$data,
  'order'=>[[0, 'desc'],[2, 'asc'],[3, 'asc']],
];
@endphp
@section('title')
    CENK -  Perceptions {{date('d-m-Y')}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Perceptions</h1>
        </div>
        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('finance') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Factures et Perceptions</li>
            </ol>
        </div>
    </div>

@stop
<div>

    <div class="row g-2">
        @foreach ($this->boxes as $box)
            <div class="col-md-3" bis_skin_checked="1">
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
    <div class="card p-2">
        <form wire:submit.prevent="search" class="mt-1">
            <div class="row">
                <div class="col-md-3">
                    <x-form::select
                        placeholder="Classe"
                        wire:model="classe_id"
                        :options="$classes"/>
                </div>
                <div class="col-md-3">
                    <x-form::select
                        placeholder="Type"
                        wire:model="frais_type"
                        :options="FraisType::cases()"/>
                </div>
                <div class="col-md-3">
                    <x-form::select
                        placeholder="Frais"
                        wire:model="frais_id"
                        :options="$frais"/>
                </div>
                <div class="col-md-3 text-center">
                    @can("perceptions.create")
                        <x-form::button wire:click="search" href="#">
                            <span class="fas fa-filter"/>
                        </x-form::button>
                    @endif
                </div>

                {{--
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
                                            </div>--}}
            </div>

        </form>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">

                    </div>
                    <div class="card-tools d-flex my-auto">

                        @can('perceptions.create')
                            <a href="{{route('finance.caisse')}}" title="facturer un élève"
                               class="btn btn-primary  ml-2">
                                <i class="fas fa-plus"></i> Percevoir
                            </a>
                        @endcan
                        @can('perceptions.create')
                            <button onclick="showModal('finance.perception.import-perception-component')"
                                    title="facturer un élève"
                                    class="btn btn-success  ml-2">
                                <i class="fas fa-file-excel"></i> Import
                            </button>
                        @endcan
                    </div>
                </div>

                <div class="card-body m-b-40 table-responsive">
                    <x-adminlte-datatable head-theme="primary" theme="s" id="table1"
                                          :heads="$heads"
                                          :config="$config"
                                          striped
                                          hoverable with-buttons/>
                </div>
            </div>
        </div>
    </div>
</div>

