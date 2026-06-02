@extends('layouts.master')

@section('title')
    {{ __('Session Years') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ __('Manage Session Years') }}
            </h3>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <span class="text-danger mt-4 ml-4">
                        {{ __('note If you change the session year the chat history will be deleted') }}
                    </span>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title">
                                {{ __('List Session Years') }}
                            </h4>
                            <button type="button" class="btn btn-theme" data-toggle="modal" data-target="#createModal">
                                <i class="fa fa-plus-circle mr-1"></i> {{ __('Create Session Years') }}
                            </button>
                        </div>
                        <div class="col-12 mt-4 text-right">
                            <b><a href="#" class="table-list-type active mr-2" data-id="0">{{__('all')}}</a></b> | <a
                                href="#" class="ml-2 table-list-type" data-id="1">{{__("Trashed")}}</a>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <table aria-describedby="mydesc" class='table' id='table_list' data-toggle="table"
                                    data-url="{{ route('session-year.show', 1) }}" data-click-to-select="true"
                                    data-side-pagination="server" data-pagination="true"
                                    data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-toolbar="#toolbar"
                                    data-show-columns="true" data-show-refresh="true" data-fixed-columns="false"
                                    data-fixed-number="2" data-fixed-right-number="1" data-trim-on-search="false"
                                    data-mobile-responsive="true" data-sort-name="id" data-sort-order="desc"
                                    data-maintain-selected="true" data-export-data-type='all' data-show-export="true"
                                    data-export-options='{ "fileName": "session-year-list-<?= date('d-m-y') ?>","ignoreColumn": ["operate"]}'
                                    data-query-params="queryParams" data-escape="true">
                                    <thead>
                                        <tr>
                                            <th scope="col" data-field="id" data-sortable="true" data-visible="false">
                                                {{__('id')}}
                                            </th>
                                            <th scope="col" data-field="no">{{__('no.')}}</th>
                                            <th scope="col" data-field="name">{{__('name')}}</th>
                                            <th scope="col" data-field="start_date" data-sortable="true">
                                                {{__('start_date')}}
                                            </th>
                                            <th scope="col" data-field="end_date" data-sortable="true">{{__('end_date')}}
                                            </th>
                                            <th scope="col" data-field="default" data-sortable="true"
                                                data-formatter="yesAndNoStatusFormatter">{{__('default')}}</th>
                                            <th data-events="sessionYearEvents" scope="col" data-field="operate"
                                                data-escape="false">{{__('action')}}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Create Modal --}}
    <div class="modal fade" id="createModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">{{ __('Create Session Years') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close"></i></span>
                    </button>
                </div>
                <form action="{{ route('session-year.store') }}" class="create-form pt-3 " id="formdata" method="POST"
                    novalidate="novalidate">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-4">
                                <label>{{ __('name') }} <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="{{ __('name') }}" required>
                            </div>
                            <div class="form-group col-sm-12 col-md-4">
                                <label>{{ __('start_date') }} <span class="text-danger">*</span></label>
                                <input type="text" name="start_date" class="datepicker-popup form-control"
                                    placeholder="{{ __('start_date') }}" autocomplete="off" required>
                            </div>
                            <div class="form-group col-sm-12 col-md-4">
                                <label>{{ __('end_date') }} <span class="text-danger">*</span></label>
                                <input type="text" name="end_date" class="datepicker-popup form-control"
                                    placeholder="{{ __('end_date') }}" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('close')}}</button>
                        <input class="btn btn-theme" id="create-btn" type="submit" value={{ __('submit') }}>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div class="modal fade" id="editModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel"> {{ __('Edit Session Years') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close"></i></span>
                    </button>
                </div>

                <form action="{{ url('session-year') }}" class="edit-form pt-3" data-success-function="formSuccessFunction"
                    id="formdata" method="POST" novalidate="novalidate">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-12 col-sm-12 col-md-4">
                                <label>{{ __('name') }} <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="edit-name" class="form-control"
                                    placeholder="{{ __('name') }}" required>
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-4">
                                <label>{{ __('start_date') }} <span class="text-danger">*</span></label>
                                <input type="text" name="start_date" id="edit-start-date"
                                    class="datepicker-popup form-control" placeholder="{{ __('start_date') }}" required>
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-4">
                                <label>{{ __('end_date') }} <span class="text-danger">*</span></label>
                                <input type="text" name="end_date" id="edit-end-date" class="datepicker-popup form-control"
                                    placeholder="{{ __('end_date') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Cancel')}}</button>
                        <input class="btn btn-theme" type="submit" value={{ __('submit') }}>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        const formSuccessFunction = () => {
            setTimeout(() => {
                window.location.reload();
            }, 3000);
        }
    </script>
@endsection