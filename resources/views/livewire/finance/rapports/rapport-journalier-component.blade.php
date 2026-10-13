@php use Carbon\Carbon; @endphp
@section('title')
    Collège Saint Fx - Rapport journalier
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Rapport Journalier</h1>
        </div>
        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('finance') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Rapport Journalier</li>
            </ol>
        </div>
    </div>
@stop

@php
    $debut = Carbon::parse($date_from);
    $fin   = Carbon::parse($date_to);
    $memeJour = $date_from === $date_to;
    $maxEleves = max(1, $sections->max('nb_eleves') ?? 1);
@endphp

<div class="container-fluid">


    <div class="card card-outline card-primary shadow-sm">
        <div class="card-body py-3">
            <div class="row align-items-end">


                <div class="col-lg-5 mb-2 mb-lg-0">
                    <label class="small text-muted mb-1 d-block">Période rapide</label>
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" wire:click="setPeriode('today')"
                                class="btn {{ $memeJour && $debut->isToday() ? 'btn-primary' : 'btn-outline-primary' }}">
                            Aujourd'hui
                        </button>
                        <button type="button" wire:click="setPeriode('yesterday')"
                                class="btn {{ $memeJour && $debut->isYesterday() ? 'btn-primary' : 'btn-outline-primary' }}">
                            Hier
                        </button>
                        <button type="button" wire:click="setPeriode('week')" class="btn btn-outline-primary">
                            Cette semaine
                        </button>
                        <button type="button" wire:click="setPeriode('month')" class="btn btn-outline-primary">
                            Ce mois
                        </button>
                    </div>
                </div>

                {{-- Dates --}}
                <div class="col-lg-5 mb-2 mb-lg-0">
                    <div class="row">
                        <div class="col-6">
                            <label for="date_from" class="small text-muted mb-1">Du</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input id="date_from" type="date" class="form-control"
                                       wire:model="date_from" max="{{ $date_to }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="date_to" class="small text-muted mb-1">Au</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input id="date_to" type="date" class="form-control"
                                       wire:model="date_to" min="{{ $date_from }}"
                                       max="{{ Carbon::today()->format('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="col-lg-2 text-lg-right">
                    <button type="button" wire:click="resetFiltre" class="btn btn-sm btn-light border" title="Réinitialiser">
                        <i class="fas fa-undo"></i>
                    </button>
                    <button type="button" wire:click="printIt" wire:loading.attr="disabled" wire:target="printIt"
                            class="btn btn-sm btn-danger">
                        <span wire:loading.remove wire:target="printIt"><i class="fa fa-file-pdf"></i> PDF</span>
                        <span wire:loading wire:target="printIt"><i class="fas fa-spinner fa-spin"></i></span>
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0 text-secondary">
            <i class="fas fa-chart-line mr-1"></i>
            @if($memeJour)
                Rapport du <strong>{{ $debut->translatedFormat('l d F Y') }}</strong>
            @else
                Rapport du <strong>{{ $debut->translatedFormat('d F Y') }}</strong>
                au <strong>{{ $fin->translatedFormat('d F Y') }}</strong>
                <span class="text-black ml-1">{{ $debut->diffInDays($fin) + 1 }} jours</span>
            @endif
        </h5>
        <span wire:loading wire:target="date_from,date_to,setPeriode,resetFiltre" class="text-muted small">
            <i class="fas fa-circle-notch fa-spin"></i> Mise à jour...
        </span>
    </div>

    <div wire:loading.class="opacity-50" wire:target="date_from,date_to,setPeriode,resetFiltre">


        <div class="row">
            <div class="col-md-4 col-sm-6">
                <div class="info-box shadow-sm">
                    <span class="info-box-icon bg-info"><i class="fas fa-user-graduate"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Élèves ayant payé</span>
                        <span class="info-box-number" style="font-size:1.6rem;">{{ $totalEleves }}</span>
                    </div>
                </div>
            </div>

            @forelse($totalGeneral as $devise => $total)
                <div class="col-md-4 col-sm-6">
                    <div class="info-box shadow-sm">
                        <span class="info-box-icon bg-success">
                            <i class="fas {{ strtoupper($devise) === 'USD' ? 'fa-dollar-sign' : 'fa-coins' }}"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total encaissé ({{ $devise }})</span>
                            <span class="info-box-number" style="font-size:1.6rem;">
                                {{ number_format($total, 2, ',', ' ') }}
                                <small>{{ $devise }}</small>
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-4 col-sm-6">
                    <div class="info-box shadow-sm">
                        <span class="info-box-icon bg-secondary"><i class="fas fa-wallet"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total encaissé</span>
                            <span class="info-box-number text-muted">0</span>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        @if($sections->isEmpty())


            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="far fa-folder-open fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Aucun paiement sur cette période</h5>
                    <p class="text-muted mb-3">Essayez une autre date ou élargissez la période.</p>
                    <button wire:click="setPeriode('month')" class="btn btn-outline-primary btn-sm">
                        Voir ce mois
                    </button>
                </div>
            </div>

        @else


            <div class="card shadow-sm">
                <div class="card-header border-0">
                    <h3 class="card-title"><i class="fas fa-layer-group mr-1"></i> Élèves ayant payé par section</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover mb-0">
                        <thead class="thead-light">
                        <tr>
                            <th style="width:40px;">#</th>
                            <th>Section</th>
                            <th class="text-center" style="width:140px;">Élèves</th>
                            <th style="width:35%;">Répartition</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sections as $section)
                            @php $pct = round(($section->nb_eleves / $maxEleves) * 100); @endphp
                            <tr>
                                <td class="text-muted">{{ $loop->iteration }}</td>
                                <td class="font-weight-bold">{{ $section->nom }}</td>
                                <td class="text-center">
                                    <span class="badge badge-info" style="font-size:.9rem;">{{ $section->nb_eleves }}</span>
                                </td>
                                <td class="align-middle">
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-info" style="width: {{ $pct }}%"></div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot class="bg-light font-weight-bold">
                        <tr>
                            <td></td>
                            <td>Total (élèves distincts)</td>
                            <td class="text-center">{{ $totalEleves }}</td>
                            <td></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="row">
                @foreach($sections as $section)
                    <div class="col-lg-6">
                        <div class="card card-outline card-primary shadow-sm">
                            <div class="card-header">
                                <h3 class="card-title font-weight-bold">{{ $section->nom }}</h3>
                                <div class="card-tools">
                                    <span class="badge badge-primary">
                                        <i class="fas fa-user-graduate"></i> {{ $section->nb_eleves }} élève(s)
                                    </span>
                                </div>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-sm table-striped mb-0">
                                    <thead class="thead-light">
                                    <tr>
                                        <th>Frais</th>
                                        <th class="text-center">Élèves</th>
                                        <th class="text-right">Montant</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($section->lignes as $ligne)
                                        <tr>
                                            <td>{{ $ligne->frais }}</td>
                                            <td class="text-center">
                                                <span class=" text-black">{{ $ligne->nb_eleves }}</span>
                                            </td>
                                            <td class="text-right text-nowrap">
                                                {{ number_format($ligne->total, 2, ',', ' ') }}
                                                <small class="text-muted">{{ $ligne->devise }}</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot class="bg-light">
                                    @foreach($section->totaux as $devise => $total)
                                        <tr class="font-weight-bold">
                                            <td colspan="2" class="text-right">Total {{ $devise }}</td>
                                            <td class="text-right text-success text-nowrap">
                                                {{ number_format($total, 2, ',', ' ') }} {{ $devise }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        @endif
    </div>
</div>



<style>
    .opacity-50 { opacity: .5; transition: opacity .15s; }
    .info-box .info-box-number small { font-size: .9rem; font-weight: 400; }
</style>