@extends('layouts.master')

@section('title')
    {{ __('timetable') }}
@endsection

@section('css')
    <style>
        :root {
            --timetable-primary: #1e293b;
            --timetable-accent: #6366f1;
            --timetable-bg: #f8fafc;
            --timetable-card-bg: #ffffff;
            --timetable-text-main: #1e293b;
            --timetable-text-muted: #64748b;
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

        /* Sidebar Styling */
        #external-events {
            background: #f8fafc;
            padding: 1.5rem;
            border-radius: 15px;
            border: 1px solid var(--timetable-border);
            height: fit-content;
        }

        #external-events h4 {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: var(--timetable-text-main);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .fc-event {
            cursor: pointer;
            margin-bottom: 15px !important;
            padding: 15px !important;
            border: none !important;
            border-radius: 12px !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 700;
            font-size: 0.85rem;
            text-align: center;
        }

        .fc-event:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
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

        .fc .fc-toolbar-title {
            font-size: 1.25rem !important;
            font-weight: 700;
            color: var(--timetable-text-main);
        }

        .fc .fc-button-primary {
            background-color: var(--timetable-accent) !important;
            border-color: var(--timetable-accent) !important;
            border-radius: 8px !important;
            font-weight: 600;
            text-transform: capitalize;
        }

        /* Ensure custom grid is visible */
        .timetable-grid-wrapper {
            display: block !important;
            opacity: 1 !important;
            visibility: visible !important;
        }

        /* Hide FullCalendar definitively */
        .fc, #calendar, .fc-view-harness, .fc-header-toolbar {
            display: none !important;
            height: 0 !important;
            overflow: hidden !important;
        }

        /* Custom Grid Styling */
        .timetable-grid-wrapper {
            margin-top: 20px;
            overflow-x: auto;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            background: #fff;
        }

        .timetable-custom-grid {
            width: 100%;
            border-collapse: collapse !important;
            table-layout: fixed;
            min-width: 1000px;
        }

        .timetable-custom-grid th, .timetable-custom-grid td {
            border: 1px solid #e2e8f0 !important;
            padding: 10px !important;
            text-align: center !important;
            vertical-align: middle !important;
        }

        .day-corner, .day-label {
            background: #f8fafc !important;
            font-weight: 800 !important;
            color: #1e293b !important;
            width: 150px !important;
            position: sticky;
            left: 0;
            z-index: 10;
        }

        .period-header {
            background: #f8fafc !important;
            font-weight: 800 !important;
            color: #1e293b !important;
        }

        .period-header .p-name {
            font-size: 0.9rem;
            margin-bottom: 2px;
        }

        .period-header .p-time {
            font-size: 0.75rem;
            color: #64748b;
            font-weight: 600;
        }

        .drop-zone {
            height: 100px;
            background: #fff;
            transition: background 0.2s;
        }

        .drop-zone.drag-over {
            background: #f0f9ff !important;
            border: 2px dashed #0ea5e9 !important;
        }

        .grid-event {
            padding: 10px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 700;
            text-align: center;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .remove-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            cursor: pointer;
            color: rgba(0,0,0,0.3);
        }

        .remove-btn:hover {
            color: #ef4444;
        }

        /* Print Styling */
        @media print {
            .navbar, .sidebar, .footer, .btn-back, .header-actions, #external-events, .mt-4.p-4 {
                display: none !important;
            }

            .container-scroller, .page-body-wrapper, .main-panel, .content-wrapper, .flex-grow-1 {
                padding: 0 !important;
                margin: 0 !important;
                width: 100% !important;
                display: block !important;
            }

            .content-wrapper {
                background: white !important;
                padding: 20px !important;
            }

            .timetable-header {
                box-shadow: none !important;
                border: none !important;
                margin-bottom: 20px !important;
            }

            .timetable-header h3 {
                font-size: 24px !important;
                text-align: center !important;
                width: 100% !important;
            }

            .col-md-9 {
                flex: 0 0 100% !important;
                max-width: 100% !important;
                width: 100% !important;
            }

            .card {
                box-shadow: none !important;
                border: none !important;
                border-radius: 0 !important;
            }

            .card-body {
                padding: 0 !important;
            }

            .timetable-grid-wrapper {
                border: 1px solid #000 !important;
                border-radius: 0 !important;
                width: 100% !important;
                overflow: visible !important;
            }

            .timetable-custom-grid {
                min-width: 100% !important;
                width: 100% !important;
                border: 1px solid #000 !important;
            }

            .timetable-custom-grid th, .timetable-custom-grid td {
                border: 1px solid #000 !important;
                color: #000 !important;
                font-size: 10px !important;
                padding: 5px !important;
            }

            .day-corner, .day-label, .period-header {
                background: #f1f5f9 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .grid-event {
                border: 1px solid rgba(0,0,0,0.1) !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .remove-btn {
                display: none !important;
            }

            @page {
                size: landscape;
                margin: 0.5cm;
            }
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="timetable-header">
            <div>
                <a href="{{ route('timetable.index') }}" class="btn-back mb-2">
                    <i class="fa fa-arrow-left"></i> {{ __('Back to List') }}
                </a>
                <!-- ANTIGRAVITY_MARKER_V1 -->
                <h3>{{ $classSection->full_name }} <span class="text-muted" style="font-weight: 400; font-size: 1.1rem;">- {{ __('Manage Timetable') }}</span></h3>
            </div>
            <div class="header-actions">
                <button class="btn btn-theme mr-2" onclick="window.print()"><i class="fa fa-print mr-2"></i> {{ __('Print') }}</button>
                <a href="{{ route('timetable.index') }}" class="btn btn-success"><i class="fa fa-check-circle mr-2"></i> {{ __('Finish Editing') }}</a>
            </div>
        </div>

        @php
            $subjectStyles = [
                'Mathematics' => ['bg' => '#DBEAFE', 'text' => '#1e40af'],
                'Maths' => ['bg' => '#DBEAFE', 'text' => '#1e40af'],
                'English' => ['bg' => '#D1FAE5', 'text' => '#065f46'],
                'Science' => ['bg' => '#EDE9FE', 'text' => '#5b21b6'],
                'Hindi' => ['bg' => '#FEF3C7', 'text' => '#92400e'],
                'Social Studies' => ['bg' => '#CCFBF1', 'text' => '#115e59'],
                'Computer' => ['bg' => '#E0F2FE', 'text' => '#075985'],
                'PE' => ['bg' => '#FEE2E2', 'text' => '#991b1b'],
                'Art' => ['bg' => '#FEF9C3', 'text' => '#854d0e'],
                'Music' => ['bg' => '#FCE7F3', 'text' => '#9d174d'],
                'Library' => ['bg' => '#E0E7FF', 'text' => '#3730a3'],
                'Games' => ['bg' => '#D1FAE5', 'text' => '#065f46'],
                'Club Activity' => ['bg' => '#F3F4F6', 'text' => '#374151'],
                'Assembly' => ['bg' => '#FEF3C7', 'text' => '#92400e'],
                'Special Class' => ['bg' => '#F1F5F9', 'text' => '#334155'],
            ];

            function getSubStyle($name, $styles) {
                return $styles[$name] ?? ['bg' => '#6366f1', 'text' => '#ffffff'];
            }

            function getSubStyleEdit($name, $styles) {
                $name = strtolower($name);
                foreach ($styles as $key => $style) {
                    if (str_contains($name, strtolower($key))) {
                        return $style;
                    }
                }
                return ['bg' => '#f1f5f9', 'text' => '#475569'];
            }
        @endphp

        <div class="row">
            <div class="col-md-3">
                <div id='external-events'>
                    <h4>{{ __('Subjects') }}</h4>
                    <p class="small text-muted mb-4">{{ __('Drag and drop subjects into the calendar grid below') }}</p>

                    @foreach ($subjectTeachers as $subjectTeacher)
                        @php $style = getSubStyle($subjectTeacher->subject->name, $subjectStyles); @endphp
                        <div class='fc-event'
                            style="background-color: {{ $style['bg'] }}; color: {{ $style['text'] }};"
                            data-color="{{ $style['bg'] }}"
                            data-subject_teacher_id="{{ $subjectTeacher->id }}"
                            data-subject_id="{{ $subjectTeacher->subject_id }}"
                            data-subject-type="{{ $subjectTeacher->class_subject ? $subjectTeacher->class_subject->type : '' }}"
                            data-duration='{{ $timetableSettingsData['timetable_duration'] ?? '01:00:00' }}'
                            data-note="">
                            <div class='fc-event-main'>
                                <div class="font-weight-bold">{{ $subjectTeacher->subject->name }}</div>
                                <div style="font-size: 0.7rem; opacity: 0.8; font-weight: 400;">{{ $subjectTeacher->teacher->full_name }}</div>
                            </div>
                        </div>
                    @endforeach

                    @foreach ($subjectWithoutTeacherAssigned as $subject)
                        @php
                            $filtered = collect($subject->class_subjects)->first();
                            $style = getSubStyle($subject->name, $subjectStyles);
                        @endphp
                        <div class='fc-event'
                            style="background-color: {{ $style['bg'] }}; color: {{ $style['text'] }};" 
                            data-color="{{ $style['bg'] }}"
                            data-duration='{{ $timetableSettingsData['timetable_duration'] ?? '01:00:00' }}'
                            data-subject_id="{{ $subject->id }}" data-note=""
                            data-subject-type="{{ $filtered['type'] ?? '' }}">
                            <div class='fc-event-main'>
                                <div class="font-weight-bold">{{ $subject->name }}</div>
                                <div style="font-size: 0.7rem; opacity: 0.8; font-weight: 400;">{{ __('No Teacher Assigned') }}</div>
                            </div>
                        </div>
                    @endforeach

                    <div class='fc-event'
                        style="background-color: #f1f5f9; color: #475569;" data-color="#f1f5f9" data-duration='00:30:00'
                        data-note="Break">
                        <div class='fc-event-main'>
                            <i class="fa fa-coffee mr-2"></i> {{ __('Break') }}
                        </div>
                    </div>

                    <div class='fc-event'
                        style="background-color: #f1f5f9; color: #475569;" data-color="#f1f5f9" data-duration='00:30:00'
                        data-note="Lunch">
                        <div class='fc-event-main'>
                            <i class="fa fa-utensils mr-2"></i> {{ __('Lunch') }}
                        </div>
                    </div>

                    <div class='fc-event' id="custom-event-draggable"
                        style="background-color: #f1f5f9; color: #475569;" data-color="#f1f5f9" data-duration='01:00:00'
                        data-note="">
                        <div class='fc-event-main'>
                            <i class="fa fa-plus-circle mr-2"></i> {{ __('Custom Block') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card shadow-sm border-0" style="border-radius: 20px;">
                    <div class="card-body p-4">
                        <div id="calendar-disabled" style="display: none !important;"></div>
                        <div class="timetable-grid-wrapper">
                            <table class="table timetable-custom-grid">
                                <thead>
                                    <tr>
                                        <th class="day-corner">Day / Period</th>
                                        @php
                                            $specPeriods = [
                                                ['name' => 'P1', 'time' => '8:00-8:45'],
                                                ['name' => 'P2', 'time' => '8:45-9:30'],
                                                ['name' => 'P3', 'time' => '9:30-10:15'],
                                                ['name' => 'Break', 'time' => '10:15-10:30', 'isBreak' => true],
                                                ['name' => 'P4', 'time' => '10:30-11:15'],
                                                ['name' => 'P5', 'time' => '11:15-12:00'],
                                                ['name' => 'P6', 'time' => '12:00-12:45'],
                                                ['name' => 'Break', 'time' => '12:45-1:30', 'isBreak' => true],
                                                ['name' => 'P7', 'time' => '1:30-2:15'],
                                                ['name' => 'P8', 'time' => '2:15-3:00'],
                                            ];
                                        @endphp
                                        @foreach($specPeriods as $period)
                                            <th class="period-header">
                                                <div class="p-name">{{ $period['name'] }}</div>
                                                <div class="p-time">{{ $period['time'] }}</div>
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $displayDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                                    @endphp
                                    @foreach($displayDays as $day)
                                        <tr>
                                            <td class="day-label">{{ $day }}</td>
                                            @foreach($specPeriods as $period)
                                                @if(isset($period['isBreak']))
                                                    <td class="break-cell" data-day="{{ $day }}" data-period="Break" data-time="{{ $period['time'] }}">
                                                        <div style="font-weight: 800; color: #94a3b8; font-size: 0.75rem; text-transform: uppercase;">Break</div>
                                                    </td>
                                                @else
                                                    <td class="drop-zone" data-day="{{ $day }}" data-period="{{ $period['name'] }}" data-time="{{ $period['time'] }}"></td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4 p-4" style="background: #ffffff; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid #f1f5f9;">
            <h6 style="font-weight: 800; color: #1e293b; margin-bottom: 20px; font-size: 0.9rem;">Subject Color Legend</h6>
            <div class="d-flex flex-wrap" style="gap: 12px;">
                @foreach ($subjectTeachers as $subjectTeacher)
                    @php $style = getSubStyle($subjectTeacher->subject->name, $subjectStyles); @endphp
                    <div style="background: {{ $style['bg'] }}; color: {{ $style['text'] }}; padding: 8px 16px; border-radius: 50px; font-size: 0.75rem; font-weight: 700; display: flex; align-items: center; border: 1px solid rgba(0,0,0,0.05);">
                        <span style="width: 6px; height: 6px; border-radius: 50%; background: {{ $style['text'] }}; display: inline-block; margin-right: 8px;"></span>
                        {{ $subjectTeacher->subject->name }}
                    </div>
                @endforeach
                @foreach ($subjectWithoutTeacherAssigned as $subject)
                    @php $style = getSubStyle($subject->name, $subjectStyles); @endphp
                    <div style="background: {{ $style['bg'] }}; color: {{ $style['text'] }}; padding: 8px 16px; border-radius: 50px; font-size: 0.75rem; font-weight: 700; display: flex; align-items: center; border: 1px solid rgba(0,0,0,0.05);">
                        <span style="width: 6px; height: 6px; border-radius: 50%; background: {{ $style['text'] }}; display: inline-block; margin-right: 8px;"></span>
                        {{ $subject->name }}
                    </div>
                @endforeach
                <div style="background: #f1f5f9; color: #475569; padding: 8px 16px; border-radius: 50px; font-size: 0.75rem; font-weight: 700; display: flex; align-items: center; border: 1px solid rgba(0,0,0,0.05);">
                    <span style="width: 6px; height: 6px; border-radius: 50%; background: #475569; display: inline-block; margin-right: 8px;"></span>
                    {{ __('Break') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function () {
            const timetables = @json($timetables);
            const subjectStyles = @json($subjectStyles);
            const palette = {
                'Mathematics': { bg: '#DBEAFE', text: '#1e40af' },
                'Maths': { bg: '#DBEAFE', text: '#1e40af' },
                'English': { bg: '#D1FAE5', text: '#065f46' },
                'Science': { bg: '#EDE9FE', text: '#5b21b6' },
                'Hindi': { bg: '#FEF3C7', text: '#92400e' },
                'Social Studies': { bg: '#CCFBF1', text: '#115e59' },
                'Computer': { bg: '#E0F2FE', text: '#075985' },
                'PE': { bg: '#FEE2E2', text: '#991b1b' },
                'Art': { bg: '#FEF9C3', text: '#854d0e' },
                'Music': { bg: '#FCE7F3', text: '#9d174d' },
                'Library': { bg: '#E0E7FF', text: '#3730a3' },
                'Games': { bg: '#D1FAE5', text: '#065f46' },
                'Club Activity': { bg: '#F3F4F6', text: '#374151' },
                'Assembly': { bg: '#FEF3C7', text: '#92400e' },
                'Special Class': { bg: '#F1F5F9', text: '#334155' }
            };
            
            function renderGridEvents() {
                $('.drop-zone').empty();
                if (!timetables || !Array.isArray(timetables)) return;

                timetables.forEach(t => {
                    try {
                        // Extract start and end time safely 
                        if (!t.start_time || !t.end_time) return;
                        
                        let sTime = t.start_time.split(':');
                        let eTime = t.end_time.split(':');
                        
                        if (sTime.length >= 2 && eTime.length >= 2) {
                            let startH = parseInt(sTime[0], 10);
                            let startM = sTime[1];
                            let endH = parseInt(eTime[0], 10);
                            let endM = eTime[1];
                            
                            const timeRange = `${startH}:${startM}-${endH}:${endM}`;
                            const cell = $(`.drop-zone[data-day="${t.day}"][data-time="${timeRange}"]`);
                            
                            if (cell.length) {
                                // Determine subject name and teacher name safely
                                let subjectName = t.subject_name || (t.subject ? t.subject.name : (t.note || (t.type === 'Break' ? 'Break' : '')));
                                let teacherName = t.teacher_name || (t.teacher ? (t.teacher.first_name + ' ' + (t.teacher.last_name || '')) : '');
                                
                                // Color logic
                                let style = {bg: '#f1f5f9', text: '#475569'};
                                if (subjectName) {
                                    style = subjectStyles[subjectName] || 
                                            palette[Object.keys(palette).find(k => subjectName.toLowerCase().includes(k.toLowerCase()))] || 
                                            {bg: t.subject_bg_color || '#f1f5f9', text: '#475569'};
                                }

                                const eventHtml = `
                                    <div class="grid-event" style="background: ${style.bg}; color: ${style.text}; border-left: 4px solid ${style.text};">
                                        <div class="event-title" style="word-break: break-word;">${subjectName}</div>
                                        <div class="event-teacher" style="font-size: 0.65rem; opacity: 0.8;">${teacherName}</div>
                                        <div class="remove-btn" onclick="removeTimetable(${t.id}, this)"><i class="fa fa-times"></i></div>
                                    </div>
                                `;
                                cell.append(eventHtml);
                            }
                        }
                    } catch (e) {
                        console.error("Error rendering timetable entry:", t, e);
                    }
                });
            }

            // Initialize Draggable subjects
            $('.fc-event').draggable({
                revert: "invalid",
                helper: "clone",
                zIndex: 100,
                start: function(event, ui) {
                    $(ui.helper).css('width', $(this).width());
                    $(ui.helper).css('height', 'auto');
                    $(ui.helper).css('padding', '10px');
                    $(ui.helper).css('border-radius', '8px');
                }
            });

            // Initialize Droppable zones
            $('.drop-zone').droppable({
                accept: ".fc-event",
                hoverClass: "drag-over",
                drop: function(event, ui) {
                    const day = $(this).data('day');
                    const timeRange = $(this).data('time');
                    const times = timeRange.split('-');
                    const start_time = times[0] + ":00";
                    const end_time = times[1] + ":00";
                    
                    const subject_teacher_id = ui.draggable.data('subject_teacher_id');
                    const subject_id = ui.draggable.data('subject_id');
                    const subject_type = ui.draggable.data('subject-type');
                    let note = ui.draggable.data('note');
                    
                    if (ui.draggable.attr('id') === 'custom-event-draggable') {
                        const customName = prompt("Enter Name (e.g., Annual Day):");
                        if (!customName) return;
                        note = customName;
                    }
                    
                    saveTimetable(day, start_time, end_time, subject_teacher_id, subject_id, subject_type, note);
                }
            });

            function saveTimetable(day, start, end, st_id, s_id, type, note) {
                let data = new FormData();
                if (st_id) data.append('subject_teacher_id', st_id);
                if (s_id) data.append('subject_id', s_id);
                if (type) data.append('subject_type', type);
                
                data.append('day', day);
                data.append('start_time', start);
                data.append('end_time', end);
                data.append('class_section_id', "{{ $classSection->id }}");
                data.append('semester_id', "{{ $classSection->class->semester_id ?? '' }}");
                data.append('note', note || '');

                ajaxRequest('POST', baseUrl + '/timetable', data, null, function (response) {
                    showSuccessToast(response.message);
                    setTimeout(() => window.location.reload(), 500);
                }, function (response) {
                    showErrorToast(response.message || "Something went wrong");
                });
            }

            window.removeTimetable = function(id, btn) {
                showDeletePopupModal(baseUrl + '/timetable/' + id, {
                    successCallBack: function () {
                        $(btn).closest('.grid-event').remove();
                        const index = timetables.findIndex(t => t.id == id);
                        if (index > -1) timetables.splice(index, 1);
                    }
                });
            };

            renderGridEvents();
        });
    </script>
@endsection