@extends('layouts.master')

@section('title')
    {{ __('View Teacher Timetable') }}
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

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            background: #fff;
            overflow: hidden;
        }

        .timetable-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding: 1rem;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        }

        .timetable-header h3 {
            margin: 0;
            font-weight: 700;
            color: var(--timetable-text-main);
        }

        /* Calendar Styling */
        .calendar-wrapper {
            background: #fff;
            padding: 1rem;
            border-radius: 15px;
        }

        .fc {
            font-family: 'Inter', sans-serif;
        }

        .fc th {
            background: #f1f5f9;
            padding: 12px !important;
            font-weight: 700 !important;
            color: var(--timetable-text-main) !important;
            border: none !important;
        }

        .fc td {
            border: 1px solid #f1f5f9 !important;
        }

        .fc-timegrid-slot {
            height: 60px !important;
        }

        .btn-back {
            background: #f1f5f9;
            color: var(--timetable-text-main);
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-back:hover {
            background: #e2e8f0;
            color: var(--timetable-text-main);
            text-decoration: none;
        }

        .fc-v-event {
            border: none !important;
            border-radius: 8px !important;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05) !important;
            padding: 5px !important;
        }

        @media print {
            @page {
                size: portrait;
                margin: 0.5cm;
            }
            .sidebar, .navbar, .footer, .btn-back, .header-actions {
                display: none !important;
            }
            .container-scroller, .page-body-wrapper, .main-panel, .content-wrapper {
                padding: 0 !important;
                margin: 0 !important;
                width: 100% !important;
                min-width: 100% !important;
                display: block !important;
                background: white !important;
            }
            .main-panel {
                height: auto !important;
            }
            .card, .card-body {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
                margin: 0 !important;
                background: white !important;
            }
            .timetable-header {
                box-shadow: none !important;
                margin-bottom: 15px !important;
                padding: 0 !important;
                justify-content: center !important;
            }
            .timetable-header h3 {
                font-size: 20px !important;
                text-align: center !important;
            }
            /* Shrink calendar for print to fit on one page */
            .fc-timegrid-slot {
                height: 45px !important;
            }
            .fc-toolbar {
                display: none !important;
            }
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="timetable-header">
            <div>
                <a href="{{ route('timetable.teacher.index') }}" class="btn-back mb-2">
                    <i class="fa fa-arrow-left"></i> {{ __('Back to List') }}
                </a>
                <h3>{{ __('Timetable for') }} {{ $teacher->full_name }}</h3>
            </div>
            <div class="header-actions">
                <button class="btn btn-theme" onclick="window.print()"><i class="fa fa-print mr-2"></i>
                    {{ __('Print') }}</button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="calendar-wrapper">
                            <div id='calendar' class="no-header-toolbar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            @foreach($timetables as $timetable)
                teacherTimetable.addEvent({
                    title: "{{$timetable->title}}",
                    daysOfWeek: [days.indexOf("{{$timetable->day}}")],
                    startTime: "{{$timetable->start_time}}",
                    endTime: "{{$timetable->end_time}}",
                    color: "{{$timetable->subject->bg_color ?? '#6366f1'}}",
                    id: "{{$timetable->id}}",
                    class_section: "{{$timetable->class_section->full_name}}"
                });
            @endforeach

            teacherTimetable.setOption("slotMinTime", "{{$timetableSettingsData['timetable_start_time'] ?? '08:00:00'}}");
            teacherTimetable.setOption("slotMaxTime", "{{$timetableSettingsData['timetable_end_time'] ?? '18:00:00'}}");
            teacherTimetable.setOption("slotDuration", "{{$timetableSettingsData['timetable_duration'] ?? '01:00:00'}}");

            teacherTimetable.render();
        });
    </script>
@endsection