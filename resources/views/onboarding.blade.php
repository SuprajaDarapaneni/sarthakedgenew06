<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Onboarding Form || {{ config('app.name') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('assets/home_page/css/style.css') }}" rel="stylesheet">
    
    @include('layouts.include')

    <style>
        :root {
            --primary-color: #182ba9;
            --bg-light: #f6f7f9;
        }
        body {
            background-color: var(--bg-light);
            font-family: 'Poppins', sans-serif;
        }
        .onboarding-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }
        .form-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 900px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        .form-header {
            background: var(--primary-color);
            color: #fff;
            padding: 30px;
            text-align: center;
        }
        .form-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0;
        }
        .form-body {
            padding: 40px;
        }
        .schoolFormWrapper .headingWrapper {
            margin-bottom: 25px;
            border-bottom: 2px solid var(--primary-color);
            display: inline-block;
        }
        .schoolFormWrapper .headingWrapper span {
            font-size: 20px;
            font-weight: 600;
            color: var(--primary-color);
            text-transform: uppercase;
        }
        .inputWrapper {
            margin-bottom: 20px;
        }
        .inputWrapper label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }
        .inputWrapper input, 
        .inputWrapper select, 
        .inputWrapper textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            transition: border-color 0.3s;
        }
        .inputWrapper input:focus {
            border-color: var(--primary-color);
            outline: none;
        }
        .commonBtn {
            background: var(--primary-color);
            color: #fff;
            border: none;
            padding: 12px 40px;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s, background 0.3s;
        }
        .commonBtn:hover {
            background: #14228a;
            transform: translateY(-2px);
        }
        .back-to-home {
            position: absolute;
            top: 20px;
            left: 20px;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }
    </style>
</head>
<body>

    <a href="{{ url('/') }}" class="back-to-home"><i class="fa fa-arrow-left"></i> Back to Home</a>

    <div class="onboarding-container">
        <div class="form-card">
            <div class="form-header">
                <img src="{{ asset('assets/correct_new_logo.png') }}" alt="logo" style="max-height: 50px; filter: brightness(0) invert(1); margin-bottom: 15px;">
                <h1>Onboarding Form</h1>
                <p class="mb-0 text-white-50">Let's get your school set up in a few simple steps.</p>
            </div>
            <div class="form-body">
                <form class="onboarding-inquiry" action="{{ url('onboarding-inquiry') }}" method="post">
                    @csrf
                    <div class="schoolFormWrapper">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="inputWrapper">
                                    <label for="name">Your Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" placeholder="Enter your full name" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="inputWrapper">
                                    <label for="email">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" placeholder="Enter your email address" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="inputWrapper">
                                    <label for="mobile">Mobile Number <span class="text-danger">*</span></label>
                                    <input type="text" oninput="this.value=this.value.replace(/[^0-9]/g,'');" name="mobile" id="mobile"
                                        placeholder="Enter your mobile number" maxlength="15" pattern="[0-9]{6,15}" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="inputWrapper">
                                    <label for="school_name">School Name <span class="text-danger">*</span></label>
                                    <input type="text" name="subject" id="school_name" placeholder="Enter your school name" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="inputWrapper">
                                    <label for="message">Message / Requirements</label>
                                    <textarea name="message" id="message" rows="4" placeholder="How can we help you setup your school?"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-5">
                        <button type="submit" class="commonBtn">Send Message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/jquery-toast-plugin/jquery.toast.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.onboarding-inquiry').on('submit', function(e) {
                e.preventDefault();
                
                let form = $(this);
                let url = form.attr('action');
                let formData = new FormData(this);
                let submitBtn = form.find('button[type="submit"]');
                
                submitBtn.attr('disabled', true).text('Processing...');
                
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.error) {
                            $.toast({
                                text: response.message,
                                showHideTransition: 'slide',
                                icon: 'error',
                                position: 'top-right',
                                hideAfter: 5000
                            });
                        } else {
                            $.toast({
                                text: response.message,
                                showHideTransition: 'slide',
                                icon: 'success',
                                position: 'top-right',
                                hideAfter: 5000
                            });
                            form[0].reset();
                        }
                        submitBtn.attr('disabled', false).text('Send Message');
                    },
                    error: function(xhr) {
                        let errorMessage = 'Something went wrong. Please try again.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        $.toast({
                            text: errorMessage,
                            showHideTransition: 'slide',
                            icon: 'error',
                            position: 'top-right',
                            hideAfter: 5000
                        });
                        submitBtn.attr('disabled', false).text('Send Message');
                    }
                });
            });
        });
    </script>
</body>
</html>
