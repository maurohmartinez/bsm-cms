@extends(backpack_view('blank'))

@section('content')
<div class="container">
    <h1>Reports</h1>

    <div class="card">
        <div class="card-body">
            <h3>Incomes</h3>
            <div id="income-chart" class="chart-lg"></div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h3>Expenses</h3>
            <div id="expense-chart" class="chart-lg"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/libs/apexcharts/dist/apexcharts.min.js" defer></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (@json($incomeData).length > 0) {
                new ApexCharts(document.getElementById('income-chart'), {
                    chart: {
                        type: "donut",
                        fontFamily: 'inherit',
                        height: 240,
                        sparkline: {
                            enabled: true
                        },
                        animations: {
                            enabled: false
                        },
                    },
                    fill: {
                        opacity: 1,
                    },
                    series: @json($incomeData),
                    labels: @json($incomeLabels),
                    tooltip: {
                        theme: 'dark'
                    },
                    grid: {
                        strokeDashArray: 4,
                    },
                    colors: [tabler.getColor("primary"), tabler.getColor("primary", 0.8), tabler.getColor("primary", 0.6), tabler.getColor("gray-300")],
                    legend: {
                        show: true,
                        position: 'bottom',
                        offsetY: 12,
                        markers: {
                            width: 10,
                            height: 10,
                            radius: 100,
                        },
                        itemMargin: {
                            horizontal: 8,
                            vertical: 8
                        },
                    },
                    tooltip: {
                        fillSeriesColor: false
                    },
                }).render();
            }

            if (@json($expenseData).length > 0) {
                new ApexCharts(document.getElementById('expense-chart'), {
                    chart: {
                        type: "donut",
                        fontFamily: 'inherit',
                        height: 240,
                        sparkline: {
                            enabled: true
                        },
                        animations: {
                            enabled: false
                        },
                    },
                    fill: {
                        opacity: 1,
                    },
                    series: @json($expenseData),
                    labels: @json($expenseLabels),
                    tooltip: {
                        theme: 'dark'
                    },
                    grid: {
                        strokeDashArray: 4,
                    },
                    colors: [tabler.getColor("primary"), tabler.getColor("primary", 0.8), tabler.getColor("primary", 0.6), tabler.getColor("gray-300")],
                    legend: {
                        show: true,
                        position: 'bottom',
                        offsetY: 12,
                        markers: {
                            width: 10,
                            height: 10,
                            radius: 100,
                        },
                        itemMargin: {
                            horizontal: 8,
                            vertical: 8
                        },
                    },
                    tooltip: {
                        fillSeriesColor: false
                    },
                }).render();
            }
        });
    </script>
</div>
@endsection
