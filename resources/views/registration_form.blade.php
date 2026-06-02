<!-- Button trigger modal -->
{{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
    Launch static backdrop modal
</button> --}}
<div class="modal fade formModal" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-xl">
        <div class="modal-content row">
            <div class="col-12 rightSide">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ __('registration_form') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="school-registration" action="{{ url('schools/registration') }}" method="post">
                        @csrf
                        <div class="schoolFormWrapper">
                            <div class="headingWrapper">
                                <span>{{ __('create_school') }}</span>
                            </div>
                            <div class="formWrapper">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="inputWrapper">
                                            <label for="name">{{ __('name') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="school_name" id="name" placeholder="{{ __('enter_your_school_name') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="inputWrapper">
                                            <label for="supportEmail">{{ __('email') }} <span class="text-danger">*</span></label>
                                            <input type="email" name="school_email" id="support-email"
                                                placeholder="{{ __('enter_your_school_email') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="inputWrapper">
                                            <label for="supportPhone">{{ __('mobile') }} <span class="text-danger">*</span></label>
                                            <input type="text" oninput="this.value=this.value.replace(/[^0-9]/g,'');" name="school_phone" id="supportPhone"
                                                placeholder="{{ __('enter_your_school_mobile_number') }}" maxlength="15" pattern="[0-9]{6,15}" 
                                                title="Please enter a valid mobile number (6-15 digits)" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="inputWrapper">
                                            <label for="address">{{ __('address') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="school_address" id="address"
                                                placeholder="{{ __('enter_your_school_address') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="inputWrapper">
                                            <label for="tagline">{{ __('tagline') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="school_tagline" id="tagline" placeholder="{{ __('tagline') }}" required>
                                        </div>
                                    </div>
                                </div>
                                @if(isset($extraFields) && count($extraFields))     
                                    <div class="row other-details mt-3">

                                        {{-- Loop the FormData --}}
                                        @foreach ($extraFields as $key => $data)
                                            {{-- Edit Extra Details ID --}}
                                            <input type="hidden" name="extra_fields[{{ $key }}][id]" id="{{ $data->type . '_' . $key }}_id" value="">

                                            {{-- Form Field ID --}}
                                            <input type="hidden" name="extra_fields[{{ $key }}][form_field_id]" value="{{ $data->id }}" id="{{ $data->type . '_' . $key }}_id">

                                            <div class='form-group col-md-12 col-lg-6 col-xl-6 col-sm-12'>

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
                                                    <select name="extra_fields[{{ $key }}][data]" id="{{ $data->type . '_' . $key }}" class="form-control select-fields" 
                                                            {{ $data->is_required == 1 ? 'required' : '' }}>
                                                        <option value="" disabled selected>Select {{ $data->name }}</option>
                                                        @foreach($data->default_values as $optionKey => $optionValue)
                                                            <option value="{{ $optionKey }}">{{ $optionValue }}</option>
                                                        @endforeach
                                                    </select>

                                                    {{-- Radio Field --}}
                                                @elseif($data->type == 'radio')
                                                    <label class="d-block">{{$data->name}} @if($data->is_required)
                                                            <span class="text-danger">*</span>
                                                        @endif</label>
                                                    <div class="row col-md-12 col-lg-12 col-xl-6 col-sm-12">
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
                                                        <div class="row col-lg-12 col-xl-6 col-md-12 col-sm-12 checkbox-group">
                                                            @foreach ($data->default_values as $chkKey => $value)
                                                                <div class="mr-2 form-check">
                                                                    <label class="form-check-label group-required">
                                                                        <input type="checkbox" name="extra_fields[{{ $key }}][data][]" value="{{ $value }}" class="form-check-input chkclass checkbox-fields checkbox-group" id="{{ $data->type . '_' . $chkKey }}"> {{ $value }}

                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        @if($data->is_required)
                                                          <span class="text-danger d-none checkbox-error">{{ __('this field is required') }}</span>
                                                       @endif

                                                    @endif
                                             
                                                    {{-- Textarea Field --}}
                                                @elseif($data->type == 'textarea')
                                                    <textarea name="extra_fields[{{ $key }}][data]" id="{{ $data->type . '_' . $key }}" class="form-control textarea-fields" placeholder="{{ $data->name }}" rows="3" {{ $data->is_required ? 'required' : '' }}></textarea>

                                                    {{-- File Upload Field --}}
                                                @elseif($data->type == 'file')
                                                    <div class="input-group col-xs-12">
                                                        <input type="file" name="extra_fields[{{ $key }}][data]" class="file-upload-default form-control" id="{{ $data->type . '_' . $key }}" style="opacity: 1; position: relative; z-index: 1;" {{ $data->is_required ? 'required' : '' }} aria-describedby="file-help-{{ $key }}">
                                                    </div>
                                                    <div id="file_div_{{$key}}" class="mt-2 d-none file-div">
                                                        <a href="" id="file_link_{{$key}}" target="_blank">{{$data->name}}</a>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="adminFormWrapper schoolFormWrapper">
                            <div class="formWrapper">
                                    @if ($trail_package)
                                    <div class="col-lg-6">
                                        
                                        <div class="" id="trialCheckboxContainer" style="display: none;">
                                            <input type="checkbox" name="trial_package" value="{{ $trail_package }}" class="m-1">
                                            {{ __('start_trial_package') }}
                                        </div>
                                        
                                    </div>    
                                    @endif

                                    {{-- @if (config('services.recaptcha.key') ?? '')
                                        <div class="col-lg-12">
                                            <div class="g-recaptcha mt-4" data-sitekey={{config('services.recaptcha.key')}}></div>
                                        </div>    
                                    @endif --}}
                                    
                                    
                                    <div class="col-12 modalfooter">

                                        <div class="inputWrapper">
                                            
                                        </div>
                                        <div>
                                            <input type="submit" class="commonBtn" value="{{ __('submit') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
