<div>
    <p class="text-center">
        <strong>Opérations du {{$dateDebut}} au {{$dateFin}}</strong>
    </p>
    <div class="">
        <div class="chartjs-size-monitor">
            <div class="chartjs-size-monitor-expand">
                <div class=""></div>
            </div>
            <div class="chartjs-size-monitor-shrink">
                <div class=""></div>
            </div>
        </div>

        <canvas id="homeChart" height="225"
                style="height: 180px; display: block; width: 538px;" width="672"
                class="chartjs-render-monitor"></canvas>
    </div>
</div>


@push('js')
    <script>
        const chart = new Chart(
            document.getElementById('homeChart'), {
                type: 'line',
                data: {
                    labels: @json($labels),
                    datasets: @json($dataset),
                    borderWidth: 1,
                },
                options: {
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    },
                    responsive: true,
                    scales: {
                        x: {
                            stacked: true,
                        },
                        y: {
                            stacked: true,
                        }
                    }
                }
            }
        );
    </script>
@endpush
