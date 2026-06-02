@extends('layouts.master')

@section('title')
    {{ __('edit') . ' ' . __('school') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ __('edit') . ' ' . __('school') }}
            </h3>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form class="edit-form school-registration-form" action="{{ route('schools.update', $school->id) }}"
                            method="POST" enctype="multipart/form-data" novalidate="novalidate">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="edit_id" value="{{ $school->id }}">

                            <div class="bg-light p-4 mt-4 mb-4">
                                <h4 class="card-title mb-4">
                                    {{ __('school') . ' ' . __('details') }}
                                </h4>
                                <div class="row">
                                    <div class="form-group col-sm-12 col-md-6">
                                        <label for="edit_school_name">{{ __('name') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="edit_school_name" id="edit_school_name"
                                            value="{{ $school->name }}" placeholder="{{ __('schools') }}"
                                            class="form-control" required>
                                    </div>
                                    <div class="form-group col-sm-12 col-md-6">
                                        <label>{{ __('logo') }}</label>
                                        <input type="file" name="edit_school_image" id="edit_school_image"
                                            class="file-upload-default"
                                            accept="image/png, image/jpg, image/jpeg, image/svg+xml" />
                                        <div class="input-group col-xs-12">
                                            <input type="text" class="form-control file-upload-info" disabled=""
                                                placeholder="{{ __('logo') }}" aria-label="" />
                                            <span class="input-group-append">
                                                <button class="file-upload-browse btn btn-theme"
                                                    type="button">{{ __('upload') }}</button>
                                            </span>
                                        </div>
                                        <div style="width: 100px; margin-top: 10px;">
                                            <img src="{{ $school->logo }}" id="edit-school-logo-tag" class="img-fluid w-100"
                                                alt="{{ $school->name }}" />
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-12 col-md-6">
                                        <label for="edit_school_support_email">{{ __('school') . ' ' . __('email') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="email" name="edit_school_support_email"
                                            id="edit_school_support_email" value="{{ $school->support_email }}"
                                            placeholder="{{ __('support') . ' ' . __('email') }}" class="form-control"
                                            required>
                                    </div>
                                    <div class="form-group col-sm-12 col-md-6">
                                        <label for="edit_school_support_phone">{{ __('school') . ' ' . __('phone') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="number" name="edit_school_support_phone"
                                            id="edit_school_support_phone" value="{{ $school->support_phone }}"
                                            placeholder="{{ __('support') . ' ' . __('phone') }}"
                                            class="form-control remove-number-increment" required>
                                    </div>
                                    
                                     <div class="form-group col-sm-12 col-md-6">
                                        <label for="assign_package">{{ __('assign_package')}} </label>
                                        <select name="assign_package" id="assign_package" class="form-control">
                                            <option value="">{{ __('select_package') }}</option>
                                            @foreach($packages as $id => $name)
                                                <option value="{{ $id }}" {{ $id == $currentPackageId ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-12 col-md-6">
                                        <label for="school_code">{{ __('school_code') }} </label>
                                        <input type="text" name="code" disabled id="school_code"
                                            value="{{ $school->code }}" placeholder="{{ __('school_code') }}"
                                            class="form-control" required>
                                    </div>

                                    <div class="form-group col-sm-12 col-md-6">
                                        <label for="edit_school_tagline">{{ __('tagline') }} <span
                                                class="text-danger">*</span></label>
                                        <textarea name="edit_school_tagline" id="edit_school_tagline" cols="30" rows="3" class="form-control"
                                            placeholder="{{ __('tagline') }}" required>{{ $school->tagline }}</textarea>
                                    </div>
                                    <div class="form-group col-sm-12 col-md-6">
                                        <label for="edit_school_address">{{ __('address') }} <span
                                                class="text-danger">*</span></label>
                                        <textarea name="edit_school_address" id="edit_school_address" cols="30" rows="3" class="form-control"
                                            placeholder="{{ __('address') }}" required>{{ $school->address }}</textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-12 col-md-12 col-lg-6 col-xl-4">
                                        <label>{{ __('domain') . ' ' . __('type') }} <span
                                                class="text-danger">*</span></label><br>
                                         <div class="d-flex">
                                             <div class="form-check form-check-inline">
                                                 <label class="form-check-label">
                                                     <input type="radio" name="edit_domain_type" value="default" class="edit_default" {{ $school->domain_type == 'default' ? 'checked' : '' }}>
                                                     {{ __('default') }}
                                                 </label>
                                             </div>
                                             <div class="form-check form-check-inline">
                                                 <label class="form-check-label">
                                                     <input type="radio" name="edit_domain_type" value="custom" class="edit_custom" {{ $school->domain_type == 'custom' ? 'checked' : '' }}>
                                                     {{ __('custom') }}
                                                 </label>
                                             </div>
                                         </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-12 col-md-4 defaultDomain"
                                        style="{{ $school->domain_type == 'default' ? '' : 'display: none' }}">
                                        <label for="edit_default_domain">{{ __('default_domain') }}</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control domain-pattern"
                                                id="edit_default_domain" name="edit_domain"
                                                value="{{ $school->domain_type == 'default' ? $school->domain : '' }}"
                                                placeholder="{{ __('domain') }}" aria-label="Recipient's username"
                                                aria-describedby="basic-addon2"
                                                {{ $school->domain_type == 'default' ? '' : 'disabled' }}>
                                            <div class="input-group-append">
                                                <span class="input-group-text text-body"
                                                    id="basic-addon2">.{{ $baseUrlWithoutScheme }}</span>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <label>{{ __('url') }}: <a href="" target="_blank"
                                                    class="text-theme school_url"></a></label>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-12 col-md-4 customDomain"
                                        style="{{ $school->domain_type == 'custom' ? '' : 'display: none' }}">
                                        <label for="edit_custom_domain">{{ __('custom_domain') }}</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control domain-pattern"
                                                id="edit_custom_domain" name="edit_domain"
                                                value="{{ $school->domain_type == 'custom' ? $school->domain : '' }}"
                                                placeholder="{{ __('domain') }}" aria-label="Recipient's username"
                                                aria-describedby="basic-addon2"
                                                {{ $school->domain_type == 'custom' ? '' : 'disabled' }}>
                                        </div>
                                        <div class="mt-2">
                                            <label>{{ __('url') }}: <a href="" target="_blank"
                                                    class="text-theme school_url"></a></label>
                                        </div>
                                    </div>
                                </div>

                                @if (!empty($extraFields))
                                    <div class="row other-details">
                                        @foreach ($extraFields as $key => $data)
                                            @php
                                                $fieldName = str_replace(' ', '_', $data->name);
                                                $fieldData = $school->extra_school_details->where('form_field_id', $data->id)->first();
                                                $value = $fieldData ? $fieldData->data : '';
                                                if ($data->type == 'checkbox' && !empty($value)) {
                                                    $value = json_decode($value, true);
                                                }
                                            @endphp

                                             <input type="hidden" name="edit_extra_fields[{{ $key }}][id]" value="{{ $fieldData ? $fieldData->id : '' }}">
                                             <input type="hidden" name="edit_extra_fields[{{ $key }}][form_field_id]" value="{{ $data->id }}">
                                             <input type="hidden" name="edit_extra_fields[{{ $key }}][input_type]" value="{{ $data->type }}">

                                             <div class='form-group col-xl-4 col-lg-6 col-md-6 col-sm-12'>
                                                 @if ($data->type != 'radio' && $data->type != 'checkbox')
                                                     <label>{{ $data->name }} @if ($data->is_required)
                                                             <span class="text-danger">*</span>
                                                         @endif
                                                     </label>
                                                 @endif

                                                 @if ($data->type == 'text')
                                                     <input type="text" name="edit_extra_fields[{{ $key }}][data]" value="{{ $value }}" class="form-control text-fields" id="edit_{{ $fieldName }}" placeholder="{{ $data->name }}" {{ $data->is_required == 1 ? 'required' : '' }}>
                                                 @elseif($data->type == 'number')
                                                     <input type="number" name="edit_extra_fields[{{ $key }}][data]" value="{{ $value }}" min="0" class="form-control number-fields" id="edit_{{ $fieldName }}" placeholder="{{ $data->name }}" {{ $data->is_required == 1 ? 'required' : '' }}>
                                                 @elseif($data->type == 'dropdown')
                                                     <select name="edit_extra_fields[{{ $key }}][data]" id="edit_{{ $fieldName }}" class="form-control select-fields" {{ $data->is_required == 1 ? 'required' : '' }}>
                                                         <option value="">Select {{ $data->name }}</option>
                                                         @foreach($data->default_values as $val)
                                                             <option value="{{ $val }}" {{ $val == $value ? 'selected' : '' }}>{{ $val }}</option>
                                                         @endforeach
                                                     </select>
                                                 @elseif($data->type == 'radio')
                                                     <label class="d-block">{{ $data->name }} @if ($data->is_required)
                                                             <span class="text-danger">*</span>
                                                         @endif
                                                     </label>
                                                     <div class="d-flex flex-wrap">
                                                         @foreach ($data->default_values as $keyRadio => $val)
                                                             <div class="form-check mr-3">
                                                                 <label class="form-check-label">
                                                                     <input type="radio" name="edit_extra_fields[{{ $key }}][data]" value="{{ $val }}" {{ $val == $value ? 'checked' : '' }} id="edit_{{ $fieldName . '_' . $keyRadio }}" class="radio-fields" {{ $data->is_required == 1 ? 'required' : '' }}>
                                                                     {{ $val }}
                                                                 </label>
                                                             </div>
                                                         @endforeach
                                                     </div>
                                                 @elseif($data->type == 'checkbox')
                                                     <label class="d-block">{{ $data->name }} @if ($data->is_required)
                                                             <span class="text-danger">*</span>
                                                         @endif
                                                     </label>
                                                     <div class="d-flex flex-wrap">
                                                         @foreach ($data->default_values as $chkKey => $val)
                                                             <div class="form-check mr-3">
                                                                 <label class="form-check-label">
                                                                     <input type="checkbox" name="edit_extra_fields[{{ $key }}][data][]" value="{{ $val }}" {{ is_array($value) && in_array($val, $value) ? 'checked' : '' }} id="edit_{{ $fieldName . '_' . $chkKey }}" class="form-check-input chkclass checkbox-fields" {{ $data->is_required == 1 ? 'required' : '' }}>
                                                                     {{ $val }}
                                                                 </label>
                                                             </div>
                                                         @endforeach
                                                     </div>
                                                 @elseif($data->type == 'textarea')
                                                     <textarea name="edit_extra_fields[{{ $key }}][data]" placeholder="{{ $data->name }}" id="edit_{{ $fieldName }}" class="form-control textarea-fields" {{ $data->is_required ? 'required' : '' }} rows="3">{{ $value }}</textarea>
                                                 @elseif($data->type == 'file')
                                                     <div class="input-group">
                                                         <input type="file" name="edit_extra_fields[{{ $key }}][data]" class="file-upload-default" id="edit_{{ $fieldName }}" {{ $data->is_required == 1 && empty($value) ? 'required' : '' }}>
                                                         <input type="text" value="" class="form-control file-upload-info" disabled placeholder="{{ __('image') }}">
                                                         <span class="input-group-append">
                                                             <button class="file-upload-browse btn btn-theme"
                                                                 type="button">{{ __('upload') }}</button>
                                                         </span>
                                                     </div>
                                                     @if ($value)
                                                         <div class="mt-2">
                                                             <a href="{{ Storage::url($value) }}" target="_blank">{{ __('View File') }}</a>
                                                         </div>
                                                     @endif
                                                 @endif
                                             </div>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="mt-4">
                                    <input class="btn btn-theme float-right ml-3" type="submit"
                                        value={{ __('save') }}>
                                    <a href="{{ route('schools.index') }}" class="btn btn-secondary float-right">{{ __('cancel') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            function updateFieldsAndURL() {
                const isDefault = $('.edit_default').is(':checked');
                $('.defaultDomain').toggle(isDefault).find('input').prop('disabled', !isDefault);
                $('.customDomain').toggle(!isDefault).find('input').prop('disabled', isDefault);

                const domain = isDefault ? $('#edit_default_domain').val() : $('#edit_custom_domain').val();
                let url = '';
                if(domain) {
                    url = 'http://' + (isDefault ? domain + '.{{ $baseUrlWithoutScheme }}' : domain);
                }
                
                // Update link
                if (!domain) {
                    $('.school_url').hide();
                } else {
                    $('.school_url').show().attr('href', url).text(url);
                }
            }

            $("input[name='edit_domain_type']").on('change', updateFieldsAndURL);
            
             // Also listen for input changes to update link in real-time
            $("#edit_default_domain, #edit_custom_domain").on('input', updateFieldsAndURL);

            // Initial check
            updateFieldsAndURL();
        });
    </script>
@endsection
