@extends(backpack_view('blank'))

<style>
    .grid-2 {
        display: grid;
        grid-template-rows: auto;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }

</style>

@section('content')

<nav aria-label="breadcrumb" class="d-none d-lg-block">
	<ol class="breadcrumb bg-transparent p-0 justify-content-end">
	<li class="breadcrumb-item text-capitalize"><a href="http://localhost/dashboard">Admin</a></li>
	<li class="breadcrumb-item text-capitalize"><a href="http://localhost/reports">Reports</a></li>
	<li class="breadcrumb-item text-capitalize active" aria-current="page">List</li>
    </ol>
</nav>

<section class="header-operation container-fluid animated fadeIn d-flex mb-3 px-0 align-items-baseline d-print-none" bp-section="page-header">
    <h1 class="text-capitalize mb-0" bp-section="page-heading">Reports</h1>
</section>

<div class="form-group w-full col-md-6 required" element="div" bp-field-wrapper="true" bp-field-name="first_period_starts_at" bp-field-type="month" bp-section="crud-field">
    <label>Report by month</label>
    <input id="monthPicker" type="month" name="first_period_starts_at" value="{{ $selectedYear }}-{{ str_pad($selectedMonth, 2, '0', STR_PAD_LEFT) }}" class="form-control">
</div>

<div class="grid-2 mt-3">
    <div class="card">
        <div class="card-body">
            <h3>Incomes</h3>
            <div id="income-chart-container">
                <div id="income-chart" class="chart-lg"></div>
                <div id="income-no-data" class="text-center" style="display: none;">
                    <div class="spinner-border text-blue mt-6 mb-6" role="status"></div>
                    <p class="mt-3">No incomes available for this month.</p>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                    <tr>
                        <th>Type</th>
                        <th>Value</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($income as $type => $value)
                    <tr>
                        <td>{{ $type }}</td>
                        <td class="text-secondary">
                            € {{ \App\Models\Transaction::toCurrency($value) }}
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h3>Expenses</h3>
            <div id="expense-chart-container">
                <div id="expense-chart" class="chart-lg"></div>
                <div id="expense-no-data" class="text-center" style="display: none;">
                    <div class="spinner-border text-blue mt-6 mb-6" role="status"></div>
                    <p class="mt-3">No expenses available for this month.</p>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                    <tr>
                        <th>Type</th>
                        <th>Value</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($expenses as $type => $value)
                        <tr>
                            <td>{{ $type }}</td>
                            <td class="text-secondary">
                                € {{ \App\Models\Transaction::toCurrency($value) }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('after_scripts')
<script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/libs/apexcharts/dist/apexcharts.min.js" defer></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let selectedMonth = '{{ $selectedMonth }}';
        let selectedYear = '{{ $selectedYear }}';

        const monthPicker = document.getElementById('monthPicker');
        monthPicker.addEventListener('input', function() {
            const [year, month] = this.value.split('-');
            selectedMonth = month;
            selectedYear = year;
            window.location.href = `?month=${selectedMonth}&year=${selectedYear}`;
        });

        const incomeData = @json(array_values($income));
        const expenseData = @json(array_values($expenses));

        if (incomeData.length > 0) {
            new ApexCharts(document.getElementById('income-chart'), {
                chart: {
                    type: "donut",
                    fontFamily: 'inherit',
                    height: 240,
                    sparkline: { enabled: true },
                    animations: { enabled: false },
                },
                fill: { opacity: 1 },
                series: incomeData,
                labels: @json(array_keys($income)),
                tooltip: { theme: 'dark' },
                grid: { strokeDashArray: 4 },
                colors: [
                    tabler.getColor("primary"),
                    tabler.getColor("primary", 0.8),
                    tabler.getColor("primary", 0.6),
                    tabler.getColor("gray-300")
                ],
                legend: {
                    show: true,
                    position: 'bottom',
                    offsetY: 12,
                    markers: { width: 10, height: 10, radius: 100 },
                    itemMargin: { horizontal: 8, vertical: 8 }
                },
                tooltip: { fillSeriesColor: false }
            }).render();
        } else {
            document.getElementById('income-chart').style.display = 'none';
            document.getElementById('income-no-data').style.display = 'block';
        }

        if (expenseData.length > 0) {
            new ApexCharts(document.getElementById('expense-chart'), {
                chart: {
                    type: "donut",
                    fontFamily: 'inherit',
                    height: 240,
                    sparkline: { enabled: true },
                    animations: { enabled: false },
                },
                fill: { opacity: 1 },
                series: expenseData,
                labels: @json(array_keys($expenses)),
                tooltip: { theme: 'dark' },
                grid: { strokeDashArray: 4 },
                colors: [
                    tabler.getColor("primary"),
                    tabler.getColor("primary", 0.8),
                    tabler.getColor("primary", 0.6),
                    tabler.getColor("gray-300")
                ],
                legend: {
                    show: true,
                    position: 'bottom',
                    offsetY: 12,
                    markers: { width: 10, height: 10, radius: 100 },
                    itemMargin: { horizontal: 8, vertical: 8 }
                },
                tooltip: { fillSeriesColor: true }
            }).render();
        } else {
            document.getElementById('expense-chart').style.display = 'none';
            document.getElementById('expense-no-data').style.display = 'block';
        }
    });
</script>
@endsection
