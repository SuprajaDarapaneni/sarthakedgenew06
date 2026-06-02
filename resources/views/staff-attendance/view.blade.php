@extends('layouts.master')

@section('title')
    {{ __('Staff Attendance Analytics') }}
@endsection

@section('css')
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            --danger-gradient:  linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
            --info-gradient:    linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
            --warning-gradient: linear-gradient(135deg, #ed64a6 0%, #d53f8c 100%);
        }

        .attendance-card {
            border: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            color: white;
            height: 100%;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .attendance-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .card-body-content { position: relative; z-index: 1; }

        .card-bg-icon {
            position: absolute;
            right: -10px;
            bottom: -10px;
            font-size: 80px;
            opacity: 0.15;
            transform: rotate(-15deg);
        }

        .stats-total   { background: var(--primary-gradient); }
        .stats-present { background: var(--success-gradient); }
        .stats-absent  { background: var(--danger-gradient); }
        .stats-leave   { background: var(--info-gradient); }
        .stats-avg     { background: var(--warning-gradient); }

        .col-md-2-4 { flex: 0 0 20%; max-width: 20%; }

        @media (max-width: 992px) { .col-md-2-4 { flex: 0 0 33.33%; max-width: 33.33%; } }
        @media (max-width: 576px) { .col-md-2-4 { flex: 0 0 100%;   max-width: 100%;   } }

        .sticky-filter {
            position: sticky;
            top: 70px;
            z-index: 100;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .chart-container {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            height: 100%;
            border: none;
        }

        .status-dot {
            height: 10px; width: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }

        .table thead th {
            border-top: none;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 1px;
            color: #8898aa;
            background-color: #f6f9fc;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header flex-wrap">
            <div class="header-left">
                <h3 class="page-title">
                    <span class="page-title-icon bg-gradient-primary text-white mr-2">
                        <i class="fa fa-line-chart"></i>
                    </span>
                    {{ __('Staff Attendance Analytics') }}
                </h3>
            </div>
            <div class="header-right d-flex flex-wrap mt-md-2 mt-sm-0">
                <button type="button" class="btn btn-outline-primary btn-icon-text border-0" id="refresh-dashboard">
                    <i class="fa fa-refresh btn-icon-prepend"></i> {{ __('Refresh') }}
                </button>
            </div>
        </div>

        {{-- Filter Bar --}}
        <div class="sticky-filter">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <label class="text-muted small font-weight-bold">{{ __('Date') }}</label>
                    <div class="input-group">
                        <input type="text" name="date" id="date_picker"
                               class="form-control datepicker-popup"
                               value="{{ date('d-m-Y') }}" data-date-end-date="0d" autocomplete="off">
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent border-left-0">
                                <i class="fa fa-calendar text-primary"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="text-muted small font-weight-bold">{{ __('Attendance Type') }}</label>
                    <select id="attendance_type" name="attendance_type" class="form-control select2" style="width:100%;">
                        <option value="">{{ __('All') }}</option>
                        <option value="1">{{ __('present') }}</option>
                        <option value="0">{{ __('absent') }}</option>
                        <option value="3">{{ __('holiday') }}</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="text-muted small font-weight-bold">{{ __('Search Staff') }}</label>
                    <div class="input-group">
                        <input type="text" id="staff_search_input" class="form-control"
                               placeholder="{{ __('Name') }}">
                        <div class="input-group-append">
                            <span class="input-group-text bg-primary border-primary">
                                <i class="fa fa-search text-white"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tally Cards --}}
        <div class="row mb-4" id="stats-container">
            <div class="col-md-2-4 col-sm-6 mb-3">
                <div class="attendance-card stats-total">
                    <div class="card-body">
                        <div class="card-body-content">
                            <h6 class="text-uppercase mb-2">{{ __('Total Staff') }}</h6>
                            <h2 class="mb-0 font-weight-bold" id="stat-total-staff">---</h2>
                        </div>
                        <i class="fa fa-users card-bg-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-2-4 col-sm-6 mb-3">
                <div class="attendance-card stats-present">
                    <div class="card-body">
                        <div class="card-body-content">
                            <h6 class="text-uppercase mb-2">{{ __('Present') }}</h6>
                            <h2 class="mb-0 font-weight-bold" id="stat-present">---</h2>
                        </div>
                        <i class="fa fa-check-circle card-bg-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-2-4 col-sm-6 mb-3">
                <div class="attendance-card stats-absent">
                    <div class="card-body">
                        <div class="card-body-content">
                            <h6 class="text-uppercase mb-2">{{ __('Absent') }}</h6>
                            <h2 class="mb-0 font-weight-bold" id="stat-absent">---</h2>
                        </div>
                        <i class="fa fa-times-circle card-bg-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-2-4 col-sm-6 mb-3">
                <div class="attendance-card stats-leave">
                    <div class="card-body">
                        <div class="card-body-content">
                            <h6 class="text-uppercase mb-2">{{ __('On Leave') }}</h6>
                            <h2 class="mb-0 font-weight-bold" id="stat-leave">---</h2>
                        </div>
                        <i class="fa fa-plane card-bg-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-2-4 col-sm-6 mb-3">
                <div class="attendance-card stats-avg">
                    <div class="card-body">
                        <div class="card-body-content">
                            <h6 class="text-uppercase mb-2">{{ __('Avg Attendance') }}</h6>
                            <h2 class="mb-0 font-weight-bold"><span id="stat-avg">---</span>%</h2>
                        </div>
                        <i class="fa fa-percent card-bg-icon"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Charts Row 1: Monthly Trends + Distribution --}}
        <div class="row mb-4">
            <div class="col-lg-8 grid-margin stretch-card">
                <div class="card chart-container">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title mb-0">{{ __('Monthly Attendance Trends') }}</h4>
                    </div>
                    <div id="monthly-trends-chart"></div>
                </div>
            </div>
            <div class="col-lg-4 grid-margin stretch-card">
                <div class="card chart-container">
                    <h4 class="card-title mb-4">{{ __('Attendance Distribution') }}</h4>
                    <div id="distribution-chart"></div>
                    <div class="mt-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="status-dot" style="background:#48bb78"></i>{{ __('Excellent (≥90%)') }}</span>
                            <span class="font-weight-bold" id="dist-excellent">0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="status-dot" style="background:#ed64a6"></i>{{ __('Average (75–89%)') }}</span>
                            <span class="font-weight-bold" id="dist-average">0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="status-dot" style="background:#f56565"></i>{{ __('Low (<75%)') }}</span>
                            <span class="font-weight-bold" id="dist-low">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Charts Row 2: Role-wise + Low Attendance Alerts --}}
        <div class="row mb-4">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card chart-container">
                    <h4 class="card-title mb-4">{{ __('Role-wise Performance') }}</h4>
                    <div id="role-wise-chart"></div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card chart-container">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title mb-0">{{ __('Low Attendance Alerts') }}</h4>
                        <span class="badge badge-pill badge-outline-danger">{{ __('Action Required') }}</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <thead class="bg-light">
                                <tr>
                                    <th>{{ __('Staff') }}</th>
                                    <th>{{ __('Role') }}</th>
                                    <th>{{ __('Avg %') }}</th>
                                </tr>
                            </thead>
                            <tbody id="low-attendance-tbody">
                                {{-- Loaded via AJAX --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Detailed List --}}
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">{{ __('Detailed Staff Attendance') }}</h4>
                        </div>
                        <table id="table_list" data-toggle="table"
                               data-url="{{ route('staff-attendance.list.show') }}"
                               data-click-to-select="true" data-side-pagination="server"
                               data-pagination="true" data-page-list="[5,10,20,50,100,200]"
                               data-search="false" data-show-refresh="true"
                               data-show-columns="true" data-trim-on-search="false"
                               data-mobile-responsive="true" data-sort-name="staff_id"
                               data-sort-order="asc" data-maintain-selected="true"
                               data-export-data-type="all" data-show-export="true"
                               data-export-options='{"fileName":"staff-attendance-{{ date("d-m-y") }}","ignoreColumn":["operate"]}'
                               data-query-params="staffAnalyticsQueryParams" data-escape="true">
                            <thead>
                                <tr>
                                    <th data-field="no" data-sortable="false">{{ __('No.') }}</th>
                                    <th data-field="name">{{ __('Staff Name') }}</th>
                                    <th data-field="type" data-formatter="attendanceTypeFormatter" data-escape="false">{{ __('Today Status') }}</th>
                                    <th data-field="present_days" data-align="center">{{ __('Present Days') }}</th>
                                    <th data-field="absent_days"  data-align="center">{{ __('Absent Days') }}</th>
                                    <th data-field="leave_days"   data-align="center">{{ __('Leave Days') }}</th>
                                    <th data-field="attendance_percentage" data-formatter="percentageFormatter" data-align="center">{{ __('Avg %') }}</th>
                                    <th data-field="attendance_status" data-formatter="attendanceStatusBadgeFormatter">{{ __('Status') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>{{-- /content-wrapper --}}
@endsection

@section('script')
    <script>
        // ---------- Query params for Bootstrap Table ----------
        function staffAnalyticsQueryParams(p) {
            return {
                limit:           p.limit,
                sort:            p.sort,
                order:           p.order,
                offset:          p.offset,
                search:          $('#staff_search_input').val(),
                date:            $('#date_picker').val(),
                attendance_type: $('#attendance_type').val(),
            };
        }

        // ---------- Formatters ----------
        function percentageFormatter(value) {
            return `<span class="font-weight-bold text-dark">${value}%</span>`;
        }

        function attendanceStatusBadgeFormatter(value) {
            let cls = 'badge-success';
            if (value === 'Warning') cls = 'badge-warning';
            if (value === 'Low')     cls = 'badge-danger';
            return `<span class="badge ${cls}">${value ?? '—'}</span>`;
        }

        // ---------- Page init ----------
        $(document).ready(function () {

            // Re-load everything when filters change
            $('#date_picker, #attendance_type').on('change', function () {
                loadDashboard();
                $('#table_list').bootstrapTable('refresh');
            });

            $('#staff_search_input').on('keyup', function () {
                $('#table_list').bootstrapTable('refresh');
            });

            $('#refresh-dashboard').on('click', function () {
                loadDashboard();
                $('#table_list').bootstrapTable('refresh');
            });

            loadDashboard();
        });

        // ---------- Chart instances ----------
        let trendsChart, distChart, roleChart;

        // ---------- Dashboard loader ----------
        function loadDashboard() {
            let params = {
                date: $('#date_picker').val(),
            };

            // Tally cards
            $.get("{{ route('staff-attendance.get-stats') }}", params, function (res) {
                $('#stat-total-staff').text(res.total_staff);
                $('#stat-present').text(res.present);
                $('#stat-absent').text(res.absent);
                $('#stat-leave').text(res.on_leave);
                $('#stat-avg').text(res.avg_attendance);
            });

            // Charts
            $.get("{{ route('staff-attendance.get-analytics') }}", params, function (res) {
                renderTrendsChart(res.monthly_trends);
                renderDistributionChart(res.distribution);
                renderRoleWiseChart(res.role_wise);
                renderLowAttendanceTable(res.low_attendance);
            });
        }

        // ---------- Chart renderers ----------
        function renderTrendsChart(data) {
            let options = {
                series: [{ name: "{{ __('Attendance %') }}", data: data.map(i => i.percentage) }],
                chart:  { height: 350, type: 'area', toolbar: { show: false }, zoom: { enabled: false } },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth' },
                colors: ['#667eea'],
                xaxis:  { categories: data.map(i => i.month) },
                yaxis:  { max: 100, min: 0 },
                fill: {
                    type: 'gradient',
                    gradient: { shadeIntensity: 1, opacityFrom: 0.7, opacityTo: 0.3 }
                }
            };
            if (trendsChart) trendsChart.destroy();
            trendsChart = new ApexCharts(document.querySelector('#monthly-trends-chart'), options);
            trendsChart.render();
        }

        function renderDistributionChart(data) {
            let options = {
                series: [data.excellent, data.average, data.low],
                chart:  { type: 'donut', height: 300 },
                labels: ["{{ __('Excellent') }}", "{{ __('Average') }}", "{{ __('Low') }}"],
                colors: ['#48bb78', '#ed64a6', '#f56565'],
                legend: { show: false },
                plotOptions: { pie: { donut: { size: '75%' } } }
            };
            $('#dist-excellent').text(data.excellent);
            $('#dist-average').text(data.average);
            $('#dist-low').text(data.low);
            if (distChart) distChart.destroy();
            distChart = new ApexCharts(document.querySelector('#distribution-chart'), options);
            distChart.render();
        }

        function renderRoleWiseChart(data) {
            let options = {
                series: [{ name: "{{ __('Attendance %') }}", data: data.map(i => i.percentage) }],
                chart:  { type: 'bar', height: 350, toolbar: { show: false } },
                plotOptions: { bar: { borderRadius: 4, horizontal: true } },
                colors: ['#4299e1'],
                dataLabels: { enabled: false },
                xaxis: { categories: data.map(i => i.name) }
            };
            if (roleChart) roleChart.destroy();
            roleChart = new ApexCharts(document.querySelector('#role-wise-chart'), options);
            roleChart.render();
        }

        function renderLowAttendanceTable(staff) {
            let html = '';
            if (staff.length === 0) {
                html = '<tr><td colspan="3" class="text-center text-muted">{{ __("No staff with low attendance") }}</td></tr>';
            } else {
                staff.forEach(s => {
                    html += `<tr>
                        <td><span class="font-weight-bold">${s.name}</span></td>
                        <td>${s.role}</td>
                        <td><span class="text-danger font-weight-bold">${s.percentage}%</span></td>
                    </tr>`;
                });
            }
            $('#low-attendance-tbody').html(html);
        }
    </script>
@endsection