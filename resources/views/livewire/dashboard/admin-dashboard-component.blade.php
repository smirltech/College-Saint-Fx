@php
    use App\Models\Annee;
    use App\Models\Depense;
    use App\Models\Revenu;
    use App\Enums\Devise;
    use Asantibanez\LivewireCharts\Models\ColumnChartModel;
    use Asantibanez\LivewireCharts\Models\PieChartModel;
@endphp
<x-admin-layout>
    <div class="pb-3"></div>
    {{--<div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="info-box bg-primary">
                    --}}{{--<span class="info-box-icon">
                        <i class="far fa-bookmark"></i></span>--}}{{--
                    <div class="info-box-content">
                        --}}{{-- <span class="info-box-text">Bookmarks</span>--}}{{--
                        --}}{{--  <span class="info-box-number">41,410</span>--}}{{--
                        <div class="progress">
                            <div class="progress-bar" style="width: 70%"></div>
                        </div>
                        <span class="progress-description">
70% Increase in 30 Days
</span>
                    </div>

                </div>

            </div>
        </div>--}}
    <div class="row">
        <div class="col-12">
            <div class="row g-2">
                @foreach ($boxes as $box)
                    <div class="col-md-3" bis_skin_checked="1">
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
        <div class="col-md-8">
            <livewire:dashboard.components.depenses-revenues-column-chart/>
        </div>

        <div class="col-md-4">
            @php
                $pieChartModel = (new PieChartModel());
                           $pieChartModel->setTitle(Annee::encours()->nom)
                           ->addSlice('Revenues', Revenu::total($devise), '#00ff00')
                           ->addSlice('Depenses', Depense::total($devise), '#ff0000');
            @endphp
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            Comparaison Revenues vs Depenses
                        </div>
                        <div class="col-md-6">
                            <x-form::select
                                wire:model="devise"
                                :options="Devise::cases()"
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
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <x-charts.male-female-donut-chart/>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <livewire:dashboard.components.frais-due-card/>
        </div>

        <div class="col-md-6">
            <livewire:dashboard.components.recettes-recentes-card/>
        </div>
        <div class="col-md-6">
            <livewire:dashboard.components.depenses-recentes-card/>
        </div>
        <div class="col-md-12">
            <livewire:scolarite.presences.charts.presences-line/>
        </div>
    </div>
</x-admin-layout>
