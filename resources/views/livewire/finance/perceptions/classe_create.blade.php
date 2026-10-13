@php use App\Enums\FraisType; @endphp
@php use App\Enums\MinervalMonth; @endphp
@section('title')
    Facturer toute la classe  {{date('d-m-Y')}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Nouvelle Facture pour toute la classe</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('finance') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('finance.perceptions') }}">Perceptions</a></li>
                <li class="breadcrumb-item active">Facturer toute la classe</li>
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

                        <div class="card-body m-b-40">
                            <x-form::validation-errors class="mb-4" :errors="$errors"/>
                            <form id="f1" wire:submit.prevent="addPerceptions">
                                <div class="row">

                                    <div class="form-group col-sm-12 col-md-6">
                                        <label for="">Classe - {{$eleveNbr}} élèves <i class="text-red">*</i></label>
                                        <x-form::select wire:model="classe_id"
                                                        class="form-control">
                                            <option value=null>Choisir classe</option>
                                            @foreach ($classes as $classe )
                                                <option value="{{ $classe->id }}">{{ $classe->code }}</option>
                                            @endforeach
                                        </x-form::select>
                                        @error('classe_id')
                                        <span class="text-red">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-12 col-md-6">
                                        <label for="">Frais</label>
                                        <x-form::select
                                                wire:ignore.self
                                                wire:change="feeSelected"
                                                wire:model="fee_id"
                                                class="form-control">
                                            @foreach ($frais as $feee )
                                                <option value="{{$feee->id}}">{{ $feee->nom }}
                                                    [{{ $feee->montant }} {{ $feee->devise}}]
                                                </option>
                                            @endforeach
                                        </x-form::select>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-12 col-md-6">
                                        <label for="">Echéance <i class="text-red">*</i></label>
                                        <input type="date" wire:model="due_date"
                                               class="form-control @error('due_date') is-invalid @enderror">
                                        @error('due_date')
                                        <span class="text-red">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-12 col-md-6">
                                        <label for="">Montant à Payer ({{$fee?->devise?->symbol()}}) <i
                                                    class="text-red">*</i></label>
                                        <input type="number" wire:model="montant"
                                               class="form-control @error('montant') is-invalid @enderror">
                                        @error('montant')
                                        <span class="text-red">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="card-footer">
                            <button form="f1" type="submit" class="btn btn-primary">Facturer</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

