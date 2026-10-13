@php

    use App\Models\Annee;use Asantibanez\LivewireCharts\Models\PieChartModel;$pieChartModel = (new PieChartModel());
               $pieChartModel->setTitle(Annee::encours()->nom)
               ->addSlice('Revenues', $revenuTotal, '#00ff00')
               ->addSlice('Depenses', $depenseTotal, '#ff0000');
@endphp
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                Revenues vs Depenses
            </div>
            <div class="col-md-6">
                <x-form::select
                    wire:model="annee_id"
                    :options="Annee::all()"
                />
            </div>
        </div>


    </div>
    <div class="card-body" style="height: 350px;">
        <livewire:livewire-pie-chart
            key="{{ $pieChartModel->reactiveKey() }}"
            :pie-chart-model="$pieChartModel"
        />
    </div>
</div>
