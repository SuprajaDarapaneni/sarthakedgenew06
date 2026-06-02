@extends('layouts.master')

@section('title')
    {{ __('Marketplace') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-theme text-white mr-2">
                    <i class="fa fa-shopping-bag"></i>
                </span> {{ __('Marketplace') }}
            </h3>
            @if(Auth::user()->hasRole('Super Admin'))
                <button type="button" id="headerAddListingBtn" class="btn btn-theme">
                    <i class="fa fa-plus"></i> {{ __('Add New Listing') }}
                </button>
            @endif
        </div>

        <div class="row">
            @forelse($products as $product)
                <div class="col-lg-4 col-md-6 grid-margin stretch-card">
                    <div class="card border-0 shadow-sm"
                        style="border-radius: 15px; overflow: hidden; transition: transform 0.3s ease;">
                        @if($product->image)
                            <div style="height: 200px; overflow: hidden;">
                                <img src="{{ Storage::url($product->image) }}" class="w-100"
                                    style="object-fit: cover; height: 100%; transition: transform 0.3s;"
                                    alt="{{ $product->title }}">
                            </div>
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fa fa-image fa-3x text-muted"></i>
                            </div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge badge-outline-primary rounded-pill">{{ $product->category }}</span>
                                @if($product->link)
                                    <a href="{{ $product->link }}" target="_blank" class="text-muted"><i
                                            class="fa fa-external-link"></i></a>
                                @endif
                            </div>
                            <h4 class="card-title font-weight-bold mb-2">{{ $product->title }}</h4>
                            <p class="card-text text-muted mb-4" style="flex-grow: 1;">
                                {{ Str::limit($product->description, 100) }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                <h4 class="text-theme font-weight-bold mb-0">
                                    {{ $product->price > 0 ? '₹' . number_format($product->price, 2) : 'Free' }}
                                </h4>
                                <div>
                                    <button class="btn btn-sm btn-theme view-product-btn" data-title="{{ $product->title }}"
                                        data-desc="{{ $product->description }}"
                                        data-price="{{ $product->price > 0 ? '₹' . number_format($product->price, 2) : 'Free' }}"
                                        data-contact="{{ $product->contact_info }}"
                                        data-image="{{ $product->image ? Storage::url($product->image) : '' }}"
                                        data-link="{{ $product->link }}">
                                        {{ __('View') }}
                                    </button>
                                    @if(Auth::user()->hasRole('Super Admin'))
                                        <a href="{{ route('marketplace.edit', $product->id) }}"
                                            class="btn btn-sm btn-outline-primary ml-1">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('marketplace.destroy', $product->id) }}" method="POST"
                                            class="d-inline ml-1" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="p-5 bg-white rounded shadow-sm">
                        <i class="fa fa-shopping-basket fa-4x text-muted mb-3"></i>
                        <h3 class="text-muted">{{ __('No products available yet.') }}</h3>
                        @if(Auth::user()->hasRole('Super Admin'))
                            <p class="mt-3">Start by adding new listings to the marketplace.</p>
                            <button type="button" id="emptyAddListingBtn" class="btn btn-theme mt-2">Add First Product</button>
                        @endif
                    </div>
                </div>
            @endforelse
        </div>

        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    <!-- Add Listing Modal -->
    <div class="modal fade" id="addListingModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title font-weight-bold ml-2">Add New Listing</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <p class="text-muted ml-2 mb-4">Configure marketplace listing details</p>
                    <form action="{{ route('marketplace.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label class="font-weight-bold ml-1">Title</label>
                            <input type="text" class="form-control rounded-input @error('title') is-invalid @enderror"
                                name="title" placeholder="Product or service name" value="{{ old('title') }}" required>
                            @error('title') <span class="invalid-feedback ml-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold ml-1">Description</label>
                            <textarea class="form-control rounded-input @error('description') is-invalid @enderror"
                                name="description" rows="3" placeholder="Brief description"
                                required>{{ old('description') }}</textarea>
                            @error('description') <span class="invalid-feedback ml-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold ml-1">Category</label>
                                <select class="form-control rounded-input" name="category" required>
                                    <option value="Software" {{ old('category') == 'Software' ? 'selected' : '' }}>Software
                                    </option>
                                    <option value="E-book" {{ old('category') == 'E-book' ? 'selected' : '' }}>E-book</option>
                                    <option value="Course" {{ old('category') == 'Course' ? 'selected' : '' }}>Course</option>
                                    <option value="Template" {{ old('category') == 'Template' ? 'selected' : '' }}>Template
                                    </option>
                                    <option value="Service" {{ old('category') == 'Service' ? 'selected' : '' }}>Service
                                    </option>
                                    <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold ml-1">Price (₹)</label>
                                <input type="number" step="0.01"
                                    class="form-control rounded-input @error('price') is-invalid @enderror" name="price"
                                    placeholder="Optional" value="{{ old('price') }}">
                                @error('price') <span class="invalid-feedback ml-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold ml-1">Poster Image</label>
                            <input type="file" class="file-upload-default" id="image" name="image" accept="image/*">
                            <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info rounded-input-left" disabled
                                    placeholder="Choose file">
                                <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-theme rounded-btn-right"
                                        type="button">Upload</button>
                                </span>
                            </div>
                            @error('image') <span class="text-danger small ml-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold ml-1">External Link</label>
                            <input type="url" class="form-control rounded-input @error('link') is-invalid @enderror"
                                name="link" placeholder="https://..." value="{{ old('link') }}">
                            @error('link') <span class="invalid-feedback ml-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold ml-1">Commission %</label>
                            <input type="number" step="0.1"
                                class="form-control rounded-input @error('commission_percentage') is-invalid @enderror"
                                name="commission_percentage" value="{{ old('commission_percentage', 10) }}">
                            @error('commission_percentage') <span class="invalid-feedback ml-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group d-flex justify-content-between align-items-center mt-3">
                            <label class="font-weight-bold mb-0 ml-1">Active</label>
                            <label class="switch">
                                <input type="checkbox" name="status" value="1" {{ old('status', 1) ? 'checked' : '' }}>
                                <span class="slider round"></span>
                            </label>
                        </div>

                        <div class="modal-footer border-0 px-0 pb-0 mt-3 d-flex justify-content-end">
                            <button type="button" class="btn btn-outline-secondary rounded-btn mr-2"
                                data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-theme rounded-btn">Add Listing</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Details Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content border-0" style="border-radius: 15px;">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div style="max-height: 400px; overflow: hidden; border-radius: 10px;">
                                <img id="modal_image" src="" class="img-fluid rounded shadow-sm"
                                    style="width: 100%; object-fit: cover;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h3 id="modal_title" class="font-weight-bold mb-3"></h3>
                            <h4 id="modal_price" class="text-theme font-weight-bold mb-4"></h4>
                            <div class="bg-light p-3 rounded mb-3">
                                <h6 class="font-weight-bold">Description</h6>
                                <p id="modal_desc" class="text-muted mb-0"></p>
                            </div>
                            <div class="mb-4">
                                <h6 class="font-weight-bold">Contact / Purchase Info</h6>
                                <p id="modal_contact" class="text-dark"></p>
                            </div>
                            <a id="modal_link" href="#" target="_blank" class="btn btn-theme btn-block">Visit External
                                Link</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function () {
            // Validation Error: Reopen Modal
            @if ($errors->any())
                $('#addListingModal').appendTo("body").modal('show');
            @endif

            // Manual Trigger for Add Listing (Fixes Z-index/Structure issues)
            $('#headerAddListingBtn, #emptyAddListingBtn').click(function (e) {
                e.preventDefault();
                $('#addListingModal').appendTo("body").modal('show');
            });

            // View Product Logic
            $('.view-product-btn').click(function () {
                var title = $(this).data('title');
                var desc = $(this).data('desc');
                var price = $(this).data('price');
                var contact = $(this).data('contact');
                var image = $(this).data('image');
                var link = $(this).data('link');

                $('#modal_title').text(title);
                $('#modal_desc').text(desc);
                $('#modal_price').text(price);
                $('#modal_contact').text(contact || 'No contact info available.');

                if (image) {
                    $('#modal_image').attr('src', image).show();
                } else {
                    $('#modal_image').hide();
                }

                if (link) {
                    $('#modal_link').attr('href', link).show();
                } else {
                    $('#modal_link').hide();
                }

                // Move to body to avoid clipping
                $('#productModal').appendTo("body").modal('show');
            });

            // File Upload Logic
            $('.file-upload-browse').on('click', function () {
                var file = $(this).parent().parent().parent().find('.file-upload-default');
                file.trigger('click');
            });
            $('.file-upload-default').on('change', function () {
                $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
            });
        });
    </script>
    <style>
        /* Card Styles */
        .card:hover {
            transform: translateY(-5px);
        }

        .badge-outline-primary {
            color: var(--theme-color);
            border: 1px solid var(--theme-color);
        }

        .bg-theme {
            background-color: var(--theme-color) !important;
        }

        .text-theme {
            color: var(--theme-color) !important;
        }

        .btn-theme {
            background-color: var(--theme-color);
            color: #fff;
        }

        .btn-theme:hover {
            background-color: var(--theme-hover-color);
            color: #fff;
        }

        /* Modal Form Styles */
        .rounded-input {
            border-radius: 8px !important;
            border: 1px solid #ced4da;
            padding: 10px 15px;
            height: auto;
        }

        .rounded-input:focus {
            border-color: var(--theme-color);
            box-shadow: 0 0 0 0.2rem rgba(var(--theme-rgb), 0.25);
        }

        .rounded-btn {
            border-radius: 8px !important;
            padding: 10px 20px;
            font-weight: 600;
        }

        .rounded-input-left {
            border-top-left-radius: 8px !important;
            border-bottom-left-radius: 8px !important;
        }

        .rounded-btn-right {
            border-top-right-radius: 8px !important;
            border-bottom-right-radius: 8px !important;
        }

        .invalid-feedback {
            display: block;
            /* Ensure it shows up */
            font-size: 0.8rem;
        }

        /* Switch Styles */
        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 26px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: var(--theme-color);
            /* Blue */
        }

        input:focus+.slider {
            box-shadow: 0 0 1px var(--theme-color);
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(24px);
            -ms-transform: translateX(24px);
            transform: translateX(24px);
        }

        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
@endsection