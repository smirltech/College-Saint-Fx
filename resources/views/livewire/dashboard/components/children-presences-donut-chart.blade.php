@php use App\Models\Annee; @endphp
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                Presences
            </div>
            <div class="col-md-6">
                <x-form::select
                    placeholder="Choisir un eleve"
                    wire:model="eleve_id"
                    :options="$eleves"
                />
            </div>
        </div>


    </div>
    <div class="card-body">
        <div>
            <p class="text-center">
                <strong>{{$eleve_id}}</strong>
            </p>
            <div>
                <div class="chartjs-size-monitor">
                    <div class="chartjs-size-monitor-expand">
                        <div class=""></div>
                    </div>
                    <div class="chartjs-size-monitor-shrink">
                        <div class=""></div>
                    </div>
                </div>

                <div class="align-content-center">
                    <canvas id="children-presences"
                            class="chartjs-render-monitor"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const chart = new Chart(
        document.getElementById('children-presences'), {
            type: 'doughnut',
            data: {
                labels: @json($labels),
                datasets: @json($dataset),
                borderWidth: 1,
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                //  cutoutPercentage: 50,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false,
                        text: 'Eleves'
                    }
                }
            }
        }
    );
</script>

