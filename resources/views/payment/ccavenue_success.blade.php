@extends('layouts.master')

@section('title')
    {{ __('Payment Success') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="card">
                    <div class="card-body">
                        <h1 class="text-success"><i class="fa fa-check-circle"></i></h1>
                        <h3>{{ __('Payment Successful') }}</h3>
                        <p>{{ __('Your payment has been processed successfully.') }}</p>
                        <a href="{{ url('/') }}" class="btn btn-theme">{{ __('Go to Home') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
