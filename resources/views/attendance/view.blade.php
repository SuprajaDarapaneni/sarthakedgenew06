@extends('layouts.master')

@section('title')
    {{ __('View Student Attendance') }}
@endsection

@section('css')
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            --danger-gradient: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
            --info-gradient: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
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
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .attendance-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .card-body-content {
            position: relative;
            z-index: 1;
        }

        .card-bg-icon {
            position: absolute;
            right: -10px;
            bottom: -10px;
            font-size: 80px;
            opacity: 0.15;
            transform: rotate(-15deg);
        }

        .stats-total {
            background: var(--primary-gradient);
        }

        .stats-present {
            background: var(--success-gradient);
        }

        .stats-absent {
            background: var(--danger-gradient);
        }

        .stats-leave {
            background: var(--info-gradient);
        }

        .stats-avg {
            background: var(--warning-gradient);
        }

        .col-md-2-4 {
            flex: 0 0 20%;
            max-width: 20%;
        }

        @media (max-width: 992px) {
            .col-md-2-4 {
                flex: 0 0 33.33%;
                max-width: 33.33%;
            }
        }

        @media (max-width: 576px) {
            .col-md-2-4 {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }

        .sticky-filter {
            position: sticky;
            top: 70px;
            z-index: 100;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .chart-container {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            height: 100%;
            border: none;
        }

        .status-dot {
            height: 10px;
            width: 10px;
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
                    </span> {{ __('Attendance Analytics') }}
                </h3>
            </div>
            <div class="header-right d-flex flex-wrap mt-md-2 mt-sm-0">
                <button type="button" class="btn btn-outline-primary btn-icon-text border-0" id="refresh-dashboard">
                    <i class="fa fa-refresh btn-icon-prepend"></i> {{ __('Refresh') }}
                </button>
                <button type="button" class="btn btn-primary btn-icon-text ml-2">
                    <i class="fa fa-download btn-icon-prepend"></i> {{ __('Export Report') }}
                </button>
            </div>
        </div>

        <!-- Enhanced Filter Bar -->
        <div class="sticky-filter">
            <form id="attendance-filter-form">
                <div class="row align-items-end">
                    <div class="col-md-2">
                        <label class="text-muted small font-weight-bold">{{ __('Academic Year') }}</label>
                        <select name="session_year_id" id="session_year_id" class="form-control select2">
                            @foreach($sessionYears as $id => $name)
                                <option value="{{ $id }}" {{ $id == $currentSessionYear->id ? 'selected' : '' }}>{{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="text-muted small font-weight-bold">{{ __('Class') }}</label>
                        <select name="class_id" id="class_id" class="form-control select2">
                            <option value="">{{ __('All Classes') }}</option>
                            @foreach($class_sections->pluck('class.name', 'class.id')->unique() as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="text-muted small font-weight-bold">{{ __('Section') }}</label>
                        <select name="class_section_id" id="class_section_id" class="form-control select2">
                            <option value="">{{ __('All Sections') }}</option>
                            @foreach($class_sections as $section)
                                <option value="{{ $section->id }}" data-class="{{ $section->class_id }}" class="section-option">
                                    {{ $section->section->name ?? '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="text-muted small font-weight-bold">{{ __('Date') }}</label>
                        <div class="input-group">
                            <input type="text" name="date" id="date_picker" class="form-control datepicker-popup"
                                value="{{ date('d-m-Y') }}">
                            <div class="input-group-append">
                                <span class="input-group-text bg-transparent border-left-0"><i
                                        class="fa fa-calendar text-primary"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="text-muted small font-weight-bold">{{ __('Search Student') }}</label>
                        <div class="input-group">
                            <input type="text" id="student_search_input" class="form-control"
                                placeholder="{{ __('Name / Roll No') }}">
                            <div class="input-group-append">
                                <span class="input-group-text bg-primary border-primary"><i
                                        class="fa fa-search text-white"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tally Cards -->
        <div class="row mb-4" id="stats-container">
            <div class="col-md-2-4 col-sm-6 mb-3">
                <div class="attendance-card stats-total">
                    <div class="card-body">
                        <div class="card-body-content">
                            <h6 class="text-uppercase mb-2">{{ __('Total Students') }}</h6>
                            <h2 class="mb-0 font-weight-bold" id="stat-total-students">---</h2>
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
                        <i class="fa fa-user-check card-bg-icon"></i>
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
                        <i class="fa fa-user-times card-bg-icon"></i>
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

        <!-- Charts Section -->
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
                            <span><i class="status-dot" style="background: #48bb78"></i> {{ __('Excellent (>90%)') }}</span>
                            <span class="font-weight-bold" id="dist-excellent">0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="status-dot" style="background: #ed64a6"></i> {{ __('Average (75-89%)') }}</span>
                            <span class="font-weight-bold" id="dist-average">0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="status-dot" style="background: #f56565"></i> {{ __('Low (<75%)') }}</span>
                            <span class="font-weight-bold" id="dist-low">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card chart-container">
                    <h4 class="card-title mb-4">{{ __('Class-wise Performance') }}</h4>
                    <div id="class-wise-chart"></div>
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
                                    <th>{{ __('Student') }}</th>
                                    <th>{{ __('Class') }}</th>
                                    <th>{{ __('Avg %') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody id="low-attendance-tbody">
                                <!-- Loaded via AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed List -->
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">{{ __('Detailed Student Attendance') }}</h4>
                        </div>
                        <table id='table_list' data-toggle="table" data-url="{{ route('attendance.list.show') }}"
                            data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                            data-page-list="[5, 10, 20, 50, 100, 200]" data-search="false" data-show-refresh="true"
                            data-toolbar="#toolbar" data-show-columns="true" data-trim-on-search="false"
                            data-mobile-responsive="true" data-sort-name="student_id" data-sort-order="asc"
                            data-maintain-selected="true" data-export-data-type='all' data-show-export="true"
                            data-query-params="attendanceStatsQueryParams" data-escape="true">
                            <thead>
                                <tr>
                                    <th data-checkbox="true"></th>
                                    <th data-field="admission_no">{{ __('Adm. No') }}</th>
                                    <th data-field="roll_no">{{ __('Roll No') }}</th>
                                    <th data-field="name">{{ __('Student Name') }}</th>
                                    <th data-field="class_section">{{ __('Class & Section') }}</th>
                                    <th data-field="present_days" data-align="center">{{ __('Present Days') }}</th>
                                    <th data-field="absent_days" data-align="center">{{ __('Absent Days') }}</th>
                                    <th data-field="leave_days" data-align="center">{{ __('Leave Days') }}</th>
                                    <th data-field="attendance_percentage" data-formatter="percentageFormatter"
                                        data-align="center">{{ __('Avg %') }}</th>
                                    <th data-field="attendance_status" data-formatter="attendanceStatusBadgeFormatter">
                                        {{ __('Status') }}
                                    </th>
                                    <th data-field="operate" data-formatter="attendanceActionFormatter">{{ __('Action') }}
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function attendanceStatsQueryParams(p) {
            return {
                limit: p.limit,
                sort: p.sort,
                order: p.order,
                offset: p.offset,
                class_section_id: $('#class_section_id').val(),
                date: $('#date_picker').val(),
                search: $('#student_search_input').val(),
                session_year_id: $('#session_year_id').val()
            };
        }

        function percentageFormatter(value) {
            return `<span class="font-weight-bold text-dark">${value}%</span>`;
        }

        function attendanceStatusBadgeFormatter(value) {
            let badgeClass = 'badge-success';
            if (value === 'Warning') badgeClass = 'badge-warning';
            if (value === 'Low') badgeClass = 'badge-danger';
            return `<span class="badge ${badgeClass}">${value}</span>`;
        }

        function attendanceActionFormatter(value, row) {
            return `<button class="btn btn-sm btn-inverse-primary btn-icon" title="View Report"><i class="fa fa-eye"></i></button>`;
        }

        $(document).ready(function () {
            // Class - Section dependent dropdown
            $('#class_id').on('change', function () {
                let classId = $(this).val();
                $('.section-option').hide();
                if (!classId) {
                    $('.section-option').show();
                } else {
                    $(`.section-option[data-class="${classId}"]`).show();
                }
                $('#class_section_id').val('').trigger('change');
            });

            $('#attendance-filter-form select, #date_picker').on('change', function () {
                loadDashboard();
                $('#table_list').bootstrapTable('refresh');
            });

            $('#student_search_input').on('keyup', function () {
                $('#table_list').bootstrapTable('refresh');
            });

            $('#refresh-dashboard').on('click', function () {
                loadDashboard();
                $('#table_list').bootstrapTable('refresh');
            });

            loadDashboard();
        });

        let trendsChart, distChart, classChart;

        function loadDashboard() {
            let params = {
                class_section_id: $('#class_section_id').val(),
                date: $('#date_picker').val(),
                session_year_id: $('#session_year_id').val()
            };

            // Get Stats
            $.get("{{ route('attendance.get-stats') }}", params, function (res) {
                $('#stat-total-students').text(res.total_students);
                $('#stat-present').text(res.present);
                $('#stat-absent').text(res.absent);
                $('#stat-leave').text(res.on_leave);
                $('#stat-avg').text(res.avg_attendance);
            });

            // Get Analytics
            $.get("{{ route('attendance.get-analytics') }}", params, function (res) {
                renderTrendsChart(res.monthly_trends);
                renderDistributionChart(res.distribution);
                renderClassWiseChart(res.class_wise);
                renderLowAttendanceTable(res.low_attendance);
            });
        }

        function renderTrendsChart(data) {
            let options = {
                series: [{
                    name: "{{ __('Attendance %') }}",
                    data: data.map(i => i.percentage)
                }],
                chart: { height: 350, type: 'area', toolbar: { show: false }, zoom: { enabled: false } },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth' },
                colors: ['#667eea'],
                xaxis: {
                    categories: data.map(i => i.month),
                },
                yaxis: { max: 100, min: 0 },
                fill: {
                    type: 'gradient',
                    gradient: { shadeIntensity: 1, opacityFrom: 0.7, opacityTo: 0.3 }
                }
            };

            if (trendsChart) trendsChart.destroy();
            trendsChart = new ApexCharts(document.querySelector("#monthly-trends-chart"), options);
            trendsChart.render();
        }

        function renderDistributionChart(data) {
            let options = {
                series: [data.excellent, data.average, data.low],
                chart: { type: 'donut', height: 300 },
                labels: ["{{ __('Excellent') }}", "{{ __('Average') }}", "{{ __('Low') }}"],
                colors: ['#48bb78', '#ed64a6', '#f56565'],
                legend: { show: false },
                plotOptions: {
                    pie: { donut: { size: '75%' } }
                }
            };

            $('#dist-excellent').text(data.excellent);
            $('#dist-average').text(data.average);
            $('#dist-low').text(data.low);

            if (distChart) distChart.destroy();
            distChart = new ApexCharts(document.querySelector("#distribution-chart"), options);
            distChart.render();
        }

        function renderClassWiseChart(data) {
            let options = {
                series: [{
                    name: "{{ __('Attendance %') }}",
                    data: data.map(i => i.percentage)
                }],
                chart: { type: 'bar', height: 350, toolbar: { show: false } },
                plotOptions: {
                    bar: { borderRadius: 4, horizontal: true }
                },
                colors: ['#4299e1'],
                dataLabels: { enabled: false },
                xaxis: {
                    categories: data.map(i => i.name),
                }
            };

            if (classChart) classChart.destroy();
            classChart = new ApexCharts(document.querySelector("#class-wise-chart"), options);
            classChart.render();
        }

        function renderLowAttendanceTable(students) {
            let html = '';
            if (students.length === 0) {
                html = '<tr><td colspan="4" class="text-center text-muted">{{ __("No critical students found") }}</td></tr>';
            } else {
                students.forEach(s => {
                    html += `<tr>
                            <td><div class="d-flex align-items-center"><span class="font-weight-bold">${s.name}</span></div></td>
                            <td>${s.class}</td>
                            <td><span class="text-danger font-weight-bold">${s.percentage}%</span></td>
                            <td><button class="btn btn-sm btn-outline-danger">{{ __('Notify') }}</button></td>
                        </tr>`;
                });
            }
            $('#low-attendance-tbody').html(html);
        }
    </script>
@endsection