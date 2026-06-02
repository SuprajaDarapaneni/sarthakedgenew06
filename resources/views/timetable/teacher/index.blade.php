@extends('layouts.master')

@section('title')
    {{ __('Teacher Timetable') }}
@endsection

@section('css')
    <style>
        :root {
            --timetable-primary: #4e73df;
            --timetable-accent: #6366f1;
            --timetable-bg: #f4f7fe;
            --timetable-card-bg: #ffffff;
            --timetable-text-main: #2e3759;
            --timetable-text-muted: #718096;
            --timetable-border: #e2e8f0;
        }

        .content-wrapper {
            background: var(--timetable-bg);
            padding: 2rem;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--timetable-text-main);
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            font-size: 1rem;
            color: var(--timetable-text-muted);
        }

        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            background: var(--timetable-card-bg);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .card-body {
            padding: 2rem;
        }

        /* Table Styles */
        .bootstrap-table .fixed-table-container {
            border: none !important;
            border-radius: 12px;
            overflow: hidden;
        }

        .table thead th {
            background: #f1f5f9 !important;
            color: var(--timetable-text-main) !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            padding: 15px !important;
            border: none !important;
        }

        .table tbody td {
            padding: 15px !important;
            vertical-align: middle !important;
            border-bottom: 1px solid #f1f5f9 !important;
            color: var(--timetable-text-main);
        }

        .day-column {
            min-width: 140px;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('Teacher Timetable') }}</h3>
            <p class="page-subtitle">{{ __('View and track schedules for all teachers') }}</p>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table aria-describedby="mydesc" class='table' id='table_list' data-toggle="table"
                                data-url="{{ route('timetable.teacher.list') }}" data-click-to-select="true"
                                data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-toolbar="#toolbar"
                                data-show-columns="true" data-show-refresh="true" data-fixed-columns="false"
                                data-fixed-number="2" data-fixed-right-number="1" data-trim-on-search="false"
                                data-mobile-responsive="true" data-sort-name="id"
                                data-query-params="AssignTeacherQueryParams" data-sort-order="desc"
                                data-maintain-selected="true" data-export-data-type='all' data-show-export="true"
                                data-export-options='{ "fileName": "teacher-timetable-list-<?= date('d-m-y') ?>" }'>
                                <thead>
                                    <tr>
                                        <th scope="col" data-field="id" data-sortable="true" data-visible="false">
                                            {{ __('id') }}</th>
                                        <th scope="col" data-field="no">{{ __('no.') }}</th>
                                        <th scope="col" data-field="full_name" data-sortable="true">{{ __('name') }}</th>
                                        <th scope="col" data-field="Monday" data-formatter="teacherTimetableDayFormatter"
                                            class="day-column">{{ __('Monday') }}</th>
                                        <th scope="col" data-field="Tuesday" data-formatter="teacherTimetableDayFormatter"
                                            class="day-column">{{ __('Tuesday') }}</th>
                                        <th scope="col" data-field="Wednesday" data-formatter="teacherTimetableDayFormatter"
                                            class="day-column">{{ __('Wednesday') }}</th>
                                        <th scope="col" data-field="Thursday" data-formatter="teacherTimetableDayFormatter"
                                            class="day-column">{{ __('Thursday') }}</th>
                                        <th scope="col" data-field="Friday" data-formatter="teacherTimetableDayFormatter"
                                            class="day-column">{{ __('Friday') }}</th>
                                        <th scope="col" data-field="Saturday" data-formatter="teacherTimetableDayFormatter"
                                            class="day-column">{{ __('Saturday') }}</th>
                                        <th scope="col" data-field="Sunday" data-formatter="teacherTimetableDayFormatter"
                                            class="day-column" data-visible="false">{{ __('Sunday') }}</th>
                                        <th scope="col" data-field="operate" data-escape="false">{{ __('action') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection