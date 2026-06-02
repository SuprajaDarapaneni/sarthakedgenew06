@extends('layouts.master')

@section('title')
    {{ __('package') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ __('manage') . ' ' . __('package') }}
            </h3>
            <div class="text-right">
                <a href="{{ route('package.create') }}" class="btn btn-theme btn-sm">
                    <i class="fa fa-plus mr-2"></i>{{ __('create') . ' ' . __('package') }}
                </a>
            </div>
        </div>

        <div class="row" id="package-grid">
            @foreach($packages as $package)
                <div class="col-md-4 grid-margin stretch-card" data-id="{{ $package->id }}">
                    <div class="card pricing-card {{ $package->highlight ? 'border-primary' : '' }}">
                        @if($package->highlight)
                            <div class="best-value-badge">
                                <i class="fa fa-star mr-1"></i> {{ __('Best Value') }}
                            </div>
                        @endif
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="card-title mb-0">{{ $package->name }}</h4>
                                @if($package->type == 1)
                                    <span class="badge badge-outline-primary">{{ __('Postpaid') }}</span>
                                @else
                                    <span class="badge badge-outline-success">{{ __('Prepaid') }}</span>
                                @endif
                            </div>

                            <div class="pricing-header my-4">
                                <h2 class="display-4 font-weight-bold text-center">
                                    {{ number_format($package->charges ?? $package->student_charge, 2) }}
                                    <small class="text-muted" style="font-size: 1rem;">
                                        / {{ $package->days }} {{ __('days') }}
                                    </small>
                                </h2>
                                <p class="text-center text-muted">{{ $package->description }}</p>
                            </div>

                            <div class="features-list mb-4">
                                <ul class="list-unstyled">
                                    @foreach($package->package_feature as $pf)
                                        <li class="mb-2">
                                            <i class="fa fa-check text-success mr-2"></i>
                                            {{ $pf->feature->name ?? '' }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="card-footer border-0 bg-transparent p-0">
                                <hr>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input change-package-status" 
                                               id="statusSwitch{{$package->id}}" 
                                               data-id="{{ $package->id}}"
                                               {{ $package->status ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="statusSwitch{{$package->id}}">
                                            {{ $package->status ? __('Live') : __('Offline') }}
                                        </label>
                                    </div>
                                    <div>
                                        <a href="{{ route('package.edit', $package->id) }}" class="btn btn-outline-primary btn-sm btn-icon-text">
                                            <i class="fa fa-edit btn-icon-prepend"></i> {{ __('Edit') }}
                                        </a>
                                        <form action="{{ url('package') }}/{{ $package->id }}" method="POST" class="d-inline-block ml-2 delete-package-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm btn-icon-text">
                                                <i class="fa fa-trash btn-icon-prepend"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('css')
<style>
    .best-value-badge {
        position: absolute;
        top: -16px;
        left: 50%;
        transform: translateX(-50%);
        background: #007bff; /* Primary Blue from Bootstrap */
        color: white;
        padding: 8px 24px;
        border-radius: 50px;
        font-weight: 700;
        box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3);
        display: flex;
        align-items: center;
        z-index: 10;
        letter-spacing: 0.5px;
        border: 2px solid white;
    }
    
    .pricing-card {
        position: relative;
        transition: transform 0.3s;
        margin-top: 20px; /* Ensure space for badge */
    }
    .pricing-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .features-list {
        max-height: 300px;
        overflow-y: auto;
    }
    /* Custom Scrollbar for Features List */
    .features-list::-webkit-scrollbar {
        width: 6px;
    }
    .features-list::-webkit-scrollbar-track {
        background: #f1f1f1; 
    }
    .features-list::-webkit-scrollbar-thumb {
        background: #888; 
        border-radius: 3px;
    }
    .features-list::-webkit-scrollbar-thumb:hover {
        background: #555; 
    }
</style>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
             // Handle Status Change
            $('.change-package-status').on('change', function () {
                var id = $(this).data('id');
                var status = $(this).is(':checked') ? 1 : 0;
                var url = "{{ route('package.status', ':id') }}";
                url = url.replace(':id', id);

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (response) {
                        showSuccessToast(response.message);
                        // Update label text
                        $('label[for="statusSwitch' + id + '"]').text(status ? "{{ __('Live') }}" : "{{ __('Offline') }}");
                    },
                    error: function (xhr) {
                        showErrorToast(xhr.responseJSON.message);
                        // Revert checkbox state on error
                        $(this).prop('checked', !status);
                    }
                });
            });

            // Handle Delete
            $(document).on('submit', '.delete-package-form', function (e) {
                e.preventDefault();
                var form = this;
                
                Swal.fire({
                    title: "{{ __('are_you_sure') }}",
                    text: "{{ __('you_wont_be_able_to_revert_this') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "{{ __('yes_delete_it') }}"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: $(form).attr('action'),
                            type: 'POST',
                            data: $(form).serialize(),
                            success: function (response) {
                                showSuccessToast(response.message);
                                $(form).closest('.col-md-4').fadeOut();
                            },
                            error: function (xhr) {
                                let msg = "An error occurred";
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    msg = xhr.responseJSON.message;
                                } else if (xhr.status == 419) {
                                    msg = "Page Expired. Please refresh and try again.";
                                }
                                showErrorToast(msg);
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection