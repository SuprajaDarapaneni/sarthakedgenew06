@extends('layouts.master')

@section('title')
    {{ __('Class') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="page-title text-dark font-weight-bold mb-1">
                    {{ __('Classes') }}
                </h3>
                <p class="text-muted small mb-0">{{ __('Manage classes, sections and class teachers') }}</p>
            </div>
            <button class="btn btn-primary d-flex align-items-center px-4 py-2"
                style="background-color: #2E447E; border: none; border-radius: 8px;" data-toggle="modal"
                data-target="#addClassModal">
                <i class="fa fa-plus mr-2"></i> {{ __('Add Class') }}
            </button>
        </div>

        <!-- Stat Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon-box mr-3 d-flex align-items-center justify-content-center"
                            style="width: 48px; height: 48px; background-color: #f8f9fa; border: 1px solid #eee; border-radius: 8px;">
                            <i class="fa fa-book-open text-primary" style="color: #2E447E !important;"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-0">{{ __('Total Classes') }}</p>
                            <h4 class="font-weight-bold mb-0">{{ $total_classes }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon-box mr-3 d-flex align-items-center justify-content-center"
                            style="width: 48px; height: 48px; background-color: #f0fff4; border: 1px solid #c6f6d5; border-radius: 8px;">
                            <i class="fa fa-users text-success"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-0">{{ __('Total Students') }}</p>
                            <h4 class="font-weight-bold mb-0">{{ $total_students }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon-box mr-3 d-flex align-items-center justify-content-center"
                            style="width: 48px; height: 48px; background-color: #f0f7ff; border: 1px solid #bee3f8; border-radius: 8px;">
                            <i class="fa fa-check-circle text-info"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-0">{{ __('Active Classes') }}</p>
                            <h4 class="font-weight-bold mb-0" style="color: #28a745;">{{ $active_classes }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon-box mr-3 d-flex align-items-center justify-content-center"
                            style="width: 48px; height: 48px; background-color: #fffaf0; border: 1px solid #feebc8; border-radius: 8px;">
                            <i class="fa fa-layer-group text-warning"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-0">{{ __('Total Sections') }}</p>
                            <h4 class="font-weight-bold mb-0">{{ $total_sections_count }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Card -->
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body">
                <div id="toolbar" class="d-flex align-items-center">
                    <div class="search-container mr-3" style="position: relative; width: 300px;">
                        <i class="fa fa-search"
                            style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #adb5bd;"></i>
                        <input type="text" id="customSearch" class="form-control pl-5"
                            placeholder="{{ __('Search classes or teachers...') }}"
                            style="border-radius: 10px; background-color: #f8f9fa; border: 1px solid #e9ecef; height: 45px;">
                    </div>

                    <select name="medium_id" id="filter_medium_id" class="form-control mr-2"
                        style="width: 150px; border-radius: 10px; height: 45px;">
                        <option value="">{{ __('All Mediums') }}</option>
                        @foreach ($mediums as $medium)
                            <option value="{{ $medium->id }}">{{ $medium->name }}</option>
                        @endforeach
                    </select>

                    <div class="ml-auto">
                        <a href="#" class="table-list-type active mr-2 font-weight-bold" data-id="0">{{__('All')}}</a> |
                        <a href="#" class="ml-2 table-list-type text-muted" data-id="1">{{__("Trashed")}}</a>
                    </div>
                </div>

                <style>
                    .bootstrap-table .fixed-table-container .table thead th {
                        border-bottom: none;
                        background-color: #fff;
                        color: #adb5bd;
                        text-transform: uppercase;
                        font-size: 11px;
                        font-weight: 600;
                        letter-spacing: 0.5px;
                        padding: 15px 10px;
                    }

                    .bootstrap-table .fixed-table-container .table tbody td {
                        padding: 15px 10px;
                        vertical-align: middle;
                        font-size: 13px;
                        color: #495057;
                        border-top: 1px solid #f8f9fa;
                    }

                    .status-badge {
                        padding: 4px 12px;
                        border-radius: 20px;
                        font-size: 11px;
                        font-weight: 600;
                        text-transform: lowercase;
                    }

                    .status-active {
                        background-color: #2E447E;
                        color: #fff;
                    }

                    .action-btn {
                        width: 32px;
                        height: 32px;
                        display: inline-flex;
                        align-items: center;
                        justify-content: center;
                        border-radius: 6px;
                        margin-right: 5px;
                        transition: all 0.2s;
                    }

                    .action-edit {
                        color: #495057;
                        background-color: transparent;
                    }

                    .action-edit:hover {
                        background-color: #f8f9fa;
                    }

                    .action-delete {
                        color: #dc3545;
                        background-color: transparent;
                    }

                    .action-delete:hover {
                        background-color: #fff5f5;
                    }
                </style>

                <table aria-describedby="mydesc" class='table table-borderless' id='table_list' data-toggle="table"
                    data-url="{{ route('class.show', [1]) }}" data-click-to-select="true" data-side-pagination="server"
                    data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="false"
                    data-show-columns="false" data-show-refresh="false" data-trim-on-search="false"
                    data-mobile-responsive="true" data-sort-name="id" data-toolbar="#toolbar" data-sort-order="desc"
                    data-query-params="classQueryParams" data-escape="true">
                    <thead>
                        <tr>
                            <th scope="col" data-field="id" data-sortable="false" data-visible="false">{{ __('id') }}</th>
                            <th scope="col" data-field="full_name" data-sortable="false"
                                data-formatter="classNameFormatter">{{ __('Class') }}</th>
                            <th scope="col" data-field="section_names" data-sortable="false">{{ __('Sections') }}</th>
                            <th scope="col" data-field="next_class_name" data-sortable="false">{{ __('Next Class') }}</th>
                            <th scope="col" data-field="class_teacher" data-sortable="false">{{ __('Class Teacher') }}</th>
                            <th scope="col" data-field="student_count" data-sortable="false" data-align="center">
                                {{ __('Students') }}
                            </th>
                            <th scope="col" data-field="subject_count" data-sortable="false" data-align="center">
                                {{ __('Subjects') }}
                            </th>
                            <th scope="col" data-field="status" data-formatter="statusFormatter" data-align="center">
                                {{ __('Status') }}
                            </th>
                            <th scope="col" data-field="operate" data-escape="false" data-align="right"
                                data-formatter="actionsFormatter">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Class Modal -->
    <div class="modal fade" id="addClassModal" tabindex="-1" role="dialog" aria-labelledby="addClassModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content border-0" style="border-radius: 15px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title font-weight-bold" id="addClassModalLabel">{{ __('Add New Class') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-2">
                    <form class="class-create-form" id="create-form" action="{{ route('class.store') }}" method="POST"
                        data-pre-submit-function="classValidation" data-success-function="successFunction"
                        novalidate="novalidate">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="font-weight-600 mb-1 small text-dark">{{ __('Medium') }} <span
                                    class="text-danger">*</span></label>
                            <div class="d-flex flex-wrap">
                                @forelse ($mediums as $medium)
                                    <div class="form-check form-check-inline mr-3 mb-2">
                                        <label class="form-check-label small">
                                            <input type="radio" class="form-check-input" name="medium_id"
                                                id="medium_{{ $medium->id }}" value="{{ $medium->id }}" required="required">
                                            {{ $medium->name }}
                                            <i class="input-helper"></i>
                                        </label>
                                    </div>
                                @empty
                                    <p class="text-danger small">{{ __('No mediums found. Please create one first.') }}</p>
                                @endforelse
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="name" class="font-weight-600 mb-1 small text-dark">{{ __('Class Name') }} <span
                                    class="text-danger">*</span></label>
                            <input name="name" id="name" type="text" placeholder="e.g., Class 11" class="form-control"
                                required="required"
                                style="border-radius: 8px; background-color: #fff; border: 1.5px solid #dee2e6; height: 45px;" />
                        </div>

                        <div class="form-group mb-3">
                            <label for="shift_id" class="font-weight-600 mb-1 small text-dark">{{ __('Shift') }} <span
                                    class="text-info">({{__("Optional")}})</span></label>
                            <select name="shift_id" id="shift_id" class="form-control"
                                style="border-radius: 8px; border: 1.5px solid #dee2e6; height: 45px;">
                                <option value="">--- {{__('Select Shift')}} ---</option>
                                @foreach($shifts as $shift)
                                    <option value="{{$shift->id}}">{{$shift->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="teacher_id" class="font-weight-600 mb-1 small text-dark">{{ __('Class Teacher') }}
                                <span class="text-danger">*</span></label>
                            <select name="teacher_id" id="teacher_id" class="form-control"
                                style="border-radius: 8px; border: 1.5px solid #dee2e6; height: 45px;">
                                <option value="">{{ __('Select teacher') }}</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->full_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="next_class_id"
                                class="font-weight-600 mb-1 small text-dark">{{ __('Next Class Mapping') }}
                                <span class="text-info">({{__("Optional")}})</span></label>
                            <select name="next_class_id" id="next_class_id" class="form-control"
                                style="border-radius: 8px; border: 1.5px solid #dee2e6; height: 45px;">
                                <option value="">{{ __('Select Next Class') }}</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->full_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-4" id="default-section-div">
                            <label class="font-weight-600 mb-1 small text-dark">{{ __('Sections') }} <span
                                    class="text-info">({{__("Optional")}})</span></label>
                            <div class="d-flex flex-wrap">
                                @forelse ($sections as $section)
                                    <div class="form-check mr-3 mb-2">
                                        <label class="form-check-label small">
                                            <input type="checkbox" class="form-check-input" name="section_id[0][]"
                                                value="{{ $section->id }}">
                                            {{ $section->name }}
                                            <i class="input-helper"></i>
                                        </label>
                                    </div>
                                @empty
                                    <p class="text-danger small">{{ __('No sections found. Please create one first.') }}</p>
                                @endforelse
                            </div>
                        </div>

                        <button class="btn btn-primary btn-block py-3 font-weight-bold" id="create-btn" type="submit"
                            style="background-color: #2E447E; border: none; border-radius: 10px;">
                            {{ __('Add Class') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        function successFunction() {
            $('#addClassModal').modal('hide');
            $('#table_list').bootstrapTable('refresh');
        }

        function classNameFormatter(value, row) {
            return '<span class="font-weight-bold">' + value + '</span>';
        }

        function statusFormatter(value, row) {
            return '<span class="status-badge status-active">active</span>';
        }

        function actionsFormatter(value, row) {
            return `
                                <div class="d-flex justify-content-end">
                                    <a href="${row.operate_edit_url || '#'}" class="action-btn action-edit" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="${row.operate_delete_url || '#'}" class="action-btn action-edit delete-form" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            `;
        }

        $(document).ready(function () {
            $('#customSearch').on('keyup', function () {
                $('#table_list').bootstrapTable('refresh', {
                    query: {
                        search: $(this).val()
                    }
                });
            });

            $('#filter_medium_id').on('change', function () {
                $('#table_list').bootstrapTable('refresh');
            });
        });

        // Override the operate formatter if it's already defined elsewhere or just use our own
        window.actionEvents = {};
    </script>
@endsection