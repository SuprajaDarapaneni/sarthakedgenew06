@extends('layouts.master')

@section('title')
    {{ __('Class Section & Teachers') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="page-title text-dark font-weight-bold mb-1">
                    {{ __('Class Sections') }}
                </h3>
                <p class="text-muted small mb-0">{{ __('Manage section names, capacity, and class teachers') }}</p>
            </div>
            @can('class-section-create')
            <button class="btn btn-primary d-flex align-items-center px-4 py-2"
                style="background-color: #2E447E; border: none; border-radius: 8px;" data-toggle="modal"
                data-target="#addSectionModal">
                <i class="fa fa-plus mr-2"></i> {{ __('Add Section') }}
            </button>
            @endcan
        </div>

        <!-- Stat Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm" style="border-radius: 12px; background: linear-gradient(135deg, #2E447E, #4B6CB7);">
                    <div class="card-body p-3">
                        <p class="text-white-50 small mb-1 uppercase font-weight-bold">{{ __('Total Sections') }}</p>
                        <h3 class="text-white mb-0">{{ $stats['total_sections'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm" style="border-radius: 12px; background-color: #fff;">
                    <div class="card-body p-3 border-left border-primary" style="border-width: 4px !important; border-radius: 12px;">
                        <p class="text-muted small mb-1 uppercase font-weight-bold">{{ __('Total Capacity') }}</p>
                        <h3 class="text-dark mb-0 font-weight-bold">{{ $stats['total_capacity'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm" style="border-radius: 12px; background-color: #fff;">
                    <div class="card-body p-3 border-left border-success" style="border-width: 4px !important; border-radius: 12px;">
                        <p class="text-muted small mb-1 uppercase font-weight-bold">{{ __('Current Strength') }}</p>
                        <h3 class="text-dark mb-0 font-weight-bold">{{ $stats['total_strength'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm" style="border-radius: 12px; background-color: #fff;">
                    <div class="card-body p-3 border-left border-info" style="border-width: 4px !important; border-radius: 12px;">
                        <p class="text-muted small mb-1 uppercase font-weight-bold">{{ __('Available Seats') }}</p>
                        <h3 class="text-dark mb-0 font-weight-bold text-info">{{ max(0, $stats['total_capacity'] - $stats['total_strength']) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Card -->
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body">
                <div id="toolbar" class="d-flex align-items-center mb-3">
                    <div class="search-container mr-3" style="position: relative; width: 300px;">
                        <i class="fa fa-search"
                            style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #adb5bd;"></i>
                        <input type="text" id="customSearch" class="form-control pl-5"
                            placeholder="{{ __('Search sections...') }}"
                            style="border-radius: 10px; background-color: #f8f9fa; border: 1px solid #e9ecef; height: 45px;">
                    </div>

                    <select name="class_id" id="filter_class_id" class="form-control mr-2"
                        style="width: 200px; border-radius: 10px; height: 45px;">
                        <option value="">{{ __('All Classes') }}</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->full_name }}</option>
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
                    
                    .capacity-badge {
                        background-color: #f8f9fa;
                        color: #495057;
                        padding: 2px 8px;
                        border-radius: 4px;
                        font-weight: 600;
                    }

                    .strength-badge {
                        background-color: #e3f2fd;
                        color: #0d47a1;
                        padding: 2px 8px;
                        border-radius: 4px;
                        font-weight: 600;
                    }

                    .available-badge {
                        padding: 2px 8px;
                        border-radius: 4px;
                        font-weight: 600;
                    }
                    .available-high { background-color: #e8f5e9; color: #2e7d32; }
                    .available-low { background-color: #fff3e0; color: #ef6c00; }
                    .available-full { background-color: #ffebee; color: #c62828; }
                </style>

                <table aria-describedby="mydesc" class='table table-borderless' id='table_list' data-toggle="table"
                       data-url="{{ route('class-section.show',[1]) }}" data-click-to-select="true" data-side-pagination="server"
                       data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="false"
                       data-show-columns="false" data-show-refresh="false" data-trim-on-search="false"
                       data-mobile-responsive="true" data-sort-name="id" data-toolbar="#toolbar" data-sort-order="desc"
                       data-query-params="classSectionQueryParams" data-escape="true">
                    <thead>
                    <tr>
                        <th scope="col" data-field="id" data-sortable="true" data-visible="false">{{ __('id') }}</th>
                        <th scope="col" data-field="no">{{ __('No.') }}</th>
                        <th scope="col" data-field="full_name" data-formatter="sectionNameFormatter">{{ __('Class Section') }}</th>
                        <th scope="col" data-field="class_teachers_list" data-formatter="classTeacherListFormatter">{{ __('Class Teacher') }}</th>
                        <th scope="col" data-field="capacity" data-align="center" data-formatter="capacityFormatter">{{ __('Capacity') }}</th>
                        <th scope="col" data-field="strength" data-align="center" data-formatter="strengthFormatter">{{ __('Strength') }}</th>
                        <th scope="col" data-field="available_seats" data-align="center" data-formatter="availableFormatter">{{ __('Available') }}</th>
                        <th scope="col" data-field="operate" data-escape="false" data-align="right">{{ __('Action') }}</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    @can('class-section-create')
    <!-- Add Section Modal -->
    <div class="modal fade" id="addSectionModal" tabindex="-1" role="dialog" aria-labelledby="addSectionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content border-0" style="border-radius: 15px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title font-weight-bold" id="addSectionModalLabel">{{ __('Add Section') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-2">
                    <form id="create-section-form" action="{{ route('class-section.store') }}" method="POST" class="create-form" data-success-function="formSuccessFunction">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="class_id" class="font-weight-600 mb-1 small text-dark">{{ __('Class') }} <span class="text-danger">*</span></label>
                            <select name="class_id" id="class_id" class="form-control" required style="border-radius: 8px; border: 1.5px solid #dee2e6; height: 45px;">
                                <option value="">{{ __('Select Class') }}</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->full_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="section_name" class="font-weight-600 mb-1 small text-dark">{{ __('Section Name') }} <span class="text-danger">*</span></label>
                            <input name="section_name" id="section_name" type="text" placeholder="e.g., A" class="form-control" required style="border-radius: 8px; border: 1.5px solid #dee2e6; height: 45px;"/>
                        </div>

                        <div class="form-group mb-3">
                            <label for="capacity" class="font-weight-600 mb-1 small text-dark">{{ __('Section Capacity') }} <span class="text-danger">*</span></label>
                            <input name="capacity" id="capacity" type="number" min="1" placeholder="e.g., 40" class="form-control" required style="border-radius: 8px; border: 1.5px solid #dee2e6; height: 45px;"/>
                        </div>

                        <div class="form-group mb-4">
                            <label for="teacher_id" class="font-weight-600 mb-1 small text-dark">{{ __('Class Teacher') }} <span class="text-danger">*</span></label>
                            <select name="teacher_id" id="teacher_id" class="form-control" required style="border-radius: 8px; border: 1.5px solid #dee2e6; height: 45px;">
                                <option value="">{{ __('Select Teacher') }}</option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->full_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button class="btn btn-primary btn-block py-3 font-weight-bold" type="submit" style="background-color: #2E447E; border: none; border-radius: 10px;">
                            {{ __('Create Section') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endcan

@endsection

@section('js')
    <script>
        function formSuccessFunction() {
            $('#addSectionModal').modal('hide');
            $('#table_list').bootstrapTable('refresh');
        }

        function sectionNameFormatter(value, row) {
            return '<span class="font-weight-bold">' + value + '</span>';
        }

        function classTeacherListFormatter(value, row) {
            if (value && Array.isArray(value) && value.length > 0) {
                return value.join(', ');
            } else if (value) {
                return value;
            }
            return '<span class="text-muted italic">Not Assigned</span>';
        }

        function capacityFormatter(value, row) {
            return '<span class="capacity-badge">' + (value || 0) + '</span>';
        }

        function strengthFormatter(value, row) {
            return '<span class="strength-badge">' + (value || 0) + '</span>';
        }

        function availableFormatter(value, row) {
            let badgeClass = 'available-high';
            if (value === 0) badgeClass = 'available-full';
            else if (value < 5) badgeClass = 'available-low';
            
            return '<span class="available-badge ' + badgeClass + '">' + value + '</span>';
        }

        function classSectionQueryParams(p) {
            return {
                limit: p.limit,
                sort: p.sort,
                order: p.order,
                offset: p.offset,
                search: $('#customSearch').val(),
                class_id: $('#filter_class_id').val(),
                show_deleted: $('.table-list-type.active').data('id')
            };
        }

        $(document).ready(function() {
            $('#customSearch').on('keyup', function() {
                $('#table_list').bootstrapTable('refresh');
            });

            $('#filter_class_id').on('change', function() {
                $('#table_list').bootstrapTable('refresh');
            });
            
            $('.table-list-type').on('click', function(e) {
                e.preventDefault();
                $('.table-list-type').removeClass('active font-weight-bold text-dark').addClass('text-muted');
                $(this).addClass('active font-weight-bold text-dark').removeClass('text-muted');
                $('#table_list').bootstrapTable('refresh');
            });
        });

        function SubjectTeachersDetailFormatter(index, row) {
            var html = [];
            html.push('<div class="p-3">');
            html.push('<h6><b>Subject Teachers</b></h6>');
            if (row.subject_teachers && row.subject_teachers.length > 0) {
                html.push('<table class="table table-sm"><thead><tr><th>Subject</th><th>Teacher</th></tr></thead><tbody>');
                $.each(row.subject_teachers, function(i, teacher) {
                    html.push('<tr><td>' + teacher.subject.name + '</td><td>' + teacher.teacher.full_name + '</td></tr>');
                });
                html.push('</tbody></table>');
            } else {
                html.push('<p class="text-muted">No subject teachers assigned yet.</p>');
            }
            html.push('</div>');
            return html.join('');
        }
        
        function subjectTeachersDetailFilter(index, row) {
            return true;
        }
    </script>
@endsection
