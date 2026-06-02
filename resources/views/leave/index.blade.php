@extends('layouts.master')

@section('title')
    {{ __('leave') }}
@endsection

@section('content')
    <div class="content-wrapper w-100">
        <div class="page-header container-fluid">
            <h3 class="page-title">
                {{ __('manage') . ' ' . __('leave') }}
            </h3>
            <button class="btn btn-theme" data-toggle="modal" data-target="#createLeaveModal">{{ __('Apply Leave') }}</button>
        </div>


        <div class="row w-100 mt-2">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-danger">Note :
                            {{ __('To modify an existing leave, kindly delete the old entry and submit a new request') }}.
                        </h6>
                        <h4 class="card-title">{{ __('my') . ' ' . __('leaves') }}</h4>
                        <div class="row" id="toolbar">
                            <div class="form-group col-sm-12 col-md-3">
                                <label for="" class="filter-menu">{{ __('session_year') }}</label>
                                <select name="session_year_id" id="session_year_id" class="form-control">
                                    @foreach($sessionYear as $key => $sy)
                                        <option value="{{ $key }}" {{ $key == $current_session_year->id ? 'selected' : '' }}>{{ $sy }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-sm-12 col-md-3">
                                <label for="filter" class="filter-menu">{{ __('filter') }}</label>
                                <select name="filter" id="filter_upcoming" class="form-control">
                                    <option value="All" selected>All</option>
                                    <option value="Today">Today</option>
                                    <option value="Tomorrow">Tomorrow</option>
                                    <option value="Upcoming">Upcoming</option>
                                </select>
                            </div>

                            <div class="form-group col-sm-12 col-md-3">
                                <label for="month" class="filter-menu">{{ __('month') }}</label>
                                <select name="month" id="filter_month_id" class="form-control">
                                    <option value="">{{ __('all') }}</option>
                                    @foreach($months as $key => $month)
                                        <option value="{{ $key }}">{{ $month }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <table aria-describedby="mydesc" class='table' id='table_list' data-toggle="table"
                               data-url="{{ route('leave.show', [1]) }}" data-click-to-select="true"
                               data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]"
                               data-search="true" data-show-columns="true" data-show-refresh="true" data-fixed-columns="false"
                               data-fixed-number="2" data-fixed-right-number="1" data-trim-on-search="false"
                               data-mobile-responsive="true" data-sort-name="id" data-sort-order="desc"
                               data-maintain-selected="true" data-export-data-type='all'
                               data-query-params="leaveQueryParams" data-toolbar="#toolbar"
                               data-export-options='{ "fileName": "leave-list-<?= date('d-m-y') ?>"
                            ,"ignoreColumn":["operate"]}' data-show-export="true" data-escape="true">
                            <thead>
                            <tr>
                                <th scope="col" data-field="id" data-sortable="true" data-visible="false">{{ __('id') }}</th>
                                <th scope="col" data-field="no">{{ __('no.') }}</th>
                                <th scope="col" data-field="from_date" >{{ __('from_date') }}</th>
                                <th scope="col" data-field="to_date" >{{ __('to_date') }}</th>
                                <th scope="col" data-field="days">{{ __('total') }}</th>
                                <th scope="col" data-events="tableDescriptionEvents" data-formatter="descriptionFormatter" data-field="reason">{{ __('reason') }}</th>
                                <th scope="col" data-formatter="fileFormatter" data-field="files">{{ __('attachments') }}</th>
                                <th scope="col" data-formatter="leaveStatusFormatter" data-field="status">{{ __('status') }}</th>
                                <th scope="col" data-field="created_at" >{{ __('created_at') }}</th>
                                <th data-events="leaveEvents" scope="col" data-field="operate" data-escape="false">
                                    {{ __('action') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="createLeaveModal" data-backdrop="static" tabindex="-1" role="dialog"
             aria-labelledby="createLeaveModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createLeaveModalLabel"> {{ __('create') . ' ' . __('leave') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fa fa-close"></i></span>
                        </button>
                    </div>
                    <form action="{{ route('leave.store') }}" class="create-form" novalidate="novalidate" data-success-function="formSuccessFunction">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="leave_master_id" class="form-control" value="{{ $leaveMaster->id ?? '' }}">
                            <input type="hidden" name="holiday_days" class="form-control holiday_days" value="{{ $leaveMaster->holiday ?? '' }}">
                            <input type="hidden" name="public_holiday" class="form-control public_holiday" value="{{ $holiday ?? '' }}">
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-12">
                                    <label>{{ __('reason') }} <span class="text-danger">*</span></label>
                                    <textarea name="reason" required id="" class="form-control" placeholder="{{ __('reason') }}"></textarea>
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>{{ __('from_date') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="from_date" id="from_date" class="form-control leave-date" placeholder="{{ __('from_date') }}" required>
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>{{ __('to_date') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="to_date" id="to_date" class="form-control leave-date" placeholder="{{ __('to_date') }}" required>
                                </div>
                                <div class="form-group col-sm-12 col-md-12">
                                    <label>{{ __('attachments') }} <span class="text-small text-info"> ({{ __('upload_multiple_files') }})</span></label>
                                    <input type="file" multiple name="files[]" id="uploadInput" accept="image/jpeg,image/png,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" class="file-upload-default"/>
                                    <div class="input-group col-xs-12">
                                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="{{ __('files') }}" required aria-label=""/>
                                        <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-theme" type="button">{{ __('upload') }}</button>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group col-sm-12 col-md-12 leave_dates mt-3"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                            <input class="btn btn-theme" type="submit" value={{ __('submit') }}>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editModal" data-backdrop="static" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> {{ __('view') . ' ' . __('leave') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fa fa-close"></i></span>
                        </button>
                    </div>
                    <form id="formdata" class="edit-form" action="{{ url('leave') }}" novalidate="novalidate">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id">
                            <div class="row form-group">
                                <div class="col-sm-12 col-md-12">
                                    <label>{{ __('reason') }} <span class="text-danger">*</span></label>
                                    <textarea name="reason" disabled id="edit_reason" class="form-control" placeholder="{{ __('reason') }}"></textarea>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-12 col-md-12">
                                    <label>{{ __('from_date') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="from_date" id="edit_from_date" class="form-control datepicker-popup datepicker-popup-no-past" placeholder="{{ __('from_date') }}" disabled required>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-12 col-md-12">
                                    <label>{{ __('to_date') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="to_date" id="edit_to_date" class="form-control datepicker-popup datepicker-popup-no-past" placeholder="{{ __('to_date') }}" disabled required>
                                </div>
                            </div>
                            <div class="form-group col-sm-12 col-md-12">
                                <label>{{ __('attachments') }} </label>
                                <div id="attachment"></div>
                            </div>
                            <div class="form-group col-sm-12 col-md-12 edit_leave_dates mt-3"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function formSuccessFunction() {
            setTimeout(() => {
                $('.leave_dates').slideUp(500);
                $('#createLeaveModal').modal('hide');
            }, 1000);
        }

        $(document).ready(function () {
            $('body').on('focus', ".leave-date", function () {
                let today = new Date();
                let minDate = new Date();
                minDate.setDate(today.getDate());
                var maxDate = moment("{{ $current_session_year->end_date }}", 'YYYY-MM-DD').format('DD-MM-YYYY');
                $(this).datepicker({
                    enableOnReadonly: false,
                    format: "dd-mm-yyyy",
                    todayHighlight: true,
                    startDate: minDate,
                    endDate: maxDate,
                    rtl: isRTL()
                });
            });
        });

    </script>
@endsection
