@php
    // -----------------------
    // Backpack ChartJS Widget
    // -----------------------
    // Uses:
    // - Backpack\CRUD\app\Http\Controllers\ChartController
    // - https://github.com/ConsoleTVs/Charts
    // - https://github.com/chartjs/Chart.js

    $controller = is_a($widget['controller'], \Backpack\Pro\Http\Controllers\ChartController::class) ? $widget['controller'] : new $widget['controller'];
    $chart = $controller->chart;
    $path = $controller->getLibraryFilePath();

    // defaults
    $widget['wrapper']['class'] = $widget['wrapper']['class'] ?? $widget['wrapperClass'] ?? 'col-sm-6 col-md-4';

    // Fix highcharts background color
    if ($chart->container === 'charts::highcharts.container' && !isset($chart->options['chart']['backgroundColor'])) {
      $chart->options['chart']['backgroundColor'] = 'transparent';
    }

  $defaultTextColor = '#606060';
  if ($chart->container === 'charts::highcharts.container') {
      $chart->options['legend']['itemStyle']['color'] ??= $defaultTextColor;
  }

  // Echarts container - Fix legend, xAxis, and yAxis text color if not set
  if ($chart->container === 'charts::echarts.container') {
      $chart->options['legend']['textStyle']['color'] ??= $defaultTextColor;
      $chart->options['xAxis']['axisLabel']['textStyle']['color'] ??= $defaultTextColor;
      $chart->options['yAxis']['axisLabel']['textStyle']['color'] ??= $defaultTextColor;
  }
@endphp

<div class="card mb-4">
    <div class="card-body row">
        <div class="col-md-9">
            @if (isset($widget['content']['header']))
                <div class="card-header">
                    <div class="card-title mb-0">{!! $widget['content']['header'] !!}</div>
                </div>
            @endif
            <div class="card-body">
                {!! $widget['content']['body'] ?? '' !!}
                <div class="card-wrapper">
                    {!! $chart->container() !!}
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <h3>Statements</h3>
            <div class="row align-items-center mt-4">
                <div class="col-auto">
                    <span class="bg-primary text-white avatar">
                      <i class="la la-wallet fs-2"></i>
                    </span>
                </div>
                <div class="col">
                    <div class="font-weight-medium">
                        Cash
                    </div>
                    <div class="text-secondary">
                        €{{ $chart->options['statement']['cash'] }}
                    </div>
                </div>
            </div>
            <div class="row align-items-center mt-4">
                <div class="col-auto">
                    <span class="bg-warning text-white avatar">
                      <i class="la la-bank fs-2"></i>
                    </span>
                </div>
                <div class="col">
                    <div class="font-weight-medium">
                        Bank
                    </div>
                    <div class="text-secondary">
                        €{{ $chart->options['statement']['bank'] }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('after_scripts')
    {{-- JavaScript Bundle with Popper --}}
    @if (is_array($path))
        @foreach ($path as $string)
            @basset($string)
        @endforeach
    @elseif (is_string($path))
        @basset($path)
    @endif

    {!! $chart->script() !!}

@endpush
