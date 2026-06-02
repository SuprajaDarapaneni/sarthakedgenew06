@extends('layouts.master')

@section('title')
    {{ __('timetable') }}
@endsection

@section('css')
    <style>
        :root {
            --timetable-primary: #4e73df;
            --timetable-secondary: #858796;
            --timetable-success: #1cc88a;
            --timetable-info: #36b9cc;
            --timetable-warning: #f6c23e;
            --timetable-danger: #e74a3b;
            --timetable-light: #f8f9fc;
            --timetable-dark: #5a5c69;
            --timetable-bg: #f4f7fe;
            --timetable-card-bg: #ffffff;
            --timetable-text-main: #2e3759;
            --timetable-text-muted: #718096;
            --timetable-accent: #6366f1;
            --timetable-border: #e2e8f0;
            --timetable-input-bg: #f8fafc;
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
            font-size: 0.9rem;
            color: var(--timetable-text-muted);
            margin-top: -0.5rem;
        }

        .header-actions {
            display: flex;
            gap: 12px;
        }

        .btn-outline-header {
            background: white;
            border: 1px solid var(--timetable-border);
            color: var(--timetable-text-main);
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-outline-header:hover {
            background: #f8fafc;
            color: var(--timetable-accent);
        }

        .btn-navy-header {
            background: #1e293b;
            color: white;
            padding: 10px 24px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 8px;
            border: none;
            transition: all 0.2s;
        }

        .btn-navy-header:hover {
            background: #0f172a;
            color: white;
        }

        .filter-row-card {
            background: white;
            border-radius: 15px;
            padding: 15px 25px;
            border: 1px solid var(--timetable-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        }

        .select-class-wrapper {
            display: flex;
            align-items: center;
            gap: 15px;
            background: #f8fafc;
            padding: 8px 20px;
            border-radius: 50px;
            border: 1px solid var(--timetable-border);
            min-width: 320px;
        }

        .select-class-wrapper i {
            color: var(--timetable-text-muted);
        }

        .select-class-wrapper label {
            margin-bottom: 0;
            font-weight: 700;
            color: var(--timetable-text-main);
            white-space: nowrap;
        }

        .select-class-wrapper .select2-container--default .select2-selection--single {
            background: transparent !important;
            border: none !important;
        }

        .academic-year-badge {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--timetable-text-main);
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

        .settings-section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--timetable-text-main);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .settings-section-title i {
            color: var(--timetable-accent);
        }

        .form-group label {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--timetable-text-main);
            margin-bottom: 8px;
        }

        .form-control {
            background-color: var(--timetable-input-bg) !important;
            border: 1px solid var(--timetable-border) !important;
            border-radius: 10px !important;
            height: 48px !important;
            padding: 12px 16px !important;
            transition: all 0.2s;
        }

        .form-control:focus {
            background-color: #fff !important;
            border-color: var(--timetable-accent) !important;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1) !important;
        }

        .btn-theme {
            background: var(--timetable-accent) !important;
            border: none !important;
            border-radius: 10px !important;
            padding: 12px 24px !important;
            font-weight: 600 !important;
            color: #fff !important;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
        }

        .btn-theme:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(99, 102, 241, 0.3);
        }

        /* Table Styles */
        #toolbar {
            margin-bottom: 1rem;
            padding: 1rem;
            background: #f8fafc;
            border-radius: 12px;
            border: 1px solid var(--timetable-border);
        }

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

        .timetable-slot-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            background: var(--timetable-bg);
            color: var(--timetable-accent);
            margin-bottom: 4px;
            border: 1px solid rgba(99, 102, 241, 0.1);
        }

        .day-column {
            min-width: 140px;
        }

        .fixed-table-pagination {
            padding: 1rem 0;
        }

        .page-item.active .page-link {
            background-color: var(--timetable-accent) !important;
            border-color: var(--timetable-accent) !important;
        }

        /* Custom Modal Styles */
        .custom-modal-content {
            border: none;
            border-radius: 20px;
        }

        .card-shadow {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .modal-title-wrapper {
            display: flex;
            flex-direction: column;
        }

        .text-theme {
            color: var(--timetable-accent);
        }

        .custom-modal-close {
            background: #f1f5f9 !important;
            width: 32px;
            height: 32px;
            border-radius: 50% !important;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 !important;
            margin: 0 !important;
            opacity: 1 !important;
            transition: all 0.2s;
        }

        .custom-modal-close:hover {
            background: #e2e8f0 !important;
        }

        .custom-input-group label {
            letter-spacing: 0.05em;
        }

        .input-with-icon {
            position: relative;
        }

        .input-inner-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            z-index: 5;
        }

        .select2-modal {
            padding-left: 40px !important;
        }

        .btn-rounded {
            border-radius: 50px !important;
        }

        .btn-light-gray {
            background: #f1f5f9;
            color: #475569;
            font-weight: 600;
        }
        
        .btn-light-gray:hover {
            background: #e2e8f0;
        }

        /* Premium Grid Specific Styles */
        .timetable-card {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            margin-top: 20px;
        }
        .timetable-grid {
            width: 100%;
            border-collapse: collapse !important;
            table-layout: fixed;
        }
        .timetable-grid th, .timetable-grid td {
            border: 1px solid #e2e8f0 !important;
            padding: 10px !important;
            text-align: center !important;
            vertical-align: middle !important;
        }
        .day-column {
            background: #f8fafc !important;
            font-weight: 800 !important;
            color: #1e293b !important;
            width: 150px !important;
            font-size: 0.95rem !important;
        }
        .period-header {
            font-weight: 800 !important;
            color: #1e293b !important;
            font-size: 0.9rem;
            margin-bottom: 3px;
        }
        .period-time {
            color: #64748b;
            font-weight: 600;
            font-size: 0.75rem;
        }
        .lecture-cell {
            border-radius: 12px;
            min-height: 80px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 10px;
            transition: all 0.2s;
        }
        .break-cell {
            background: #f1f5f9;
            color: #94a3b8;
            font-weight: 800;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .empty-cell {
            border: 2px dashed #f1f5f9;
            border-radius: 12px;
            min-height: 80px;
        }
        #legend-wrapper {
            margin-top: 30px;
            padding: 20px;
            background: #fff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }
        .legend-item {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.8rem;
            margin-right: 15px;
            margin-bottom: 10px;
        }

        @media print {
            @page { size: landscape; margin: 10mm; }
            .no-print, .main-sidebar, .navbar, .footer, .btn, .settings-section-title, .timetable-settings-form, hr, .filter-row-card {
                display: none !important;
            }
            .content-wrapper { padding: 0 !important; background: white !important; }
            .card, .card-body { box-shadow: none !important; padding: 0 !important; margin: 0 !important; }
            .table-responsive { overflow: visible !important; width: 100% !important; }
            table { width: 100% !important; table-layout: fixed !important; border-collapse: collapse !important; }
            th, td { font-size: 10px !important; padding: 4px !important; border: 1px solid #cbd5e1 !important; }
            .shadow-sm { box-shadow: none !important; border: 1px solid rgba(0,0,0,0.1) !important; }
            * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
       <div class="page-header" style="background: #ffffff; padding: 25px 30px; border-bottom: 1px solid #e2e8f0; margin-bottom: 25px;">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h3 class="page-title" style="margin: 0; font-weight: 800; color: #1e293b; font-size: 1.75rem;">Timetable</h3>
                <p class="text-muted mb-0" style="font-size: 0.95rem; margin-top: 5px;">View and manage class timetables</p>
            </div>
            <div class="col-sm-6 text-right">
                <div class="d-flex justify-content-end align-items-center" style="gap: 12px;">
                    <button class="btn btn-outline-secondary" style="border: 1px solid #e2e8f0; border-radius: 8px; font-weight: 600; padding: 10px 18px; color: #475569;" id="btn-print-main">
                        <i class="fa fa-print mr-2"></i> Print
                    </button>
                    <button class="btn btn-outline-secondary" style="border: 1px solid #e2e8f0; border-radius: 8px; font-weight: 600; padding: 10px 18px; color: #475569;" id="btn-export-main">
                        <i class="fa fa-download mr-2"></i> Export
                    </button>
                    <a href="#" onclick="alert('Please select a Class Section first, then click the Edit button in its row below to edit the timetable.'); return false;" class="btn btn-primary" style="background: #1e293b; border: none; border-radius: 8px; font-weight: 600; padding: 10px 22px; color: #fff;" id="btn-edit-main">
                        <i class="fa fa-edit mr-2"></i> Edit Timetable
                    </a>
                </div>
            </div>
        </div>
    </div>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="settings-section-title">
                            <i class="fa fa-cog"></i> {{ __('Timetable Settings') }}
                        </div>
                        <form class="edit-form edit-form-without-reset timetable-settings-form mb-5"
                            action="{{ route('timetable.settings') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row align-items-end">
                                <div class="form-group col-sm-12 col-md-3">
                                    <label for="starting_time">{{ __('Starting Time') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="time" name="timetable_start_time" id="starting_time" class="form-control"
                                        value="{{ $timetableData['timetable_start_time'] ?? ""}}" />
                                </div>

                                <div class="form-group col-sm-12 col-md-3">
                                    <label for="ending_time">{{ __('Ending Time') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="time" name="timetable_end_time" id="ending_time" class="form-control"
                                        value="{{ $timetableData['timetable_end_time'] ?? ""}}" />
                                </div>
                                <div class="form-group col-sm-12 col-md-3">
                                    <label for="duration">{{ __('Timeslot Duration') }}
                                        <small>({{__('in Minutes')}})</small><span class="text-danger">*</span></label>
                                    <input type="number" name="timetable_duration" id="duration" class="form-control"
                                        min="1" value="{{ $timetableData['timetable_duration'] ?? ""}}" />
                                </div>
                                <div class="form-group col-sm-12 col-md-3">
                                    <button type="submit" id="generate"
                                        class="btn btn-theme w-100">{{__('Save Settings')}}</button>
                                </div>
                            </div>
                        </form>

                        <hr class="mb-5" style="border-top: 1px dashed var(--timetable-border);">

                        <div id="toolbar"></div>

                        <!-- Create Timetable Modal -->
                        <div class="modal fade" id="createTimetableModal" tabindex="-1" role="dialog"
                            aria-labelledby="createTimetableModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content custom-modal-content card-shadow">
                                    <div class="modal-header border-0 pb-0">
                                        <div class="modal-title-wrapper">
                                            <h5 class="modal-title font-weight-bold text-dark" id="createTimetableModalLabel">
                                                <i class="fa fa-calendar-plus-o text-theme mr-2"></i> {{ __('Create New Timetable') }}
                                            </h5>
                                            <p class="text-muted small mb-0">{{ __('Select a class to set up its schedule') }}</p>
                                        </div>
                                        <button type="button" class="close custom-modal-close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body py-4">
                                        <div class="form-group custom-input-group mb-0">
                                            <label class="font-weight-bold text-muted small uppercase mb-2">{{ __('Select Class Section') }} <span class="text-danger">*</span></label>
                                            <div class="input-with-icon">
                                                <i class="fa fa-university input-inner-icon"></i>
                                                <select name="class_section_id" id="create_timetable_class_section_id" class="form-control select2-modal" required>
                                                    <option value="">{{ __('Select Class Section') }}</option>
                                                    @foreach($classes as $id => $name)
                                                        <option value="{{ $id }}">{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0 pt-0">
                                        <button type="button" class="btn btn-light-gray btn-rounded px-4" data-dismiss="modal">{{ __('Close') }}</button>
                                        <button type="button" class="btn btn-theme btn-rounded px-4 shadow-sm" id="btn-proceed-create">
                                            {{ __('Proceed to Manage') }} <i class="fa fa-arrow-right ml-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Clone Timetable Modal -->
                        <div class="modal fade" id="cloneTimetableModal" tabindex="-1" role="dialog"
                            aria-labelledby="cloneTimetableModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="cloneTimetableModalLabel">
                                            {{ __('Clone Timetable (Template)') }}
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('timetable.copy') }}" method="POST" class="create-form">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>{{ __('Copy From (Template)') }} <span
                                                        class="text-danger">*</span></label>
                                                <select name="from_class_section_id" class="form-control" required>
                                                    <option value="">{{ __('Select Class Section') }}</option>
                                                    @foreach($classes as $id => $name)
                                                        <option value="{{ $id }}">{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>{{ __('Copy To') }} <span class="text-danger">*</span></label>
                                                <select name="to_class_section_id" class="form-control" required>
                                                    <option value="">{{ __('Select Class Section') }}</option>
                                                    @foreach($classes as $id => $name)
                                                        <option value="{{ $id }}">{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <p class="text-warning small"><i class="fa fa-exclamation-triangle"></i>
                                                {{ __('Warning: This will overwrite any existing timetable for the target class section.') }}
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">{{ __('Close') }}</button>
                                            <button type="submit" class="btn btn-theme">{{ __('Copy Timetable') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                <div class="col-md-12">
                <div class="filter-row-card" style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 20px 30px; margin-bottom: 30px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <span style="font-weight: 700; color: #475569; margin-right: 20px; font-size: 0.95rem;"><i class="fa fa-calendar-check-o mr-2"></i> Select Class:</span>
                                <div style="flex-grow: 1; max-width: 300px;">
                                    <select name="class_section_id" id="timetable_class_section_id" class="form-control select2" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; height: 45px !important;">
                                        <option value="">{{ __('Select Class') }}</option>
                                        @foreach ($classes as $id => $name)
                                            <option value="{{ $id }}">
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-right">
                            <span class="badge" style="background: #f1f5f9; color: #475569; padding: 10px 20px; border-radius: 50px; font-weight: 700; font-size: 0.85rem;">
                                Academic Year: {{ date('Y') }}-{{ date('Y') + 1 }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- The Detailed Grid will be injected here via JS --}}
                <div id="detailed-timetable-wrapper">
                    <div class="empty-state text-center" style="padding: 100px 0; background: #ffffff; border-radius: 16px; border: 2px dashed #e2e8f0;">
                        <i class="fa fa-calendar-o" style="font-size: 4rem; color: #cbd5e1; margin-bottom: 20px;"></i>
                        <h4 style="color: #64748b; font-weight: 600;">No Class Selected</h4>
                        <p style="color: #94a3b8;">Please select a class from the dropdown above to view its timetable</p>
                    </div>
                </div>

                {{-- Legacy List View hidden by default --}}
                <div id="legacy-table-view" style="display: none;">
                    <div class="card">
                        <div class="card-body">
                            <table aria-describedby="mydesc" class='table' id='table_list' data-toggle="table"
                                data-url="{{ route('timetable.show', 1) }}" data-click-to-select="true"
                                data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-toolbar="#toolbar"
                                data-show-columns="true" data-show-refresh="true" data-fixed-columns="true"
                                data-fixed-number="2" data-fixed-right-number="1" data-trim-on-search="false"
                                data-mobile-responsive="true" data-sort-name="id" data-sort-order="desc"
                                data-maintain-selected="true" data-export-types='["txt","excel"]'
                                data-export-options='{ "fileName": "timetable-list-{{ date('d-m-Y') }}" }'
                                data-query-params="timetableQueryParams">
                                <thead>
                                    <tr>
                                        <th scope="col" data-field="id" data-sortable="true" data-visible="false">
                                            {{ __('id') }}</th>
                                        <th scope="col" data-field="no" data-sortable="false">{{ __('no.') }}</th>
                                        <th scope="col" data-field="class_section_name" data-sortable="true">
                                            {{ __('class') . ' ' . __('section') }}</th>
                                        <th scope="col" data-field="monday" data-sortable="false"
                                            data-formatter="timetableFormatter">{{ __('monday') }}</th>
                                        <th scope="col" data-field="tuesday" data-sortable="false"
                                            data-formatter="timetableFormatter">{{ __('tuesday') }}</th>
                                        <th scope="col" data-field="wednesday" data-sortable="false"
                                            data-formatter="timetableFormatter">{{ __('wednesday') }}</th>
                                        <th scope="col" data-field="thursday" data-sortable="false"
                                            data-formatter="timetableFormatter">{{ __('thursday') }}</th>
                                        <th scope="col" data-field="friday" data-sortable="false"
                                            data-formatter="timetableFormatter">{{ __('friday') }}</th>
                                        <th scope="col" data-field="saturday" data-sortable="false"
                                            data-formatter="timetableFormatter">{{ __('saturday') }}</th>
                                        <th scope="col" data-field="sunday" data-sortable="false"
                                            data-formatter="timetableFormatter">{{ __('sunday') }}</th>
                                        <th scope="col" data-field="operate" data-sortable="false"
                                            data-events="timetableEvents">
                                            {{ __('operate') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            // Initial hide
            $('#detailed-timetable-wrapper').addClass('d-none');

            // Handle class selection change
            $('#timetable_class_section_id').on('change', function () {
                let classSectionId = $(this).val();
                let $btnEdit = $('#btn-edit-main');
                
                if (classSectionId) {
                    // Update Edit button route dynamically
                    $btnEdit.attr('href', "{{ url('timetable') }}/" + classSectionId + "/edit");
                    $btnEdit.removeAttr('onclick');
                    
                    // Fetch details from show route - using a dummy id to call the index but with class_id filter
                    $.ajax({
                        url: "{{ route('timetable.show', [1]) }}",
                        type: "GET",
                        data: { class_section_id: classSectionId },
                        success: function(response) {
                            if (response && response.rows && response.rows.length > 0) {
                                renderDetailedTimetable(response.rows[0]);
                                $('#detailed-timetable-wrapper').removeClass('d-none');
                            } else {
                                // Show empty state for selected class
                                renderDetailedTimetable({ full_name: $('#timetable_class_section_id option:selected').text(), id: classSectionId });
                                $('#detailed-timetable-wrapper').removeClass('d-none');
                            }
                        },
                        error: function() {
                            showErrorToast("{{ __('Error fetching timetable data') }}");
                        }
                    });
                } else {
                    $('#detailed-timetable-wrapper').addClass('d-none');
                    $btnEdit.attr('href', '#');
                    $btnEdit.attr('onclick', "alert('Please select a Class Section first, then click the Edit button in its row below to edit the timetable.'); return false;");
                }
            });

            // Handle create redirection
            $('#btn-proceed-create').on('click', function () {
                let classSectionId = $('#create_timetable_class_section_id').val();
                if (classSectionId) {
                    window.location.href = "{{ url('timetable') }}/" + classSectionId + "/edit";
                } else {
                    showErrorToast("{{ __('Please select a class section') }}");
                }
            });

            // Action buttons
            $('#btn-print-main').on('click', function() { window.print(); });
        });

        function renderDetailedTimetable(data) {
            console.log("Rendering timetable for:", data.full_name);
            const days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const specPeriods = [
                { name: 'P1', time: '8:00-8:45' },
                { name: 'P2', time: '8:45-9:30' },
                { name: 'P3', time: '9:30-10:15' },
                { name: 'Break', time: '10:15-10:30', isBreak: true },
                { name: 'P4', time: '10:30-11:15' },
                { name: 'P5', time: '11:15-12:00' },
                { name: 'P6', time: '12:00-12:45' },
                { name: 'Break', time: '12:45-1:30', isBreak: true },
                { name: 'P7', time: '1:30-2:15' },
                { name: 'P8', time: '2:15-3:00' }
            ];

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

            let gridHtml = `
                <div class="timetable-card p-4 mt-4" style="background: #ffffff; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); overflow: hidden;">
                    <div class="table-responsive">
                        <table class="table table-bordered" style="width: 100%; border-collapse: separate; border-spacing: 0; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden;">
                            <thead style="background: #f8fafc;">
                                <tr>
                                    <th style="padding: 15px; color: #1e293b; font-weight: 800; border: 1px solid #e2e8f0; width: 120px; text-align: center; vertical-align: middle; background: #f1f5f9;">Day / Period</th>
            `;

            specPeriods.forEach(p => {
                gridHtml += `
                    <th class="text-center" style="padding: 10px; border: 1px solid #e2e8f0; min-width: 100px;">
                        <div style="font-weight: 800; color: #1e293b; font-size: 0.9rem;">${p.name}</div>
                        <div style="font-size: 0.7rem; color: #64748b; font-weight: 500; margin-top: 2px;">${p.time}</div>
                    </th>
                `;
            });

            gridHtml += `</tr></thead><tbody>`;

            days.forEach(day => {
                gridHtml += `<tr><td style="padding: 15px; font-weight: 700; color: #475569; background: #f8fafc; border: 1px solid #e2e8f0; text-align: center; vertical-align: middle;">${day}</td>`;
                specPeriods.forEach(p => {
                    if (p.isBreak) {
                        gridHtml += `
                            <td style="background: #f1f5f9; border: 1px solid #e2e8f0; vertical-align: middle;" class="text-center">
                                <span style="color: #94a3b8; font-weight: 700; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px;">BREAK</span>
                            </td>
                        `;
                    } else {
                        let dayTimetable = data.timetable || [];
                        let pTimeParts = p.time.split('-');
                        let pStart = pTimeParts[0];
                        let pStartH = parseInt(pStart.split(':')[0], 10);
                        let pStartM = pStart.split(':')[1];

                        let lecture = dayTimetable.find(l => {
                            if (!l.start_time || !l.day) return false;
                            
                            // Robust day matching
                            if (l.day.toLowerCase().trim() !== day.toLowerCase().trim()) return false;
                            
                            let lTimeParts = l.start_time.split(':');
                            if (lTimeParts.length < 2) return false;
                            
                            let lStartH = parseInt(lTimeParts[0], 10);
                            let lStartM = lTimeParts[1];
                            
                            // Check if start time matches the period's start time
                            return lStartH === pStartH && lStartM === pStartM;
                        });

                        if (lecture) {
                            console.log("Matched lecture:", lecture.subject_name, "at", p.name, "on", day);
                            let subjectName = lecture.subject_name || (lecture.subject ? lecture.subject.name : (lecture.note || (lecture.type === 'Break' ? 'Break' : '')));
                            let teacher = lecture.teacher || (lecture.subject_teacher ? lecture.subject_teacher.teacher : null);
                            let teacherName = lecture.teacher_name || (teacher ? (teacher.first_name + ' ' + (teacher.last_name || '')) : '');
                            
                            let style = palette[subjectName] || palette[Object.keys(palette).find(k => subjectName && subjectName.toLowerCase().includes(k.toLowerCase()))] || { bg: '#f1f5f9', text: '#475569' };
                            gridHtml += `
                                <td style="padding: 6px; border: 1px solid #e2e8f0; vertical-align: middle;">
                                    <div class="shadow-sm" style="background: ${style.bg}; color: ${style.text}; border-left: 4px solid ${style.text}; padding: 10px; border-radius: 10px; min-height: 60px; display: flex; flex-direction: column; justify-content: center;">
                                        <div style="font-weight: 800; font-size: 0.8rem; line-height: 1.1; margin-bottom: 2px; word-break: break-word;">${subjectName}</div>
                                        <div style="font-size: 0.65rem; opacity: 0.8; font-weight: 600;">${teacherName}</div>
                                    </div>
                                </td>
                            `;
                        } else {
                            gridHtml += `<td style="border: 1px solid #e2e8f0; background: #ffffff;"><div style="min-height: 60px;"></div></td>`;
                        }
                    }
                });
                gridHtml += `</tr>`;
            });

            gridHtml += `</tbody></table></div></div>`;
            
            // Legend
            gridHtml += `
                <div class="mt-4 p-4" style="background: #ffffff; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid #f1f5f9;">
                    <h6 style="font-weight: 800; color: #1e293b; margin-bottom: 15px; font-size: 0.9rem;">Subject Color Legend</h6>
                    <div class="d-flex flex-wrap" style="gap: 10px;">
            `;

            Object.keys(palette).forEach(subject => {
                let style = palette[subject];
                gridHtml += `
                    <div style="background: ${style.bg}; color: ${style.text}; padding: 6px 14px; border-radius: 50px; font-size: 0.7rem; font-weight: 700; display: flex; align-items: center; border: 1px solid rgba(0,0,0,0.05);">
                        <span style="width: 6px; height: 6px; border-radius: 50%; background: ${style.text}; display: inline-block; margin-right: 6px;"></span>
                        ${subject}
                    </div>
                `;
            });

            gridHtml += `
                    </div>
                </div>
            `;

            $('#detailed-timetable-wrapper').html(gridHtml).removeClass('d-none');
            
            // Re-bind print and export since grid just rendered
            $('#btn-print-main').off('click').on('click', function() {
                var printContents = document.getElementById('detailed-timetable-wrapper').innerHTML;
                var printWindow = window.open('', '_blank');
                printWindow.document.write('<html><head><title>Timetable Print</title>');
                printWindow.document.write('<style>');
                printWindow.document.write('@page { size: landscape; margin: 10mm; }');
                printWindow.document.write('body { font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; padding: 0; margin: 0; background: #fff; }');
                printWindow.document.write('table { width: 100%; border-collapse: collapse; table-layout: fixed; margin-bottom: 20px; }');
                printWindow.document.write('th, td { border: 1px solid #cbd5e1; padding: 8px; text-align: center; vertical-align: middle; font-size: 11px; word-wrap: break-word; overflow: hidden; }');
                printWindow.document.write('th { background-color: #f8fafc !important; color: #1e293b !important; font-weight: 800; text-transform: uppercase; }');
                printWindow.document.write('.timetable-card { box-shadow: none !important; margin: 0 !important; padding: 0 !important; border: none !important; }');
                printWindow.document.write('.table-responsive { overflow: visible !important; width: 100% !important; }');
                printWindow.document.write('.shadow-sm { box-shadow: none !important; border: 1px solid rgba(0,0,0,0.1) !important; margin: 1px; padding: 6px !important; border-radius: 6px !important; }');
                printWindow.document.write('* { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }');
                printWindow.document.write('h2 { color: #1e293b; font-weight: 800; }');
                printWindow.document.write('</style>');
                printWindow.document.write('</head><body>');
                printWindow.document.write('<div style="padding: 20px;">');
                printWindow.document.write('<h2 style="text-align: center; margin-bottom: 20px;">Class Timetable</h2>');
                printWindow.document.write(printContents);
                printWindow.document.write('</div>');
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.print();
            });
            
            $('#btn-export-main').off('click').on('click', function() {
                // simple CSV export of the grid
                var csv = [];
                var rows = document.querySelectorAll('#detailed-timetable-wrapper table tr');
                
                for (var i = 0; i < rows.length; i++) {
                    var row = [], cols = rows[i].querySelectorAll('td, th');
                    for (var j = 0; j < cols.length; j++) {
                        var cellText = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, " ").trim();
                        // escape quotes
                        cellText = cellText.replace(/"/g, '""');
                        row.push('"' + cellText + '"');
                    }
                    csv.push(row.join(','));
                }
                
                var csvFile = new Blob([csv.join('\n')], {type: 'text/csv'});
                var downloadLink = document.createElement("a");
                downloadLink.download = 'timetable-export.csv';
                downloadLink.href = window.URL.createObjectURL(csvFile);
                downloadLink.style.display = "none";
                document.body.appendChild(downloadLink);
                downloadLink.click();
            });
        }
    </script>
@endsection
```