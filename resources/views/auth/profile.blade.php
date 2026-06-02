@extends('layouts.master')

@section('title')
    {{ __('profile') }}
@endsection


@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ __('profile') }}
            </h3>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form class="pt-3 profile-update-form edit-form-without-reset" id="edit-form"
                            enctype="multipart/form-data" action="{{ route('auth.profile.update') }}"
                            novalidate="novalidate">
                            @csrf
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-4">
                                    <label>{{ __('first_name') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="first_name" value="{{ $userData->first_name }}"
                                        class="form-control" placeholder="{{ __('first_name') }}" required>
                                </div>
                                <div class="form-group col-sm-12 col-md-4">
                                    <label>{{ __('last_name') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="last_name" value="{{ $userData->last_name }}"
                                        class="form-control" placeholder="{{ __('last_name') }}" required>

                                </div>
                                <div class="form-group col-sm-12 col-md-4">
                                    <label>{{ __('mobile') }}</label>
                                    <input type="number" name="mobile" value="{{ $userData->mobile }}"
                                        class="form-control remove-number-increment" placeholder="{{ __('mobile') }}">
                                </div>
                                <div class="form-group col-sm-12 col-md-12">
                                    <label>{{ __('gender') }} <span class="text-danger">*</span></label><br>
                                    <div class="d-flex">
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" name="gender" value="male" {{ Str::lower($userData->gender) == 'male' ? 'checked' : '' }}>
                                                {{ __('male') }}
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" name="gender" value="female" {{ Str::lower($userData->gender) == 'female' ? 'checked' : '' }}>
                                                {{ __('female') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-12 col-md-4">
                                    <label for="image">{{ __('image') }}</label>
                                    <input type="file" name="image" accept="image/jpg,image/png,image/jpeg"
                                        class="file-upload-default" />
                                    <div class="input-group col-xs-12">
                                        <input type="text" id="image" class="form-control file-upload-info" disabled=""
                                            placeholder="{{ __('image') }}" required="required" />
                                        <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-theme"
                                                type="button">{{ __('upload') }}</button>
                                        </span>
                                    </div>
                                    <div style="width: 40px;">
                                        <img src="{{$userData->image}}" id="edit-user-image-tag" class="img-fluid w-100"
                                            alt="" />
                                    </div>
                                </div>
                                <div class="form-group col-sm-12 col-md-4">
                                    <label>{{ __('dob') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="dob" value="{{ date('d-m-Y', strtotime($userData->dob)) }}"
                                        class="datepicker-popup-no-future form-control" placeholder="{{ __('dob') }}"
                                        required>
                                    <span class="input-group-addon input-group-append"></span>
                                </div>
                                <div class="form-group col-sm-12 col-md-4">
                                    <label>{{ __('email') }} <span class="text-danger">*</span></label>
                                    <input type="email" name="email" value="{{ $userData->email }}" class="form-control"
                                        placeholder="{{ __('email') }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label>{{ __('current_address') }} <span class="text-danger">*</span></label>
                                    <textarea name="current_address" id="current_address" class="form-control"
                                        placeholder="{{ __('current_address') }}" rows="2"
                                        required>{{ $userData->current_address }}</textarea>
                                </div>
                                <div class="form-group col-6">
                                    <label>{{ __('permanent_address') }} <span class="text-danger">*</span></label>
                                    <textarea name="permanent_address" id="permanent_address" class="form-control"
                                        placeholder="{{ __('permanent_address') }}" rows="2"
                                        required>{{ $userData->permanent_address }}</textarea>
                                </div>
                            </div>
                            <div class="row">
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


                            <input class="btn btn-theme" type="submit" value={{ __('submit') }}>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            @if($userData->dob)
                $('.dob').val(moment("{{ $userData->dob }}", 'YYYY-MM-DD').format('DD-MM-YYYY'))
            @endif

            // two factor verification
            if ({{ $userData->two_factor_enabled }} == 1) {
                $('#two_factor_verification').prop('checked', true);
                $('#two_factor_verification').val(1);
            } else {
                $('#two_factor_verification').prop('checked', false);
                $('#two_factor_verification').val(0);
            }

            $('.profile-update-form').on('submit', function (e) {
                e.preventDefault();
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            });
        });
    </script>
@endsection