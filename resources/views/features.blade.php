@extends('layouts.master')

@section('title')
    {{ __('features') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ __('features') }}
            </h3>
            <div class="text-right">
                <button type="button" class="btn btn-theme btn-sm" data-toggle="modal" data-target="#createFeatureModal">
                    <i class="fa fa-plus mr-2"></i>{{ __('create') . ' ' . __('feature') }}
                </button>
            </div>
        </div>

        <div class="row" id="features-grid">
            @foreach($features as $feature)
                <div class="col-md-4 grid-margin stretch-card" data-id="{{ $feature->id }}">
                    <div class="card feature-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fa fa-cube text-primary icon-lg mr-3"></i>
                                <h4 class="card-title mb-0">{{ $feature->name }}</h4>
                            </div>
                            <hr>
                            <h6 class="text-muted mb-3">{{ __('Permissions Included') }}:</h6>
                            <div class="permissions-list">
                                @if(!empty($feature->permission))
                                    <ul class="list-unstyled">
                                        @foreach($feature->permission as $perm)
                                            <li class="mb-2 d-flex align-items-start">
                                                <i class="fa fa-check text-success mr-2 mt-1"></i>
                                                <span>{{ $perm }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-muted text-center py-3">{{ __('No specific permissions listed') }}</p>
                                @endif
                            </div>
                            
                            <div class="card-footer border-0 bg-transparent p-0 mt-3">
                                <hr>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input change-feature-status" 
                                               id="statusSwitch{{$feature->id}}" 
                                               data-id="{{ $feature->id}}"
                                               {{ $feature->status ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="statusSwitch{{$feature->id}}">
                                            {{ $feature->status ? __('Active') : __('Inactive') }}
                                        </label>
                                    </div>
                                    <div>
                                        <button class="btn btn-outline-primary btn-sm btn-icon-text edit-feature-btn" 
                                                data-id="{{ $feature->id }}" 
                                                data-name="{{ $feature->name }}"
                                                data-toggle="modal" 
                                                data-target="#editFeatureModal">
                                            <i class="fa fa-edit btn-icon-prepend"></i> {{ __('Edit') }}
                                        </button>
                                         <button class="btn btn-outline-danger btn-sm btn-icon-text delete-feature-btn" data-id="{{ $feature->id }}">
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
    </div>

    <!-- Create Feature Modal -->
    <div class="modal fade" id="createFeatureModal" tabindex="-1" role="dialog" aria-labelledby="createFeatureModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createFeatureModalLabel">{{ __('create') . ' ' . __('feature') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="create-form" action="{{ route('features.store') }}" method="POST" novalidate="novalidate">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{ __('name') }} <span class="text-danger">*</span></label>
                            <input name="name" type="text" placeholder="{{ __('name') }}" class="form-control" required/>
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

    <!-- Edit Feature Modal -->
    <div class="modal fade" id="editFeatureModal" tabindex="-1" role="dialog" aria-labelledby="editFeatureModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editFeatureModalLabel">{{ __('edit') . ' ' . __('feature') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="edit-form" action="{{ route('features.update', ':id') }}" method="POST" novalidate="novalidate">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit_feature_id_input">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{ __('name') }} <span class="text-danger">*</span></label>
                            <input name="name" id="edit_feature_name" type="text" placeholder="{{ __('name') }}" class="form-control" required/>
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
@endsection

@section('css')
    <style>
        .feature-card {
            transition: transform 0.3s, box-shadow 0.3s;
            border: 1px solid #e3e3e3;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            border-color: #007bff;
        }

        .icon-lg {
            font-size: 1.5rem;
        }

        .permissions-list {
            max-height: 250px;
            overflow-y: auto;
            padding-right: 5px;
        }

        /* Custom Scrollbar */
        .permissions-list::-webkit-scrollbar {
            width: 6px;
        }

        .permissions-list::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .permissions-list::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 3px;
        }

        .permissions-list::-webkit-scrollbar-thumb:hover {
            background: #aaa;
        }
    </style>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Status Change
            $('.change-feature-status').on('change', function() {
                var id = $(this).data('id');
                var status = $(this).is(':checked') ? 1 : 0;
                var url = "{{ route('features.status', ':id') }}";
                url = url.replace(':id', id);

                $.ajax({
                    url: url,
                    type: 'PUT',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        showSuccessToast(response.message);
                        $('label[for="statusSwitch' + id + '"]').text(status ? "{{ __('Active') }}" : "{{ __('Inactive') }}");
                    },
                    error: function(xhr) {
                        showErrorToast(xhr.responseJSON.message);
                        $(this).prop('checked', !status);
                    }
                });
            });

            // Edit Feature Button Click
            $('.edit-feature-btn').on('click', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');

                $('#edit_feature_id_input').val(id);
                $('#edit_feature_name').val(name);

                // Update form action URL
                var url = "{{ route('features.update', ':id') }}";
                url = url.replace(':id', id);
                $('#editFeatureModal form').attr('action', url);
            });

            // Handle Delete Feature
            $('.delete-feature-btn').on('click', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                var url = "{{ route('features.destroy', ':id') }}";
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
                                $('[data-id="' + id + '"]').closest('.col-md-4').fadeOut(); // Corrected selector to remove the card
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