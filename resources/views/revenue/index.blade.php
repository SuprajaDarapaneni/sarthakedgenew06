@extends('layouts.master')

@section('title')
    Revenue
@endsection

@section('content')
<style>
    :root {
        --rev-primary: #1a237e;
        --rev-secondary: #283593;
        --rev-accent: #3949ab;
        --rev-light: #e8eaf6;
        --rev-green: #00897b;
        --rev-purple: #7b1fa2;
        --rev-orange: #f57c00;
        --rev-blue2: #1565c0;
    }

    .rev-page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 24px;
    }
    .rev-page-header h2 {
        font-size: 26px;
        font-weight: 800;
        color: #1a237e;
        margin: 0 0 4px 0;
    }
    .rev-page-header p {
        color: #6c757d;
        margin: 0;
        font-size: 13px;
    }
    .rev-header-actions { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }

    .rev-year-select {
        border: 1.5px solid #c5cae9;
        border-radius: 8px;
        padding: 7px 14px;
        font-size: 13px;
        color: #1a237e;
        background: #fff;
        cursor: pointer;
        min-width: 130px;
        outline: none;
    }
    .rev-export-btn {
        border: 1.5px solid #c5cae9;
        border-radius: 8px;
        padding: 7px 18px;
        font-size: 13px;
        color: #1a237e;
        background: #fff;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: background 0.2s;
    }
    .rev-export-btn:hover { background: #e8eaf6; color: #1a237e; text-decoration: none; }

    /* ---- Stat Cards ---- */
    .rev-stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 20px; }
    @media (max-width: 1100px) { .rev-stats-row { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 600px) { .rev-stats-row { grid-template-columns: 1fr; } }

    .rev-stat-card {
        background: #fff;
        border-radius: 14px;
        padding: 22px 22px 18px;
        border: 1px solid #e8eaf6;
        box-shadow: 0 2px 8px rgba(26,35,126,0.06);
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 10px;
    }
    .rev-stat-left {}
    .rev-stat-label {
        font-size: 12px;
        color: #6c757d;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        margin-bottom: 6px;
    }
    .rev-stat-value {
        font-size: 26px;
        font-weight: 800;
        color: #1a237e;
        line-height: 1.2;
        margin-bottom: 6px;
    }
    .rev-stat-growth {
        font-size: 12px;
        font-weight: 600;
        color: #00897b;
        display: flex;
        align-items: center;
        gap: 3px;
    }
    .rev-stat-growth.negative { color: #c62828; }
    .rev-stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 18px;
    }
    .rev-stat-icon.blue   { background: #e8eaf6; color: #1a237e; }
    .rev-stat-icon.green  { background: #e0f2f1; color: #00897b; }
    .rev-stat-icon.sky    { background: #e3f2fd; color: #1565c0; }
    .rev-stat-icon.purple { background: #f3e5f5; color: #7b1fa2; }

    /* ---- Charts Row ---- */
    .rev-charts-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px; }
    @media (max-width: 900px) { .rev-charts-row { grid-template-columns: 1fr; } }

    .rev-card {
        background: #fff;
        border-radius: 14px;
        border: 1px solid #e8eaf6;
        box-shadow: 0 2px 8px rgba(26,35,126,0.06);
        padding: 24px;
    }
    .rev-card-title {
        font-size: 16px;
        font-weight: 700;
        color: #1a237e;
        margin-bottom: 4px;
    }
    .rev-card-subtitle {
        font-size: 12px;
        color: #9e9e9e;
        margin-bottom: 18px;
    }

    /* Legend */
    .rev-legend { display: flex; gap: 18px; flex-wrap: wrap; margin-top: 14px; }
    .rev-legend-item { display: flex; align-items: center; gap: 6px; font-size: 12px; color: #555; }
    .rev-legend-dot { width: 11px; height: 11px; border-radius: 50%; display: inline-block; }

    /* ---- Revenue Breakdown ---- */
    .rev-breakdown-row { display: grid; grid-template-columns: 1fr; gap: 16px; margin-bottom: 20px; }
    .rev-breakdown-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .rev-breakdown-item:last-child { border-bottom: none; }
    .rev-breakdown-left { display: flex; align-items: center; gap: 14px; }
    .rev-breakdown-dot { width: 14px; height: 14px; border-radius: 50%; flex-shrink: 0; }
    .rev-breakdown-name { font-size: 14px; font-weight: 600; color: #212121; }
    .rev-breakdown-pct  { font-size: 12px; color: #9e9e9e; margin-top: 2px; }
    .rev-breakdown-right { text-align: right; }
    .rev-breakdown-amount { font-size: 16px; font-weight: 700; color: #1a237e; }
    .rev-breakdown-change { font-size: 12px; color: #00897b; font-weight: 600; margin-top: 2px; }

    /* ---- Stacked Bar Chart ---- */
    .rev-stacked-section { margin-bottom: 20px; }

    /* ---- Export Reports ---- */
    .rev-export-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
    @media (max-width: 700px) { .rev-export-row { grid-template-columns: 1fr; } }
    .rev-export-card {
        background: #fff;
        border: 1.5px solid #e8eaf6;
        border-radius: 12px;
        padding: 22px;
        text-align: center;
        cursor: pointer;
        transition: box-shadow 0.2s, border-color 0.2s;
    }
    .rev-export-card:hover { box-shadow: 0 4px 18px rgba(26,35,126,0.12); border-color: #c5cae9; }
    .rev-export-card i { font-size: 22px; margin-bottom: 8px; display: block; }
    .rev-export-card .rev-ec-title { font-size: 13px; font-weight: 700; color: #212121; }
    .rev-export-card .rev-ec-label { font-size: 11px; color: #9e9e9e; }

    /* first card download icon */
    .rev-export-card:nth-child(1) i { color: #1a237e; }
    .rev-export-card:nth-child(2) i { color: #00897b; }
    .rev-export-card:nth-child(3) i { color: #f57c00; }
</style>

<div class="content-wrapper">
    <div class="container-fluid py-3">

        {{-- Page Header --}}
        <div class="rev-page-header">
            <div>
                <h2>Revenue</h2>
                <p>SarthakEdge financial overview and analytics</p>
            </div>
            <div class="rev-header-actions">
                <form method="GET" action="{{ route('revenue.index') }}" id="yearFilterForm">
                    <select name="year" class="rev-year-select" onchange="document.getElementById('yearFilterForm').submit()">
                        @foreach(array_reverse($availableYears) as $yr)
                            <option value="{{ $yr }}" @selected($yr == $year)>{{ $yr }}</option>
                        @endforeach
                    </select>
                </form>
                <a href="{{ route('revenue.index') }}?year={{ $year }}&download=csv" class="rev-export-btn" target="_blank" download>
                    <i class="fa fa-download"></i> Export Report
                </a>
            </div>
        </div>

        {{-- Stat Cards --}}
        <div class="rev-stats-row">
            {{-- Total Revenue --}}
            <div class="rev-stat-card" style="background: linear-gradient(135deg,#e8eaf6 0%,#fff 100%);">
                <div class="rev-stat-left">
                    <div class="rev-stat-label">Total Revenue</div>
                    <div class="rev-stat-value">
                        {{ $settings['currency_symbol'] ?? '₹' }}{{ number_format($totalRevenue, 0) }}
                    </div>
                    @if($growth != 0)
                    <div class="rev-stat-growth {{ $growth < 0 ? 'negative' : '' }}">
                        <i class="fa fa-arrow-{{ $growth >= 0 ? 'up' : 'down' }}"></i>
                        {{ number_format(abs($growth), 1) }}% vs last year
                    </div>
                    @endif
                </div>
                <div class="rev-stat-icon blue"><i class="fa fa-inr"></i></div>
            </div>

            {{-- MRR --}}
            <div class="rev-stat-card">
                <div class="rev-stat-left">
                    <div class="rev-stat-label">MRR</div>
                    <div class="rev-stat-value">
                        {{ $settings['currency_symbol'] ?? '₹' }}{{ number_format($mrr, 0) }}
                    </div>
                    <div class="rev-stat-growth"><i class="fa fa-arrow-up"></i> Current Month</div>
                </div>
                <div class="rev-stat-icon green"><i class="fa fa-line-chart"></i></div>
            </div>

            {{-- ARR --}}
            <div class="rev-stat-card">
                <div class="rev-stat-left">
                    <div class="rev-stat-label">ARR</div>
                    <div class="rev-stat-value">
                        {{ $settings['currency_symbol'] ?? '₹' }}{{ number_format($arr, 0) }}
                    </div>
                    <div class="rev-stat-growth"><i class="fa fa-arrow-up"></i> MRR × 12</div>
                </div>
                <div class="rev-stat-icon sky"><i class="fa fa-calendar"></i></div>
            </div>

            {{-- Avg Revenue/School --}}
            <div class="rev-stat-card">
                <div class="rev-stat-left">
                    <div class="rev-stat-label">Avg. Revenue/School</div>
                    <div class="rev-stat-value">
                        {{ $settings['currency_symbol'] ?? '₹' }}{{ number_format($avgPerSchool, 0) }}
                    </div>
                    <div class="rev-stat-growth"><i class="fa fa-arrow-up"></i> Per school avg</div>
                </div>
                <div class="rev-stat-icon purple"><i class="fa fa-bar-chart"></i></div>
            </div>
        </div>

        {{-- Charts Row --}}
        <div class="rev-charts-row">
            {{-- Revenue Trend Area Chart --}}
            <div class="rev-card">
                <div class="rev-card-title">Revenue Trend</div>
                <div class="rev-card-subtitle">Monthly revenue over time</div>
                <canvas id="revenueTrendChart" height="220"></canvas>
            </div>

            {{-- Subscription by Source Donut Chart --}}
            <div class="rev-card">
                <div class="rev-card-title">Revenue by Source</div>
                <div class="rev-card-subtitle">Breakdown by revenue stream</div>
                <div style="display:flex;justify-content:center;align-items:center;height:220px;">
                    <canvas id="revenueDonutChart" style="max-height:220px;max-width:220px;"></canvas>
                </div>
                <div class="rev-legend">
                    <div class="rev-legend-item"><span class="rev-legend-dot" style="background:#1a237e"></span> Subscriptions</div>
                    <div class="rev-legend-item"><span class="rev-legend-dot" style="background:#3949ab"></span> Add-ons</div>
                    <div class="rev-legend-item"><span class="rev-legend-dot" style="background:#7986cb"></span> Other Revenue</div>
                </div>
            </div>
        </div>

        {{-- Revenue Breakdown Table --}}
        <div class="rev-card rev-breakdown-row mb-3">
            <div class="rev-card-title">Revenue Breakdown</div>
            <div class="rev-card-subtitle">Detailed view of revenue streams</div>

            @php
                $sym = $settings['currency_symbol'] ?? '₹';
                $total = $totalRevenue ?: 1; // avoid /0
                $streams = [
                    ['name' => 'Subscriptions', 'color' => '#1a237e', 'amount' => $subscriptionRevenue],
                    ['name' => 'Add-ons',       'color' => '#3949ab', 'amount' => $addonRevenue],
                    ['name' => 'Other Revenue', 'color' => '#7986cb', 'amount' => $otherRevenue],
                ];
            @endphp

            @foreach($streams as $stream)
            <div class="rev-breakdown-item">
                <div class="rev-breakdown-left">
                    <span class="rev-breakdown-dot" style="background:{{ $stream['color'] }}"></span>
                    <div>
                        <div class="rev-breakdown-name">{{ $stream['name'] }}</div>
                        <div class="rev-breakdown-pct">{{ number_format(($stream['amount'] / $total) * 100, 1) }}% of total</div>
                    </div>
                </div>
                <div class="rev-breakdown-right">
                    <div class="rev-breakdown-amount">{{ $sym }}{{ number_format($stream['amount'], 0) }}</div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Monthly Revenue by Stream Stacked Bar --}}
        <div class="rev-card rev-stacked-section mb-3">
            <div class="rev-card-title">Monthly Revenue by Stream</div>
            <div class="rev-card-subtitle">Stacked view of all revenue sources</div>
            <canvas id="monthlyStackedChart" height="160"></canvas>
            <div class="rev-legend mt-3">
                <div class="rev-legend-item"><span class="rev-legend-dot" style="background:#1a237e"></span> Subscriptions</div>
                <div class="rev-legend-item"><span class="rev-legend-dot" style="background:#3949ab"></span> Add-ons</div>
                <div class="rev-legend-item"><span class="rev-legend-dot" style="background:#7986cb"></span> Other Revenue</div>
            </div>
        </div>


        {{-- Export Reports --}}
        <div class="rev-card mb-3">
            <div class="rev-card-title">Export Reports</div>
            <div class="rev-card-subtitle">Download financial reports</div>
            <div class="rev-export-row">
                <a href="{{ route('revenue.index') }}?year={{ $year }}&download=csv" class="rev-export-card text-decoration-none" target="_blank" download>
                    <i class="fa fa-download"></i>
                    <div class="rev-ec-title">Revenue Summary</div>
                    <div class="rev-ec-label">(CSV)</div>
                </a>
                <a href="{{ route('revenue.index') }}?year={{ $year }}&download=excel" class="rev-export-card text-decoration-none" target="_blank" download>
                    <i class="fa fa-download"></i>
                    <div class="rev-ec-title">GST Report</div>
                    <div class="rev-ec-label">(Excel)</div>
                </a>
                <a href="{{ route('revenue.index') }}?year={{ $year }}&download=pdf" class="rev-export-card text-decoration-none" target="_blank" download>
                    <i class="fa fa-download"></i>
                    <div class="rev-ec-title">Financial Statement</div>
                    <div class="rev-ec-label">(PDF)</div>
                </a>
            </div>
        </div>

    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

    const monthlyTrend = @json(array_values($monthlyTrend));

    const totalRev     = {{ $totalRevenue }};
    const monthlySubTrend   = @json(array_values($monthlySubTrend));
    const monthlyAddonTrend = @json(array_values($monthlyAddonTrend));
    const monthlyOtherTrend = @json(array_values($monthlyOtherTrend));

    // ---- Area Chart ----
    const areaCtx = document.getElementById('revenueTrendChart').getContext('2d');
    const gradient = areaCtx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(26,35,126,0.25)');
    gradient.addColorStop(1, 'rgba(26,35,126,0.01)');

    new Chart(areaCtx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Revenue',
                data: monthlyTrend,
                borderColor: '#1a237e',
                backgroundColor: gradient,
                borderWidth: 2.5,
                pointBackgroundColor: '#1a237e',
                pointRadius: 3,
                fill: true,
                tension: 0.4,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false }, tooltip: {
                callbacks: {
                    label: ctx => ' ₹' + Number(ctx.raw).toLocaleString('en-IN')
                }
            }},
            scales: {
                x: { grid: { color: '#f0f4ff' }, ticks: { color: '#555', font: { size: 11 } }},
                y: { grid: { color: '#f0f4ff' }, ticks: {
                    color: '#555', font: { size: 11 },
                    callback: v => '₹' + (v >= 1000 ? (v/1000).toFixed(0) + 'K' : v)
                },
                beginAtZero: true }
            }
        }
    });

    // ---- Donut Chart ----
    const donutCtx = document.getElementById('revenueDonutChart').getContext('2d');
    new Chart(donutCtx, {
        type: 'doughnut',
        data: {
            labels: ['Subscriptions', 'Add-ons', 'Other Revenue'],
            datasets: [{
                data: [{{ $subscriptionRevenue }}, {{ $addonRevenue }}, {{ $otherRevenue }}],
                backgroundColor: ['#1a237e', '#3949ab', '#7986cb'],
                borderWidth: 2,
                borderColor: '#fff',
                hoverOffset: 6
            }]
        },
        options: {
            responsive: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ' ₹' + Number(ctx.raw).toLocaleString('en-IN')
                    }
                }
            },
            cutout: '68%'
        }
    });

    // ---- Stacked Bar Chart ----
    const barCtx = document.getElementById('monthlyStackedChart').getContext('2d');
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [
                {
                    label: 'Subscriptions',
                    data: monthlySubTrend,
                    backgroundColor: '#1a237e',
                    borderRadius: 0,
                    stack: 'rev'
                },
                {
                    label: 'Add-ons',
                    data: monthlyAddonTrend,
                    backgroundColor: '#3949ab',
                    borderRadius: 0,
                    stack: 'rev'
                },
                {
                    label: 'Other Revenue',
                    data: monthlyOtherTrend,
                    backgroundColor: '#7986cb',
                    borderRadius: 2,
                    stack: 'rev'
                },
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false }, tooltip: {
                callbacks: {
                    label: ctx => ' ' + ctx.dataset.label + ': ₹' + Number(ctx.raw).toLocaleString('en-IN')
                }
            }},
            scales: {
                x: { stacked: true, grid: { display: false }, ticks: { color: '#555', font: { size: 11 } }},
                y: { stacked: true, grid: { color: '#f0f4ff' },
                    ticks: {
                        color: '#555', font: { size: 11 },
                        callback: v => '₹' + (v >= 1000 ? (v/1000).toFixed(0) + 'K' : v)
                    },
                    beginAtZero: true
                }
            }
        }
    });


</script>
@endsection
