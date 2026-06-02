@extends('layouts.master')

@section('title')
    {{ __('Fees Transaction Logs') }}
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Page Header -->
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="fa fa-history"></i>
            </span>
            {{ __('Fees Transaction Logs') }}
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <span></span>{{ __('Fees Transaction Logs') }}
                    <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Quick Stats Row -->
    <div class="row mb-3" id="transaction-stats">
        <div class="col-6 col-md-3 grid-margin stretch-card">
            <div class="card card-statistics" style="border-left:4px solid #6c63ff;">
                <div class="custom-card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle p-2 mr-3" style="background:rgba(108,99,255,0.12);">
                            <i class="fa fa-file-text-o text-primary" style="font-size:1.3rem;"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small">{{ __('Total Txns') }}</p>
                            <h5 class="font-weight-bold mb-0 stat-total-txn">—</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3 grid-margin stretch-card">
            <div class="card card-statistics" style="border-left:4px solid #1bcfb4;">
                <div class="custom-card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle p-2 mr-3" style="background:rgba(27,207,180,0.12);">
                            <i class="fa fa-check-circle" style="color:#1bcfb4;font-size:1.3rem;"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small">{{ __('Succeeded') }}</p>
                            <h5 class="font-weight-bold mb-0 stat-success">—</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3 grid-margin stretch-card">
            <div class="card card-statistics" style="border-left:4px solid #fe7c96;">
                <div class="custom-card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle p-2 mr-3" style="background:rgba(254,124,150,0.12);">
                            <i class="fa fa-times-circle" style="color:#fe7c96;font-size:1.3rem;"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small">{{ __('Failed') }}</p>
                            <h5 class="font-weight-bold mb-0 stat-failed">—</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3 grid-margin stretch-card">
            <div class="card card-statistics" style="border-left:4px solid #f3ae4b;">
                <div class="custom-card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle p-2 mr-3" style="background:rgba(243,174,75,0.12);">
                            <i class="fa fa-clock-o" style="color:#f3ae4b;font-size:1.3rem;"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small">{{ __('Pending') }}</p>
                            <h5 class="font-weight-bold mb-0 stat-pending">—</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card search-container">
            <div class="card">
                <div class="card-body">
                    <!-- Filter Toolbar -->
                    <div id="toolbar">
                        <div class="row align-items-end mb-2">
                            <!-- Payment Status -->
                            <div class="form-group col-6 col-md-2 mb-2">
                                <label class="filter-menu small font-weight-bold" for="filter_payment_status">
                                    {{ __('Payment Status') }}
                                </label>
                                <select name="filter_payment_status" id="filter_payment_status" class="form-control form-control-sm">
                                    <option value="">{{ __('All') }}</option>
                                    <option value="failed">{{ __('failed') }}</option>
                                    <option value="succeed">{{ __('succeed') }}</option>
                                    <option value="pending">{{ __('pending') }}</option>
                                </select>
                            </div>

                            <!-- Payment Gateway -->
                            <div class="form-group col-6 col-md-2 mb-2">
                                <label class="filter-menu small font-weight-bold" for="filter_payment_gateway">
                                    {{ __('Payment Gateway') }}
                                </label>
                                <select name="filter_payment_gateway" id="filter_payment_gateway" class="form-control form-control-sm">
                                    <option value="">{{ __('All') }}</option>
                                    <option value="1">{{ __('Razorpay') }}</option>
                                    <option value="2">{{ __('Stripe') }}</option>
                                    <option value="cash">{{ __('Cash / Offline') }}</option>
                                </select>
                            </div>

                            <!-- Month -->
                            <div class="form-group col-6 col-md-2 mb-2">
                                <label class="filter-menu small font-weight-bold" for="filter_month">
                                    {{ __('Month') }}
                                </label>
                                <select name="month" id="filter_month" class="form-control form-control-sm paid-month">
                                    <option value="">{{ __('All') }}</option>
                                    @foreach($months as $key => $month)
                                        <option value="{{ $key }}" {{ $key == date('n') ? 'selected' : '' }}>{{ $month }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Session Year -->
                            <div class="form-group col-6 col-md-2 mb-2">
                                <label class="filter-menu small font-weight-bold" for="filter_session_year_id">
                                    {{ __('Session Year') }}
                                </label>
                                <select name="session_year_id" id="filter_session_year_id" class="form-control form-control-sm">
                                    @foreach ($session_year_all as $session_year)
                                        <option value="{{ $session_year->id }}"
                                            {{ $session_year->default ? 'selected' : '' }}>
                                            {{ $session_year->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Reset Filters -->
                            <div class="form-group col-6 col-md-2 mb-2 d-flex align-items-end">
                                <button type="button" class="btn btn-outline-secondary btn-sm w-100" id="reset-filters">
                                    <i class="fa fa-refresh mr-1"></i>{{ __('Reset') }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <table aria-describedby="mydesc" class='table table-hover' id='table_list'
                           data-toggle="table"
                           data-url="{{ route('fees.transactions.log.list', 1) }}"
                           data-click-to-select="true"
                           data-side-pagination="server"
                           data-pagination="true"
                           data-page-list="[5, 10, 20, 50, 100, 200]"
                           data-page-size="10"
                           data-search="true"
                           data-toolbar="#toolbar"
                           data-show-columns="true"
                           data-show-refresh="true"
                           data-fixed-columns="false"
                           data-fixed-right-number="1"
                           data-trim-on-search="false"
                           data-mobile-responsive="true"
                           data-sort-name="id"
                           data-sort-order="desc"
                           data-maintain-selected="true"
                           data-export-data-type='all'
                           data-export-options='{ "fileName": "fees-transactions-<?= date('d-m-y') ?>", "ignoreColumn": ["operate"] }'
                           data-show-export="true"
                           data-query-params="feesPaymentTransactionQueryParams"
                           data-escape="true">
                        <thead>
                        <tr>
                            <th scope="col" data-field="id" data-sortable="false" data-visible="false">{{ __('id') }}</th>
                            <th scope="col" data-field="no">{{ __('no.') }}</th>
                            <th scope="col" data-field="user.full_name" data-align="center">{{ __('User') }}</th>
                            <th scope="col" data-field="amount" data-align="center" data-formatter="inrCurrencyFormatter">{{ __('Amount') }}</th>
                            <th scope="col" data-field="payment_gateway" data-align="center" data-formatter="feesTransactionParentGateway">{{ __('Payment Gateway') }}</th>
                            <th scope="col" data-field="payment_status" data-align="center" data-formatter="transactionPaymentStatus">{{ __('Payment Status') }}</th>
                            <th scope="col" data-field="order_id" data-align="center" data-visible="false">{{ __('order_id') }}</th>
                            <th scope="col" data-field="payment_id" data-align="center" data-visible="false">{{ __('payment_id') }}</th>
                            <th scope="col" data-field="created_at" data-sortable="false" data-visible="true">{{ __('date') }}</th>
                            <th scope="col" data-field="updated_at" data-sortable="false" data-visible="false">{{ __('updated_at') }}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
// INR currency formatter for the table
function inrCurrencyFormatter(value) {
    if (value === null || value === undefined) return '—';
    return '₹ ' + parseFloat(value).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

// Extended query params to include gateway + month filters
function feesPaymentTransactionQueryParams(params) {
    params.payment_status    = $('#filter_payment_status').val();
    params.payment_gateway   = $('#filter_payment_gateway').val();
    params.month             = $('#filter_month').val();
    params.session_year_id   = $('#filter_session_year_id').val();
    return params;
}

// Bind filter change events
$('#filter_payment_status, #filter_payment_gateway, #filter_month, #filter_session_year_id').on('change', function () {
    $('#table_list').bootstrapTable('refresh');
});

// Reset filters
$('#reset-filters').on('click', function () {
    $('#filter_payment_status').val('');
    $('#filter_payment_gateway').val('');
    $('#filter_month').val('');
    $('#filter_session_year_id').find('option[selected]').prop('selected', true);
    $('#table_list').bootstrapTable('refresh');
});

// Update stats on table load
$('#table_list').on('load-success.bs.table', function (e, data) {
    if (!data || !data.rows) return;
    const rows = data.rows;
    $('.stat-total-txn').text(data.total || 0);
    const succeeded = rows.filter(r => r.payment_status == 1 || r.payment_status === 'succeed').length;
    const failed    = rows.filter(r => r.payment_status == 0 || r.payment_status === 'failed').length;
    const pending   = rows.filter(r => r.payment_status == 2 || r.payment_status === 'pending').length;
    $('.stat-success').text(succeeded);
    $('.stat-failed').text(failed);
    $('.stat-pending').text(pending);
});
</script>
@endsection
