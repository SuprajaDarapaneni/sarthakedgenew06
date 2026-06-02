<!DOCTYPE html>
<html lang="en">
@php
    $lang = Session::get('language');
@endphp
@if($lang)
    @if ($lang->is_rtl)
        <html lang="en" dir="rtl">
    @else
        <html lang="en" dir="ltl">
    @endif
@else
    <html lang="en" dir="ltl">
@endif

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="{{ asset('assets/home_page/css/style.css') }}" rel="stylesheet">

    <title>{{ __('login') }} || {{ config('app.name') }}</title>

    @include('layouts.include')

    <style>
        :root {
            --primary-color:
                {{ $systemSettings['theme_primary_color'] ?? '#56cc99' }}
            ;
            --secondary-color:
                {{ $systemSettings['theme_secondary_color'] ?? '#215679' }}
            ;
            --secondary-color1:
                {{ $systemSettings['theme_secondary_color_1'] ?? '#38a3a5' }}
            ;
            --primary-background-color:
                {{ $systemSettings['theme_primary_background_color'] ?? '#f2f5f7' }}
            ;
            --text--secondary-color:
                {{ $systemSettings['theme_text_secondary_color'] ?? '#5c788c' }}
            ;

        }

        .modal .modal-dialog {
            margin-top: unset !important;
        }

        a {
            color: #007bff !important;
        }

        .form-check .form-check-label input {
            opacity: 1 !important;
        }
    </style>
    <script async src="https://www.google.com/recaptcha/api.js"></script>
</head>

<body>
    <div class="d-flex min-vh-100">
        <!-- Left Side: Branding & Info -->
        <div class="d-none d-lg-flex flex-column justify-content-center align-items-center w-50 position-relative"
            style="background: #1557AC; color: white; overflow: hidden;">
            <!-- Background Decorations -->
            <div
                style="position: absolute; top: -150px; right: -150px; width: 500px; height: 500px; border-radius: 50%; background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);">
            </div>
            <div
                style="position: absolute; bottom: -200px; left: -200px; width: 600px; height: 600px; border-radius: 50%; background: radial-gradient(circle, rgba(255,255,255,0.03) 0%, transparent 70%);">
            </div>

            <div class="z-index-1 text-center position-relative p-5" style="max-width: 550px;">
                <div class="d-flex align-items-center justify-content-center mb-5">
                    <a href="{{ url('/') }}">
                        <img class="img-fluid" style="max-height: 140px;"
                            src="{{ asset('assets/web-site-images/logo.png') }}" alt="logo">
                    </a>
                </div>

                <h3 class="fw-bold mb-4" style="font-size: 26px;">Streamline Your School Operations</h3>
                <p class="mb-5" style="color: rgba(255,255,255,0.8); font-size: 15px; line-height: 1.6;">
                    A comprehensive school management platform designed to simplify administration, enhance
                    communication, and empower educators with intelligent automation and AI-powered insights.
                </p>

                <div class="d-flex justify-content-between align-items-center text-center mx-auto mt-4"
                    style="max-width: 450px;">
                    <!-- Statistics removed -->
                </div>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="d-flex flex-column justify-content-center align-items-center w-100 w-lg-50 position-relative p-3"
            style="background-color: #f6f7f9;">
            <div class="w-100 mx-auto" style="max-width: 420px; z-index: 10;">
                <h3 class="fw-bold text-dark mb-2" style="font-size: 26px;">Welcome back</h3>
                <p class="text-muted mb-5" style="font-size: 15px;">Enter your credentials to access your dashboard</p>

                @if (env('DEMO_MODE'))
                    <div class="alert alert-info text-center" role="alert">
                        NOTE : <a target="_blank" href="https://eschool-saas.wrteam.me/login">-- Click Here --</a> if you
                        cannot login.
                    </div>
                @endif
                <div class="mt-3">
                    @if (\Session::has('emailSuccess'))
                        <div class="alert alert-success text-center" role="alert">{{ \Session::get('emailSuccess') }}.</div>
                    @endif
                    @if (\Session::has('success'))
                        <div class="alert alert-success text-center" role="alert">{{ \Session::get('success') }}.</div>
                        <div class="alert alert-success text-center mt-2" role="alert">Please ensure you use your registered
                            email for login, and your contact number as the password.</div>
                    @endif
                    @if (\Session::has('emailError'))
                        <div class="alert alert-danger text-center" role="alert">{{ \Session::get('emailError') }}.</div>
                    @endif
                    @if (\Session::has('error'))
                        <div class="alert alert-danger text-center" role="alert">{{ \Session::get('error') }}.</div>
                    @endif
                </div>

                <form action="{{ route('login') }}" id="frmLogin" method="POST" class="pt-2">
                    @csrf

                    <div class="form-group mb-4 position-relative">
                        <label for="email" class="fw-bold text-dark mb-2 d-block" style="font-size: 14px;">Email
                            Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"
                                style="border-radius: 6px 0 0 6px; border-color: #e2e8f0; color: #94a3b8; border-right: none;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                    </path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                            </span>
                            <input id="email" type="text" class="form-control bg-white" name="email"
                                value="{{ isset($school) && !empty($school) && $school->type == 'demo' ? $school->user->email : old('email') }}"
                                required autocomplete="email" autofocus placeholder="info@sarthakedge.com"
                                style="border-radius: 0 6px 6px 0; border-color: #e2e8f0; border-left: none; height: 46px; font-size: 15px; box-shadow: none;">
                        </div>
                    </div>

                    <div class="form-group mb-2 position-relative">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label for="password" class="fw-bold text-dark mb-0 form-label"
                                style="font-size: 14px;">Password</label>
                            @if (Route::has('password.request'))
                                <a class="text-decoration-none" style="font-size: 13px; color: #1557AC;"
                                    href="{{ route('password.request') }}">
                                    Forgot password?
                                </a>
                            @endif
                        </div>
                        <div class="input-group">
                            <span class="input-group-text bg-white"
                                style="border-radius: 6px 0 0 6px; border-color: #e2e8f0; color: #94a3b8; border-right: none;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                            </span>
                            <input id="password" type="password" class="form-control bg-white" name="password" required
                                value="{{ isset($school) && !empty($school) && $school->type == 'demo' ? $school->user->mobile : '' }}"
                                autocomplete="current-password" placeholder="********"
                                style="border-color: #e2e8f0; border-left: none; border-right: none; height: 46px; font-size: 15px; box-shadow: none;">
                            <span class="input-group-text bg-white border-start-0" id="togglePasswordShowHide"
                                style="border-radius: 0 6px 6px 0; border-color: #e2e8f0; color: #94a3b8; cursor: pointer; border-left: none;">
                                <i class="fa fa-eye-slash" id="togglePassword" style="font-size: 16px;"></i>
                            </span>
                        </div>
                    </div>

                    @if ($school ?? '')
                        <div class="form-group d-none">
                            <input id="school_code" type="text" class="form-control" name="code"
                                value="{{ $school->code }}">
                        </div>
                    @else
                        <!-- Space for school code if needed -->
                        <div class="form-group mb-3 mt-4">
                            <label for="school_code" class="fw-bold text-dark mb-2 form-label"
                                style="font-size: 14px;">{{ __('school_code') }}</label>
                            <input id="school_code" type="text" class="form-control bg-white" name="code"
                                value="{{ old('school_code') }}" placeholder="{{ __('school_code') }}"
                                style="border-radius: 6px; border: 1px solid #e2e8f0; height: 46px; font-size: 15px; box-shadow: none; padding-left: 15px;">
                        </div>
                    @endif

                    <div class="form-group mt-4 mb-4">
                        <div class="form-check d-flex align-items-center ps-0">
                            <input type="checkbox" class="form-check-input mt-0 me-2" id="remember" name="remember"
                                style="width: 16px; height: 16px; border: 1px solid #cbd5e1; border-radius: 4px; margin-left: 0;">
                            <label class="form-check-label text-muted" for="remember" style="font-size: 14px;">Remember
                                me for 30 days</label>
                        </div>
                    </div>

                    <div class="mt-4 pt-2">
                        <input type="submit" name="btnlogin" id="login_btn" value="Sign In" class="btn w-100 fw-bold"
                            style="background-color: #1557AC; color: white; border-radius: 6px; height: 48px; font-size: 16px; border: none; transition: .3s background;"
                            onmouseover="this.style.backgroundColor='#104385'"
                            onmouseout="this.style.backgroundColor='#1557AC'" />
                    </div>
                </form>

                <div class="text-center mt-5">
                    <span class="text-muted" style="font-size: 14px;">Need help? </span>
                    <a href="#" class="text-decoration-none" style="color: #1557AC; font-size: 14px;"
                        data-bs-toggle="modal" data-bs-target="#staticBackdrop">Contact Support</a>
                </div>

                <div class="text-center mt-5 pt-4">
                    <span class="text-muted" style="font-size: 12px;">© 2026 SarthakEdge — Your Digital Edge</span>
                </div>

                @include('registration_form')

                @if (env('DEMO_MODE'))
                    <div class="row mt-4 pt-3">
                        <hr style="width: -webkit-fill-available; border-color: #e2e8f0;">
                        <div class="col-12 text-center mb-4 text-muted" style="font-size: 14px;">Demo Credentials</div>
                    </div>
                    @if (empty($school) ?? '')
                        <div class="col-12 text-center" style="font-size: 13px;">Super Admin Panels</div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <button class="btn w-100 btn-success mt-2" style="font-size: 13px;" id="superadmin_btn">Super
                                    Admin</button>
                            </div>
                            <div class="col-md-6">
                                <button class="btn w-100 btn-info mt-2" style="font-size: 13px;"
                                    id="superadmin_staff_btn">Staff</button>
                            </div>
                        </div>
                    @endif
                    <div class="col-12 text-center mt-4" style="font-size: 13px;">School Admin Panels</div>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <button class="btn w-100 btn-info mt-2" style="font-size: 12px; padding: 6px;"
                                id="schooladmin_btn">School Admin</button>
                        </div>
                        <div class="col-md-4">
                            <button class="btn w-100 btn-danger mt-2" style="font-size: 12px; padding: 6px;"
                                id="teacher_btn">Teacher</button>
                        </div>
                        <div class="col-md-4">
                            <button class="btn w-100 btn-primary mt-2" style="font-size: 12px; padding: 6px;"
                                id="schooladmin_staff_btn">Staff</button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="{{ asset('/assets/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('/assets/jquery-toast-plugin/jquery.toast.min.js') }}"></script>
    <script src="{{ asset('/assets/js/custom/common.js') }}"></script>
    <script src="{{ asset('/assets/js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('/assets/js/custom/function.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

    <script type='text/javascript'>
        $("#frmLogin").validate({
            rules: {
                username: "required",
                password: "required",
            },
            success: function (label, element) {
                $(element).parent().removeClass('has-danger')
                $(element).removeClass('form-control-danger')
            },
            errorPlacement: function (label, element) {
                if (label.text()) {
                    if ($(element).attr("name") == "password") {
                        label.insertAfter(element.parent()).addClass('text-danger mt-2');
                    } else {
                        label.addClass('mt-2 text-danger');
                        label.insertAfter(element);
                    }
                }
            },
            highlight: function (element, errorClass) {
                $(element).parent().addClass('has-danger')
                $(element).addClass('form-control-danger')
            }
        });

        const togglePassword = document.querySelector("#togglePasswordShowHide");
        const password = document.querySelector("#password");

        togglePassword.addEventListener("click", function () {
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            // this.classList.toggle("fa-eye");
            if (password.getAttribute("type") === 'password') {
                $('#togglePassword').addClass('fa-eye-slash');
                $('#togglePassword').removeClass('fa-eye');
            } else {
                $('#togglePassword').removeClass('fa-eye-slash');
                $('#togglePassword').addClass('fa-eye');
            }
        });

        @if (env('DEMO_MODE'))
            // Super admin panel
            $('#superadmin_btn').on('click', function (e) {
                $('#email').val('superadmin@gmail.com');
                $('#password').val('superadmin');
                $('#login_btn').attr('disabled', true);
                $(this).attr('disabled', true);
                $('#frmLogin').submit();
            })

            $('#superadmin_staff_btn').on('click', function (e) {
                $('#email').val('mahesh@gmail.com');
                $('#password').val('staff@123');
                $('#login_btn').attr('disabled', true);
                $(this).attr('disabled', true);
                $('#frmLogin').submit();
            })

            // School Panel
            $('#schooladmin_btn').on('click', function (e) {
                $('#email').val('school1@gmail.com');
                $('#password').val('school@123');
                $('#school_code').val('SCH202412');
                $('#login_btn').attr('disabled', true);
                $(this).attr('disabled', true);
                $('#frmLogin').submit();
            })
            $('#teacher_btn').on('click', function (e) {
                $('#email').val('teacher@gmail.com');
                $('#password').val('0111111111');
                $('#school_code').val('SCH202412');
                $('#login_btn').attr('disabled', true);
                $(this).attr('disabled', true);
                $('#frmLogin').submit();
            })

            $('#schooladmin_staff_btn').on('click', function (e) {
                $('#email').val('smitc@gmail.com');
                $('#password').val('965555885');
                $('#school_code').val('SCH202412');
                $('#login_btn').attr('disabled', true);
                $(this).attr('disabled', true);
                $('#frmLogin').submit();
            })
        @endif

        const please_wait = "{{__('Please wait')}}"
        const processing_your_request = "{{__('Processing your request')}}"
    </script>
</body>

@if (Session::has('error'))
    <script type='text/javascript'>
        $.toast({
            text: '{{ Session::get('error') }}',
            showHideTransition: 'slide',
            icon: 'error',
            loaderBg: '#f2a654',
            position: 'top-right'
        });
    </script>
@endif

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script type='text/javascript'>
            $.toast({
                text: '{{ $error }}',
                showHideTransition: 'slide',
                icon: 'error',
                loaderBg: '#f2a654',
                position: 'top-right'
            });
        </script>
    @endforeach
@endif

</html>