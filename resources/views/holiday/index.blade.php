@extends('layouts.master')

@section('title')
    {{ __('holiday') }}
@endsection

@section('content')
    @php
        /** @var \App\Models\User $user */
        $user = Auth::user();
    @endphp
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ __('manage') . ' ' . __('holiday') }}
            </h3>
            @if ($user->can('holiday-create'))
                <button type="button" class="btn btn-theme btn-sm" data-toggle="modal" data-target="#createModal">
                    <i class="fa fa-plus mr-1"></i> {{ __('create') . ' ' . __('holiday') }}
                </button>
            @endif
        </div>

        <div class="row">
            @if ($user->can('holiday-list'))
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">
                                {{ __('list') . ' ' . __('holiday') }}
                            </h4>
                            <div class="row" id="toolbar">
                                <div class="form-group col-12 col-sm-12 col-md-3 col-lg-3">
                                    <label for="filter_session_year_id" class="filter-menu">{{__("session_year")}}</label>
                                    <select name="filter_session_year_id" id="filter_session_year_id" class="form-control">
                                        @foreach ($sessionYears as $sessionYear)
                                            <option value="{{ $sessionYear->id }}" {{$sessionYear->default == 1 ? "selected" : ""}}>
                                                {{ $sessionYear->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-12 col-sm-12 col-md-3 col-lg-3">
                                    <label for="filter_month_id" class="filter-menu">{{__("month")}}</label>
                                    <select name="month" id="filter_month" class="form-control">
                                        <option value="0">{{ __('All') }}</option>
                                        @foreach ($months as $key => $month)
                                            <option value="{{ $key }}">{{ $month }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <table aria-describedby="mydesc" class='table' id='table_list' data-toggle="table"
                                        data-url="{{ route('holiday.show', 1) }}" data-click-to-select="true"
                                        data-side-pagination="server" data-pagination="true"
                                        data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-toolbar="#toolbar"
                                        data-show-columns="true" data-show-refresh="true" data-fixed-columns="false"
                                        data-fixed-number="2" data-fixed-right-number="1" data-trim-on-search="false"
                                        data-mobile-responsive="true" data-sort-name="id" data-sort-order="desc"
                                        data-maintain-selected="true" data-export-data-type='all' data-show-export="true"
                                        data-export-options='{ "fileName": "holiday-list-<?= date('d-m-y') ?>","ignoreColumn": ["operate"]}'
                                        data-query-params="holidayQueryParams">
                                        <thead>
                                            <tr>
                                                <th scope="col" data-field="id" data-sortable="true" data-visible="false">
                                                    {{ __('id') }}
                                                </th>
                                                <th scope="col" data-field="no"> {{ __('no.') }} </th>
                                                <th scope="col" data-field="date" data-width="150"
                                                    data-formatter="dateRangeFormatter"> {{ __('date_range') }} </th>
                                                <th scope="col" data-field="title">{{ __('title') }} </th>
                                                <th scope="col" data-events="tableDescriptionEvents"
                                                    data-formatter="descriptionFormatter" data-field="description">
                                                    {{ __('description') }}
                                                </th>
                                                @if ($user->can('holiday-edit') || $user->can('holiday-delete'))
                                                    <th data-events="holidayEvents" data-width="150" scope="col"
                                                        data-field="operate">{{ __('action') }}</th>
                                                @endif
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>


    <div class="modal fade" id="editModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> {{ __('edit_holiday') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close"></i></span>
                    </button>
                </div>
                <form id="formdata" class="edit-form" action="{{url('holiday')}}" novalidate="novalidate">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="row form-group">
                            <div class="col-sm-12 col-md-6">
                                <label>{{ __('start_date') }} <span class="text-danger">*</span></label>
                                <input type="text" name="date" id="edit-date" class="datepicker-popup form-control" placeholder="{{ __('start_date') }}" required>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label>{{ __('end_date') }}</label>
                                <input type="text" name="end_date" id="edit-end-date" class="datepicker-popup form-control" placeholder="{{ __('end_date') }}">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-12 col-md-12">
                                <label>{{ __('title') }} <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="edit-title" class="form-control" placeholder="{{ __('title') }}" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-12 col-md-12">
                                <label>{{ __('description') }}</label>
                                <textarea name="description" id="edit-description" class="form-control" placeholder="{{ __('description') }}"></textarea>
                            </div>
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

    {{-- Create Modal --}}
    @if ($user->can('holiday-create'))
        <div class="modal fade" id="createModal" data-backdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel"> {{ __('create') . ' ' . __('holiday') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fa fa-close"></i></span>
                        </button>
                    </div>
                    <form class="create-form" id="create-form" action="{{route('holiday.store')}}" method="POST"
                        novalidate="novalidate">
                        @csrf
                        <div class="modal-body">
                            <div class="row form-group">
                                <div class="col-sm-12 col-md-6">
                                    <label>{{ __('start_date') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="date" class="datepicker-popup form-control" placeholder="{{ __('start_date') }}" required autocomplete="off">
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <label>{{ __('end_date') }}</label>
                                    <input type="text" name="end_date" class="datepicker-popup form-control" placeholder="{{ __('end_date') }}" autocomplete="off">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-12 col-md-12">
                                    <label>{{ __('title') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control" placeholder="{{ __('title') }}" required>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-12 col-md-12">
                                    <label>{{ __('description') }}</label>
                                    <textarea name="description" rows="2" class="form-control" placeholder="{{ __('description') }}"></textarea>
                                </div>
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
    @endif
@endsection

@section('js')
    <script>
        let schoolDateFormat = "{{$schoolSettings['date_format'] ?? 'd-m-Y'}}";
        function dateRangeFormatter(value, row) {
            if (row.end_date && row.end_date !== row.date) {
                return row.date + ' to ' + row.end_date;
            }
            return row.date;
        }

        $(function () {
            const sessionStart = "{{ format_date($current_sessionYear->start_date) }}";
            const sessionEnd = "{{ format_date($current_sessionYear->end_date) }}";

            $('.datepicker-popup').datepicker({
                format: 'dd-mm-yyyy',
                startDate: sessionStart,
                endDate: sessionEnd,
                autoclose: true,
                todayHighlight: true
            });
        });
    </script>
@endsection