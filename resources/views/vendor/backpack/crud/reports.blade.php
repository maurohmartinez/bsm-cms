@extends(backpack_view('blank'))

@php
    $defaultBreadcrumbs = [
      trans('backpack::crud.admin') => backpack_url('dashboard'),
      'Reports' => backpack_url('reports'),
      trans('backpack::crud.edit') => false,
    ];

    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-baseline d-print-none" bp-section="page-header">
        <h1 class="text-capitalize mb-0" bp-section="page-heading">Reports</h1>
        <p class="ms-2 ml-2 mb-0" bp-section="page-subheading">Income and expenses.</p>
        <p class="mb-0 ms-2 ml-2" bp-section="page-subheading-back-button">
            <small>
                <a href="{{ backpack_url('transaction') }}" class="d-print-none font-sm">
                    <i class="la la-angle-double-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i> Transactions}
                    <span>Reports.</span>
                </a>
            </small>
        </p>
    </section>
@endsection

@section('content')
    <div class="row grid-2">
        <div class="col-12 mb-3">
            <input id="monthPicker" type="month" name="first_period_starts_at" value="{{ $selectedYear }}-{{ str_pad($selectedMonth, 2, '0', STR_PAD_LEFT) }}" class="form-control">
        </div>
        <div class="col-md-6">
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
        </div>
        <div class="col-md-6">
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
    </div>

@endsection

@section('after_scripts')
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script>
        (() => {
            let selectedMonth = '{{ $selectedMonth }}';
            let selectedYear = '{{ $selectedYear }}';

            const monthPicker = document.getElementById('monthPicker');
            monthPicker.addEventListener('input', function () {
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
                        sparkline: {enabled: true},
                        animations: {enabled: false},
                    },
                    fill: {opacity: 1},
                    series: incomeData,
                    labels: @json(array_keys($income)),
                    tooltip: {theme: 'dark'},
                    grid: {strokeDashArray: 4},
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
                        markers: {width: 10, height: 10, radius: 100},
                        itemMargin: {horizontal: 8, vertical: 8}
                    },
                    tooltip: {fillSeriesColor: false}
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
                        sparkline: {enabled: true},
                        animations: {enabled: false},
                    },
                    fill: {opacity: 1},
                    series: expenseData,
                    labels: @json(array_keys($expenses)),
                    tooltip: {theme: 'dark'},
                    grid: {strokeDashArray: 4},
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
                        markers: {width: 10, height: 10, radius: 100},
                        itemMargin: {horizontal: 8, vertical: 8}
                    },
                    tooltip: {fillSeriesColor: true}
                }).render();
            } else {
                document.getElementById('expense-chart').style.display = 'none';
                document.getElementById('expense-no-data').style.display = 'block';
            }
        })();
    </script>
@endsection
