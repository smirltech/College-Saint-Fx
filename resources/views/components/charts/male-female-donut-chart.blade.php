<div>
    <p class="text-center">
        <strong>Eleves</strong>
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

        <div>
            <canvas id="male-female-chart"
                    class="chartjs-render-monitor"></canvas>
        </div>
    </div>
</div>


@push('js')
    <script>
        const chart = new Chart(
            document.getElementById('male-female-chart'), {
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
                            display: true,
                            text: 'Eleves'
                        }
                    }
                }
            }
        );
    </script>
@endpush
