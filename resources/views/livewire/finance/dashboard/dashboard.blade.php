@php use App\Enums\Mois; @endphp
<section class="content">

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="row g-2">
                    @foreach ($boxes as $box)
                        <div class="col-12 col-sm-6 col-md-3" bis_skin_checked="1">
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
            </div>
        </div>
        <div class="row" bis_skin_checked="1">
            <div class="col-md-12" bis_skin_checked="1">
                <div class="card" bis_skin_checked="1">
                    <div class="card-header" bis_skin_checked="1">
                        <h5 class="card-title">Racapitulatif des opérations de {{$dayCount}} jours</h5>
                        <div class="card-tools" bis_skin_checked="1">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body" bis_skin_checked="1">
                        <div class="row" bis_skin_checked="1">
                            <div class="col-md-8" bis_skin_checked="1">
                                <livewire:finance.dashboard.components.home-dashboard-graph :day-count="$dayCount"/>
                            </div>

                            <div class="col-md-4" bis_skin_checked="1">
                                <livewire:finance.dashboard.components.home-dashboard-performance
                                    :day-count="$dayCount"/>
                            </div>

                        </div>

                    </div>

                    <div class="card-footer" bis_skin_checked="1">
                        <livewire:finance.dashboard.components.home-totaux :day-count="$dayCount"/>
                    </div>

                </div>

            </div>

        </div>
    </div>
</section>
