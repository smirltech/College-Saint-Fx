@section('title')
    Liste d'unités de mesure
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Liste d'unités de mesure</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('logistique') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Unités de Mesure</li>
            </ol>
        </div>
    </div>

@stop
<div wire:ignore.self class="">
    @include('livewire.logistiques.fongibles.units.modals.crud')
    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">

                            </div>
                            <div class="card-tools d-flex my-auto">
                                @can('units.create')
                                    <button type="button"
                                            class="btn btn-primary  ml-2" data-toggle="modal"
                                            data-target="#add-unit-modal"><span
                                            class="fa fa-plus"></span></button>
                                @endcan
                            </div>
                        </div>

                        <div class="card-body m-b-40">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th style="width: 50px">#</th>
                                        <th>NOM</th>
                                        <th style="width: 100px">ABRÉVIATION</th>
                                        <th style="width: 50px"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($units as $i=>$unit)
                                        <tr>
                                            <td>{{$i+1}}</td>
                                            <td>{{$unit->nom}}</td>
                                            <td>{{$unit->code}}</td>
                                            <td>
                                                <div class="d-flex float-right">
                                                    @can('units.update',$unit)
                                                        <button wire:click="getSelectedUnit({{$unit}})" type="button"
                                                                title="Modifier" class="btn btn-info  ml-2"
                                                                data-toggle="modal"
                                                                data-target="#update-unit-modal">
                                                            <span class="fa fa-pen"></span>
                                                        </button>
                                                    @endcan
                                                    @can('units.delete',$unit)
                                                        <button wire:click="getSelectedUnit({{$unit}})" type="button"
                                                                title="supprimer" class="btn btn-danger  ml-2"
                                                                data-toggle="modal"
                                                                data-target="#delete-unit-modal">
                                                            <span class="fa fa-trash"></span>
                                                        </button>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

