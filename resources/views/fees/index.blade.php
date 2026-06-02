@extends('layouts.master')

@section('title')
    {{ __('Manage Fees')}}
@endsection

@section('css')
    <style>
        /* ── THEME COLORS ── */
        :root {
            --nb-primary: #162fac;
            --nb-primary-dark: #0f2190;
            --nb-primary-light: rgba(22, 47, 172, 0.1);
            --nb-text-muted: #64748b;
            --nb-bg-light: #f8fafc;
        }

        /* Wrapper */
        .fees-v3-wrapper {
            background: #f0f4f8;
            padding: 2.5rem 1rem 4rem;
            min-height: 100vh;
        }

        /* ── Hero / Entry Card ── */
        .adm-card-hero {
            background: #ffffff;
            border-radius: 24px;
            padding: 4rem 2rem;
            text-align: center;
            box-shadow: 0 10px 40px rgba(30, 41, 59, 0.08);
            border: 1px solid #e2e8f0;
            position: relative;
            overflow: hidden;
            max-width: 700px;
            margin: 0 auto;
            z-index: 1;
        }

        .adm-hero-icon-box {
            width: 84px;
            height: 84px;
            margin: 0 auto 1.8rem;
            background: var(--nb-primary);
            border-radius: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 12px 28px rgba(22, 47, 172, 0.3);
        }

        .adm-hero-icon-box i {
            font-size: 32px;
            color: #ffffff;
        }

        .adm-hero-title {
            font-size: 2.2rem;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 0.8rem;
            letter-spacing: -0.5px;
        }

        .adm-hero-desc {
            font-size: 1.05rem;
            color: var(--nb-text-muted);
            max-width: 480px;
            margin: 0 auto 2.5rem;
            line-height: 1.7;
        }

        /* Main Action Button */
        .adm-btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            background: var(--nb-primary) !important;
            color: #ffffff !important;
            padding: 1rem 3rem;
            border-radius: 16px;
            font-size: 1.1rem;
            font-weight: 700;
            border: none;
            cursor: pointer;
            box-shadow: 0 10px 25px rgba(22, 47, 172, 0.4);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none !important;
            position: relative;
            z-index: 100;
        }

        .adm-btn-primary:hover {
            transform: translateY(-4px);
            background: var(--nb-primary-dark) !important;
            box-shadow: 0 15px 35px rgba(22, 47, 172, 0.5);
            color: #ffffff !important;
        }

        .adm-features-row {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0;
            margin-top: 3rem;
            flex-wrap: wrap;
        }

        .adm-feature {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1.2rem;
        }

        .adm-feature i {
            color: var(--nb-primary);
            font-size: 14px;
        }

        .adm-feature span {
            font-size: 0.85rem;
            color: var(--nb-text-muted);
            font-weight: 600;
        }

        .adm-feature-sep {
            width: 1px;
            height: 20px;
            background: #e2e8f0;
        }

        /* ── Modal Design ── */
        .adm-modal-content {
            border: none;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 30px 90px rgba(0, 0, 0, 0.25);
        }

        .adm-modal-header {
            background: var(--nb-primary);
            padding: 1.5rem 2.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: none;
        }

        .adm-modal-header .header-info {
            color: #ffffff;
        }

        .adm-modal-header h5 {
            font-size: 1.35rem;
            font-weight: 700;
            margin: 0;
        }

        .adm-modal-header p {
            font-size: 0.85rem;
            opacity: 0.8;
            margin: 0.2rem 0 0;
        }

        .adm-modal-close {
            background: rgba(255, 255, 255, 0.15);
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 10px;
            color: #fff;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.2s;
        }

        .modal-body.adm-modal-body {
            background: var(--nb-bg-light);
            padding: 2rem;
        }



        .adm-form-card {
            background: #ffffff;
            border-radius: 18px;
            padding: 1.8rem;
            border: 1px solid #e8edf5;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 12px rgba(30, 41, 59, 0.03);
        }

        .adm-form-card h6 {
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
            margin-bottom: 1.5rem;
            padding-bottom: 0.8rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .adm-btn-nav {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--nb-primary);
            color: #ffffff !important;
            border: none;
            padding: 0.8rem 1.8rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 6px 15px rgba(22, 47, 172, 0.25);
            text-decoration: none !important;
        }

        .form-control {
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            background: #fafafa;
            padding: 0.6rem 0.9rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: var(--nb-primary);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(22, 47, 172, 0.08);
        }

        @media (max-width: 600px) {
            .adm-card-hero {
                padding: 3rem 1.5rem;
            }

            .adm-hero-title {
                font-size: 1.8rem;
            }
        }
    </style>

@endsection

@section('content')
    <div class="content-wrapper fees-v3-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ __('Manage Fees') }}
            </h3>
        </div>

        <!-- Hero Card -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 col-xl-6">
                <div class="adm-card-hero">
                    <div class="adm-hero-icon-box">
                        <i class="fa fa-money"></i>
                    </div>
                    <h2 class="adm-hero-title">{{ __('Fees Management') }}</h2>
                    <p class="adm-hero-desc">
                        {{ __('Efficiently organize and create school fees. Configure compulsory fees, optional charges, and flexible installment plans.') }}
                    </p>

                    <button type="button" class="adm-btn-primary" id="btn-trigger-fees">
                        <i class="fa fa-plus-circle"></i>
                        {{ __('Create Fees') }}
                    </button>

                    <div class="adm-features-row">
                        <div class="adm-feature"><i class="fa fa-check-circle"></i> <span>{{ __('Installments') }}</span>
                        </div>
                        <div class="adm-feature-sep"></div>
                        <div class="adm-feature"><i class="fa fa-shield"></i> <span>{{ __('Compulsory') }}</span></div>
                        <div class="adm-feature-sep"></div>
                        <div class="adm-feature"><i class="fa fa-history"></i> <span>{{ __('Optional') }}</span></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Fees Modal -->
        <div class="modal fade" id="feesModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static"
            data-keyboard="false">
            <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
                <div class="modal-content adm-modal-content">
                    <div class="modal-header adm-modal-header">
                        <div class="header-info">
                            <h5 style="color:#ffffff; margin:0;">{{ __('Create Fees Structure') }}</h5>
                            <p style="color:rgba(255,255,255,0.8); margin:0.2rem 0 0; font-size:0.85rem;">
                                {{ __('Define fees components and payment rules') }}
                            </p>
                        </div>
                        <button type="button" class="adm-modal-close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body adm-modal-body">
                        <form id="create-form" class="create-form common-validation-rules"
                            action="{{ route('fees.store') }}" method="POST" novalidate="novalidate"
                            data-success-function="successFunction">
                            @csrf
                            <div class="adm-form-card">
                                <h6>{{ __('General Information') }}</h6>
                                <div class="row">
                                    <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                        <label>{{ __('Prefix Name') }} <span class="text-danger">*</span> <span
                                                class="fa fa-info-circle" data-toggle="tooltip" data-placement="right"
                                                title="{{__("Fees names will be created based on the Classes Prefix will be appended before Class Name.eg. Prefix Name - Class Name")}}"></span></label>
                                        <input type="text" name="name" class="form-control"
                                            placeholder="{{ __('Prefix Name') }}" required>
                                    </div>

                                    <div class="form-group col-sm-12 col-md-12 col-lg-6">
                                        <label for="class-id">{{ __('Classes') }} <span class="text-danger">*</span></label>
                                        <select name="class_id[]" id="class-id"
                                            class="class-id form-control select2 select2-hidden-accessible" tabindex="-1"
                                            aria-hidden="true" required multiple>
                                            @foreach ($classes as $item)
                                                <option value="{{ $item->id }}">{{ $item->full_name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="form-check w-fit-content">
                                            <label class="form-check-label user-select-none">
                                                <input type="checkbox" class="form-check-input" id="select-all"
                                                    value="1">{{__("Select All")}}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="adm-form-card">
                                <h6>{{ __('Compulsory Fees') }}</h6>
                                <div class="compulsory-fees-types">
                                    <div data-repeater-list="compulsory_fees_type" class="row col-12 pl-0 pr-0">
                                        <div class="row col-12 mb-3" data-repeater-item>
                                            <div class="form-group col-md-12 col-lg-5">
                                                <select name="fees_type_id" id="fees_type_id" class="form-control fees_type"
                                                    aria-label="Fees Type" required>
                                                    <option value="">{{ __('Select Fees Type')}}</option>
                                                    @foreach ($feesTypeData as $feesType)
                                                        <option value="{{ $feesType->id }}">{{ $feesType->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group col-md-12 col-lg-5">
                                                <input type="number" name="amount" class="form-control amount"
                                                    placeholder="{{ __('enter') . ' ' . __('fees') . ' ' . __('amount') }}"
                                                    required min="0" data-convert="number">
                                            </div>

                                            <div class="col-md-12 col-lg-2">
                                                <button type="button"
                                                    class="btn btn-inverse-danger btn-icon remove-fees-type"
                                                    data-repeater-delete>
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 pr-0 pl-0">
                                        <button class="btn btn-dark btn-sm" type="button" data-repeater-create>
                                            <i class="fa fa-plus-circle fa-2x mr-2" aria-hidden="true"></i>
                                            {{__('Add New Data')}}
                                        </button>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="form-group col-sm-12 col-md-6 col-lg-4">
                                        <label>{{ __('due_date')}} <span class="text-danger">*</span></label>
                                        <input type="text" name="due_date" class="datepicker-popup-no-past form-control"
                                            placeholder="{{ __('due_date') }}" required autocomplete="off">
                                    </div>

                                    <div class="form-group col-sm-12 col-md-6 col-lg-4">
                                        <label>{{ __('due_charges')}} <span class="text-danger">*</span> <span
                                                class="text-info small">( {{__('in_percentage')}} )</span></label>
                                        <input type="number" name="due_charges_percentage" id="due_charges_percentage"
                                            class="form-control" placeholder="{{ __('due_charges') }}" required min="0">
                                    </div>

                                    <div class="form-group col-sm-12 col-md-6 col-lg-4">
                                        <label>{{ __('due_charges')}} <span class="text-danger">*</span> <span
                                                class="text-info small">( {{__('Amount')}} )</span></label>
                                        <input type="number" name="due_charges_amount" id="due_charges_amount"
                                            class="form-control" placeholder="{{ __('due_charges') }}" required min="0">
                                    </div>
                                </div>
                            </div>

                            <div class="adm-form-card">
                                <h6>{{ __('Fees Installment')}}</h6>
                                <div class="mb-4">
                                    <div class="form-inline col-md-12 pl-0">
                                        <label>{{__('include_fees_installment')}}</label> <span
                                            class="ml-1 text-danger">*</span>
                                        <div class="ml-4 d-flex">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" name="include_fee_installments"
                                                        class="fees-installment-toggle user-select-none" value="1">
                                                    {{ __('Enable') }}
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" name="include_fee_installments"
                                                        class="fees-installment-toggle user-select-none" value="0" checked>
                                                    {{ __('Disable') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="fees-installment-repeater" style="display: none">
                                    <div data-repeater-list="fees_installments" class="row">
                                        <div data-repeater-item class="col-12 mb-4 p-3 border rounded">
                                            <div class="row">
                                                <div class="form-group col-lg-6 col-xl-3">
                                                    <label>{{ __('installment_name') }} <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="name" class="form-control installment-name"
                                                        placeholder="{{ __('installment') . ' ' . __('name') }}" required>
                                                </div>
                                                <div class="form-group col-lg-6 col-xl-3">
                                                    <label>{{ __('amount') }} <span class="text-danger">*</span></label>
                                                    <input type="number" name="amount"
                                                        class="form-control installment-amount"
                                                        placeholder="{{ __('amount') }}" required min="0"
                                                        data-convert="number">
                                                </div>
                                                <div class="form-group col-lg-6 col-xl-3">
                                                    <label>{{ __('due_date') }} <span class="text-danger">*</span></label>
                                                    <input type="text" name="due_date"
                                                        class="datepicker-popup-no-past form-control installment-due-date"
                                                        placeholder="{{ __('due_date') }}" autocomplete="off" required>
                                                </div>
                                                <div class="form-group col-lg-6 col-xl-3 mt-4">
                                                    <button type="button"
                                                        class="btn btn-inverse-danger btn-icon remove-installment-fee float-right"
                                                        data-repeater-delete>
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="form-group col-md-6 col-lg-4">
                                                    <label>{{ __('Due Charges Type') }} <span
                                                            class="text-danger">*</span></label>
                                                    <div class="d-flex">
                                                        <div class="form-check form-check-inline">
                                                            <label class="form-check-label mr-2">
                                                                <input type="radio" name="due_charges_type" value="fixed"
                                                                    class="form-check-input" required>
                                                                {{ __('Fixed Amount') }}
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="form-check-label">
                                                                <input type="radio" name="due_charges_type"
                                                                    value="percentage" class="form-check-input" required
                                                                    checked>
                                                                {{ __('Percentage') }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 col-lg-4">
                                                    <label>{{ __('due_charges') }} <span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" name="due_charges"
                                                        class="installment-due-charges form-control"
                                                        placeholder="{{ trans('due_charges') }}" required min="0"
                                                        data-convert="number">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 pl-0">
                                        <button id="add-installment" class="btn btn-dark btn-sm" type="button"
                                            data-repeater-create>
                                            <i class="fa fa-plus-circle fa-2x mr-2" aria-hidden="true"></i>
                                            {{__('Add New Data')}}
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="adm-form-card">
                                <h6>{{ __('Optional Fees') }}</h6>
                                <small class="text-danger mb-2 d-block">*
                                    {{__("Optional Fees does not support Due charges & Installment Facility")}}</small>
                                <div class="optional-fees-types">
                                    <div data-repeater-list="optional_fees_type" class="row col-12 pl-0 pr-0">
                                        <div class="row col-12 mb-3" data-repeater-item>
                                            <div class="form-group col-md-12 col-lg-5">
                                                <select name="fees_type_id" id="fees_type_id" class="form-control fees_type"
                                                    aria-label="Fees Type" required>
                                                    <option value="">{{ __('Select Fees Type')}}</option>
                                                    @foreach ($feesTypeData as $feesType)
                                                        <option value="{{ $feesType->id }}">{{ $feesType->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group col-md-12 col-lg-5">
                                                <input type="number" name="amount" class="form-control amount"
                                                    placeholder="{{ __('enter') . ' ' . __('fees') . ' ' . __('amount') }}"
                                                    required min="0" data-convert="number">
                                            </div>

                                            <div class="col-md-12 col-lg-2">
                                                <button type="button"
                                                    class="btn btn-inverse-danger btn-icon remove-fees-type"
                                                    data-repeater-delete>
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 pr-0 pl-0">
                                        <button class="btn btn-dark btn-sm" type="button" data-repeater-create>
                                            <i class="fa fa-plus-circle fa-2x mr-2" aria-hidden="true"></i>
                                            {{__('Add New Data')}}
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer pr-0 pb-0">
                                <button type="button" class="adm-btn-secondary"
                                    data-dismiss="modal">{{ __('Close') }}</button>
                                <button class="adm-btn-nav ml-2" type="submit">{{ __('submit') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            {{ __('List Fees')}}
                        </h4>


                        <div class="row" id="toolbar">
                            <div class="form-group col-sm-12 col-md-3">
                                <label for="filter-session-year-id" class="filter-menu">{{__("session_year")}}</label>
                                <select name="session_year_id" id="filter_session_year_id" class="form-control">
                                    @foreach($sessionYear as $key => $year)
                                        <option value="{{ $key }}" {{ $key == $defaultSessionYear->id ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-sm-12 col-md-3">
                                <label for="filter-medium_id" class="filter-menu">{{__("medium")}}</label>
                                <select name="medium_id" id="filter_medium_id" class="form-control">
                                    <option value="">{{ __('all') }}</option>
                                    @foreach($mediums as $key => $medium)
                                        <option value="{{ $key }}">{{ $medium }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 text-right">
                            <b><a href="#" class="table-list-type active mr-2" data-id="0">{{__('all')}}</a></b> | <a
                                href="#" class="ml-2 table-list-type" data-id="1">{{__("Trashed")}}</a>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <table aria-describedby="mydesc" class='table' id='table_list' data-toggle="table"
                                    data-url="{{ route('fees.show', 1) }}" data-click-to-select="true"
                                    data-side-pagination="server" data-pagination="true"
                                    data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-toolbar="#toolbar"
                                    data-show-columns="true" data-show-refresh="true" data-trim-on-search="false"
                                    data-mobile-responsive="true" data-sort-name="id" data-sort-order="desc"
                                    data-maintain-selected="true" data-export-data-type='all' data-show-export="true"
                                    data-query-params="feesQueryParams" data-escape="true" data-escape-title="false">
                                    <thead>
                                        <tr>
                                            <th scope="col" data-field="id" data-sortable="true" data-visible="false">
                                                {{__('id')}}
                                            </th>
                                            <th scope="col" data-field="no">{{__('no.')}}</th>
                                            <th scope="col" data-field="name" data-sortable="true">{{__('name')}}</th>
                                            <th scope="col" data-field="class.full_name" data-visible="false">
                                                {{__('Class')}}
                                            </th>
                                            <th scope="col" data-field="format_due_date" data-sortable="true">
                                                {{__('due_date')}}
                                            </th>
                                            <th scope="col" data-field="due_charges" data-align="center">
                                                {{__('due_charges')}} <small>(%)</small>
                                            </th>
                                            <th scope="col" data-field="installments"
                                                data-formatter="feesInstallmentFormatter">{{__('Fees Installment')}}</th>
                                            <th scope="col" data-field="fees_type" data-align="left"
                                                data-formatter="feesTypeFormatter">{{ __('Fees') }} {{__('type')}}</th>
                                            <th scope="col" data-field="compulsory_fees" data-align="center">
                                                {{ __('Compulsory Amount')}}
                                            </th>
                                            <th scope="col" data-field="total_fees" data-align="center">
                                                {{ __('Total Amount')}}
                                            </th>
                                            <th scope="col" data-events="feesEvents" data-field="operate"
                                                data-escape="false">{{__('action')}}</th>
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

@endsection
@section('js')
    <script>
        // Manual trigger for Fees Modal
        $('#btn-trigger-fees').on('click', function () {
            $('#feesModal').modal('show');
        });

        // Fix for select2 inside modal
        $('#feesModal').on('shown.bs.modal', function () {
            $('.select2').select2({
                dropdownParent: $('#feesModal')
            });
        });

        $('.compulsory-fees-types').find('[data-repeater-create]').click();

        function successFunction() {
            $('.compulsory-fees-types [data-repeater-item]').slice(1).empty();
            $('.fees-installment-repeater [data-repeater-item]').slice(0).empty();
            $('.fees-installment-repeater').hide();
        }

        // Handle installment amount calculations
        $(document).ready(function () {
            // Function to calculate total fees amount
            function calculateTotalAmount() {
                let totalAmount = 0;
                // Calculate compulsory fees
                $('.compulsory-fees-types .amount').each(function () {
                    let amount = parseFloat($(this).val()) || 0;
                    totalAmount += amount;
                });

                // Calculate optional fees
                $('.optional-fees-types .amount').each(function () {
                    let amount = parseFloat($(this).val()) || 0;
                    totalAmount += amount;
                });
                return totalAmount;
            }

            // Function to update installment amounts
            function updateInstallmentAmounts() {
                let totalAmount = calculateTotalAmount();
                let $installments = $('.fees-installment-repeater [data-repeater-item]');
                let totalInstallments = $installments.length;

                if (totalInstallments === 0) return;

                // Calculate equal base amount
                let baseAmount = Math.floor((totalAmount / totalInstallments) * 100) / 100;
                let totalDistributed = baseAmount * totalInstallments;

                // Remaining due to rounding
                let remaining = Math.round((totalAmount - totalDistributed) * 100) / 100;

                // Refresh selection before looping (fix for deleted last item)
                $installments = $('.fees-installment-repeater [data-repeater-item]');

                $installments.each(function (index) {
                    let finalAmount = baseAmount;

                    // Add remainder to the last one (re-evaluated .last())
                    if (index === $installments.length - 1) {
                        finalAmount += remaining;
                    }

                    $(this).find('.installment-amount').val(finalAmount.toFixed(2));
                });
            }


            // Function to handle dynamic installment amount changes
            function handleInstallmentAmountChange(changedIndex) {
                let totalAmount = calculateTotalAmount();
                let $installments = $('.fees-installment-repeater [data-repeater-item]');
                let totalInstallments = $installments.length;

                // Get the changed amount
                let changedAmount = parseFloat($installments.eq(changedIndex).find('.installment-amount').val()) || 0;

                // If last installment was changed, adjust the first (n-1) installments equally
                if (changedIndex === totalInstallments - 1) {
                    let remainingAmount = totalAmount - changedAmount;
                    let equalInstallments = totalInstallments - 1;
                    let equalAmount = Math.floor((remainingAmount / equalInstallments) * 100) / 100;

                    $installments.each(function (index) {
                        if (index < equalInstallments) {
                            $(this).find('.installment-amount').val(equalAmount.toFixed(2));
                        }
                    });
                } else {
                    // If any other installment was changed
                    let totalEqualAmount = 0;
                    let equalInstallments = totalInstallments - 1;

                    // Calculate total of equal installments
                    $installments.each(function (index) {
                        if (index < equalInstallments) {
                            let amount = parseFloat($(this).find('.installment-amount').val()) || 0;
                            totalEqualAmount += amount;
                        }
                    });

                    // Set remaining amount to last installment
                    let remainingAmount = (totalAmount - totalEqualAmount).toFixed(2);
                    $installments.last().find('.installment-amount').val(remainingAmount);
                }
            }

            // Listen for changes in compulsory fees amount
            $(document).on('input', '.compulsory-fees-types .amount', function () {
                updateInstallmentAmounts();
            });

            // Listen for changes in optional fees amount
            // $(document).on('input', '.optional-fees-types .amount', function() {
            //     updateInstallmentAmounts();
            // });

            // Listen for changes in any installment amount
            $(document).on('input', '.fees-installment-repeater [data-repeater-item] .installment-amount', function () {
                let changedIndex = $(this).closest('[data-repeater-item]').index();
                handleInstallmentAmountChange(changedIndex);
            });

            // Listen for installment addition
            $(document).on('click', '#add-installment', function () {
                setTimeout(updateInstallmentAmounts, 100);
            });

            // Listen for installment removal
            $(document).on('click', '[data-repeater-delete]', function () {
                setTimeout(updateInstallmentAmounts, 500);
            });

            // Handle fees installment toggle
            $('.fees-installment-toggle').change(function () {
                if ($(this).val() == '1') {
                    $('.fees-installment-repeater').show();
                    updateInstallmentAmounts();
                } else {
                    $('.fees-installment-repeater').hide();
                    $('.fees-installment-repeater [data-repeater-item]').slice(0).empty();
                }
            });

            // Initialize if installments are enabled
            if ($('.fees-installment-toggle:checked').val() == '1') {
                updateInstallmentAmounts();
            }
        });
    </script>
@endsection