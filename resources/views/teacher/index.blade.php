@extends('layouts.master')

@section('title')
    {{ __('teacher') }}
@endsection

@section('content')
    @php
        /** @var \App\Models\User $user */
        $user = Auth::user();
    @endphp
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ __('manage_teacher') }}
            </h3>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h4 class="card-title">
                                    {{ __('list_teacher') }}
                                </h4>
                            </div>
                            <div class="col-6 text-right">
                                <button type="button" class="btn btn-theme" data-toggle="modal"
                                    data-target="#createTeacherModal">
                                    <i class="fa fa-plus-circle mr-1"></i> {{ __('Add Teacher') }}
                                </button>
                            </div>
                        </div>

                        <!-- Create Teacher Modal -->
                        <div class="modal fade" id="createTeacherModal" tabindex="-1" role="dialog"
                            aria-labelledby="createTeacherModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="createTeacherModalLabel">{{ __('create_teacher') }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form class="create-form pt-3" id="formdata" action="{{ route('teachers.store') }}"
                                        enctype="multipart/form-data" method="POST" novalidate="novalidate">
                                        <div class="modal-body">
                                            @csrf
                                            <div class="row">
                                                <div class="form-group col-sm-12 col-md-4">
                                                    <label>{{ __('email') }} <span class="text-danger">*</span></label>
                                                    <input type="text" name="email" class="form-control" placeholder="{{ __('email') }}" required>
                                                </div>
                                                <div class="form-group col-sm-12 col-md-4">
                                                    <label>{{ __('first_name') }} <span class="text-danger">*</span></label>
                                                    <input type="text" name="first_name" class="form-control" placeholder="{{ __('first_name') }}" required>
                                                </div>
                                                <div class="form-group col-sm-12 col-md-4">
                                                    <label>{{ __('last_name') }} <span class="text-danger">*</span></label>
                                                    <input type="text" name="last_name" class="form-control" placeholder="{{ __('last_name') }}" required>
                                                </div>

                                                <div class="form-group col-sm-12 col-md-12">
                                                    <label>{{ __('gender') }} <span class="text-danger">*</span></label><br>
                                                    <div class="d-flex">
                                                        <div class="form-check form-check-inline">
                                                            <label class="form-check-label">
                                                                <input type="radio" name="gender" value="male" checked>
                                                                {{ __('male') }}
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="form-check-label">
                                                                <input type="radio" name="gender" value="female">
                                                                {{ __('female') }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group col-sm-12 col-md-4">
                                                    <label>{{ __('mobile') }} <span class="text-danger">*</span></label>
                                                    <input type="number" name="mobile" class="form-control remove-number-increment" placeholder="{{ __('mobile') }}" required min="1">
                                                </div>

                                                <div class="form-group col-sm-12 col-md-4">
                                                    <label>{{ __('dob') }} <span class="text-danger">*</span></label>
                                                    <input type="text" name="dob" class="datepicker-popup-no-future form-control" placeholder="{{ __('dob') }}" required autocomplete="off">
                                                </div>
                                                <div class="form-group col-sm-12 col-md-4">
                                                    <label for="image">{{ __('image') }} <span
                                                            class="text-info text-small">(308px*338px)</span></label>
                                                    <input type="file" name="image" class="file-upload-default"
                                                        accept="image/png,image/jpeg,image/jpg" />
                                                    <div class="input-group col-xs-12">
                                                        <input type="text" class="form-control file-upload-info" id="image"
                                                            disabled="" placeholder="{{ __('image') }}" />
                                                        <span class="input-group-append">
                                                            <button class="file-upload-browse btn btn-theme"
                                                                type="button">{{ __('upload') }}</button>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-12 col-md-4">
                                                    <label>{{ __('qualification') }} <span
                                                            class="text-danger">*</span></label>
                                                    <textarea name="qualification" class="form-control" placeholder="{{ __('qualification') }}" required rows="3"></textarea>
                                                </div>

                                                <div class="form-group col-sm-12 col-md-4 current_address_div">
                                                    <label>{{ __('current_address') }} <span
                                                            class="text-danger">*</span></label>
                                                    <textarea name="current_address" id="current_address" class="form-control" placeholder="{{ __('current_address') }}" required rows="3"></textarea>
                                                </div>
                                                <div class="form-group col-sm-12 col-md-4 permanent_address_div">
                                                    <label>{{ __('permanent_address') }} <span
                                                            class="text-danger">*</span></label>
                                                    <div class="form-check mb-2">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="same_as_current_address">
                                                            {{ __('Same as current address') }}
                                                        </label>
                                                    </div>
                                                    <textarea name="permanent_address" id="permanent_address" class="form-control" placeholder="{{ __('permanent_address') }}" required rows="3"></textarea>
                                                </div>
                                                <div class="form-group col-sm-12 col-md-4">
                                                    <label for="salary">{{__('Salary') }} <span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" name="salary" id="salary"
                                                        placeholder="{{__('Salary')}}" class="form-control" min="0"
                                                        required>
                                                </div>
                                                @hasFeature('Teacher Management')
                                                <div class="form-group col-sm-12 col-md-4">
                                                    <label for="joining_date">{{ __('joining_date') }}</label>
                                                    <input type="text" name="joining_date" class="datepicker-popup form-control" placeholder="{{ __('joining_date') }}" autocomplete="off">
                                                </div>
                                                <div class="form-group col-sm-12 col-md-4">
                                                    <label>{{ __('status') }} <span class="text-danger">*</span></label><br>
                                                    <div class="d-flex">
                                                        <div class="form-check form-check-inline">
                                                            <label class="form-check-label">
                                                                <input type="radio" name="status" value="1">
                                                                {{ __('Active') }}
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="form-check-label">
                                                                <input type="radio" name="status" value="0" checked>
                                                                {{ __('inactive') }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if(count($extraFields))
                                                    {{-- Loop the FormData --}}
                                                    @foreach ($extraFields as $key => $data)
                                                        @if ($data->user_type == 2)
                                                            <div class="form-group col-sm-12 col-md-4">
                                                                {{-- Edit Extra Details ID --}}
                                                                <input type="hidden" name="extra_fields[{{ $key }}][id]" id="{{ $data->type . '_' . $key . '_id' }}" value="">

                                                                {{-- Form Field ID --}}
                                                                <input type="hidden" name="extra_fields[{{ $key }}][form_field_id]" id="{{ $data->type . '_' . $key . '_id' }}" value="{{ $data->id }}">


                                                                {{-- Add lable to all the elements excluding checkbox --}}
                                                                @if($data->type != 'radio' && $data->type != 'checkbox')
                                                                    <label>{{$data->name}} @if($data->is_required)
                                                                        <span class="text-danger">*</span>
                                                                    @endif</label>
                                                                @endif

                                                                {{-- Text Field --}}
                                                                @if($data->type == 'text')
                                                                    <input type="text" name="extra_fields[{{ $key }}][data]" class="form-control text-fields" id="{{ $data->type . '_' . $key }}" placeholder="{{ $data->name }}" {{ $data->is_required == 1 ? 'required' : '' }}>
                                                                    {{-- Number Field --}}
                                                                @elseif($data->type == 'number')
                                                                    <input type="number" name="extra_fields[{{ $key }}][data]" class="form-control number-fields" id="{{ $data->type . '_' . $key }}" placeholder="{{ $data->name }}" min="0" {{ $data->is_required == 1 ? 'required' : '' }}>

                                                                    {{-- Dropdown Field --}}
                                                                @elseif($data->type == 'dropdown')
                                                                                                    <select name="extra_fields[{{ $key }}][data]" id="{{ $data->type . '_' . $key }}" class="form-control select-fields" {{ $data->is_required == 1 ? 'required' : '' }}>
                                                                        <option value="">{{ __('Select') . ' ' . $data->name }}</option>
                                                                        @foreach ($data->default_values as $option)
                                                                            <option value="{{ $option }}">{{ $option }}</option>
                                                                        @endforeach
                                                                    </select>

                                                                                                    {{-- Radio Field --}}
                                                                @elseif($data->type == 'radio')
                                                                    <label class="d-block">{{$data->name}} @if($data->is_required)
                                                                        <span class="text-danger">*</span>
                                                                    @endif</label>
                                                                    <div class="">
                                                                        @if(count($data->default_values))
                                                                            @foreach ($data->default_values as $keyRadio => $value)
                                                                                <div class="form-check mr-2">
                                                                                    <label class="form-check-label">
                                                                                        <input type="radio" name="extra_fields[{{ $key }}][data]" value="{{ $value }}" class="radio-fields" id="{{ $data->type . '_' . $keyRadio }}" {{ $data->is_required == 1 ? 'required' : '' }}>
                                                                                        {{$value}}
                                                                                    </label>
                                                                                </div>
                                                                            @endforeach
                                                                        @endif
                                                                    </div>

                                                                    {{-- Checkbox Field --}}
                                                                @elseif($data->type == 'checkbox')
                                                                    <label class="d-block">{{$data->name}} @if($data->is_required)
                                                                        <span class="text-danger">*</span>
                                                                    @endif</label>
                                                                    @if(count($data->default_values))
                                                                        <div class="row col-lg-12 col-xl-6 col-md-12 col-sm-12">
                                                                            @foreach ($data->default_values as $chkKey => $value)
                                                                                <div class="mr-2 form-check">
                                                                                    <label class="form-check-label">
                                                                                        <input type="checkbox" name="extra_fields[{{ $key }}][data][]" value="{{ $value }}" class="form-check-input chkclass checkbox-fields" id="{{ $data->type . '_' . $chkKey }}" {{ $data->is_required == 1 ? 'required' : '' }}>
                                                                                        {{ $value }}

                                                                                    </label>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    @endif

                                                                    {{-- Textarea Field --}}
                                                                @elseif($data->type == 'textarea')
                                                                    <textarea name="extra_fields[{{ $key }}][data]" id="{{ $data->type . '_' . $key }}" class="form-control textarea-fields" placeholder="{{ $data->name }}" rows="3" {{ $data->is_required ? 'required' : '' }}></textarea>

                                                                    {{-- File Upload Field --}}
                                                                @elseif($data->type == 'file')
                                                                    <div class="input-group col-xs-12">
                                                                        <input type="file" name="extra_fields[{{ $key }}][data]" class="file-upload-default" id="{{ $data->type . '_' . $key }}" {{ $data->is_required ? 'required' : '' }}>
                                                                        <input type="text" class="form-control file-upload-info" disabled placeholder="{{ __('image') }}">
                                                                        <span class="input-group-append">
                                                                            <button class="file-upload-browse btn btn-theme"
                                                                                type="button">{{ __('upload') }}</button>
                                                                        </span>
                                                                    </div>
                                                                    <div id="file_div_{{$key}}" class="mt-2 d-none file-div">
                                                                        <a href="" id="file_link_{{$key}}"
                                                                            target="_blank">{{$data->name}}</a>
                                                                    </div>

                                                                @endif
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @endHasFeature

                                                <div class="col-sm-12 col-md-12 mb-3">
                                                    <hr>
                                                </div>

                                                {{-- allowances --}}
                                                <div class="form-group col-sm-12 col-md-6">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <h4 class="mb-0 mr-3">{{ __('allowances') }}</h4>
                                                        <button type="button"
                                                            class="btn btn-inverse-primary btn-sm btn-icon create-payroll-setting"
                                                            data-type="allowance" title="Create New Allowance">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>

                                                    <div class="form-group col-md-12 col-sm-12 allowance-div">
                                                        <div data-repeater-list="allowance_data">
                                                            <div class="row allowance_type_div" id="allowance_type_div"
                                                                data-repeater-item>
                                                                <div class="form-group col-xl-4">
                                                                    <label>{{ __('allowance_type') }} </label>
                                                                    <select id="allowance_id" name="allowance[0][id]"
                                                                        class="form-control allowance_id">
                                                                        <option value="">--{{ __('select') }}--</option>
                                                                        @foreach ($allowances as $allowance)
                                                                            <option value="{{ $allowance->id }}"
                                                                                data-value="{{ (isset($allowance->amount)) ? $allowance->amount : $allowance->percentage }}"
                                                                                data-type="{{ (isset($allowance->amount)) ? 'amount' : 'percentage' }}">
                                                                                {{ $allowance->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-xl-4" id="amount_allowance_div"
                                                                    style="display: none">
                                                                    <label>{{ __('amount') }} <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="number" id="allowance_amount"
                                                                        name="allowance[0][amount]"
                                                                        class="allowance_amount form-control"
                                                                        placeholder="{{ __('amount') }}" min="1" required>
                                                                </div>

                                                                <div class="form-group col-xl-4"
                                                                    id="percentage_allowance_div" style="display: none">
                                                                    <label>{{ __('percentage') }} <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="number" id="allowance_percentage"
                                                                        name="allowance[0][percentage]"
                                                                        class="allowance_percentage form-control"
                                                                        placeholder="{{ __('percentage') }}" min="0.1"
                                                                        max="100" required>
                                                                </div>

                                                                <div class="form-group col-xl-1 mt-4">
                                                                    <button type="button"
                                                                        class="btn btn-inverse-danger btn-icon remove-allowance-div"
                                                                        data-repeater-delete>
                                                                        <i class="fa fa-times"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="form-group col-sm-12 mt-4">
                                                        <button type="button"
                                                            class="btn btn-inverse-success add-allowance-div"
                                                            data-repeater-create>
                                                            <i class="fa fa-plus"></i> {{ __('add_new_allowances') }}
                                                        </button>
                                                    </div>
                                                </div>


                                                {{-- deductions --}}

                                                <div class="form-group col-sm-12 col-md-6">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <h4 class="mb-0 mr-3">{{ __('deductions') }}</h4>
                                                        <button type="button"
                                                            class="btn btn-inverse-primary btn-sm btn-icon create-payroll-setting"
                                                            data-type="deduction" title="Create New Deduction">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>

                                                    <div class="form-group col-sm-12 deduction-div">
                                                        <div data-repeater-list="deduction_data">
                                                            <div class="row deduction_type_div" id="deduction_type_div"
                                                                data-repeater-item>
                                                                <div class="form-group col-xl-4">
                                                                    <label>{{ __('deduction_type') }} </label>
                                                                    <select id="deduction_id" name="deduction[0][id]"
                                                                        class="form-control deduction_id">
                                                                        <option value="">--{{ __('select') }}--</option>
                                                                        @foreach ($deductions as $deduction)
                                                                            <option value="{{ $deduction->id }}"
                                                                                data-value="{{ (isset($deduction->amount)) ? $deduction->amount : $deduction->percentage }}"
                                                                                data-type="{{ (isset($deduction->amount)) ? 'amount' : 'percentage' }}">
                                                                                {{ $deduction->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-xl-4" id="amount_deduction_div"
                                                                    style="display: none">
                                                                    <label>{{ __('amount') }} <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text" id="deduction_amount"
                                                                        name="deduction[0][amount]"
                                                                        class="deduction_amount form-control"
                                                                        placeholder="{{ __('amount') }}" required>
                                                                </div>

                                                                <div class="form-group col-xl-4"
                                                                    id="percentage_deduction_div" style="display: none">
                                                                    <label>{{ __('percentage') }} <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text" id="deduction_percentage"
                                                                        name="deduction[0][percentage]"
                                                                        class="deduction_percentage form-control"
                                                                        placeholder="{{ __('percentage') }}" required>
                                                                </div>

                                                                <div class="form-group col-xl-1 mt-4">
                                                                    <button type="button"
                                                                        class="btn btn-inverse-danger btn-icon remove-deduction-div"
                                                                        data-repeater-delete>
                                                                        <i class="fa fa-times"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="form-group col-sm-12 mt-4">
                                                        <button type="button"
                                                            class="btn btn-inverse-success add-deduction-div"
                                                            data-repeater-create>
                                                            <i class="fa fa-plus"></i> {{ __('add_new_deduction') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">{{ __('Close') }}</button>
                                            <input class="btn btn-theme" id="create-btn" type="submit" value={{ __('submit') }}>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="toolbar">
                            <div class="form-group col-12 d-flex">
                                <button id="update-status" class="btn btn-secondary" disabled><span
                                        class="update-status-btn-name">{{ __('Inactive') }}</span></button>
                            </div>
                        </div>

                        <div class="col-12 mt-4 text-right">
                            <b><a href="#" class="table-list-type active mr-2" data-id="0">{{__('active')}}</a></b> | <a
                                href="#" class="ml-2 table-list-type" data-id="1">{{__("Inactive")}}</a>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <table aria-describedby="mydesc" class='table' id='table_list' data-toggle="table"
                                    data-url="{{ route('teachers.show', [1]) }}" data-click-to-select="true"
                                    data-side-pagination="server" data-pagination="true"
                                    data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-toolbar="#toolbar"
                                    data-show-columns="true" data-show-refresh="true" data-trim-on-search="false"
                                    data-mobile-responsive="true" data-sort-name="id" data-sort-order="desc"
                                    data-maintain-selected="true" data-export-data-type='all' data-show-export="true"
                                    data-export-options='{ "fileName": "teacher-list-<?= date('d-m-y') ?>" ,"ignoreColumn":["operate"]}'
                                    data-query-params="activeDeactiveQueryParams" data-escape="true">
                                    <thead>
                                        <tr>
                                            <th data-field="state" data-checkbox="true"></th>
                                            <th scope="col" data-field="id" data-sortable="true" data-visible="false">
                                                {{ __('id') }}</th>
                                            <th scope="col" data-field="no">{{ __('no.') }}</th>
                                            <th scope="col" data-field="user.full_name"
                                                data-formatter="TeacherNameFormatter">{{ __('name') }}</th>
                                            <th scope="col" data-field="gender">{{ __('gender') }}</th>
                                            <th scope="col" data-field="mobile">{{ __('mobile') }}</th>
                                            <th scope="col" data-field="dob" data-visible="false">{{ __('dob') }}</th>
                                            <th scope="col" data-field="staff.qualification">{{ __('qualification') }}</th>
                                            <th scope="col" data-field="current_address">{{ __('current_address') }}</th>
                                            <th scope="col" data-field="permanent_address">{{ __('permanent_address') }}
                                            </th>
                                            <th scope="col" data-field="staff.salary" data-visible="false">
                                                {{ __('Salary') }}</th>
                                            <th data-events="teacherEvents" scope="col"
                                                data-formatter="actionColumnFormatter" data-field="operate"
                                                data-escape="false">{{ __('action') }}</th>
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


    <div class="modal fade" id="editModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('edit_teacher') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close"></i></span>
                    </button>
                </div>
                <form id="editdata" class="edit-form" action="{{ url('teachers') }}" novalidate="novalidate"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-12 col-lg-4">
                                <label>{{ __('email') }} <span class="text-danger">*</span></label>
                                <input type="text" name="email" id="email" class="form-control" placeholder="{{ __('email') }}" required>
                            </div>
                            <div class="form-group col-sm-12 col-md-12 col-lg-4">
                                <label>{{ __('first_name') }} <span class="text-danger">*</span></label>
                                <input type="text" name="first_name" id="first_name" class="form-control" placeholder="{{ __('first_name') }}" required>
                            </div>
                            <div class="form-group col-sm-12 col-md-12 col-lg-4">
                                <label>{{ __('last_name') }} <span class="text-danger">*</span></label>
                                <input type="text" name="last_name" id="last_name" class="form-control" placeholder="{{ __('last_name') }}" required>
                            </div>
                            <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                <label>{{ __('gender') }} <span class="text-danger">*</span></label>
                                <div class="d-flex">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" name="gender" value="male" class="form-check-input edit" id="gender-male">
                                            {{ __('male') }}
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" name="gender" value="female" class="form-check-input edit" id="gender-female">
                                            {{ __('female') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-sm-12 col-md-12 col-lg-4">
                                <label>{{ __('mobile') }} <span class="text-danger">*</span></label>
                                <input type="number" name="mobile" id="mobile" class="form-control remove-number-increment" placeholder="{{ __('mobile') }}" required min="1">
                            </div>

                            <div class="form-group col-sm-12 col-md-12 col-lg-4">
                                <label>{{ __('dob') }} <span class="text-danger">*</span></label>
                                <input type="text" name="dob" id="edit-dob" class="datepicker-popup-no-future form-control" placeholder="{{ __('dob') }}" required>
                                <span class="input-group-addon input-group-append"></span>
                            </div>
                            <div class="form-group col-sm-12 col-md-12 col-lg-4">
                                <label for="edit-image">{{ __('image') }} <span
                                        class="text-info text-small">(308px*338px)</span></label><br>
                                {{-- <input type="file" name="image" id="edit_image" class="form-control"
                                    placeholder="{{__('image')}}"> --}}
                                <input type="file" name="image" class="file-upload-default"
                                    accept="image/png,image/jpeg,image/jpg" />
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" id="edit-image" disabled=""
                                        placeholder="{{ __('image') }}" />
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-theme"
                                            type="button">{{ __('upload') }}</button>
                                    </span>
                                </div>
                                <div style="width: 60px;" class="mt-2">
                                    <img src="" id="edit-teacher-image-tag" class="img-fluid w-100" alt="" />
                                </div>
                            </div>
                            <div class="form-group col-sm-12 col-md-12 col-lg-4">
                                <label>{{ __('qualification') }} <span class="text-danger">*</span></label>
                                <textarea name="qualification" id="qualification" class="form-control" placeholder="{{ __('qualification') }}" required rows="3"></textarea>
                            </div>
                            <div class="form-group col-sm-12 col-md-12 col-lg-4">
                                <label>{{ __('current_address') }} <span class="text-danger">*</span></label>
                                <textarea name="current_address" id="edit_current_address" class="form-control" placeholder="{{ __('current_address') }}" required rows="3"></textarea>
                            </div>
                            <div class="form-group col-sm-12 col-md-12 col-lg-4">
                                <label>{{ __('permanent_address') }} <span class="text-danger">*</span></label>
                                <div class="form-check mb-2">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" id="edit_same_as_current_address">
                                        {{ __('Same as current address') }}
                                    </label>
                                </div>
                                <textarea name="permanent_address" id="edit_permanent_address" class="form-control" placeholder="{{ __('permanent_address') }}" required rows="3"></textarea>
                            </div>
                            <div class="form-group col-sm-12 col-md-4">
                                <label for="edit_salary">{{__('Salary') }} <span class="text-danger">*</span></label>
                                <input type="number" name="salary" min="0" id="edit_salary" placeholder="{{__('Salary')}}"
                                    class="form-control" required>
                            </div>

                            <div class="form-group col-sm-12 col-md-4">
                                <label for="joining_date">{{ __('joining_date') }}</label>
                                <input type="text" name="joining_date" id="edit_joining_date" class="datepicker-popup form-control" placeholder="{{ __('joining_date') }}" autocomplete="off">
                            </div>

                            @if(!empty($extraFields))

                                {{-- Loop the FormData --}}
                                @foreach ($extraFields as $key => $data)
                                    @php $fieldName = str_replace(' ', '_', $data->name) @endphp
                                    {{-- Edit Extra Details ID --}}
                                    <input type="hidden" name="extra_fields[{{ $key }}][id]" id="{{ $fieldName }}_id" value="">

                                    {{-- Form Field ID --}}
                                    <input type="hidden" name="extra_fields[{{ $key }}][form_field_id]" value="{{ $data->id }}">

                                    {{-- FormFieldType --}}
                                    <input type="hidden" name="extra_fields[{{ $key }}][input_type]" value="{{ $data->type }}">

                                    <div class='form-group col-md-12 col-lg-6 col-xl-4 col-sm-12'>

                                        {{-- Add lable to all the elements excluding checkbox --}}
                                        @if($data->type != 'radio' && $data->type != 'checkbox')
                                            <label>{{$data->name}} @if($data->is_required)
                                                <span class="text-danger">*</span>
                                            @endif</label>
                                        @endif

                                        {{-- Text Field --}}
                                        @if($data->type == 'text')
                                            <input type="text" name="extra_fields[{{ $key }}][data]" class="form-control text-fields" id="{{ $fieldName }}" placeholder="{{ $data->name }}" {{ $data->is_required == 1 ? 'required' : '' }}>
                                            {{-- Number Field --}}
                                        @elseif($data->type == 'number')
                                            <input type="number" name="extra_fields[{{ $key }}][data]" class="form-control number-fields" id="{{ $fieldName }}" placeholder="{{ $data->name }}" min="0" {{ $data->is_required == 1 ? 'required' : '' }}>

                                            {{-- Dropdown Field --}}
                                        @elseif($data->type == 'dropdown')
                                                            <select name="extra_fields[{{ $key }}][data]" id="{{ $fieldName }}" class="form-control select-fields" {{ $data->is_required == 1 ? 'required' : '' }}>
                                                <option value="">{{ __('Select') . ' ' . $data->name }}</option>
                                                @foreach ($data->default_values as $option)
                                                    <option value="{{ $option }}">{{ $option }}</option>
                                                @endforeach
                                            </select>

                                                            {{-- Radio Field --}}
                                        @elseif($data->type == 'radio')
                                            <label class="d-block">{{$data->name}} @if($data->is_required)
                                                <span class="text-danger">*</span>
                                            @endif</label>
                                            <div class="row form-check-inline ml-1">
                                                @foreach ($data->default_values as $keyRadio => $value)
                                                    <div class="col-md-12 col-lg-12 col-xl-6 col-sm-12 form-check">
                                                        <label class="form-check-label">
                                                            <input type="radio" name="extra_fields[{{ $key }}][data]" value="{{ $value }}" class="radio-fields" id="{{ $fieldName . '_' . $keyRadio }}" {{ $data->is_required == 1 ? 'required' : '' }}>
                                                            {{$value}}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>

                                            {{-- Checkbox Field --}}
                                        @elseif($data->type == 'checkbox')
                                            <label class="d-block">{{$data->name}} @if($data->is_required)
                                                <span class="text-danger">*</span>
                                            @endif</label>
                                            <div class="row form-check-inline ml-1">
                                                @foreach ($data->default_values as $chkKey => $value)
                                                    <div class="col-lg-12 col-xl-6 col-md-12 col-sm-12 form-check">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" name="extra_fields[{{ $key }}][data][]" value="{{ $value }}" class="form-check-input chkclass checkbox-fields" id="{{ $fieldName . '_' . $chkKey }}" {{ $data->is_required == 1 ? 'required' : '' }}>
                                                            {{ $value }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>

                                            {{-- Textarea Field --}}
                                        @elseif($data->type == 'textarea')
                                            <textarea name="extra_fields[{{ $key }}][data]" id="{{ $fieldName }}" class="form-control textarea-fields" placeholder="{{ $data->name }}" rows="3" {{ $data->is_required ? 'required' : '' }}></textarea>

                                            {{-- File Upload Field --}}
                                        @elseif($data->type == 'file')
                                            <div class="input-group col-xs-12">
                                                <input type="file" name="extra_fields[{{ $key }}][data]" class="file-upload-default" id="{{ $fieldName }}">
                                                <input type="text" class="form-control file-upload-info" disabled placeholder="{{ __('image') }}">
                                                <span class="input-group-append">
                                                    <button class="file-upload-browse btn btn-theme"
                                                        type="button">{{ __('upload') }}</button>
                                                </span>
                                            </div>
                                            <div id="file_div_{{$fieldName}}" class="mt-2 d-none file-div">
                                                <a href="" id="file_link_{{$fieldName}}" target="_blank">{{$data->name}}</a>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @endif

                        </div>

                        <div class="row">

                        </div>

                        <div class="row">
                            <div class="form-group col-sm-12 col-md-4">
                                <div class="d-flex">
                                    <div class="form-check w-fit-content">
                                        <label class="form-check-label ml-4">
                                            <input type="checkbox" class="form-check-input" name="reset_password"
                                                value="1">{{ __('reset_password') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-sm-12 col-md-4">
                                <div class="d-flex">
                                    <div class="form-check w-fit-content">
                                        <label class="form-check-label ml-4">
                                            <input type="checkbox" class="form-check-input" id="two_factor_verification"
                                                name="two_factor_verification" value="0">
                                            {{ __('two_factor_verification') }}
                                        </label>
                                    </div>
                                </div>
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
    <!-- Create Payroll Setting Modal -->
        <div class="modal fade" id="payrollSettingModal" tabindex="-1" role="dialog" aria-labelledby="payrollSettingModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="payrollSettingModalLabel">{{ __('Create New') }} <span id="setting_type_label"></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="payroll-setting-form" action="{{ route('payroll-setting.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" id="setting_type">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>{{ __('name') }} <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" required placeholder="{{ __('name') }}">
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label>{{ __('amount') }}</label>
                                    <input type="number" name="amount" class="form-control" placeholder="{{ __('amount') }}">
                                </div>
                                <div class="form-group col-6">
                                    <label>{{ __('percentage') }}</label>
                                    <input type="number" name="percentage" class="form-control" placeholder="{{ __('percentage') }}" max="100">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                            <button type="submit" class="btn btn-theme">{{ __('submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection
@section('script')
    <script>
        let userIds;
        $('.table-list-type').on('click', function (e) {
            let value = $(this).data('id');
            let ActiveLang = window.trans['Active'];
            let DeactiveLang = window.trans['Inactive'];
            if (value === "" || value === 0 || value == null) {
                $("#update-status").data("id")
                $('.update-status-btn-name').html(DeactiveLang);
            } else {
                $('.update-status-btn-name').html(ActiveLang);
            }
        })

        $(document).ready(function() {
            // Same as current address logic
            $('#same_as_current_address').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#permanent_address').val($('#current_address').val());
                    $('#permanent_address').attr('readonly', true);
                } else {
                    $('#permanent_address').attr('readonly', false);
                }
            });

            $('#current_address').on('input', function() {
                if ($('#same_as_current_address').is(':checked')) {
                    $('#permanent_address').val($(this).val());
                }
            });

            // Edit Modal address logic
            $('#edit_same_as_current_address').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#edit_permanent_address').val($('#edit_current_address').val());
                    $('#edit_permanent_address').attr('readonly', true);
                } else {
                    $('#edit_permanent_address').attr('readonly', false);
                }
            });

            $('#edit_current_address').on('input', function() {
                if ($('#edit_same_as_current_address').is(':checked')) {
                    $('#edit_permanent_address').val($(this).val());
                }
            });

            // Handle creating new payroll settings
            $('.create-payroll-setting').on('click', function() {
                let type = $(this).data('type');
                $('#setting_type').val(type);
                $('#setting_type_label').text(type.charAt(0).toUpperCase() + type.slice(1));
                $('#payrollSettingModal').modal('show');
            });

            $('#payroll-setting-form').on('submit', function(e) {
                e.preventDefault();
                let form = $(this);
                let url = form.attr('action');
                let formData = form.serialize();

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (!response.error) {
                            showSuccessToast(response.message);
                            $('#payrollSettingModal').modal('hide');
                            form[0].reset();

                            // Refresh lists or add to dropdown
                            // For simplicity, let's just append the new option to all relevant selects
                            let type = $('#setting_type').val();
                            let newOption = `<option value="${response.data.id}" data-value="${response.data.amount || response.data.percentage}" data-type="${response.data.amount ? 'amount' : 'percentage'}">${response.data.name}</option>`;

                            if (type === 'allowance') {
                                $('.allowance_id').append(newOption);
                            } else {
                                $('.deduction_id').append(newOption);
                            }
                        } else {
                            showErrorToast(response.message);
                        }
                    },
                    error: function(xhr) {
                        showErrorToast(xhr.responseJSON.message || 'Something went wrong');
                    }
                });
            });
        });


        function updateUserStatus(tableId, buttonClass) {
            var selectedRows = $(tableId).bootstrapTable('getSelections');
            var selectedRowsValues = selectedRows.map(function (row) {
                return row.id;
            });
            userIds = JSON.stringify(selectedRowsValues);

            if (buttonClass != null) {
                if (selectedRowsValues.length) {
                    $(buttonClass).prop('disabled', false);
                } else {
                    $(buttonClass).prop('disabled', true);
                }
            }
        }

        $('#table_list').bootstrapTable({
            onCheck: function (row) {
                updateUserStatus("#table_list", '#update-status');
            },
            onUncheck: function (row) {
                updateUserStatus("#table_list", '#update-status');
            },
            onCheckAll: function (rows) {
                updateUserStatus("#table_list", '#update-status');
            },
            onUncheckAll: function (rows) {
                updateUserStatus("#table_list", '#update-status');
            }
        });
        $("#update-status").on('click', function (e) {
            Swal.fire({
                title: window.trans["Are you sure"],
                text: window.trans["Change Status For Selected Users"],
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: window.trans["Yes, Change it"],
                cancelButtonText: window.trans["Cancel"]
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = baseUrl + '/teachers/change-status-bulk';
                    let data = new FormData();
                    data.append("ids", userIds)

                    function successCallback(response) {
                        $('#table_list').bootstrapTable('refresh');
                        $('#update-status').prop('disabled', true);
                        userIds = null;
                        showSuccessToast(response.message);
                    }

                    function errorCallback(response) {
                        showErrorToast(response.message);
                    }

                    ajaxRequest('POST', url, data, null, successCallback, errorCallback);
                }
            })
        })
    </script>
    <script type="text/javascript">

        document.addEventListener('DOMContentLoaded', function() {
            let allowanceCounter = 1; // Initialize a counter for new allowance rows

            // Function to toggle visibility of amount and percentage fields
            function toggleAllowanceFields(allowanceTypeElement) {
                const selectedOption = allowanceTypeElement.options[allowanceTypeElement.selectedIndex];
                const allowanceType = selectedOption.getAttribute('data-type');
                const allowanceValue = selectedOption.getAttribute('data-value');
                const allowanceDiv = allowanceTypeElement.closest('.allowance_type_div');
                const amountDiv = allowanceDiv.querySelector('#amount_allowance_div');
                const percentageDiv = allowanceDiv.querySelector('#percentage_allowance_div');

                if (allowanceType === 'amount') {
                    percentageDiv.style.display = 'none';
                    amountDiv.style.display = 'block';
                    allowanceDiv.querySelector('.allowance_amount').value = allowanceValue;
                    allowanceDiv.querySelector('.allowance_percentage').value = '';
                } else if (allowanceType === 'percentage') {
                    amountDiv.style.display = 'none';
                    percentageDiv.style.display = 'block';
                    allowanceDiv.querySelector('.allowance_amount').value = '';
                    allowanceDiv.querySelector('.allowance_percentage').value = allowanceValue;
                } else {
                    amountDiv.style.display = 'none';
                    percentageDiv.style.display = 'none';
                }
            }

            // Attach change event listener to the initial allowance type dropdown
            document.querySelectorAll('.allowance_id').forEach(function(element) {
                element.addEventListener('change', function() {
                    toggleAllowanceFields(element);
                });
            });

            // Repeater functionality to handle adding new allowance rows
            const addAllowanceButton = document.querySelector('.add-allowance-div');
            const allowanceDataContainer = document.querySelector('[data-repeater-list="allowance_data"]');

            addAllowanceButton.addEventListener('click', function() {
                const newItem = allowanceDataContainer.querySelector('[data-repeater-item]').cloneNode(true);

                // Clear input values
                allowanceDataContainer.querySelector('#allowance_type_div').style.display = '';
                newItem.querySelectorAll('input').forEach(input => input.value = '');
                newItem.querySelector('.allowance_id').value = '';
                newItem.querySelector('#amount_allowance_div').style.display = 'none';
                newItem.querySelector('#percentage_allowance_div').style.display = 'none';

                // Update the name attributes
                newItem.querySelectorAll('[name]').forEach(input => {
                    const name = input.getAttribute('name');
                    const newName = name.replace(/\[\d+\]/, `[${allowanceCounter}]`);
                    input.setAttribute('name', newName);
                });

                // Increment the counter
                allowanceCounter++;

                // Add event listeners to new elements
                newItem.querySelector('.allowance_id').addEventListener('change', function() {
                    toggleAllowanceFields(newItem.querySelector('.allowance_id'));
                });
                newItem.querySelector('.remove-allowance-div').addEventListener('click', function() {
                    newItem.remove();
                });

                allowanceDataContainer.appendChild(newItem);
            });

            // Attach click event listener to the initial remove button
            document.querySelectorAll('.remove-allowance-div').forEach(function(button) {
                button.addEventListener('click', function() {
                    // button.closest('[data-repeater-item]').remove();
                    button.closest('[data-repeater-item]').style.display = 'none';
                });
            });
        });


        document.addEventListener('DOMContentLoaded', function() {
            let deductionCounter = 1; // Initialize a counter for new deduction rows

            // Function to toggle visibility of amount and percentage fields
            function toggleDeductionFields(deductionTypeElement) {
                const selectedOption = deductionTypeElement.options[deductionTypeElement.selectedIndex];
                const deductionType = selectedOption.getAttribute('data-type');
                const deductionValue = selectedOption.getAttribute('data-value');
                const deductionDiv = deductionTypeElement.closest('.deduction_type_div');
                const amountDiv = deductionDiv.querySelector('#amount_deduction_div');
                const percentageDiv = deductionDiv.querySelector('#percentage_deduction_div');

                if (deductionType === 'amount') {
                    percentageDiv.style.display = 'none';
                    amountDiv.style.display = 'block';
                    deductionDiv.querySelector('.deduction_amount').value = deductionValue;
                    deductionDiv.querySelector('.deduction_percentage').value = '';
                } else if (deductionType === 'percentage') {
                    amountDiv.style.display = 'none';
                    percentageDiv.style.display = 'block';
                    deductionDiv.querySelector('.deduction_amount').value = '';
                    deductionDiv.querySelector('.deduction_percentage').value = deductionValue;
                } else {
                    amountDiv.style.display = 'none';
                    percentageDiv.style.display = 'none';
                }
            }

            // Attach change event listener to the initial deduction type dropdown
            document.querySelectorAll('.deduction_id').forEach(function(element) {
                element.addEventListener('change', function() {
                    toggleDeductionFields(element);
                });
            });

            // Repeater functionality to handle adding new deduction rows
            const addDeductionButton = document.querySelector('.add-deduction-div');
            const deductionDataContainer = document.querySelector('[data-repeater-list="deduction_data"]');

            addDeductionButton.addEventListener('click', function() {
                const newItem = deductionDataContainer.querySelector('[data-repeater-item]').cloneNode(true);

                deductionDataContainer.querySelector('#deduction_type_div').style.display = '';
                // Clear input values
                newItem.querySelectorAll('input').forEach(input => input.value = '');
                newItem.querySelector('.deduction_id').value = '';
                newItem.querySelector('#amount_deduction_div').style.display = 'none';
                newItem.querySelector('#percentage_deduction_div').style.display = 'none';

                // Update the name attributes
                newItem.querySelectorAll('[name]').forEach(input => {
                    const name = input.getAttribute('name');
                    const newName = name.replace(/\[\d+\]/, `[${deductionCounter}]`);
                    input.setAttribute('name', newName);
                });

                // Increment the counter
                deductionCounter++;

                // Add event listeners to new elements
                newItem.querySelector('.deduction_id').addEventListener('change', function() {
                    toggleDeductionFields(newItem.querySelector('.deduction_id'));
                });
                newItem.querySelector('.remove-deduction-div').addEventListener('click', function() {
                    newItem.remove();
                });

                deductionDataContainer.appendChild(newItem);
            });

            // Attach click event listener to the initial remove button
            document.querySelectorAll('.remove-deduction-div').forEach(function(button) {
                button.addEventListener('click', function() {
                    // button.closest('[data-repeater-item]').remove();
                    button.closest('[data-repeater-item]').style.display = 'none';
                });
            });
        });



    </script>
@endsection
