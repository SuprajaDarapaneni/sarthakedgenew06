@extends('layouts.master')

@section('title')
    {{ __('manage') . ' ' . __('form-fields') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ __('manage') . ' ' . __('form-fields') }}
            </h3>
        </div>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title">
                                {{ __('list') . ' ' . __('form-fields') }}
                            </h4>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-secondary mr-2" id="preview-fields" data-toggle="modal"
                                    data-target="#previewFieldModal">{{__('preview') . ' ' . __('form-fields')}}</button>
                                <button type="button" class="btn btn-theme" data-toggle="modal" data-target="#createModal">
                                    <i class="fa fa-plus-circle mr-1"></i> {{ __('create') . ' ' . __('form-fields') }}
                                </button>
                            </div>
                        </div>

                        <div class="row mt-3" id="toolbar">
                            <div class="form-group col-sm-12 col-md-4">
                                <label class="filter-menu">{{ __('user_type') }} <span class="text-danger">*</span></label>
                                <select required name="filter_all_user_type" class="form-control" id="filter_all_user_type">
                                    <option value="">{{ __('all_user_type') }}</option>
                                    <option value="1">{{__('Student')}}</option>
                                    <option value="2">{{__('Teacher')}}/{{__('Staff')}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 text-right d-flex justify-content-end mb-2">
                            <b><a href="#" class="table-list-type active mr-2" data-id="0">{{__('all')}}</a></b> |
                            <a href="#" class="ml-2 table-list-type" data-id="1">{{__("Trashed")}}</a>
                        </div>

                        <table aria-describedby="mydesc" class='table reorder-table-row' id='table_list' data-toggle="table"
                            data-url="{{ route('form-fields.show', 1) }}" data-click-to-select="true"
                            data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]"
                            data-search="true" data-toolbar="#toolbar" data-show-columns="true" data-show-refresh="true"
                            data-trim-on-search="false" data-mobile-responsive="true" data-use-row-attr-func="true"
                            data-reorderable-rows="true" data-maintain-selected="true" data-export-data-type='all'
                            data-export-options='{ "fileName": "{{__('form-fields')}}-<?= date(' d-m-y') ?>" ,"ignoreColumn":["operate"]}'
                            data-show-export="true" data-query-params="FormFieldQueryParams" data-escape="true">
                            <thead>
                                <tr>
                                    <th scope="col" data-field="id" data-sortable="true" data-visible="false">{{ __('id') }}
                                    </th>
                                    <th scope="col" data-field="no">{{ __('no.') }}</th>
                                    <th scope="col" data-field="name">{{ __('name') }}</th>
                                    <th scope="col" data-field="type">{{ __('type') }}</th>
                                    <th scope="col" data-field="user_type">{{ __('user_type') }}</th>
                                    <th scope="col" data-field="is_required" data-formatter="yesAndNoStatusFormatter">
                                        {{ __('is') . ' ' . __('required') }}
                                    </th>
                                    <th scope="col" data-field="default_values"
                                        data-formatter="formFieldDefaultValuesFormatter">{{ __('Default Values') }}</th>
                                    <th scope="col" data-field="rank" data-sortable="false">{{ __('rank') }}</th>
                                    <th scope="col" data-field="operate" data-sortable="false"
                                        data-events="formFieldsEvents" data-escape="false">{{ __('action') }}</th>
                                </tr>
                            </thead>
                        </table>
                        <span class="d-block mb-4 mt-2 text-danger small">{{ __('draggable_rows_notes') }}</span>
                        <div class="mt-1 d-none d-md-block">
                            <button id="change-order-form-field" class="btn btn-theme">{{ __('update_rank') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Create Modal --}}
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">{{ __('create') . ' ' . __('form-fields') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="pt-3 create-form" method="POST" data-success-function="formSuccessFunction"
                    action="{{ url('form-fields') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-4">
                                <label>{{ __('name') }} <span class="text-danger">*</span></label>
                                <input type="text" name="name" onkeypress="validateInput(event)"
                                    placeholder="{{__('name')}}" class="form-control" required>
                            </div>
                            <div class="form-group col-sm-12 col-md-4">
                                <label>{{ __('type') }} <span class="text-danger">*</span></label>
                                <select name="type" id="type-field" class="form-control type-field">
                                    <option value="text" selected>{{__('Text')}}</option>
                                    <option value="number">{{ __('Numeric') }}</option>
                                    <option value="dropdown">{{ __('Dropdown') }}</option>
                                    <option value="radio">{{ __('Radio Button') }}</option>
                                    <option value="checkbox">{{ __('Checkbox') }}</option>
                                    <option value="textarea">{{ __('TextArea') }}</option>
                                    <option value="file">{{ __('File Upload') }}</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-12 col-md-4">
                                <label>{{ __('user_type') }} <span class="text-danger">*</span></label>
                                <select name="user_type" class="form-control" required>
                                    <option value="" selected disabled>{{ __('select_user_type') }}</option>
                                    <option value="1">{{__('Student')}}</option>
                                    <option value="2">{{__('Teacher')}}/{{__('Staff')}}</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-12 col-md-2">
                                <label>{{ __('required') }} </label>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input required-field" name="required"
                                        id="customSwitchCreate">
                                    <label class="custom-control-label" for="customSwitchCreate"></label>
                                </div>
                            </div>
                        </div>

                        {{-- Option Section --}}
                        <div class="default-values-section" style="display: none">
                            <div class="mt-4" data-repeater-list="default_data">
                                <div class="col-md-5 pl-0 mb-4">
                                    <button type="button" class="btn btn-success add-new-option" data-repeater-create
                                        title="Add new row">
                                        <span><i class="fa fa-plus"></i> {{__('add_new_option')}}</span>
                                    </button>
                                </div>
                                <div class="row option-section" data-repeater-item>
                                    <div class="form-group col-md-5">
                                        <label>{{ __('option') }} - <span class="option-number">1</span> <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="option" placeholder="{{__('text')}}" class="form-control"
                                            required>
                                    </div>
                                    <div class="form-group col-md-1 pl-0 mt-4">
                                        <button data-repeater-delete type="button"
                                            class="btn btn-icon btn-inverse-danger remove-default-option"
                                            title="{{__('remove') . ' ' . __('option')}}" disabled>
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </div>
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

    {{-- Preview Fields Model --}}
    <div class="modal fade" id="previewFieldModal" tabindex="-1" role="dialog" aria-labelledby="previewFieldModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewFieldModalLabel">{{__('preview') . ' ' . __('form-fields')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row preview-content">
                        @if(!empty($formFields))
                            @foreach ($formFields as $data)
                                <div class='form-group col-md-4 col-sm-12'>
                                    <label>{{$data->name}} @if($data->is_required) <span class="text-danger">*</span> @endif</label>
                                    @if($data->type == 'text')
                                        <input type="text" class="form-control" placeholder="{{$data->name}}">
                                    @elseif($data->type == 'number')
                                        <input type="number" min="0" class="form-control" placeholder="{{$data->name}}">
                                    @elseif($data->type == 'dropdown')
                                        <select class="form-control">
                                            <option value="" disabled selected>Select {{$data->name}}</option>
                                            @if(!empty($data->default_values))
                                                @foreach ($data->default_values as $value)
                                                    <option value="{{$value}}">{{$value}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    @elseif($data->type == 'radio')
                                        <div class="d-flex">
                                            @if(!empty($data->default_values))
                                                @foreach ($data->default_values as $value)
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" name="{{$data->name}}" value="{{$value}}"> {{$value}}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    @elseif($data->type == 'checkbox')
                                        <div class="row form-check-inline">
                                            @foreach ($data->default_values as $value)
                                                <div class="col-6 col-md-4 form-check mr-4">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" class="form-check-input" value="{{ $value }}"> {{ $value }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @elseif($data->type == 'textarea')
                                        <textarea placeholder="{{ $data->name }}" class="form-control" rows="2"></textarea>
                                    @elseif($data->type == 'file')
                                        <div class="input-group col-xs-12">
                                            <input type="file" class="file-upload-default" />
                                            <input type="text" class="form-control file-upload-info" disabled
                                                placeholder="{{ __('image') }}" />
                                            <span class="input-group-append">
                                                <button class="file-upload-browse btn btn-theme"
                                                    type="button">{{ __('upload') }}</button>
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">{{ __('edit') . ' ' . __('form-fields') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="pt-3 edit-form edit-common-validation-rules" action="{{ url('form-fields') }}"
                    novalidate="novalidate">
                    <input type="hidden" name="edit_id" id="edit-id" value="" />
                    <div class="modal-body">
                        <div class="form-group col-sm-12">
                            <label>{{ __('name') }} <span class="text-danger">*</span></label>
                            <input type="text" name="name" onkeypress="validateInput(event)" id="edit-name"
                                placeholder="{{__('name')}}" class="form-control" required>
                        </div>
                        <div class="form-group col-sm-12">
                            <label>{{ __('type') }} <span class="text-danger">*</span></label>
                            <select id="edit-type-select" class="form-control edit-type-field">
                                <option value="text" selected>Text</option>
                                <option value="number">Numeric</option>
                                <option value="dropdown">Dropdown</option>
                                <option value="radio">Radio Button</option>
                                <option value="checkbox">Checkbox</option>
                                <option value="textarea">TextArea</option>
                                <option value="file">File Upload</option>
                            </select>
                            <input type="hidden" name="type" id="edit-type-field-value" value="">
                        </div>
                        <div class="form-group col-sm-12 col-md-4">
                            <label>{{ __('required') }} </label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" name="edit_required"
                                    id="customSwitchEditToggle">
                                <label class="custom-control-label" id="edit-required-toggle"
                                    for="customSwitchEditToggle"></label>
                            </div>
                        </div>

                        {{-- Option Section --}}
                        <div class="edit-default-values-section ml-4" style="display: none">
                            <div class="mt-4" data-repeater-list="edit_default_data">
                                <div class="pl-0 mb-4">
                                    <button type="button" class="btn btn-success add-new-edit-option" data-repeater-create
                                        title="{{__('add_new_option')}}">
                                        <span><i class="fa fa-plus"></i> {{__('add_new_option')}}</span>
                                    </button>
                                </div>
                                <div class="row edit-option-section" data-repeater-item>
                                    <div class="form-group col-md-10">
                                        <label>{{ __('option') }} - <span class="edit-option-number">1</span> <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="option" placeholder="{{__('text')}}" class="form-control"
                                            required>
                                    </div>
                                    <div class="form-group col-md-1 pl-0 mt-4">
                                        <button data-repeater-delete type="button"
                                            class="btn btn-icon btn-inverse-danger remove-edit-default-option"
                                            title="{{__('remove') . ' ' . __('option')}}" disabled>
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('close') }}</button>
                        <input class="btn btn-theme" type="submit" value={{ __('submit') }} />
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('#table_list').on('load-success.bs.table', function (e, data) {
            if (data && data.total > 1) {
                $('#change-order-form-field').show();
            } else {
                $('#change-order-form-field').hide();
            }
        });

        function formSuccessFunction() {
            $('#createModal').modal('hide');
            $('#type-field').val('text').trigger('change');
            $('[data-repeater-item]').slice(2).remove();
        }

        function validateInput(event) {
            var charCode = event.which || event.keyCode;
            if (!(charCode >= 65 && charCode <= 90) && !(charCode >= 97 && charCode <= 122) && !(charCode === 32)) {
                event.preventDefault();
            }
        }

        $(document).on('click', '.edit-data, .delete-form', function (e) {
            e.preventDefault();
            e.stopPropagation();
            let targetModal = $(this).data('target');
            if (targetModal) {
                $(targetModal).modal('show');
            }
        });

        $('#table_list').on('post-body.bs.table', function () {
            $('#table_list').tableDnD({
                onDragClass: "drag-row",
                dragHandle: 'td:not([data-field="operate"])'
            });

            $('#table_list td[data-field="operate"], .card-view .card-view-value')
                .off('mousedown touchstart')
                .on('mousedown touchstart', function (e) {
                    e.stopPropagation();
                });
        });
    </script>
@endsection