@extends('layouts.master')

@section('title')
    {{ __('Transfer & Promote Students') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ __('Transfer & Promote Students')}}
            </h3>
        </div>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title">{{ __('Transfer & Promote Students') }}</h4>
                            <div class="d-flex">
                                @can('transfer-student-create')
                                    <button type="button" class="btn btn-theme mr-2" data-toggle="modal"
                                        data-target="#transferModal">
                                        <i class="fa fa-exchange mr-1"></i> {{ __('Transfer Student') }}
                                    </button>
                                @endcan
                                @can('promote-student-create')
                                    <button type="button" class="btn btn-theme" data-toggle="modal" data-target="#promoteModal">
                                        <i class="fa fa-level-up mr-1"></i> {{ __('Promote Student') }}
                                    </button>
                                @endcan
                            </div>
                        </div>
                        <p class="text-muted">
                            {{ __('Use the buttons above to transfer students between sections or promote them to the next session year.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @can('transfer-student-create')
        {{-- Transfer Student Modal --}}
        <div class="modal fade" id="transferModal" tabindex="-1" role="dialog" aria-labelledby="transferModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="transferModalLabel">{{ __('Transfer Student In Next Section') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('transfer-student.store') }}" data-success-function="transferSuccessFunction"
                        class="create-form pt-3" id="transfer-form">
                        @csrf
                        <div class="modal-body">
                            <div class="row" id="toolbar1">
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>{{ __('Current Class Section') }} <span class="text-danger">*</span></label>
                                    <select required name="current_class_section_id" id="transfer_class_section"
                                        class="form-control select2" style="width:100%;" tabindex="-1" aria-hidden="true">
                                        <option value="">{{ __('Select Class') }}</option>
                                        @foreach ($classSections as $classSection)
                                            <option value="{{ $classSection->id }}" data-class="{{ $classSection->class_id }}"
                                                data-section="{{ $classSection->section_id }}">
                                                {{ $classSection->full_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>{{ __('Transfer Class Section') }} <span class="text-danger">*</span></label>
                                    <select required name="new_class_section_id" id="new_transfer_class_section"
                                        class="form-control select2" style="width:100%;" tabindex="-1" aria-hidden="true">
                                        <option value="">{{ __('Select Class') }}</option>
                                        <option value="data-not-found">-- {{ __('no_data_found') }} --</option>
                                        @foreach ($classSections as $classSection)
                                            <option value="{{ $classSection->id }}" data-class="{{ $classSection->class_id }}"
                                                data-section="{{ $classSection->section_id }}">
                                                {{ $classSection->full_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <table aria-describedby="mydesc" class='table1 transfer_student_table'
                                        id='transfer-student-table-list' data-toggle="table"
                                        data-url="{{ route('transfer-student.show', [1]) }}" data-side-pagination="server"
                                        data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true"
                                        data-toolbar="#toolbar1" data-show-columns="true" data-show-refresh="true"
                                        data-fixed-columns="false" data-fixed-number="2" data-fixed-right-number="1"
                                        data-trim-on-search="false" data-mobile-responsive="true" data-sort-name="id"
                                        data-sort-order="desc" data-response-handler="responseHandler"
                                        data-maintain-selected="true" data-export-data-type='all' data-click-to-select="true"
                                        data-export-options='{ "fileName": "transfer-student-list-<?= date('d-m-y') ?>" ,"ignoreColumn": ["operate"]}'
                                        data-query-params="transferStudentQueryParams" data-escape="true">
                                        <thead>
                                            <tr>
                                                <th data-field="transfer" data-checkbox="true"></th>
                                                <th scope="col" data-field="student_id" data-sortable="true"
                                                    data-visible="false">{{ __('id') }}</th>
                                                <th scope="col" data-field="user_id" data-sortable="true" data-visible="false">
                                                    {{ __('User Id') }}</th>
                                                <th scope="col" data-field="no">{{ __('no.') }}</th>
                                                <th scope="col" data-field="name">{{ __('name') }}</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <textarea id="student_ids" name="student_ids" style="display: none"></textarea>
                            <input type="hidden" name="student_id" id="transfer-student-id">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('close') }}</button>
                            <input class="btn btn-theme btn-transfer" id="create-btn" type="submit" value={{ __('submit') }}>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan

    @can('promote-student-create')
        {{-- Promote Student Modal --}}
        <div class="modal fade" id="promoteModal" tabindex="-1" role="dialog" aria-labelledby="promoteModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="promoteModalLabel">{{ __('Promote Student In Next Session') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('promote-student.store') }}" data-success-function="promoteSuccessFunction"
                        class="create-form pt-3" id="promote-form">
                        @csrf
                        <div class="modal-body">
                            <div class="row" id="toolbar2">
                                <div class="form-group col-sm-12 col-md-4">
                                    <label>{{ __('Class Section') }} <span class="text-danger">*</span></label>
                                    <select required name="class_section_id" id="student_class_section"
                                        class="form-control select2" style="width:100%;" tabindex="-1" aria-hidden="true">
                                        <option value="">{{ __('Select Class') }}</option>
                                        @foreach ($classSections as $section)
                                            <option value="{{ $section->id }}" data-class="{{ $section->class->id }}">
                                                {{ $section->full_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-12 col-md-4">
                                    <label>{{ __('Promote In') }} <span class="text-danger">*</span></label>
                                    <select required name="session_year_id" id="session_year_id" class="form-control select2"
                                        style="width:100%;" tabindex="-1" aria-hidden="true">
                                        <option value="">{{ __('Select Session Years') }}</option>
                                        @foreach ($sessionYears as $years)
                                            <option value="{{ $years->id }}">
                                                {{ $years->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-12 col-md-4">
                                    <label>{{ __('Promote Class') }} <span class="text-danger">*</span></label>
                                    <select required name="new_class_section_id" id="new_student_class_section"
                                        class="form-control select2" style="width:100%;" tabindex="-1" aria-hidden="true">
                                        <option value="">{{ __('Select Class') }}</option>
                                        <option value="data-not-found">-- {{ __('no_data_found') }} --</option>
                                        @foreach ($classSections as $section)
                                            <option value="{{ $section->id }}" data-class="{{ $section->class->id }}">
                                                {{ $section->full_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <table aria-describedby="mydesc" class='table promote_student_table'
                                        id='promote_student_table_list' data-toggle="table"
                                        data-url="{{ route('promote-student.show', [1]) }}" data-click-to-select="true"
                                        data-side-pagination="server" data-pagination="false"
                                        data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-toolbar="#toolbar2"
                                        data-show-columns="true" data-show-refresh="true" data-fixed-columns="false"
                                        data-fixed-number="2" data-fixed-right-number="1" data-trim-on-search="false"
                                        data-mobile-responsive="true" data-sort-name="id" data-sort-order="desc"
                                        data-maintain-selected="true" data-export-data-type='all' data-show-export="true"
                                        data-export-options='{ "fileName": "promote-student-list-<?= date('d-m-y') ?>" ,"ignoreColumn": ["operate"]}'
                                        data-query-params="promoteStudentQueryParams" data-escape="true">
                                        <thead>
                                            <tr>
                                                <th scope="col" data-field="id" data-sortable="true" data-visible="false">
                                                    {{ __('id') }}</th>
                                                <th scope="col" data-field="no">{{ __('no.') }}</th>
                                                <th scope="col" data-field="student_id" data-visible="false">
                                                    {{ __('Student Id') }}</th>
                                                <th scope="col" data-field="user.full_name">{{ __('name') }}</th>
                                                <th scope="col" data-field="result"
                                                    data-formatter="promoteStudentResultFormatter">{{ __('result') }}</th>
                                                <th scope="col" data-field="status"
                                                    data-formatter="promoteStudentStatusFormatter">{{ __('status') }}</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('close') }}</button>
                            <input class="btn btn-theme btn_promote" id="create-btn" type="submit" value={{ __('submit') }}>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
@endsection

@section('script')
    <script>
        // Adjust Bootstrap Table inside modal
        $('#transferModal, #promoteModal').on('shown.bs.modal', function () {
            $(this).find('table').bootstrapTable('resetView');
        });

        $('#transfer_class_section').on('change', function () {
            // Refresh the bootstrap table
            $('#transfer-student-table-list').bootstrapTable('refresh');

            // Get the selected value
            let selectedValue = $(this).val();

            // Reset the new transfer class section dropdown
            $("#new_transfer_class_section").val("").removeAttr('disabled');
            $("#new_transfer_class_section").find('option').hide();

            // Show the empty option
            $("#new_transfer_class_section").find('option[value=""]').show();

            if (selectedValue && selectedValue !== '') {
                // Get all options except the selected one and the empty/data-not-found options
                let availableOptions = $("#new_transfer_class_section").find('option').filter(function () {
                    let optionValue = $(this).val();
                    return optionValue !== selectedValue && optionValue !== '' && optionValue !== 'data-not-found';
                });

                // If there are available options, show them
                if (availableOptions.length > 0) {
                    availableOptions.show();
                } else {
                    // If no options available, show data-not-found and disable
                    $("#new_transfer_class_section").find('option[value="data-not-found"]').show();
                    $("#new_transfer_class_section").val("data-not-found").attr('disabled', true);
                }
            } else {
                // If no current class section selected, show data-not-found
                $("#new_transfer_class_section").find('option[value="data-not-found"]').show();
                $("#new_transfer_class_section").val("data-not-found").attr('disabled', true);
            }

            // Trigger Change event
            $("#new_transfer_class_section").trigger('change');
        });


        $('#student_class_section').on('change', function () {
            $('#promote_student_table_list').bootstrapTable('refresh');
        });


        $('.btn_promote').hide();
        $('.btn-transfer').hide()

        function set_data() {
            $(document).ready(function () {
                student_class = $('#student_class_section').val();
                session_year = $('#session_year_id').val();
                promote_class = $('#new_student_class_section').val();

                if (student_class != '' && session_year != '' && promote_class != '') {
                    $('.btn_promote').show();
                } else {
                    $('.btn_promote').hide();
                }
            });
        }

        $('#student_class_section,#session_year_id,#new_student_class_section').on('change', function () {
            set_data();
        });

        function transferSuccessFunction(response) {
            $('#transferModal').modal('hide');
            $('#transfer-student-table-list').bootstrapTable('refresh');
            $('.btn-transfer').hide();
        }

        function promoteSuccessFunction(response) {
            $('#promoteModal').modal('hide');
            $('#promote_student_table_list').bootstrapTable('refresh');
            $('.btn_promote').hide();
        }

        // Generic success function if needed by other components
        function formSuccessFunction(response) {
            $('.modal').modal('hide');
            $('.table1').bootstrapTable('refresh');
            $('.promote_student_table').bootstrapTable('refresh');
        }

        // Check Events on Transfer Student List Table
        $('#transfer-student-table-list').bootstrapTable({
            onCheck: function (row) {
                updateStudentIdsHidden("#transfer-student-table-list", '#transfer-student-id', '.btn-transfer');
            },
            onUncheck: function (row) {
                updateStudentIdsHidden("#transfer-student-table-list", '#transfer-student-id', '.btn-transfer');
            },
            onCheckAll: function (rows) {
                updateStudentIdsHidden("#transfer-student-table-list", '#transfer-student-id', '.btn-transfer');
            },
            onUncheckAll: function (rows) {
                updateStudentIdsHidden("#transfer-student-table-list", '#transfer-student-id', '.btn-transfer');
            }
        });


        // Maintain selected on server side
        var $transfer_table = $('#transfer-student-table-list')
        var selections = []

        function responseHandler(res) {
            $.each(res.rows, function (i, row) {
                row.transfer = $.inArray(row.student_id, selections) !== -1
            })
            return res
        }

        $(function () {
            $transfer_table.on('check.bs.table check-all.bs.table uncheck.bs.table uncheck-all.bs.table',
                function (e, rowsAfter, rowsBefore) {
                    var rows = rowsAfter
                    student_id = [];
                    if (e.type === 'uncheck-all') {
                        rows = rowsBefore
                    }

                    var ids = $.map(!$.isArray(rows) ? [rows] : rows, function (row) {
                        return row.student_id
                    })

                    var func = $.inArray(e.type, ['check', 'check-all']) > -1 ? 'union' : 'difference'
                    selections = window._[func](selections, ids)
                    selections.forEach(element => {
                        student_id.push(element);
                    });
                    $('textarea#student_ids').val(student_id);
                })
        })
    </script>
@endsection