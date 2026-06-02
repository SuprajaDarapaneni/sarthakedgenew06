@extends('layouts.master')

@section('title')
    {{ __('Add New Listing') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ __('Add New Listing') }}
            </h3>
            <a href="{{ route('marketplace.index') }}"
                class="btn btn-secondary text-white">{{ __('Back to Marketplace') }}</a>
        </div>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('Product Details') }}</h4>
                        <p class="card-description">
                            {{ __('Fill in the details for the new product.') }}
                        </p>
                        <form class="forms-sample" action="{{ route('marketplace.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="title" class="col-sm-3 col-form-label">{{ __('Title') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="title" name="title"
                                        placeholder="{{ __('Product Title') }}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="category" class="col-sm-3 col-form-label">{{ __('Category') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="category" id="category" required>
                                        <option value="" disabled selected>Select Category</option>
                                        <option value="Software">Software</option>
                                        <option value="E-book">E-book</option>
                                        <option value="Course">Course</option>
                                        <option value="Template">Template</option>
                                        <option value="Service">Service</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="price" class="col-sm-3 col-form-label">{{ __('Price') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="number" step="0.01" class="form-control" id="price" name="price"
                                            placeholder="0.00" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-sm-3 col-form-label">{{ __('Description') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="description" name="description" rows="5"
                                        placeholder="{{ __('Product Description') }}" required></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="image" class="col-sm-3 col-form-label">{{ __('Product Image') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="file" class="file-upload-default" id="image" name="image" required
                                        accept="image/*">
                                    <div class="input-group col-xs-12">
                                        <input type="text" class="form-control file-upload-info" disabled
                                            placeholder="{{ __('Upload Image') }}">
                                        <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-theme"
                                                type="button">{{ __('Upload') }}</button>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="contact_info" class="col-sm-3 col-form-label">{{ __('Contact Info') }}
                                    (Optional)</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="contact_info" name="contact_info"
                                        placeholder="{{ __('Email or Phone for inquiries') }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="link" class="col-sm-3 col-form-label">{{ __('External Link') }}
                                    (Optional)</label>
                                <div class="col-sm-9">
                                    <input type="url" class="form-control" id="link" name="link"
                                        placeholder="{{ __('https://example.com/product') }}">
                                </div>
                            </div>

                            <div class="form-check form-check-flat form-check-primary">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="status" value="1" checked>
                                    {{ __('Active') }}
                                </label>
                            </div>

                            <button type="submit" class="btn btn-theme mr-2">{{ __('Submit') }}</button>
                            <button type="reset" class="btn btn-light">{{ __('Cancel') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Include file upload script logic usually present in main JS or inline here
        (function ($) {
            'use strict';
            $(function () {
                $('.file-upload-browse').on('click', function () {
                    var file = $(this).parent().parent().parent().find('.file-upload-default');
                    file.trigger('click');
                });
                $('.file-upload-default').on('change', function () {
                    $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
                });
            });
        })(jQuery);
    </script>
@endsection