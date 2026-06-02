@extends('layouts.master')

@section('title')
    {{ __('Fees Type') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Page Header -->
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="fa fa-tags"></i>
                </span>
                {{ __('Manage Fees Type') }}
            </h3>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">
                        <span></span>{{ __('Fees Type') }}
                        <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Stats Row -->
        <div class="row mb-3" id="fees-type-stats">
            <div class="col-md-3 col-sm-6 grid-margin stretch-card">
                <div class="card card-statistics" style="border-left: 4px solid #6c63ff;">
                    <div class="custom-card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle p-2 mr-3" style="background: rgba(108,99,255,0.15);">
                                <i class="fa fa-tags text-primary" style="font-size:1.4rem;"></i>
                            </div>
                            <div>
                                <p class="mb-0 text-muted">{{ __('Total Fee Types') }}</p>
                                <h5 class="font-weight-bold mb-0 total-types-count">—</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 grid-margin stretch-card">
                <div class="card card-statistics" style="border-left: 4px solid #1bcfb4;">
                    <div class="custom-card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle p-2 mr-3" style="background: rgba(27,207,180,0.15);">
                                <i class="fa fa-puzzle-piece" style="color:#1bcfb4;font-size:1.4rem;"></i>
                            </div>
                            <div>
                                <p class="mb-0 text-muted">{{ __('With Components') }}</p>
                                <h5 class="font-weight-bold mb-0 with-components-count">—</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Card -->
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card search-container">
                <div class="card">
                    <div class="card-body">
                        <!-- Toolbar -->
                        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2" id="toolbar">
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <!-- Status Tabs -->
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-primary active table-list-type"
                                        data-id="0">
                                        <i class="fa fa-list mr-1"></i>{{ __('All') }}
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger table-list-type" data-id="1">
                                        <i class="fa fa-trash mr-1"></i>{{ __('Trashed') }}
                                    </button>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                @can('fees-type-create')
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#createFeesTypeModal">
                                        <i class="fa fa-plus-circle mr-1"></i> {{ __('Create Fee Type') }}
                                    </button>
                                @endcan
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table aria-describedby="mydesc" class='table table-hover' id='table_list' data-toggle="table"
                                data-url="{{ route('fees-type.show', 1) }}" data-click-to-select="true"
                                data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-page-size="10" data-search="true"
                                data-toolbar="#toolbar" data-show-columns="true" data-show-refresh="true"
                                data-fixed-columns="false" data-fixed-number="2" data-fixed-right-number="1"
                                data-trim-on-search="false" data-mobile-responsive="true" data-sort-name="id"
                                data-sort-order="desc" data-maintain-selected="true" data-export-data-type='all'
                                data-show-export="true" data-query-params="queryParams" data-escape="true">
                                <thead>
                                    <tr>
                                        <th scope="col" data-field="id" data-sortable="true" data-visible="false">
                                            {{ __('id') }}
                                        </th>
                                        <th scope="col" data-field="no">{{ __('no.') }}</th>
                                        <th scope="col" data-field="name" data-sortable="true">{{ __('Fee Type Name') }}
                                        </th>
                                        <th scope="col" data-field="components_count" data-sortable="false"
                                            data-align="center" data-formatter="componentsCountFormatter">
                                            {{ __('Components') }}
                                        </th>
                                        <th scope="col" data-field="description" data-sortable="false">
                                            {{ __('description') }}
                                        </th>
                                        <th scope="col" data-events="FeesTypeActionEvents" data-field="operate"
                                            data-escape="false" data-align="center">{{ __('action') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ======== CREATE FEES TYPE MODAL ======== -->
    <div class="modal fade" id="createFeesTypeModal" tabindex="-1" role="dialog" aria-labelledby="createFeesTypeLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #6c63ff 0%, #3d5af1 100%);">
                    <h5 class="modal-title text-white" id="createFeesTypeLabel">
                        <i class="fa fa-tags mr-2"></i>{{ __('Create Fee Type') }}
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times"></i></span>
                    </button>
                </div>
                <form id="create-fees-type-form" action="{{ url('fees-type') }}" method="POST" novalidate>
                    @csrf
                    <div class="modal-body">
                        <!-- Fee Type Name & Description -->
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>{{ __('Fee Type Name') }} <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control"
                                    placeholder="{{ __('e.g. Tuition Fee') }}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __('Description') }}</label>
                                <input type="text" name="description" class="form-control"
                                    placeholder="{{ __('Optional description') }}">
                            </div>
                        </div>

                        <!-- Fee Components Section -->
                        <div class="border rounded p-3 bg-light mt-2">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h6 class="font-weight-bold mb-0">
                                    <i class="fa fa-puzzle-piece text-primary mr-2"></i>
                                    {{ __('Fee Components') }}
                                    <small class="text-muted font-weight-normal ml-1">({{ __('optional') }})</small>
                                </h6>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="add-component-btn">
                                    <i class="fa fa-plus mr-1"></i>{{ __('Add Component') }}
                                </button>
                            </div>
                            <div id="components-container">
                                <!-- Components are added here dynamically -->
                                <div class="text-center text-muted py-3" id="no-components-msg">
                                    <i class="fa fa-info-circle mr-1"></i>
                                    {{ __('No components added. Click "Add Component" to break this fee type into sub-components.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save mr-1"></i>{{ __('Save Fee Type') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ======== EDIT FEES TYPE MODAL ======== -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editFeesTypeLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editFeesTypeLabel">
                        <i class="fa fa-edit mr-2"></i>{{ __('Edit Fees Type') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close"></i></span>
                    </button>
                </div>
                <form id="edit-form" class="pt-3 edit-form" action="{{ url('fees-type') }}">
                    <input type="hidden" name="edit_id" id="edit_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_name">{{ __('name') }} <span class="text-danger">*</span></label>
                            <input type="text" name="edit_name" id="edit_name" class="form-control edit_name"
                                placeholder="{{ __('name') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_description">{{ __('description') }}</label>
                            <textarea name="edit_description" id="edit_description" class="form-control edit_description"
                                placeholder="{{ __('description') }}" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('close') }}</button>
                        <input class="btn btn-theme" type="submit" value="{{ __('submit') }}" />
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <style>
        .component-row {
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 10px;
            position: relative;
            transition: box-shadow 0.2s ease;
        }

        .component-row:hover {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .remove-component {
            position: absolute;
            top: 8px;
            right: 8px;
            border: none;
            background: none;
            color: #dc3545;
            cursor: pointer;
            font-size: 1rem;
            padding: 2px 6px;
        }

        .remove-component:hover {
            background: #ffe5e5;
            border-radius: 4px;
        }

        #fees-type-stats .card {
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
            border-radius: 10px;
        }

        .table-list-type.active {
            font-weight: 600;
        }
    </style>

    <script>
        let componentIndex = 0;

        // ---- Component Row Template ----
        function createComponentRow(index) {
            return `
                <div class="component-row" id="component-row-${index}">
                    <button type="button" class="remove-component" data-index="${index}" title="${window.trans['delete'] || 'Remove'}">
                        <i class="fa fa-times"></i>
                    </button>
                    <div class="row">
                        <div class="form-group col-md-6 mb-2">
                            <label class="small font-weight-bold">{{ __('Component Name') }} <span class="text-danger">*</span></label>
                            <input type="text" name="components[${index}][name]" class="form-control form-control-sm" placeholder="{{ __('e.g. Library Fee') }}" required>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="small font-weight-bold">{{ __('Description') }}</label>
                            <input type="text" name="components[${index}][description]" class="form-control form-control-sm" placeholder="{{ __('Optional') }}">
                        </div>
                    </div>
                </div>`;
        }

        // ---- Add Component ----
        $('#add-component-btn').on('click', function () {
            $('#no-components-msg').hide();
            const row = createComponentRow(componentIndex++);
            $('#components-container').append(row);
        });

        // ---- Remove Component ----
        $(document).on('click', '.remove-component', function () {
            const index = $(this).data('index');
            $(`#component-row-${index}`).remove();
            if ($('#components-container .component-row').length === 0) {
                $('#no-components-msg').show();
            }
        });

        // ---- Submit Create Form via AJAX ----
        $('#create-fees-type-form').on('submit', function (e) {
            e.preventDefault();
            const form = $(this);
            const url = form.attr('action');
            const submitBtn = form.find('[type="submit"]');

            submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i>{{ __("Saving...") }}');

            $.ajax({
                url: url,
                method: 'POST',
                data: form.serialize(),
                success: function (res) {
                    if (res.error === false) {
                        $('#createFeesTypeModal').modal('hide');
                        form[0].reset();
                        $('#components-container').empty();
                        $('#no-components-msg').show();
                        componentIndex = 0;
                        $('#table_list').bootstrapTable('refresh');
                        updateStats();
                        showSuccessToast('{{ __("Fee Type created successfully!") }}');
                    } else {
                        showErrorAlert(res.message || '{{ __("Something went wrong!") }}');
                    }
                },
                error: function (xhr) {
                    const errors = xhr.responseJSON?.errors;
                    if (errors) {
                        let msg = Object.values(errors).flat().join('<br>');
                        showErrorAlert(msg);
                    } else {
                        showErrorAlert('{{ __("Failed to create fee type.") }}');
                    }
                },
                complete: function () {
                    submitBtn.prop('disabled', false).html('<i class="fa fa-save mr-1"></i>{{ __("Save Fee Type") }}');
                }
            });
        });

        // ---- Table status tabs ----
        $(document).on('click', '.table-list-type', function () {
            $('.table-list-type').removeClass('active');
            $(this).addClass('active');
            $('#table_list').bootstrapTable('refresh');
        });

        // ---- Update Stats ----
        function updateStats() {
            // pulls from current table data
            const total = $('#table_list').bootstrapTable('getData').length;
            // we'll use the server total count from the response instead
        }

        // ---- On Table Load ----
        $('#table_list').on('load-success.bs.table', function (e, data) {
            if (data && data.total !== undefined) {
                $('.total-types-count').text(data.total);
                // Count those with components
                const withComps = (data.rows || []).filter(r => r.components_count > 0).length;
                $('.with-components-count').text(withComps);
            }
        });

        // ---- Toast helper ----
        function showSuccessToast(msg) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({ icon: 'success', title: msg, toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 });
            } else {
                alert(msg);
            }
        }
        function showErrorAlert(msg) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({ icon: 'error', title: 'Error', html: msg });
            } else {
                alert(msg);
            }
        }
    </script>
@endsection