@php
    use App\Models\Annee;use App\Models\Depense;use App\Models\Revenu;use Asantibanez\LivewireCharts\Models\ColumnChartModel;use Asantibanez\LivewireCharts\Models\PieChartModel;
@endphp
<x-admin-layout>
    <div class="row">
        <div class="col-12">
            <div class="row g-2">
                @foreach ($boxes as $box)
                    <div class="col-md-4" bis_skin_checked="1">
                        <div class="info-box" bis_skin_checked="1">
                                    <span class="info-box-icon  bg-{{ $box['theme'] }} elevation-1">
                                        <i class="{{ $box['icon'] }}"></i></span>
                            <div class="info-box-content" bis_skin_checked="1">
                                <span class="info-box-text">{{ $box['text'] }} </span>
                                <span class="info-box-number">{{ $box['title'] }}</span>
                                @isset($box['rate'])
                                    <div class="progress">
                                        <div class="progress-bar bg-{{ $box['theme'] }}" role="progressbar"
                                             style="width: {{$box['rate']}}%;"
                                             aria-valuenow="{{$box['rate']}}"
                                             aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                            </div>
                            @endisset
                        </div>
                    </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="col-md-4">
        <livewire:dashboard.components.children-presences-donut-chart/>
    </div>

    <div class="col-md-8">
        <livewire:dashboard.components.frais-due-card/>
    </div>

    <div class="col-md-12">
        <livewire:dashboard.components.children-card-component/>
    </div>
    </div>
</x-admin-layout>
