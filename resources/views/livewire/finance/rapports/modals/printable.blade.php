    @php use App\Enums\FraisType;use App\Enums\RevenuType;use App\Models\Annee;use App\Models\Depense;use App\Models\DepenseType;use App\Models\Perception;use App\Models\Revenu;use Illuminate\Support\Carbon;use Illuminate\Support\Facades\DB; @endphp

    @php
        $soldeCDF = DB::table('perceptions')
                ->where('devise', 'CDF')
                ->sum('montant') +
                DB::table('revenus')
                ->where('devise', 'CDF')
                ->sum('montant') -
                DB::table('depenses')
                ->where('devise', 'CDF')
                ->sum('montant');

        $soldeUSD =  DB::table('perceptions')
                ->where('devise', 'USD')
                ->sum('montant') +
                DB::table('revenus')
                ->where('devise', 'USD')
                ->sum('montant') -
                DB::table('depenses')
                ->where('devise', 'USD')
                ->sum('montant');
    @endphp
    <div>
        <div class="">
            <div style="text-align: center;" class=" justify-content-center">
                  COLLÈGE ST FRANÇOIS XAVIER FINANCE - {{$anneeNom}}
            </div>
            <br>
        </div>
        <div class="">
            <div class="card">
                <div style="display: flex; justify-content: space-between" class="card-header">
                    <div class="card-title">Rapport financier de la période
                        du {{Carbon::parse($date_from)->format('d/m/Y')}}
                        au {{Carbon::parse($date_to)->format('d/m/Y')}}</div>
                    <div class="card-tools d-flex">
                        <div class="ml-2"> Compte : {{auth()->user()->name}}</div>
                        <div class="ml-2"> Date : {{Carbon::now()->format('d-m-Y H:i')}}</div>
                    </div>
                </div>
                <div class="card-body m-b-5">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>ENTREES</h4>
                            <hr>
                            <ol class="list-group">
                                @if($perception != 0)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <strong>Perceptions</strong>
                                    </li>
                                    <table class="table table-bordered table-striped">
                                        <thead class="text-center">
                                        <tr class="titres text-uppercase">
                                            <th rowspan="2">Libellé</th>
                                            <th colspan="2">Fc</th>
                                            <th colspan="2">$</th>
                                        </tr>
                                        <tr class="titres">
                                            <th>Nbre</th>
                                            <th>Montant</th>
                                            <th>Nbre</th>
                                            <th>Montant</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php


                                            $perceptionCDFCountTotal = 0;
                                            $perceptionUSDCountTotal = 0;

                                            $perceptionCDFTotal = 0;
                                            $perceptionUSDTotal = 0;
                                        @endphp
                                        @foreach(FraisType::cases() as $k=>$type)
                                            @php
                                                $perceptionQuery = Perception::whereHas('frais', function ($q) use ($type) {
                                                    $q->where('type', $type);
                                                })
                                                ->whereDate('created_at', '>=', $date_from)
                                                ->whereDate('created_at', '<=', $date_to);

                                                $perceptionCDFCount = $perceptionQuery->clone()->cdf()->count();
                                                $perceptionUSDCount = $perceptionQuery->clone()->usd()->count();

                                                $perceptionCDF = $perceptionQuery->clone()->cdf()->sum('montant');
                                                $perceptionUSD = $perceptionQuery->clone()->usd()->sum('montant');

                                                   if(!$perceptionUSDCount && !$perceptionCDFCount){
                                                    continue;
                                                }

                                                $perceptionCDFCountTotal += $perceptionCDFCount;
                                                $perceptionUSDCountTotal += $perceptionUSDCount;
                                                $perceptionCDFTotal += $perceptionCDF;
                                                $perceptionUSDTotal += $perceptionUSD;


                                            @endphp
                                            <tr class="titres">
                                                <td style="text-align: left">{{$type->label()}}</td>
                                                <td class="text-center">{{$perceptionCDFCount}}</td>
                                                <td class="text-center">{{number_format($perceptionCDF)}}</td>
                                                <td class="text-center">{{$perceptionUSDCount}}</td>
                                                <td class="text-center">{{number_format($perceptionUSD)}}</td>
                                            </tr>

                                        @endforeach
                                        <tr class="titres">
                                            <th>Total</th>
                                            <th class="text-center">{{number_format($perceptionCDFCountTotal)}}</th>
                                            <th class="text-center">{{number_format($perceptionCDFTotal)}}Fc</th>
                                            <th class="text-center">{{number_format($perceptionUSDCountTotal)}}</th>
                                            <th class="text-center">{{number_format($perceptionUSDTotal)}}$</th>
                                        </tr>
                                        </tbody>
                                    </table>
                                @endif
                                @if($revenuAuxiliaire != 0)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <strong>Revenus Auxiliaires</strong>
                                    </li>
                                    <table class="table table-bordered table-striped">
                                        <thead class="text-center text-uppercase">
                                        <tr class="titres">
                                            <th>Libellé</th>
                                            <th>Fc</th>
                                            <th>$</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $perceptionCDFCountTotal = 0;
                                            $perceptionUSDCountTotal = 0;
                                            $perceptionCDFTotal = 0;
                                            $perceptionUSDTotal = 0;
                                        @endphp
                                        @foreach(RevenuType::cases() as $k=>$type)
                                            @php
                                                $revenuQuery = Revenu::where('type', $type)
                                                ->whereDate('created_at', '>=', $date_from)
                                                ->whereDate('created_at', '<=', $date_to);

                                               // $perceptionCDFCount = $revenuQuery->clone()->cdf()->count();
                                              //  $perceptionUSDCount = $revenuQuery->clone()->usd()->count();

                                                $perceptionCDF = $revenuQuery->clone()->cdf()->sum('montant');
                                                $perceptionUSD = $revenuQuery->clone()->usd()->sum('montant');


                                                if(!$perceptionUSD && !$perceptionCDF){
                                                    continue;
                                                }

                                              //  $perceptionCDFCountTotal += $perceptionCDFCount;
                                               // $perceptionUSDCountTotal += $perceptionUSDCount;
                                                $perceptionCDFTotal += $perceptionCDF;
                                                $perceptionUSDTotal += $perceptionUSD;



                                            @endphp
                                            <tr class="titres">
                                                <td style="text-align: left">{{$type->label()}}</td>
                                                <td class="text-center">{{number_format($perceptionCDF)}}</td>
                                                <td class="text-center">{{number_format($perceptionUSD)}}</td>
                                            </tr>

                                        @endforeach
                                        <tr class="titres">
                                            <th>Total</th>
                                            <th class="text-center">{{number_format($perceptionCDFTotal)}}Fc</th>
                                            <th class="text-center">{{number_format($perceptionUSDTotal)}}$</th>
                                        </tr>
                                        </tbody>
                                    </table>
                                @endif
                            </ol>
                        </div>
                        <div class="col-md-6">
                            <h4>SORTIES</h4>
                            <hr>
                            <table class="table table-bordered table-striped">
                                <thead class="text-center text-uppercase">
                                <tr class="titres">
                                    <th>Libellé</th>
                                    <th>Fc</th>
                                    <th>$</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $depensesCDFTotal = 0;
                                    $depensesUSDTotal = 0;
                                @endphp
                                @foreach(DepenseType::all() as $depenseType)
                                    @php
                                        $depenseQuery = Depense::where('depense_type_id', $depenseType->id)
                                            ->whereDate('date', '>=', $date_from)
                                            ->whereDate('date', '<=', $date_to);

                                            $depensesUSD = $depenseQuery->clone()->usd()->sum('montant');
                                            $depensesCDF = $depenseQuery->clone()->cdf()->sum('montant');

                                            if(!$depensesUSD && !$depensesCDF){
                                                continue;
                                            }

                                            $depensesCDFTotal += $depensesCDF;
                                            $depensesUSDTotal += $depensesUSD;



                                    @endphp
                                    <tr class="titres">
                                        <td style="text-align: left">{{$depenseType->nom}}</td>
                                        <td class="text-center">
                                            {{number_format($depensesCDF)}}
                                        </td>
                                        <td class="text-center">
                                            {{number_format($depensesUSD)}}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="titres">
                                    <th>Total</th>
                                    <th class="text-center">{{number_format($depensesCDFTotal)}} Fc</th>
                                    <th class="text-center">{{number_format($depensesUSDTotal)}} $</th>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h4>SOLDE</h4>
                            <hr>
                            <ol class="list-group">
                                <li class="list-group m-1
                                @if($soldeCDF < 0)
                                    list-group-item-danger
                                @else
                                    list-group-item-success
                                @endif
                                    d-flex justify-content-between align-items-center">
                                    <strong>CDF {{number_format($soldeCDF)}} </strong>
                                </li>
                                <li class="list-group m-1
                                @if($soldeUSD < 0)
                                    list-group-item-danger
                                @else
                                    list-group-item-success
                                @endif
                                d-flex justify-content-between align-items-center">
                                    <strong>USD {{number_format($soldeUSD)}}</strong>
                                </li>


                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style>

            table {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
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
