@php use App\Enums\Devise;use App\Enums\FraisType;use App\Enums\RevenuType;use App\Models\Annee;use App\Models\Classe;use App\Models\Frais;use App\Models\Perception;use App\Models\Revenu;use App\Models\Section;use Illuminate\Support\Carbon; @endphp
<div>
    <div class="">
        <div style="text-align: center;" class=" justify-content-center">
             COLLÈGE ST FRANÇOIS XAVIER FINANCE - {{$anneeNom ?? ''}}
        </div>
        <br>
    </div>
    <div class="">
        <div class="card">
            <div style="display: flex; justify-content: space-between" class="card-header">
                <div class="card-title">Insolvables / En ordres
                    <div class="card-tools d-flex">
                        <div class="ml-2">Section : {{Section::find($frais_id)?->nom}} Classe
                            : {{Classe::find($classe_id)?->nom}}</div>
                        <div class="ml-2"> Frais : {{Frais::find($frais_id)?->nom}}</div>
                        <div class="ml-2"> Compte : {{auth()->user()->name}}</div>
                        <div class="ml-2"> Date : {{Carbon::now()->format('d-m-Y H:i')}}</div>
                    </div>
                </div>
            </div>
            @if($frais_id)
                <div class="card-body m-b-5">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>En ordre</h4>
                            <hr>
                            <table class="table table-bordered table-striped">
                                <thead class="text-center">
                                <tr class="titres text-uppercase">
                                    <th rowspan="2">NO.</th>
                                    <th rowspan="2">ELEVE</th>
                                    <th rowspan="2">CLASSE</th>
                                    <th rowspan="2">FRAIS</th>
                                    <th colspan="2">MONTANT PAYÉ</th>
                                </tr>
                                <tr class="titres text-uppercase">
                                    <th>Fc</th>
                                    <th>$</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $totalCDF = 0;
                                    $totalUSD = 0;
                                @endphp
                                @foreach($this->perceptions??[] as $perception)
                                    <tr class="cotes">
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$perception->inscription->label}}</td>
                                        <td>{{$perception->classe}}</td>
                                        <td>{{$perception->label}}</td>
                                        @if($perception->devise == Devise::CDF)
                                            <td>{{number_format($perception->montant)}} Fc</td>
                                            <td>-</td>
                                            @php
                                                $totalCDF += $perception->montant;
                                            @endphp
                                        @else
                                            <td>-</td>
                                            <td>{{number_format($perception->montant)}} $</td>
                                            @php
                                                $totalUSD += $perception->montant;
                                            @endphp
                                        @endif
                                    </tr>
                                @endforeach
                                <tr class="titres">
                                    <td colspan="4">Total</td>
                                    <td>{{number_format($totalCDF)}} Fc</td>
                                    <td>{{number_format($totalUSD)}} $</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <h4>Insolvables</h4>
                            <hr>
                            <table class="table table-bordered table-striped">
                                <thead class="text-center">
                                <tr class="titres text-uppercase">
                                    <th>NO.</th>
                                    <th>ELEVE</th>
                                    <th>CLASSE</th>
                                    <th>FRAIS</th>
                                    <th>MONTANT</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $totalCDF = 0;
                                    $totalUSD = 0;
                                    $totalPaidCDF = 0;
                                    $totalPaidUSD = 0;
                                @endphp
                                @foreach($this->insolvables??[] as $insolvable)
                                    @php
                                        $frais = Frais::find($frais_id);
                                    @endphp
                                    <tr class="cotes">
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$insolvable->label}}</td>
                                        <td>{{$insolvable->classe->code}}</td>
                                        <td>{{$frais?->nom}}</td>
                                        <td class="text-center">{{number_format($frais->montant??0)}} {{$frais?->devise}}</td>
                                       {{-- <td class="text-center">{{number_format($frais->paidCDF()) ?? 0}} Fc</td>
                                        <td class="text-center">{{number_format($frais->paidUSD()) ?? 0}} $</td>--}}
                                       {{-- @php
                                            $totalUSD += $frais?->montant;
                                            $totalPaidUSD += $frais->paidUSD();
                                            $totalPaidCDF += $frais->paidCDF();
                                        @endphp--}}
                                    </tr>
                                @endforeach
                                <tr class="titres">
                                    <td colspan="4">Total</td>
                                    <td>{{number_format($totalUSD)}} {{$frais?->devise}}</td>
                                   {{-- <td>{{number_format($totalPaidCDF)}} Fc</td>
                                    <td>{{number_format($totalPaidUSD)}} $</td>--}}
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-danger">
                    Veuillez sélectionner un frais pour afficher la liste des insolvables.
                </div>
            @endif
        </div>
        <style>

            table {
                font-family: " Trebuchet MS ", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                border-spacing: 0;
                width: 100%;
                border: #454342;
            }


            .titres > th, .titres > td, .cotes > td {
                border: 1px solid gray;
                padding: 3px;
            }

            .titres > td, .titres > th {
                text-align: center;
                font-weight: 500;
                padding: 5px;

            }

            .titres > th {
                font-weight: bold;

            }


        </style>

    </div>
</div>