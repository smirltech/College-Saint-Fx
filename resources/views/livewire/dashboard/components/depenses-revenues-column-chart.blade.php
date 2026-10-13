@php
    use App\Enums\PresenceStatus;use App\Models\Annee;use App\Models\Depense;use App\Models\Perception;use App\Models\Presence;use App\Models\Revenu;use Asantibanez\LivewireCharts\Models\ColumnChartModel;use Asantibanez\LivewireCharts\Models\LineChartModel;use Carbon\Carbon;use Carbon\CarbonInterval;
@endphp
<div>
    @php


        $dates = new DatePeriod(
    Annee::start(),
      CarbonInterval::month(),
     Annee::end()
   );

        $title = "Du ".$dates->start->format('d/m/Y')." au ".$dates->end->format('d/m/Y');

        $columnChartModel = (new ColumnChartModel())->multiColumn();

    foreach ($dates as $date) {
        $revenues = Perception::where('created_at', 'like', $date->format('Y-m').'%')->whereDevise('USD')->sum('montant');
        $depenses = Depense::where('created_at','like', $date->format('Y-m').'%')->whereDevise('USD')->sum('montant');

    $columnChartModel->addSeriesColumn('Peceptions', $date->format('M'), $revenues);
    $columnChartModel->addSeriesColumn('Depenses', $date->format('M'), $depenses);
    }
    @endphp
    <div class="card">
        <div class="card-header">
            Perceptions vs Depenses ({{$title}})
        </div>
        <div class="card-body" style="height: 350px;">
            <livewire:livewire-column-chart
                :column-chart-model="$columnChartModel"
            />
        </div>
    </div>
</div>
