@extends('layouts.master')

@section('title')
    {{ __('transactions') }} {{__('logs')}}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ __('transactions') }} {{__('logs')}}
            </h3>
        </div>
        <div class="row mb-4">
            <div class="col-md-3 col-sm-6 grid-margin stretch-card">
                <div class="card shadow-sm border-0 rounded" style="border-radius: 12px; height: 110px;">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 50px; height: 50px; background-color: rgba(63, 136, 253, 0.1);">
                            <i class="fa fa-exchange text-primary" style="font-size: 22px;"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1 font-weight-bold" style="font-size: 0.85rem;">{{ __('Total Transactions') }}</p>
                            <h3 class="mb-0 font-weight-bold" style="font-size: 1.5rem; color: #333;">{{ $total_transactions }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 grid-margin stretch-card">
                <div class="card shadow-sm border-0 rounded" style="border-radius: 12px; height: 110px;">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 50px; height: 50px; background-color: rgba(26, 179, 148, 0.1);">
                            <i class="fa fa-check-circle" style="font-size: 22px; color: #1ab394;"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1 font-weight-bold" style="font-size: 0.85rem;">{{ __('Successful') }}</p>
                            <h3 class="mb-0 font-weight-bold" style="font-size: 1.5rem; color: #333;">{{ $successful }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 grid-margin stretch-card">
                <div class="card shadow-sm border-0 rounded" style="border-radius: 12px; height: 110px;">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 50px; height: 50px; background-color: rgba(35, 198, 200, 0.1);">
                            <i class="fa fa-money" style="font-size: 22px; color: #23c6c8;"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1 font-weight-bold" style="font-size: 0.85rem;">{{ __('Total Revenue') }} <span style="font-size:12px;">💵</span></p>
                            <h3 class="mb-0 font-weight-bold" style="font-size: 1.5rem; color: #333;">{{ $settings['currency_symbol'] ?? '₹' }}{{ number_format($total_revenue, 2) }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 grid-margin stretch-card">
                <div class="card shadow-sm border-0 rounded" style="border-radius: 12px; height: 110px;">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 50px; height: 50px; background-color: rgba(248, 172, 89, 0.1);">
                            <i class="fa fa-line-chart" style="font-size: 22px; color: #f8ac59;"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1 font-weight-bold" style="font-size: 0.85rem;">{{ __('GST (18%)') }}</p>
                            <h3 class="mb-0 font-weight-bold" style="font-size: 1.5rem; color: #333;">{{ $settings['currency_symbol'] ?? '₹' }}{{ number_format($gst, 2) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card search-container">
                <div class="card">
                    <div class="card-body">
                        <div id="toolbar" class="row">
                            <div class="col col-md-4">
                                <label for="filter_payment_status" style="font-size: 0.86rem;width: 110px">
                                    {{ __('Payment Status') }}
                                </label>
                                <select name="filter_payment_status" id="filter_payment_status" class="form-control">
                                    <option value="">{{__('all')}}</option>
                                    <option value="failed">{{__('failed')}}</option>
                                    <option value="succeed">{{__('succeed')}}</option>
                                    <option value="pending">{{__('pending')}}</option>
                                </select>
                            </div>
                        </div>
                        <table aria-describedby="mydesc" class='table' id='table_list' data-toggle="table"
                            data-url="{{ url('subscriptions/transactions/list') }}" data-click-to-select="true"
                            data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]"
                            data-search="true" data-toolbar="#toolbar" data-show-columns="true" data-show-refresh="true"
                            data-fixed-columns="false" data-fixed-number="2" data-fixed-right-number="1"
                            data-trim-on-search="false" data-mobile-responsive="true" data-sort-name="id"
                            data-sort-order="desc" data-maintain-selected="true" data-export-types='all'
                            data-export-options='{ "fileName": "{{__('fees')}}-{{__('transactions')}}-<?= date(' d-m-y') ?>" ,"ignoreColumn":["operate"]}'
                            data-show-export="true" data-query-params="subscriptionTransactionQueryParams"
                            data-escape="true">
                            <thead>
                                <tr>
                                    <th scope="col" data-field="id" data-sortable="true" data-visible="false">{{__('id')}}
                                    </th>
                                    <th scope="col" data-field="no">{{ __('no.') }}</th>
                                    <th scope="col" data-field="date">{{ __('date') }}</th>
                                    <th scope="col" data-field="school.logo" data-formatter="imageFormatter"
                                        data-align="center">{{ __('logo')}}</th>
                                    <th scope="col" data-field="school.name" data-align="center">{{ __('school')}}</th>
                                    <th scope="col" data-field="amount" data-align="center">{{ __('Amount')}}</th>
                                    <th scope="col" data-field="payment_gateway" data-align="center"
                                        data-formatter="subscriptionTransactionParentGateway">{{ __('Payment Type') }}</th>
                                    <th scope="col" data-field="payment_status" data-align="center"
                                        data-formatter="transactionPaymentStatus">{{ __('Payment Status') }}</th>
                                    <th scope="col" data-field="order_id" data-align="center" data-visible="false">
                                        {{ __('order_id_cheque_number') }}</th>
                                    <th scope="col" data-field="payment_id" data-align="center" data-visible="false">
                                        {{ __('payment_id') }}</th>
                                    <th scope="col" data-field="created_at" data-sortable="true" data-visible="false">
                                        {{ __('created_at') }}</th>
                                    <th scope="col" data-field="updated_at" data-sortable="true" data-visible="false">
                                        {{ __('updated_at') }}</th>
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
        $(document).ready(function () {
            for (let i = 0; i < document.styleSheets.length; i++) {
                let sheet = document.styleSheets[i];
                try {
                    if (!sheet.cssRules) continue; // Skip if cannot access
                    for (let j = sheet.cssRules.length - 1; j >= 0; j--) {
                        let rule = sheet.cssRules[j];
                        if (rule.selectorText &&
                            (rule.selectorText.includes('.search-container .search') ||
                                rule.selectorText.includes('.search-container .columns.columns-right.btn-group.float-right'))) {
                            sheet.deleteRule(j);
                        }
                    }
                } catch (e) {
                    // Cross-origin stylesheets may throw errors
                    continue;
                }
            }
        });
    </script>
@endsection