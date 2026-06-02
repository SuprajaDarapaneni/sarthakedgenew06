@extends('layouts.master')
@section('title')
    {{ __('dashboard') }}
@endsection
@section('content')

    @php
        /** @var \App\Models\User $user */
        $user = Auth::user();
    @endphp

    <style>
        .truncateTitle {
            max-width: 100px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .dashboard-card {
            border: none;
            border-radius: 12px;
            transition: box-shadow 0.2s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .dashboard-card:hover {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .badge-soft-warning {
            background-color: #fff8e1;
            color: #f57c00;
            border: 1px solid #ffe0b2;
        }

        .badge-soft-primary {
            background-color: #e3f2fd;
            color: #1976d2;
            border: 1px solid #bbdefb;
        }

        .badge-soft-success {
            background-color: #e8f5e9;
            color: #388e3c;
            border: 1px solid #c8e6c9;
        }

        .badge-soft-danger {
            background-color: #ffebee;
            color: #d32f2f;
            border: 1px solid #ffcdd2;
        }

        .quick-action-btn {
            background: #fff;
            border: 1px solid #edf2f7;
            border-radius: 14px;
            padding: 20px 10px 16px;
            text-decoration: none !important;
            color: #4a5568 !important;
            transition: box-shadow 0.2s, border-color 0.2s;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .quick-action-btn:hover {
            background: #f8fafc;
            border-color: #cbd5e0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.09);
        }

        .quick-action-icon {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-bottom: 10px;
        }

        .activity-item {
            padding: 12px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .task-item {
            display: flex;
            align-items: center;
            padding: 10px 0;
        }

        .task-checkbox {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            border: 2px solid #cbd5e0;
            margin-right: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .task-checkbox:hover {
            border-color: #48bb78;
            background: rgba(72, 187, 120, 0.1);
        }

        .task-checkbox.checked {
            background: #48bb78;
            border-color: #48bb78;
        }

        .task-checkbox.checked::after {
            content: '\f00c';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            color: white;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        .card-header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
    </style>

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-theme text-white mr-2">
                    <i class="fa fa-home"></i>
                </span> {{ __('dashboard') }}
            </h3>
            @if ($user->hasRole('Super Admin'))
                <button class="btn btn-theme px-4 py-2" style="border-radius: 10px;">
                    <i class="fa fa-file-pdf mr-2"></i> {{ __('Generate Report') }}
                </button>
            @endif
        </div>
        {{-- School Dashboard --}}
        {{-- School Dashboard --}}
        @if ($user->hasRole('School Admin') || $user->school_id)

            {{-- Welcome & Top Bar --}}
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card dashboard-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <div>
                                    <h3 class="font-weight-bold mb-1" style="color: #1a202c;">{{ __('Welcome back') }}!</h3>
                                    <p class="text-muted mb-0">{{ __('Here\'s what\'s happening at your school today.') }}</p>
                                </div>
                                <div class="text-right d-flex align-items-center mt-3 mt-md-0">
                                    <div class="mr-4 text-right">
                                        <span class="text-muted small d-block">{{ __('Academic Year') }}</span>
                                        <span class="font-weight-bold text-dark" style="font-size: 1.1rem;">
                                            {{ $sessionYear->where('default', 1)->first()->name ?? 'N/A' }}
                                        </span>
                                    </div>
                                    <div class="text-right border-left pl-4">
                                        <span class="text-muted small d-block">{{ __('Today') }}</span>
                                        <span class="font-weight-bold text-dark" style="font-size: 1.1rem;">
                                            {{ \Carbon\Carbon::now()->format('l, d F Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Alerts Row --}}
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex flex-wrap" style="gap: 15px;">
                        @if($fees_detail['unPaidFees'] + $fees_detail['partialPaidFees'] > 0)
                            <div class="badge-soft-warning px-3 py-2 rounded-pill d-flex align-items-center">
                                <i class="fa fa-exclamation-triangle mr-2"></i>
                                {{ $fees_detail['unPaidFees'] + $fees_detail['partialPaidFees'] }}
                                {{ __('students have overdue fees') }}
                            </div>
                        @endif

                        @if($pending_admissions_count > 0)
                            <div class="badge-soft-primary px-3 py-2 rounded-pill d-flex align-items-center">
                                <i class="fa fa-user-clock mr-2"></i>
                                {{ $pending_admissions_count }} {{ __('pending admission requests') }}
                            </div>
                        @endif

                        <div
                            class="{{ $staff_attendance_marked ? 'badge-soft-success' : 'badge-soft-danger' }} px-3 py-2 rounded-pill d-flex align-items-center">
                            <i class="fa {{ $staff_attendance_marked ? 'fa-check-circle' : 'fa-times-circle' }} mr-2"></i>
                            {{ $staff_attendance_marked ? __('All staff attendance marked') : __('Staff attendance pending') }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Enhanced Stat Cards --}}
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card dashboard-card">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="text-muted mb-1">{{ __('Total Students') }}</p>
                                    <h2 class="font-weight-bold mb-1">{{ number_format($total_students) }}</h2>
                                    <p class="mb-0 text-success small">
                                        <i class="fa fa-arrow-up mr-1"></i> +{{ $new_students_this_month }}
                                        {{ __('this month') }}
                                    </p>
                                </div>
                                <div class="stat-icon bg-soft-primary"
                                    style="background: rgba(66, 153, 225, 0.1); color: #3182ce;">
                                    <i class="fa fa-graduation-cap"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card dashboard-card">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="text-muted mb-1">{{ __('Total Teachers') }}</p>
                                    <h2 class="font-weight-bold mb-1">{{ $teacher }}</h2>
                                    <p class="mb-0 text-muted small">
                                        {{ $teachers_on_leave_today }} {{ __('on leave today') }}
                                    </p>
                                </div>
                                <div class="stat-icon bg-soft-success"
                                    style="background: rgba(72, 187, 120, 0.1); color: #38a169;">
                                    <i class="fa fa-chalkboard-teacher"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card dashboard-card">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="text-muted mb-1">{{ __('Today\'s Attendance') }}</p>
                                    <h2 class="font-weight-bold mb-1 text-dark">{{ number_format($today_attendance_pct, 1) }}%
                                    </h2>
                                    <p class="mb-0 {{ $attendance_trend >= 0 ? 'text-success' : 'text-danger' }} small">
                                        <i class="fa fa-arrow-{{ $attendance_trend >= 0 ? 'up' : 'down' }} mr-1"></i>
                                        {{ abs(number_format($attendance_trend, 1)) }}% {{ __('vs yesterday') }}
                                    </p>
                                </div>
                                <div class="stat-icon bg-soft-warning"
                                    style="background: rgba(237, 137, 54, 0.1); color: #dd6b20;">
                                    <i class="fa fa-user-check"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card dashboard-card">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="text-muted mb-1">{{ __('Fee Collection') }}</p>
                                    <h2 class="font-weight-bold mb-1 text-dark">
                                        {{ $settings['currency_symbol'] ?? '' }}{{ number_format($total_collected_fees / 1000, 1) }}K
                                    </h2>
                                    <p class="mb-0 text-muted small">
                                        {{ $settings['currency_symbol'] ?? '' }}{{ number_format(($total_expected_fees - $total_collected_fees) / 1000, 1) }}K
                                        {{ __('pending') }}
                                    </p>
                                </div>
                                <div class="stat-icon bg-soft-info" style="background: rgba(0, 188, 212, 0.1); color: #0097a7;">
                                    <i class="fa fa-file-invoice-dollar"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="row mb-5">
                <div class="col-12">
                    <div class="card dashboard-card">
                        <div class="card-body">
                            <h5 class="font-weight-bold mb-4">{{ __('Quick Actions') }}</h5>
                            <div class="row">
                                <div class="col-6 col-md-2 mb-3">
                                    <a href="{{ route('students.create') }}" class="quick-action-btn d-block">
                                        <div class="quick-action-icon"
                                            style="background: rgba(99,102,241,0.12); color: #6366f1;">
                                            <i class="fa fa-user-plus"></i>
                                        </div>
                                        <span class="font-weight-semibold small">{{ __('New Admission') }}</span>
                                    </a>
                                </div>
                                <div class="col-6 col-md-2 mb-3">
                                    <a href="{{ route('attendance.index') }}" class="quick-action-btn d-block">
                                        <div class="quick-action-icon"
                                            style="background: rgba(72,187,120,0.12); color: #38a169;">
                                            <i class="fa fa-clipboard-list"></i>
                                        </div>
                                        <span class="font-weight-semibold small">{{ __('Mark Attendance') }}</span>
                                    </a>
                                </div>
                                <div class="col-6 col-md-2 mb-3">
                                    <a href="{{ route('fees.paid.index') }}" class="quick-action-btn d-block">
                                        <div class="quick-action-icon"
                                            style="background: rgba(237,137,54,0.12); color: #dd6b20;">
                                            <i class="fas fa-hand-holding-usd"></i>
                                        </div>
                                        <span class="font-weight-semibold small">{{ __('Collect Fee') }}</span>
                                    </a>
                                </div>
                                <div class="col-6 col-md-2 mb-3">
                                    <a href="{{ route('reports.student.student-reports') }}" class="quick-action-btn d-block">
                                        <div class="quick-action-icon"
                                            style="background: rgba(56,189,248,0.12); color: #0284c7;">
                                            <i class="fa fa-chart-line"></i>
                                        </div>
                                        <span class="font-weight-semibold small">{{ __('Generate Report') }}</span>
                                    </a>
                                </div>
                                <div class="col-6 col-md-2 mb-3">
                                    <a href="{{ route('notifications.index') }}" class="quick-action-btn d-block">
                                        <div class="quick-action-icon"
                                            style="background: rgba(102,126,234,0.12); color: #667eea;">
                                            <i class="fa fa-paper-plane"></i>
                                        </div>
                                        <span class="font-weight-semibold small">{{ __('Send Notification') }}</span>
                                    </a>
                                </div>
                                <div class="col-6 col-md-2 mb-3">
                                    <a href="{{ route('transportation-requests.index') }}" class="quick-action-btn d-block">
                                        <div class="quick-action-icon"
                                            style="background: rgba(245,101,101,0.12); color: #e53e3e;">
                                            <i class="fas fa-bus"></i>
                                        </div>
                                        <span class="font-weight-semibold small">{{ __('Transport') }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Attendance & Fee Charts --}}
            <div class="row mb-5">
                <div class="col-md-8">
                    <div class="card dashboard-card">
                        <div class="card-body">
                            <h5 class="font-weight-bold mb-4">{{ __('Weekly Attendance Trend') }}</h5>
                            <div style="position: relative; height: 300px; overflow: hidden;">
                                <canvas id="weeklyAttendanceChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card dashboard-card">
                        <div class="card-body">
                            <h5 class="font-weight-bold mb-4">{{ __('Fee Collection Breakdown') }}</h5>
                            <div style="position: relative; height: 220px; overflow: hidden;">
                                <canvas id="feeCollectionPieChart"></canvas>
                            </div>
                            <div class="mt-4 text-center">
                                <h4 class="font-weight-bold mb-0 text-dark">
                                    {{ $settings['currency_symbol'] ?? '' }}{{ number_format($total_collected_fees / 100000, 1) }}L
                                </h4>
                                <p class="text-muted small">{{ __('Total Collected') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Activity, Tasks, Events --}}
            <div class="row">
                <div class="col-md-5 mb-4">
                    <div class="card dashboard-card h-100">
                        <div class="card-body">
                            <div class="card-header-flex">
                                <h5 class="font-weight-bold mb-0 text-dark">{{ __('Recent Activity') }}</h5>
                                <a href="#" class="small text-primary font-weight-bold">{{ __('View All') }}</a>
                            </div>
                            <div class="activity-list">
                                @forelse($recent_activities as $activity)
                                    <div class="activity-item d-flex align-items-center px-0">
                                        <div class="stat-icon mr-3"
                                            style="width: 40px; height: 40px; background: rgba(0,0,0,0.05); flex-shrink: 0;">
                                            <i class="fa {{ $activity['icon'] }} text-{{ $activity['color'] == 'primary' ? 'info' : $activity['color'] }}"
                                                style="font-size: 1rem;"></i>
                                        </div>
                                        <div class="flex-grow-1 min-width-0">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0 font-weight-bold text-dark text-truncate"
                                                    style="font-size: 0.9rem;">{{ __($activity['title']) }}</h6>
                                                <small class="text-muted ml-2"
                                                    style="font-size: 0.75rem; flex-shrink: 0;">{{ $activity['time'] }}</small>
                                            </div>
                                            <p class="text-muted mb-0 small text-truncate">{{ $activity['desc'] }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center text-muted my-4">{{ __('No recent activities') }}</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card dashboard-card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h5 class="font-weight-bold text-dark mb-0">{{ __('Today\'s Tasks') }}</h5>
                                <button type="button" class="btn btn-xs btn-outline-primary rounded-circle" data-toggle="modal"
                                    data-target="#addTaskModal">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <p class="text-muted small mb-0">{{ $completed_tasks }} of {{ $total_tasks }} completed</p>
                                <div class="progress" style="width: 80px; height: 8px; border-radius: 10px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $total_tasks > 0 ? ($completed_tasks / $total_tasks) * 100 : 0 }}%"
                                        aria-valuenow="{{ $total_tasks > 0 ? ($completed_tasks / $total_tasks) * 100 : 0 }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>

                            <div class="task-list">
                                @forelse($tasks as $task)
                                    <div class="task-item" data-id="{{ $task->id }}">
                                        <div class="task-checkbox {{ $task->status ? 'checked' : '' }}" onclick="toggleTaskStatus({{ $task->id }}, {{ $task->status ? 0 : 1 }})"></div>
                                        <span class="{{ $task->status ? 'text-muted' : 'text-dark' }} small" style="{{ $task->status ? 'text-decoration: line-through;' : '' }}">
                                            {{ $task->title }}
                                        </span>
                                        @if($task->priority == 'high')
                                            <i class="fa fa-exclamation-circle text-danger ml-auto small"></i>
                                        @elseif($task->priority == 'medium')
                                            <i class="fa fa-clock text-warning ml-auto small"></i>
                                        @else
                                            <i class="fa fa-info-circle text-muted ml-auto small"></i>
                                        @endif
                                    </div>
                                @empty
                                    <p class="text-center text-muted small my-3">{{ __('Add your first task today!') }}</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4">
                    <div class="card dashboard-card h-100">
                        <div class="card-body">
                            <div class="card-header-flex">
                                <h5 class="font-weight-bold mb-0 text-dark">{{ __('Upcoming Events') }}</h5>
                                <a href="{{ route('holiday.index') }}"
                                    class="small text-primary font-weight-bold">{{ __('View All') }}</a>
                            </div>
                            <div class="events-list">
                                @forelse($upcoming_events as $event)
                                    <div class="d-flex mb-3 align-items-center">
                                        <div class="stat-icon mr-3"
                                            style="width: 40px; height: 40px; background: #edf2f7; color: #4a5568; flex-shrink: 0;">
                                            <i class="fa fa-calendar-alt" style="font-size: 1rem;"></i>
                                        </div>
                                        <div class="flex-grow-1 min-width-0">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="mb-0 font-weight-bold text-dark text-truncate"
                                                    style="font-size: 0.85rem;">{{ $event->title }}</h6>
                                                <span
                                                    class="badge badge-soft-{{ $event->event_type == 'holiday' ? 'danger' : 'warning' }} ml-1"
                                                    style="font-size: 0.6rem; flex-shrink: 0;">{{ $event->event_type }}</span>
                                            </div>
                                            <small class="text-muted" style="font-size: 0.75rem;">
                                                <i class="fa fa-clock mr-1"></i> {{ $event->time }}
                                            </small>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center text-muted my-4">{{ __('No upcoming events') }}</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($user->hasRole('Super Admin') || ($user->school_id == null && $user->hasRole('Admin')))
            {{-- Welcome Bar --}}
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card dashboard-card">
                        <div class="card-body">
                            <h3 class="font-weight-bold mb-1" style="color: #1a202c;">{{ __('Welcome back') }}!</h3>
                            <p class="text-muted mb-0">{{ __('Here\'s what\'s happening with SarthakEdge today.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Super Admin Stat Cards --}}
            <div class="row">
                <div class="col-md-2 mb-4">
                    <div class="card dashboard-card h-100">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="text-muted small mb-1">{{ __('Total Schools') }}</p>
                                    <h3 class="font-weight-bold mb-0 text-dark">{{ $super_admin['total_school'] }}</h3>
                                    <p class="mb-0 text-muted small mt-1">
                                        {{ __('Total integrated') }}
                                    </p>
                                </div>
                                <div class="stat-icon bg-soft-primary" style="width: 36px; height: 36px; font-size: 1rem;">
                                    <i class="fa fa-university"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <div class="card dashboard-card h-100">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="text-muted small mb-1">{{ __('Active Schools') }}</p>
                                    <h3 class="font-weight-bold mb-0 text-dark">{{ $super_admin['active_schools'] }}</h3>
                                    <p class="mb-0 text-muted small mt-1">
                                        {{ round(($super_admin['active_schools'] / max(1, $super_admin['total_school'])) * 100) }}% rate
                                    </p>
                                </div>
                                <div class="stat-icon bg-soft-success" style="width: 36px; height: 36px; font-size: 1rem;">
                                    <i class="fa fa-check-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <div class="card dashboard-card h-100">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="text-muted small mb-1">{{ __('Inactive Schools') }}</p>
                                    <h3 class="font-weight-bold mb-0 text-dark">{{ $super_admin['inactive_schools'] }}</h3>
                                    <p class="mb-0 text-danger small mt-1">Need attention</p>
                                </div>
                                <div class="stat-icon bg-soft-danger" style="width: 36px; height: 36px; font-size: 1rem;">
                                    <i class="fa fa-clock"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <div class="card dashboard-card h-100">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="text-muted small mb-1">{{ __('Total Packages') }}</p>
                                    <h3 class="font-weight-bold mb-0 text-dark">{{ $super_admin['total_packages'] }}</h3>
                                </div>
                                <div class="stat-icon bg-soft-warning" style="width: 36px; height: 36px; font-size: 1rem;">
                                    <i class="fa fa-box"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <div class="card dashboard-card h-100">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="text-muted small mb-1">{{ __('Total Revenue') }}</p>
                                    <h3 class="font-weight-bold mb-0 text-dark">₹{{ number_format($super_admin['total_revenue'] / 100, 0) }}</h3>
                                    <p class="mb-0 text-muted small mt-1">
                                        {{ __('Gross Revenue') }}
                                    </p>
                                </div>
                                <div class="stat-icon bg-soft-info" style="width: 36px; height: 36px; font-size: 1rem;">
                                    <i class="fa fa-rupee-sign"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <div class="card dashboard-card h-100">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="text-muted small mb-1">{{ __('MRR') }}</p>
                                    <h3 class="font-weight-bold mb-0 text-dark">₹{{ number_format($super_admin['mrr'] / 100, 0) }}</h3>
                                    <p class="mb-0 {{ $super_admin['revenue_growth'] >= 0 ? 'text-success' : 'text-danger' }} small mt-1">
                                        <i class="fa fa-arrow-{{ $super_admin['revenue_growth'] >= 0 ? 'up' : 'down' }} mr-1"></i> {{ abs(number_format($super_admin['revenue_growth'], 1)) }}%
                                    </p>
                                </div>
                                <div class="stat-icon bg-soft-primary" style="width: 36px; height: 36px; font-size: 1rem;">
                                    <i class="fa fa-chart-line"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Charts Row 1 --}}
            <div class="row mb-4">
                <div class="col-md-6 mb-4">
                    <div class="card dashboard-card">
                        <div class="card-body">
                            <h5 class="font-weight-bold mb-4 text-dark">{{ __('Subscription Growth') }}</h5>
                            <div style="height: 300px;">
                                <canvas id="subscriptionGrowthChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card dashboard-card">
                        <div class="card-body">
                            <h5 class="font-weight-bold mb-4 text-dark">{{ __('Revenue Trend') }}</h5>
                            <div style="height: 300px;">
                                <canvas id="revenueTrendChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Stats & Alrets Row --}}
            <div class="row mb-4">
                <div class="col-md-4 mb-4">
                    <div class="card dashboard-card">
                        <div class="card-body">
                            <h5 class="font-weight-bold mb-4 text-dark">{{ __('Revenue Distribution') }}</h5>
                            <div style="height: 250px;">
                                <canvas id="revenueDistributionChart"></canvas>
                            </div>
                            <div class="mt-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted small"><i class="fa fa-circle text-primary mr-1"></i> Subscriptions</span>
                                    <span class="font-weight-bold small">₹{{ number_format($super_admin['charts']['revenue_distribution']['Subscriptions'] / 100) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted small"><i class="fa fa-circle text-info mr-1"></i> Add-ons</span>
                                    <span class="font-weight-bold small">₹{{ number_format($super_admin['charts']['revenue_distribution']['Add-ons'] / 100) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted small"><i class="fa fa-circle text-warning mr-1"></i> AI Revenue</span>
                                    <span class="font-weight-bold small">₹{{ number_format($super_admin['charts']['revenue_distribution']['AI Revenue'] / 100) }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted small"><i class="fa fa-circle text-secondary mr-1"></i> Marketplace</span>
                                    <span class="font-weight-bold small">₹{{ number_format($super_admin['charts']['revenue_distribution']['Marketplace'] / 100) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 mb-4">
                    <div class="card dashboard-card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="font-weight-bold mb-0 text-dark"><i class="fa fa-exclamation-triangle mr-2"></i> {{ __('Smart Alerts') }}</h5>
                                <a href="#" class="btn btn-sm btn-outline-secondary">{{ __('View All') }}</a>
                            </div>
                            
                            <div class="alert-list">
                                @php $alert_count = 0; @endphp
                                @foreach ($server_configuration as $key => $value)
                                    @if (($settings[$key] ?? 0) == 0)
                                        @php $alert_count++; @endphp
                                        <div class="activity-item d-flex align-items-center py-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                            <div class="badge badge-soft-danger mr-3" style="width: 70px;">Critical</div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 font-weight-bold text-dark">{{ $value['title'] }}</h6>
                                                <p class="text-muted small mb-0">{{ $value['description'] ?? '' }}</p>
                                            </div>
                                            <a href="{{ $value['link'] }}" target="_blank" class="btn btn-sm btn-link text-primary">{{ __('Setup') }}</a>
                                        </div>
                                    @endif
                                @endforeach

                                @if($alert_count == 0)
                                    <div class="text-center py-4">
                                        <i class="fa fa-check-circle text-success mb-2" style="font-size: 2rem;"></i>
                                        <p class="text-muted mb-0">{{ __('All systems optimal') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Stats Small --}}
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card dashboard-card" style="background: #f0f4ff;">
                        <div class="card-body py-3 d-flex align-items-center">
                            <div class="stat-icon mr-3" style="background: #c3d4ff; color: #4361ee;">
                                <i class="fa fa-bolt"></i>
                            </div>
                            <div>
                                <p class="text-muted small mb-0">AI Queries Today</p>
                                <h4 class="font-weight-bold mb-0 text-dark">{{ number_format($super_admin['ai_queries']) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card dashboard-card" style="background: #f0fff4;">
                        <div class="card-body py-3 d-flex align-items-center">
                            <div class="stat-icon mr-3" style="background: #c6f6d5; color: #38a169;">
                                <i class="fa fa-credit-card"></i>
                            </div>
                            <div>
                                <p class="text-muted small mb-0">Payments Today</p>
                                <h4 class="font-weight-bold mb-0 text-dark">₹{{ number_format($super_admin['payments_today'] / 100, 0) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card dashboard-card" style="background: #ebf8ff;">
                        <div class="card-body py-3 d-flex align-items-center">
                            <div class="stat-icon mr-3" style="background: #bee3f8; color: #3182ce;">
                                <i class="fa fa-users"></i>
                            </div>
                            <div>
                                <p class="text-muted small mb-0">Active Users</p>
                                <h4 class="font-weight-bold mb-0 text-dark">{{ number_format($super_admin['active_users']) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card dashboard-card" style="background: #faf5ff;">
                        <div class="card-body py-3 d-flex align-items-center">
                            <div class="stat-icon mr-3" style="background: #e9d8fd; color: #805ad5;">
                                <i class="fa fa-signal"></i>
                            </div>
                            <div>
                                <p class="text-muted small mb-0">Uptime</p>
                                <h4 class="font-weight-bold mb-0 text-dark">{{ $super_admin['uptime'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Existing Super Admin Tables (Simplified) --}}
            <div class="row">
                <div class="col-md-7 mb-4">
                    <div class="card dashboard-card">
                        <div class="card-body">
                            <div class="card-header-flex">
                                <h5 class="font-weight-bold mb-0 text-dark">{{ __('Recent Schools') }}</h5>
                                <a href="{{ route('schools.index') }}" class="small text-primary font-weight-bold">{{ __('View All') }}</a>
                            </div>
                            <div class="table-responsive mt-3">
                                <table class="table custom-table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('School') }}</th>
                                            <th>{{ __('Admin') }}</th>
                                            <th class="text-center">{{ __('Status') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($schools->take(4) as $school)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ $school->logo }}" onerror="onErrorImage(event)" class="rounded-circle mr-2" style="width: 30px; height: 30px;" alt="">
                                                        <span>{{ $school->name }}</span>
                                                    </div>
                                                </td>
                                                <td>{{ $school?->user?->full_name }}</td>
                                                <td class="text-center">
                                                    <span class="badge badge-soft-{{ $school->status ? 'success' : 'danger' }}">{{ $school->status ? 'Active' : 'Inactive' }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 mb-4">
                    <div class="card dashboard-card">
                        <div class="card-body">
                           <h5 class="font-weight-bold mb-4 text-dark">{{ __('Subscription Details') }}</h5>
                           <div id="packageChartSmall" style="height: 250px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Add Task Modal --}}
    <div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="addTaskModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTaskModalLabel">{{ __('Add New Task') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="create-task-form">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{ __('Task Description') }} <span class="text-danger">*</span></label>
                            <input type="text" name="task_name" class="form-control"
                                placeholder="{{ __('Enter task description') }}" required>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Priority') }}</label>
                            <select name="priority" class="form-control">
                                <option value="low">{{ __('Low') }}</option>
                                <option value="medium" selected>{{ __('Medium') }}</option>
                                <option value="high">{{ __('High') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-theme">{{ __('Save Task') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')

    @if ($user->school_id)
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    @endif

    @if ($user->hasRole('Super Admin'))
        <script>
            $(document).ready(function () {
                $('.server-configuration-checkbox').change(function () {
                    var checkbox = $(this);
                    var value = checkbox.prop('checked') ? 1 : 0;
                    var name = checkbox.attr('id');

                    $.ajax({
                        url: "{{ route('server-configuration.update') }}",
                        type: 'POST',
                        data: {
                            name: name,
                            value: value,
                        },
                        success: function (response) {
                            showSuccessToast(response.message);
                        },
                        error: function (xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });

                });
            });
        </script>
    @endif




    @if (!$user->school_id && $user->hasRole('Super Admin'))
        <script>
            $(document).ready(function () {
                // Subscription Growth Chart
                var subCtx = document.getElementById('subscriptionGrowthChart').getContext('2d');
                new Chart(subCtx, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode(array_column($super_admin['charts']['subscription_growth'], 'month')) !!},
                        datasets: [{
                            label: "{{ __('Active Subscriptions') }}",
                            data: {!! json_encode(array_column($super_admin['charts']['subscription_growth'], 'count')) !!},
                            borderColor: '#4361ee',
                            backgroundColor: 'rgba(67, 97, 238, 0.1)',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 3
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: { y: { beginAtZero: true, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } }
                    }
                });

                // Revenue Trend Chart
                var revCtx = document.getElementById('revenueTrendChart').getContext('2d');
                new Chart(revCtx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode(array_column($super_admin['charts']['revenue_trend'], 'month')) !!},
                        datasets: [{
                            label: "{{ __('Revenue (₹)') }}",
                            data: {!! json_encode(array_map(function($v) { return $v/100; }, array_column($super_admin['charts']['revenue_trend'], 'amount'))) !!},
                            backgroundColor: '#4361ee',
                            borderRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: { y: { beginAtZero: true, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } }
                    }
                });

                // Revenue Distribution Chart
                var distCtx = document.getElementById('revenueDistributionChart').getContext('2d');
                new Chart(distCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ["Subscriptions", "Add-ons", "AI Revenue", "Marketplace"],
                        datasets: [{
                            data: [
                                {{ $super_admin['charts']['revenue_distribution']['Subscriptions'] / 100 }},
                                {{ $super_admin['charts']['revenue_distribution']['Add-ons'] / 100 }},
                                {{ $super_admin['charts']['revenue_distribution']['AI Revenue'] / 100 }},
                                {{ $super_admin['charts']['revenue_distribution']['Marketplace'] / 100 }}
                            ],
                            backgroundColor: ['#4361ee', '#4cc9f0', '#7209b7', '#f72585'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: { legend: { display: false } }
                    }
                });
            });
        </script>
    @endif

    @if (!$user->school_id)
        <script>
            window.onload = setTimeout(() => {
                $('.year-filter').trigger('change');

                if (typeof addon_graph === "function") {
                    addon_graph(<?php    echo json_encode($addon_graph[0]); ?>, <?php    echo json_encode($addon_graph[1]); ?>);
                }
                
                if (document.getElementById('packageChartSmall')) {
                   // Render package chart in our small container too
                   package_graph(<?php    echo json_encode($package_graph[0]); ?>, <?php    echo json_encode($package_graph[1]); ?>, 'packageChartSmall');
                } else {
                   package_graph(<?php    echo json_encode($package_graph[0]); ?>, <?php    echo json_encode($package_graph[1]); ?>);
                }
            }, 500);
        </script>
    @endif


    @if ($user->hasRole('School Admin') || $user->school_id)
        <script>
            $(document).ready(function () {
                // Weekly Attendance Chart
                var attendanceCtx = document.getElementById('weeklyAttendanceChart').getContext('2d');
                new Chart(attendanceCtx, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode(array_column($weekly_attendance_data, 'day')) !!},
                        datasets: [{
                            label: "{{ __('Present') }}",
                            data: {!! json_encode(array_column($weekly_attendance_data, 'present')) !!},
                            borderColor: '#48bb78',
                            backgroundColor: 'rgba(72, 187, 120, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#48bb78',
                            pointBorderWidth: 2,
                            pointRadius: 4
                        }, {
                            label: "{{ __('Absent') }}",
                            data: {!! json_encode(array_column($weekly_attendance_data, 'absent')) !!},
                            borderColor: '#f56565',
                            backgroundColor: 'rgba(245, 101, 101, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#f56565',
                            pointBorderWidth: 2,
                            pointRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        resizeDelay: 100,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                labels: {
                                    usePointStyle: true,
                                    padding: 20,
                                    font: { size: 12 }
                                }
                            },
                            tooltip: {
                                backgroundColor: '#1a202c',
                                padding: 12,
                                titleFont: { size: 14 },
                                bodyFont: { size: 13 },
                                cornerRadius: 8
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    display: true,
                                    color: '#f1f5f9',
                                    drawBorder: false
                                },
                                ticks: {
                                    font: { size: 11 },
                                    color: '#64748b'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: { size: 11 },
                                    color: '#64748b'
                                }
                            }
                        }
                    }
                });

                // Fee Collection Pie Chart
                var feeCtx = document.getElementById('feeCollectionPieChart').getContext('2d');
                new Chart(feeCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ["{{ __('Collected') }}", "{{ __('Pending') }}"],
                        datasets: [{
                            data: [{{ $total_collected_fees }}, {{ max(0, $total_expected_fees - $total_collected_fees) }}],
                            backgroundColor: ['#48bb78', '#f1f5f9'],
                            hoverBackgroundColor: ['#38a169', '#e2e8f0'],
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        resizeDelay: 100,
                        cutout: '75%',
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function (context) {
                                        var label = context.label || '';
                                        if (label) { label += ': '; }
                                        if (context.parsed !== null) {
                                            label += new Intl.NumberFormat('en-US', { style: 'currency', currency: "{{ $settings['currency_code'] ?? 'USD' }}" }).format(context.parsed);
                                        }
                                        return label;
                                    }
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endif

    <script>
        window.onload = setTimeout(() => {
            $('#filter_expense_session_year_id').trigger('change');
            $('.filter_birthday').trigger('change');
            $('.filter_leaves').trigger('change');
            $('#exam_result_session_year_id').trigger('change');

            const selectElement = document.getElementById('exam_reuslt_exam_name');
            if (selectElement) {
                var selectedIndex = selectElement.selectedIndex || 0;
                var options = selectElement.options;

                // Iterate through options starting from the next index
                for (var i = selectedIndex + 1; i < options.length; i++) {
                    if (options[i].style.display !== "none") {
                        // Set the next visible option as selected
                        selectElement.selectedIndex = i;
                        break;
                    }
                }
            }


            $('#exam_reuslt_exam_name').trigger('change');
            fees_details(<?php echo json_encode($fees_detail); ?>);

            $('.class-section-attendance').trigger('change');
            $('#fees-over-due-class-section').trigger('change');

        }, 500);
    </script>

    <script>
        function toggleTaskStatus(taskId, status) {
            $.ajax({
                url: "{{ url('tasks') }}/" + taskId,
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    _method: 'PUT',
                    status: status
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr) {
                    let errorMsg = 'Something went wrong';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    } else if (xhr.responseText) {
                        try {
                            let resp = JSON.parse(xhr.responseText);
                            if (resp.message) errorMsg = resp.message;
                        } catch(e) {
                            errorMsg = xhr.responseText.substring(0, 100);
                        }
                    }
                    $.toast({
                        text: errorMsg,
                        showHideTransition: 'slide',
                        icon: 'error',
                        loaderBg: '#f2a654',
                        position: 'top-right'
                    });
                }
            });
        }

        $('#create-task-form').on('submit', function(e) {
            e.preventDefault();
            let formData = {
                _token: "{{ csrf_token() }}",
                title: $(this).find('input[name="task_name"]').val(),
                priority: $(this).find('select[name="priority"]').val()
            };

            $.ajax({
                url: "{{ route('tasks.store') }}",
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#addTaskModal').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    let errorMsg = 'Something went wrong';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    } else if (xhr.responseText) {
                        try {
                            let resp = JSON.parse(xhr.responseText);
                            if (resp.message) errorMsg = resp.message;
                        } catch(e) {
                            errorMsg = xhr.responseText.substring(0, 100);
                        }
                    }
                    $.toast({
                        text: errorMsg,
                        showHideTransition: 'slide',
                        icon: 'error',
                        loaderBg: '#f2a654',
                        position: 'top-right'
                    });
                }
            });
        });
    </script>

    @if ($boys || $girls)
        <script>
            gender_ratio(<?php    echo $boys; ?>, <?php    echo $girls; ?>, <?php    echo $total_students; ?>);
        </script>
    @endif
@endsection