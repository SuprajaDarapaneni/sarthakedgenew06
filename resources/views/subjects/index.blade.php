@extends('layouts.master')

@section('title')
    {{ __('subject') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <style>
            :root {
                --primary-color: #2E447E;
                --secondary-color: #6c757d;
                --success-color: #4CAF50;
                --bg-light: #f8f9fa;
                --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
                --transition: all 0.3s ease;
            }

            .page-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 2rem;
            }

            .page-title-box h3 {
                font-weight: 700;
                color: #1a1a1a;
                margin-bottom: 0.2rem;
                font-size: 1.75rem;
            }

            .page-title-box p {
                color: #666;
                font-size: 0.95rem;
            }

            .btn-add-subject {
                background-color: var(--primary-color);
                color: white;
                border: none;
                padding: 0.75rem 1.75rem;
                border-radius: 8px;
                font-weight: 600;
                display: flex;
                align-items: center;
                gap: 8px;
                transition: var(--transition);
                box-shadow: 0 4px 12px rgba(46, 68, 126, 0.2);
            }

            .btn-add-subject:hover {
                background-color: #243561;
                transform: translateY(-2px);
                color: white;
            }

            /* Stat Cards */
            .stats-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
                gap: 1.5rem;
                margin-bottom: 2rem;
            }

            .stat-card {
                background: white;
                padding: 1.5rem;
                border-radius: 12px;
                box-shadow: var(--card-shadow);
                display: flex;
                align-items: center;
                gap: 1.25rem;
                border: 1px solid rgba(0, 0, 0, 0.03);
                transition: var(--transition);
            }

            .stat-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            }

            .stat-icon {
                width: 50px;
                height: 50px;
                border-radius: 10px;
                background: rgba(46, 68, 126, 0.1);
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--primary-color);
                font-size: 1.25rem;
            }

            .stat-info .stat-label {
                display: block;
                color: #666;
                font-size: 0.85rem;
                margin-bottom: 4px;
            }

            .stat-info .stat-value {
                display: block;
                font-size: 1.5rem;
                font-weight: 700;
                color: #1a1a1a;
            }

            /* Search & Filter Bar */
            .search-filter-card {
                background: white;
                padding: 1rem;
                border-radius: 12px;
                margin-bottom: 1.5rem;
                box-shadow: var(--card-shadow);
            }

            .search-container {
                position: relative;
                flex: 1;
            }

            .search-container i {
                position: absolute;
                left: 12px;
                top: 50%;
                transform: translateY(-50%);
                color: #999;
            }

            .search-container input {
                padding-left: 40px;
                border-radius: 8px;
                border: 1px solid #e0e0e0;
                background-color: #fcfcfc;
                transition: var(--transition);
                height: 48px;
            }

            .search-container input:focus {
                border-color: var(--primary-color);
                background-color: #fff;
                box-shadow: 0 0 0 4px rgba(46, 68, 126, 0.1);
            }

            .filter-dropdown {
                min-width: 200px;
                height: 48px !important;
                border-radius: 8px !important;
                border: 1px solid #e0e0e0 !important;
                background-color: #fcfcfc !important;
            }

            /* Table Styles */
            .table-card {
                background: white;
                border-radius: 12px;
                box-shadow: var(--card-shadow);
                overflow: hidden;
            }

            .table thead th {
                background: #f8faff;
                color: #888;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                font-size: 0.75rem;
                border-bottom: 2px solid #edf2f9;
                padding: 1.25rem 1rem;
            }

            .table tbody td {
                padding: 1.25rem 1rem;
                vertical-align: middle;
                color: #444;
                font-size: 0.95rem;
            }

            .subject-name-cell {
                font-weight: 700;
                color: #2c3e50;
            }

            .code-badge {
                background: #f0f2f5;
                color: #5d6d7e;
                padding: 4px 10px;
                border-radius: 6px;
                font-weight: 600;
                font-size: 0.8rem;
                letter-spacing: 0.5px;
            }

            .type-badge {
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 0.8rem;
                font-weight: 600;
                text-transform: lowercase;
            }

            .type-core {
                background: var(--primary-color);
                color: white;
            }

            .type-elective {
                background: #6c5ce7;
                color: white;
            }

            .type-optional {
                background: #00cec9;
                color: white;
            }

            .type-theory {
                background: #636e72;
                color: white;
            }

            .type-practical {
                background: #ff7675;
                color: white;
            }

            .status-badge {
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 0.8rem;
                font-weight: 600;
                display: inline-flex;
                align-items: center;
                gap: 5px;
            }

            .status-active {
                background: rgba(46, 68, 126, 0.1);
                color: var(--primary-color);
            }

            .status-inactive {
                background: #ffebeb;
                color: #ff4757;
            }

            .action-btn {
                width: 32px;
                height: 32px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 6px;
                transition: var(--transition);
                margin: 0 4px;
            }

            .edit-btn {
                color: #5d6d7e;
                background: #f0f2f5;
            }

            .delete-btn {
                color: #ff4757;
                background: #ffebeb;
            }

            .edit-btn:hover {
                background: #e2e6ea;
            }

            .delete-btn:hover {
                background: #ffd1d1;
            }

            /* Modal Style */
            .modal-content {
                border: none;
                border-radius: 16px;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            }

            .modal-header {
                border-bottom: 1px solid #f0f2f5;
                padding: 1.5rem;
            }

            .modal-title {
                font-weight: 700;
                color: #1a1a1a;
            }

            .modal-body {
                padding: 2rem;
            }

            .form-group label {
                font-weight: 600;
                color: #444;
                margin-bottom: 8px;
            }

            .form-control {
                border-radius: 8px;
                padding: 0.75rem 1rem;
                border: 1px solid #e0e0e0;
                height: auto;
            }

            .btn-submit {
                background: var(--primary-color);
                color: white;
                border: none;
                padding: 1rem;
                font-weight: 700;
                border-radius: 8px;
                width: 100%;
                margin-top: 1rem;
            }
        </style>

        <div class="page-header">
            <div class="page-title-box">
                <h3>Subjects</h3>
                <p>Manage subjects, codes, types and class mappings</p>
            </div>
            <button class="btn btn-add-subject" data-toggle="modal" data-target="#createModal">
                <i class="fa fa-plus"></i> Add Subject
            </button>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon"><i class="fa fa-book"></i></div>
                <div class="stat-info">
                    <span class="stat-label">Total Subjects</span>
                    <span class="stat-value">{{ $stats['total'] }}</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(46, 68, 126, 0.1); color: var(--primary-color);">
                    <i class="fa fa-layer-group"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-label">Core Subjects</span>
                    <span class="stat-value">{{ $stats['core'] }}</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(108, 92, 231, 0.1); color: #6c5ce7;">
                    <i class="fa fa-list-check"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-label">Elective</span>
                    <span class="stat-value">{{ $stats['elective'] }}</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(0, 206, 201, 0.1); color: #00cec9;">
                    <i class="fa fa-star"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-label">Optional</span>
                    <span class="stat-value">{{ $stats['optional'] }}</span>
                </div>
            </div>
        </div>

        <div class="search-filter-card">
            <div class="row align-items-center">
                <div class="col-md-9">
                    <div class="search-container">
                        <i class="fa fa-search"></i>
                        <input type="text" id="customSearch" class="form-control" placeholder="Search subjects...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select id="typeFilter" class="form-control filter-dropdown">
                        <option value="">All Types</option>
                        <option value="Core">Core</option>
                        <option value="Elective">Elective</option>
                        <option value="Optional">Optional</option>
                        <option value="Theory">Theory</option>
                        <option value="Practical">Practical</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="table-card">
            <table aria-describedby="mydesc" class='table' id='table_list' data-toggle="table"
                data-url="{{ route('subjects.show', [1]) }}" data-click-to-select="true" data-side-pagination="server"
                data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true"
                data-show-columns="false" data-show-refresh="false" data-fixed-columns="false" data-trim-on-search="false"
                data-mobile-responsive="true" data-sort-name="id" data-sort-order="desc"
                data-query-params="SubjectQueryParams" data-toolbar="" data-escape="false">
                <thead>
                    <tr>
                        <th data-field="id" data-visible="false">ID</th>
                        <th data-field="image" data-formatter="subjectImageFormatter">IMAGE</th>
                        <th data-field="name" data-formatter="subjectNameFormatter">SUBJECT</th>
                        <th data-field="code" data-formatter="subjectCodeFormatter">CODE</th>
                        <th data-field="type" data-formatter="subjectTypeFormatter">TYPE</th>
                        <th data-field="classes">CLASSES</th>
                        <th data-field="teacher_name">TEACHER</th>
                        <th data-field="periods_per_week">PERIODS/WEEK</th>
                        <th data-field="status_val" data-formatter="subjectStatusFormatter">STATUS</th>
                        <th data-field="operate" data-events="subjectEvents">ACTIONS</th>
                    </tr>
                </thead>
            </table>
        </div>

        <!-- Create Modal -->
        <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Subject</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <form class="create-form" id="create-form" action="{{ route('subjects.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Subject Name *</label>
                                <input name="name" type="text" placeholder="e.g., Biology" class="form-control" required />
                            </div>

                            <div class="form-group">
                                <label>Subject Code *</label>
                                <input name="code" type="text" placeholder="e.g., BIO" class="form-control" required />
                            </div>

                            <div class="form-group">
                                <label>Type *</label>
                                <select name="type" class="form-control" required>
                                    <option value="Core">Core</option>
                                    <option value="Elective">Elective</option>
                                    <option value="Optional">Optional</option>
                                    <option value="Theory">Theory</option>
                                    <option value="Practical">Practical</option>
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label>{{ __('medium') }} *</label>
                                <div class="d-flex flex-wrap gap-3">
                                    @foreach ($mediums as $medium)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="medium_id"
                                                id="m_{{ $medium->id }}" value="{{ $medium->id }}">
                                            <label class="form-check-label"
                                                for="m_{{ $medium->id }}">{{ $medium->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Classes * (Multi-select)</label>
                                        <select name="class_id[]" class="form-control select2 class-selector" multiple
                                            required>
                                            @foreach($classes as $class)
                                                <option value="{{ $class->id }}" data-medium-id="{{ $class->medium_id }}"
                                                    data-shift-id="{{ $class->shift_id }}"
                                                    data-stream-id="{{ $class->stream_id }}">{{ $class->full_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @if($semesters->count())
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Semester (Optional)</label>
                                            <select name="semester_id" class="form-control">
                                                <option value="">Select Semester</option>
                                                @foreach($semesters as $semester)
                                                    <option value="{{ $semester->id }}">{{ $semester->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            @if($shifts->count() || $streams->count())
                                <div class="row">
                                    @if($shifts->count())
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Shift (Optional)</label>
                                                <select name="shift_id" id="create_shift_id" class="form-control filter-class">
                                                    <option value="">Select Shift</option>
                                                    @foreach($shifts as $shift)
                                                        <option value="{{ $shift->id }}">{{ $shift->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                    @if($streams->count())
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Stream (Optional)</label>
                                                <select name="stream_id" id="create_stream_id" class="form-control filter-class">
                                                    <option value="">Select Stream</option>
                                                    @foreach($streams as $stream)
                                                        <option value="{{ $stream->id }}">{{ $stream->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Teacher</label>
                                        <select name="teacher_id" class="form-control select2">
                                            <option value="">Teacher name</option>
                                            @foreach($teachers as $teacher)
                                                <option value="{{ $teacher->id }}">{{ $teacher->full_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Periods Per Week</label>
                                        <input name="periods_per_week" type="number" placeholder="5" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Subject Image (Optional)</label>
                                        <input name="image" type="file" class="form-control" accept="image/*" />
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-submit">Add Subject</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Subject</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <form class="edit-form" id="edit-form" action="{{ url('subjects') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <input type="hidden" name="edit_id" id="edit_id">

                            <div class="form-group">
                                <label>Subject Name *</label>
                                <input name="name" id="edit_name" type="text" class="form-control" required />
                            </div>

                            <div class="form-group">
                                <label>Subject Code *</label>
                                <input name="code" id="edit_code" type="text" class="form-control" required />
                            </div>

                            <div class="form-group">
                                <label>Type *</label>
                                <select name="type" id="edit_type_select" class="form-control" required>
                                    <option value="Core">Core</option>
                                    <option value="Elective">Elective</option>
                                    <option value="Optional">Optional</option>
                                    <option value="Theory">Theory</option>
                                    <option value="Practical">Practical</option>
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label>{{ __('medium') }} *</label>
                                <div class="d-flex flex-wrap gap-3">
                                    @foreach ($mediums as $medium)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input edit-medium" type="radio" name="medium_id"
                                                id="em_{{ $medium->id }}" value="{{ $medium->id }}">
                                            <label class="form-check-label"
                                                for="em_{{ $medium->id }}">{{ $medium->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Classes * (Multi-select)</label>
                                        <select name="class_id[]" id="edit_class_id"
                                            class="form-control select2-edit class-selector" multiple required>
                                            @foreach($classes as $class)
                                                <option value="{{ $class->id }}" data-medium-id="{{ $class->medium_id }}"
                                                    data-shift-id="{{ $class->shift_id }}"
                                                    data-stream-id="{{ $class->stream_id }}">{{ $class->full_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @if($semesters->count())
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Semester (Optional)</label>
                                            <select name="semester_id" id="edit_semester_id" class="form-control">
                                                <option value="">Select Semester</option>
                                                @foreach($semesters as $semester)
                                                    <option value="{{ $semester->id }}">{{ $semester->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            @if($shifts->count() || $streams->count())
                                <div class="row">
                                    @if($shifts->count())
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Shift (Optional)</label>
                                                <select name="shift_id" id="edit_shift_id" class="form-control">
                                                    <option value="">Select Shift</option>
                                                    @foreach($shifts as $shift)
                                                        <option value="{{ $shift->id }}">{{ $shift->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                    @if($streams->count())
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Stream (Optional)</label>
                                                <select name="stream_id" id="edit_stream_id" class="form-control">
                                                    <option value="">Select Stream</option>
                                                    @foreach($streams as $stream)
                                                        <option value="{{ $stream->id }}">{{ $stream->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Teacher</label>
                                        <select name="teacher_id" id="edit_teacher_id" class="form-control select2-edit">
                                            <option value="">Teacher name</option>
                                            @foreach($teachers as $teacher)
                                                <option value="{{ $teacher->id }}">{{ $teacher->full_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Periods Per Week</label>
                                        <input name="periods_per_week" id="edit_periods_per_week" type="number"
                                            class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-0 mt-3">
                                        <label>Subject Image (Optional)</label>
                                        <input name="image" type="file" class="form-control" accept="image/*" />
                                        <small class="text-muted">Leave empty to keep current image</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary px-4">Update Subject</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function SubjectQueryParams(p) {
            return {
                limit: p.limit,
                sort: p.sort,
                order: p.order,
                offset: p.offset,
                search: $('#customSearch').val(),
                medium_id: $('#filter_subject_id').val(),
                type: $('#typeFilter').val()
            };
        }

        // Custom Search & Filter
        $('#customSearch').on('input', function () {
            $('#table_list').bootstrapTable('refresh');
        });

        $('#typeFilter').on('change', function () {
            $('#table_list').bootstrapTable('refresh');
        });

        // Formatters
        function subjectImageFormatter(value, row) {
            return value ? `<img src="${value}" style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover;" onerror="this.src='/assets/images/placeholder.png'">` : '-';
        }

        function subjectNameFormatter(value, row) {
            return `<span class="subject-name-cell">${value}</span>`;
        }

        function subjectCodeFormatter(value, row) {
            return value ? `<span class="code-badge">${value}</span>` : '-';
        }

        function subjectTypeFormatter(value, row) {
            let className = 'type-' + value.toLowerCase();
            return `<span class="type-badge ${className}">${value}</span>`;
        }

        function subjectStatusFormatter(value, row) {
            let statusClass = value == 1 ? 'status-active' : 'status-inactive';
            let statusText = value == 1 ? 'active' : 'inactive';
            return `<span class="status-badge ${statusClass}">${statusText}</span>`;
        }

        // Action Events Override
        window.subjectEvents = {
            'click .edit-data': function (e, value, row) {
                $('#editModal').modal('show');
                $('#edit_id').val(row.id);
                $('#edit_name').val(row.name);
                $('#edit_code').val(row.code);
                $('#edit_type_select').val(row.eng_type);
                $(`input[name=medium_id][value=${row.medium_id}].edit-medium`).prop('checked', true);
                $('#edit_teacher_id').val(row.teacher_id).trigger('change');
                $('#edit_periods_per_week').val(row.periods_per_week);
                $('#edit_class_id').val(row.class_ids).trigger('change');
                $('#edit_semester_id').val(row.semester_id);
            }
        };

        $(document).ready(function () {
            $('.select2').select2({
                width: '100%',
                dropdownParent: $('#createModal')
            });

            $('.select2-edit').select2({
                width: '100%',
                dropdownParent: $('#editModal')
            });

            function filterClasses(modalId) {
                let mediumId = $(modalId + ' input[name="medium_id"]:checked').val();
                let shiftId = $(modalId + ' select[name="shift_id"]').val();
                let streamId = $(modalId + ' select[name="stream_id"]').val();

                $(modalId + ' .class-selector option').each(function () {
                    let optMedium = $(this).data('medium-id');
                    let optShift = $(this).data('shift-id');
                    let optStream = $(this).data('stream-id');

                    let show = true;
                    if (mediumId && optMedium != mediumId) show = false;
                    if (shiftId && optShift != shiftId) show = false;
                    if (streamId && optStream != streamId) show = false;

                    if (show) {
                        $(this).prop('disabled', false);
                    } else {
                        $(this).prop('disabled', true);
                    }
                });
                $(modalId + ' .class-selector').select2({
                    width: '100%',
                    dropdownParent: $(modalId)
                });
            }

            // Create Modal Filters
            $('#createModal input[name="medium_id"], #create_shift_id, #create_stream_id').on('change', function () {
                filterClasses('#createModal');
            });

            // Edit Modal Filters
            $('#editModal input[name="medium_id"], #edit_shift_id, #edit_stream_id').on('change', function () {
                filterClasses('#editModal');
            });
        });
    </script>
@endsection