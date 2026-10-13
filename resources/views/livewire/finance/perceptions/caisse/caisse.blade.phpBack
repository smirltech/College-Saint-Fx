@php
    use App\Enums\InscriptionCategorie;use Carbon\Carbon;
    use App\Enums\GraviteRetard;
    use App\Helpers\Helpers;
@endphp
@section('title')
    Caisse  {{date('d-m-Y')}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3"> Perception </h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('finance') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Caisse</li>
            </ol>
        </div>
    </div>

@stop
<div wire:ignore.self class="">
    @include('livewire.finance.perceptions.caisse.modals.paiement')
    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h4>Liste d'élèves</h4>
                            </div>
                        </div>
                        <div class="card-body m-b-40">
                            <div class="row mb-3">
                                <div class="col-1">
                                    @php
                                        $annee = \App\Models\Annee::encours();
                                        $nbEleves = $inscriptions->where('annee_id', \App\Models\Annee::encours()->id);

                                        @endphp
                                    <span class="input-group-text rounded">{{count($nbEleves)}}</span>
                                </div>
                                <div class="col-5">
                                    <x-form::select
                                        wire:model="classe_id"
                                        :options="$classes"
                                        placeholder="Classe"/>
                                </div>

                                <div class="col-5">
                                    <x-form::select
                                        wire:model="inscription_id"
                                        :options="$inscriptionOptions"
                                        placeholder="Elève"/>
                                </div>

                                <div class="col-1">
                                    <button wire:click.debounce="clearSearch" title="Annuler recherche"
                                            class="btn btn-default">
                                        <i class="fas fa-close"></i>
                                    </button>
                                </div>
                            </div>
                            <div class=" table-responsive">
                                <table class="table table-striped">
                                    <thead class="bg-primary">
                                    <tr>
                                        <th style="width: 50px;">#</th>
                                        <th>MATRICULE</th>
                                        <th>NOM</th>
                                        <th>CATEGORIE</th>
                                        <th>CLASSE</th>
                                        <th style="width: 50px;"></th>

                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($inscriptions as $i=>$inscrit)
                                        @if($inscrit->annee->encours)
                                            <tr>
                                                <td>{{$i+1}}</td>
                                                <td>{{$inscrit->matricule}}</td>
                                                <td>{{$inscrit->fullName}}</td>
                                                <td>{{$inscrit->categorie?->label()}}</td>
                                                <td>{{$inscrit->classe->code}}</td>
                                                <td>

                                                    <div class="d-flex float-right">
                                                        <button
                                                            onclick="showModal('finance.perception.perception-create-component','{{$inscrit->id}}')"
                                                            title="Payer facture"
                                                            class="btn btn-primary btn-sm m-1">
                                                            <i class="fas fa-hand-holding-dollar"></i>
                                                        </button>
                                                        <button wire:click="getSelectedInscription('{{$inscrit->id}}')"
                                                                title="Voir élève"
                                                                class="btn btn-info btn-sm m-1">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </td>

                                            </tr>
                                        @endif

                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h4>Élève : {{$inscription?->fullName}}
                                    - {{$inscription?->categorie?->label()??'N/A'}}</h4>
                            </div>
                            <div class="card-tools d-flex my-auto">
                                @if($inscription != null)
                                    <button wire:click.debounce="clearSelection" title="Annuler"
                                            class="btn btn-default  ml-2">
                                        <i class="fas fa-close"></i>
                                    </button>
                                @endif

                            </div>
                        </div>
                        <div class="card-body m-b-40">

                            <div class="">
                                <table class="table mb-3">
                                    <thead class="bg-primary">
                                    <tr>
                                        <th>#</th>
                                        <th>FRAIS A PAYER</th>
                                        <th>MONTANT DU</th>
                                        <th>MONTANT PAYE</th>
                                        <th>RESTE</th>
                                        <th>DATE</th>
                                        <th>ACTION</th>

                                    </tr>
                                    </thead>
                                    @foreach($perceptions ?? [] as $percept)
                                        @php($reste =$percept->reste)
                                        <tr>
                                            <td> {{$loop->iteration}}
                                            <td> {{$percept->label}}</td>
                                            <td>
                                                {{number_format($percept->frais_montant)}} {{ $percept->frais->devise }}
                                            </td>
                                            <td>
                                                {{number_format($percept->montant)}} {{ $percept->devise }}
                                            </td>
                                            <td>
                                                <span class="badge badge-{{Helpers::balanceColor($reste)}}">
                                                {{$reste }} {{ $percept->frais->devise }}
                                            </span>
                                            </td>
                                            <td>
                                                {{ Carbon::parse($percept->created_at)->format('d/m/Y')}}
                                            </td>
                                            <td>
                                                <x-form::button
                                                    link="{{route('finance.perceptions.print', ['perception' => $percept->id])}}"
                                                    class="btn btn-info btn-sm m-1">
                                                    <i class="fas fa-print"></i>
                                                </x-form::button>
                                                <x-form::button
                                                    onclick="showModal('finance.perception.perception-create-component','{{$percept->inscription->id}}','{{$percept->id}}')"
                                                    class="btn btn-warning btn-sm m-1">
                                                    <i class="fas fa-edit"></i>
                                                </x-form::button>
                                                <x-form::button
                                                    onclick="showDeleteModal('Perception','{{$percept->id}}')"
                                                    class="btn btn-danger btn-sm m-1">
                                                    <i class="fas fa-trash"></i>
                                                </x-form::button>
                                            </td>

                                        </tr>
                                    @endforeach

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

