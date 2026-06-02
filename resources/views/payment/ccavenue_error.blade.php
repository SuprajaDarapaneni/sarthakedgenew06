@extends('layouts.master')

@section('title')
    {{ __('Payment Failed') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="card">
                    <div class="card-body">
                        <h1 class="text-danger"><i class="fa fa-times-circle"></i></h1>
                        <h3>{{ __('Payment Failed') }}</h3>
                        <p>{{ __('Something went wrong with your payment. Please try again or contact support.') }}</p>
                        <a href="{{ url('/') }}" class="btn btn-theme">{{ __('Go to Home') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
