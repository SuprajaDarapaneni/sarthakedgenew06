@extends('layouts.master')

@section('title')
    {{ __('addons') }}
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            {{ __('manage') . ' ' . __('addons') }}
        </h3>
        <div class="text-right">
            <button type="button" class="btn btn-theme btn-sm" data-toggle="modal" data-target="#createAddonModal">
                <i class="fa fa-plus mr-2"></i>{{ __('create') . ' ' . __('addon') }}
            </button>
        </div>
    </div>

    <div class="row" id="addon-grid">
        @foreach($addons as $addon)
            <div class="col-md-4 grid-margin stretch-card" data-id="{{ $addon->id }}">
                <div class="card addon-card {{ $addon->status ? 'border-success' : '' }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="card-title mb-0">{{ $addon->name }}</h4>
                             <span class="badge badge-outline-primary">{{ __('Addon') }}</span>
                        </div>
                        
                        <div class="pricing-header my-4 text-center">
                            <h2 class="font-weight-bold">
                                {{ number_format($addon->price, 2) }}
                            </h2>
                             <p class="text-muted">{{ __('One-time Purchase') }}</p>
                        </div>
                        
                        <div class="features-list mb-4 text-center">
                             @if($addon->feature)
                                <div class="mb-2">
                                    <i class="fa fa-star text-warning mr-2"></i>
                                    <strong>{{ __('Feature') }}:</strong> {{ $addon->feature->name }}
                                </div>
                            @endif
                        </div>

                        <div class="card-footer border-0 bg-transparent p-0">
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input change-addon-status" 
                                           id="statusSwitch{{$addon->id}}" 
                                           data-id="{{ $addon->id}}"
                                           {{ $addon->status ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="statusSwitch{{$addon->id}}">
                                        {{ $addon->status ? __('Live') : __('Offline') }}
                                    </label>
                                </div>
                                <div>
                                    <button class="btn btn-outline-primary btn-sm btn-icon-text edit-addon-btn" 
                                            data-id="{{ $addon->id }}" 
                                            data-name="{{ $addon->name }}"
                                            data-price="{{ $addon->price }}"
                                            data-feature-id="{{ $addon->feature_id }}"
                                            data-toggle="modal" 
                                            data-target="#editModal">
                                        <i class="fa fa-edit btn-icon-prepend"></i> {{ __('Edit') }}
                                    </button>
                                     <button class="btn btn-outline-danger btn-sm btn-icon-text delete-addon-btn" data-id="{{ $addon->id }}">
                                        <i class="fa fa-trash btn-icon-prepend"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createAddonModal" tabindex="-1" role="dialog" aria-labelledby="createAddonModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createAddonModalLabel">{{ __('create') . ' ' . __('addon') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="create-form" action="{{ route('addons.store') }}" method="POST" novalidate="novalidate">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{ __('name') }} <span class="text-danger">*</span></label>
                            <input name="name" type="text" placeholder="{{ __('name') }}" class="form-control" required/>
                        </div>
                        <div class="form-group">
                            <label>{{ __('price') }} <span class="text-danger">*</span></label>
                            <input type="number" name="price" class="form-control" required placeholder="{{ __('price') }}" min="0" step="0.01">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Feature') }} <span class="text-danger">*</span></label>
                            <select name="feature_id" class="form-control" required>
                                <option value="">{{ __('Select Feature') }}</option>
                                @foreach($features as $feature)
                                    <option value="{{ $feature->id }}">{{ $feature->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('close') }}</button>
                        <button type="submit" class="btn btn-theme">{{ __('submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">{{ __('edit') . ' ' . __('addon') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="edit-form" action="{{ route('addons.update', ':id') }}" method="POST" novalidate="novalidate">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{ __('name') }} <span class="text-danger">*</span></label>
                            <input name="name" id="edit_name" type="text" placeholder="{{ __('name') }}" class="form-control" required/>
                        </div>
                        <div class="form-group">
                            <label>{{ __('price') }} <span class="text-danger">*</span></label>
                            <input type="number" name="price" id="edit_price" class="form-control" required placeholder="{{ __('price') }}" min="0" step="0.01">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Feature') }} <span class="text-danger">*</span></label>
                            <select name="feature_id" id="edit_feature_id" class="form-control" required>
                                <option value="">{{ __('Select Feature') }}</option>
                                @foreach($features as $feature)
                                    <option value="{{ $feature->id }}">{{ $feature->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('close') }}</button>
                        <button type="submit" class="btn btn-theme">{{ __('submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    .addon-card {
        transition: transform 0.3s;
    }
    .addon-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
</style>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        // Status Change
        $('.change-addon-status').on('change', function() {
            var id = $(this).data('id');
            var status = $(this).is(':checked') ? 1 : 0;
            var url = "{{ route('addons.status', ':id') }}";
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: 'PUT', // Assuming PUT based on controller
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    showSuccessToast(response.message);
                    $('label[for="statusSwitch' + id + '"]').text(status ? "{{ __('Live') }}" : "{{ __('Offline') }}");
                },
                error: function(xhr) {
                    showErrorToast(xhr.responseJSON.message);
                    $(this).prop('checked', !status);
                }
            });
        });

        // Edit Button Click
        $('.edit-addon-btn').on('click', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var price = $(this).data('price');
            var featureId = $(this).data('feature-id');

            $('#edit_id').val(id);
            $('#edit_name').val(name);
            $('#edit_price').val(price);
            $('#edit_feature_id').val(featureId);

            // Update form action URL
            var url = "{{ route('addons.update', ':id') }}";
            url = url.replace(':id', id);
            $('#editModal form').attr('action', url);
        });
        
         // Handle Delete
        $('.delete-addon-btn').on('click', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            var url = "{{ route('addons.destroy', ':id') }}";
            url = url.replace(':id', id);
            
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
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            showSuccessToast(response.message);
                            $('[data-id="' + id + '"]').closest('.col-md-4').fadeOut();
                        },
                        error: function (xhr) {
                            showErrorToast(xhr.responseJSON.message);
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
