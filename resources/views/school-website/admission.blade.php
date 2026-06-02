@extends('layouts.school.master')
@section('title')
    {{ __('admission') }}
@endsection

@section('css')
    <style>
        /* ── THEME COLORS (Matches School Master) ── */
        :root {
            --nb-primary: #162fac;
            --nb-primary-dark: #0f2190;
            --nb-primary-light: rgba(22, 47, 172, 0.1);
            --nb-text-muted: #64748b;
            --nb-bg-light: #f8fafc;
        }

        .admissionPage {
            background: #f0f4f8;
            padding: 3rem 0;
            min-height: 100vh;
        }

        /* ── Main Container ── */
        .adm-v3-container {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(30, 41, 59, 0.08);
            border: 1px solid #e2e8f0;
            overflow: hidden;
            margin-bottom: 3rem;
        }

        /* Header */
        .adm-form-header {
            background: var(--nb-primary);
            padding: 2.5rem;
            color: #ffffff;
            text-align: center;
        }

        .adm-form-header h1 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .adm-form-header p {
            font-size: 1rem;
            opacity: 0.9;
            margin: 0;
        }

        /* Stepper */
        .adm-stepper-container {
            background: var(--nb-bg-light);
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #e8edf5;
        }

        .adm-stepper {
            display: flex;
            align-items: center;
            justify-content: center;
            max-width: 800px;
            margin: 0 auto;
            padding: 0;
            list-style: none;
        }

        .adm-step-item {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            position: relative;
            z-index: 1;
        }

        .adm-step-line {
            flex: 1;
            height: 2px;
            background: #cbd5e1;
            min-width: 30px;
            max-width: 80px;
            margin: 0 10px;
            transition: all 0.4s;
        }

        .adm-step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #ffffff;
            border: 2px solid #cbd5e1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 700;
            color: #94a3b8;
            transition: all 0.3s;
        }

        .adm-step-label {
            font-size: 0.9rem;
            font-weight: 600;
            color: #94a3b8;
            white-space: nowrap;
        }

        .adm-step-item.active .adm-step-circle {
            background: var(--nb-primary);
            border-color: var(--nb-primary);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(22, 47, 172, 0.3);
        }

        .adm-step-item.active .adm-step-label {
            color: var(--nb-primary);
            font-weight: 700;
        }

        .adm-step-item.completed .adm-step-circle {
            background: var(--nb-primary);
            border-color: var(--nb-primary);
            color: #ffffff;
            opacity: 0.7;
        }

        /* Form Content */
        .adm-form-body {
            padding: 3rem;
            background: var(--nb-bg-light);
        }

        .adm-form-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 2.22rem;
            border: 1px solid #e8edf5;
            box-shadow: 0 4px 12px rgba(30, 41, 59, 0.03);
            margin-bottom: 2rem;
        }

        .adm-form-card h6 {
            font-size: 1.15rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1.8rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .adm-form-card label {
            font-size: 0.9rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: 0.6rem;
            display: block;
        }

        .adm-form-card .form-control {
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .adm-form-card .form-control:focus {
            border-color: var(--nb-primary);
            box-shadow: 0 0 0 4px rgba(22, 47, 172, 0.08);
        }

        /* Upload Zones */
        .adm-upload-zone {
            border: 2px dashed #cbd5e1;
            border-radius: 16px;
            padding: 2.5rem 1rem;
            text-align: center;
            background: #f8fafc;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }
        .adm-upload-zone:hover {
            border-color: var(--nb-primary);
            background: rgba(22, 47, 172, 0.05);
        }
        .adm-upload-zone i {
            font-size: 2.8rem;
            color: var(--nb-primary);
            margin-bottom: 1rem;
            display: block;
        }
        .adm-upload-zone p {
            font-weight: 700;
            color: #334155;
            margin-bottom: 0.2rem;
        }

        .adm-file-preview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 1.2rem;
        }

        .adm-file-preview-item {
            position: relative;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1rem;
            text-align: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .adm-file-remove {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #ef4444;
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            cursor: pointer;
            border: 2px solid white;
        }

        /* Footer / Navigation */
        .adm-form-footer {
            background: #ffffff;
            padding: 2rem 3rem;
            border-top: 1px solid #e8edf5;
            display: flex;
            justify-content: space-between;
        }

        .adm-btn-secondary {
            background: #f1f5f9;
            color: #475569;
            border: none;
            padding: 1rem 2rem;
            border-radius: 14px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
        }

        .adm-btn-nav {
            background: var(--nb-primary);
            color: #ffffff !important;
            padding: 1rem 2.5rem;
            border-radius: 14px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            box-shadow: 0 8px 20px rgba(22, 47, 172, 0.25);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .adm-form-body { padding: 1.5rem; }
            .adm-step-label { display: none; }
            .adm-form-header { padding: 2rem 1rem; }
            .adm-form-footer { padding: 1.5rem; }
        }
        
        .adm-upload-box {
            width: 120px;
            height: 140px;
            border: 2px dashed #cbd5e1;
            border-radius: 18px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            cursor: pointer;
            background: #ffffff;
            transition: all 0.3s;
            margin: 0 auto;
            overflow: hidden;
            background-size: cover;
            background-position: center;
        }
        .adm-upload-box i { font-size: 2rem; color: #94a3b8; }
        .adm-upload-box span { font-size: 0.8rem; color: #64748b; font-weight: 600; }
    </style>
@endsection

@section('content')
    <div class="main admissionPage">
        <div class="container">
            <div class="adm-v3-container">
                <!-- Header -->
                <div class="adm-form-header">
                    <h1>{{ __('student_admission_form') }}</h1>
                    <p>{{ __('Please complete all 4 steps to submit your online registration.') }}</p>
                </div>

                <!-- Stepper -->
                <div class="adm-stepper-container">
                    <ul class="adm-stepper">
                        <li class="adm-step-item active" data-step="1">
                            <div class="adm-step-circle">1</div>
                            <div class="adm-step-label">{{ __('Personal Info') }}</div>
                        </li>
                        <div class="adm-step-line" id="line-1"></div>
                        <li class="adm-step-item" data-step="2">
                            <div class="adm-step-circle">2</div>
                            <div class="adm-step-label">{{ __('Parents Info') }}</div>
                        </li>
                        <div class="adm-step-line" id="line-2"></div>
                        <li class="adm-step-item" data-step="3">
                            <div class="adm-step-circle">3</div>
                            <div class="adm-step-label">{{ __('Academic Info') }}</div>
                        </li>
                        <div class="adm-step-line" id="line-3"></div>
                        <li class="adm-step-item" data-step="4">
                            <div class="adm-step-circle">4</div>
                            <div class="adm-step-label">{{ __('Documents') }}</div>
                        </li>
                    </ul>
                </div>

                <!-- Body -->
                <div class="adm-form-body">
                    <form id="online-admission-form" action="{{ route('online-admission.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                        @csrf

                        <!-- Tab Content -->
                        <div class="tab-content">
                            <!-- Step 1: Personal -->
                            <div class="tab-pane fade show active" id="step-1">
                                <div class="adm-form-card">
                                    <h6><i class="fa fa-user text-primary"></i> {{ __('Student Information') }}</h6>
                                    <div class="row">
                                        <div class="col-md-3 mb-4">
                                            <div class="adm-upload-box" id="student-photo-preview" onclick="document.getElementById('student-photo-input').click()">
                                                <i class="fa fa-camera"></i>
                                                <span>{{ __('Upload Photo') }}</span>
                                            </div>
                                            <input type="file" name="image" id="student-photo-input" class="d-none" accept="image/*" onchange="previewProfile(this, 'student-photo-preview')">
                                        </div>
                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-3">
                                                    <label>{{ __('First Name') }} <span class="text-danger">*</span></label>
                                                    <input type="text" name="first_name" class="form-control" required placeholder="John">
                                                </div>
                                                <div class="form-group col-md-6 mb-3">
                                                    <label>{{ __('Last Name') }} <span class="text-danger">*</span></label>
                                                    <input type="text" name="last_name" class="form-control" required placeholder="Doe">
                                                </div>
                                                <div class="form-group col-md-6 mb-3">
                                                    <label>{{ __('Date of Birth') }} <span class="text-danger">*</span></label>
                                                    <input type="date" name="dob" class="form-control" required>
                                                </div>
                                                <div class="form-group col-md-6 mb-3">
                                                    <label>{{ __('Gender') }} <span class="text-danger">*</span></label>
                                                    <div class="d-flex gap-4 mt-2">
                                                        <label class="d-flex align-items-center gap-2" style="cursor:pointer">
                                                            <input type="radio" name="gender" value="male" checked> {{ __('male') }}
                                                        </label>
                                                        <label class="d-flex align-items-center gap-2" style="cursor:pointer">
                                                            <input type="radio" name="gender" value="female"> {{ __('female') }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-3">
                                            <label>{{ __('Mobile Number') }}</label>
                                            <input type="text" name="mobile" class="form-control" placeholder="Optional">
                                        </div>
                                        <div class="form-group col-md-6 mb-3">
                                            <label>{{ __('Current Address') }} <span class="text-danger">*</span></label>
                                            <textarea name="current_address" class="form-control" rows="3" required></textarea>
                                        </div>
                                        <div class="form-group col-md-6 mb-3">
                                            <label>{{ __('Permanent Address') }} <span class="text-danger">*</span></label>
                                            <textarea name="permanent_address" class="form-control" rows="3" required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2: Guardian -->
                            <div class="tab-pane fade" id="step-2">
                                <div class="adm-form-card">
                                    <h6><i class="fa fa-users text-primary"></i> {{ __('Parents / Guardian Information') }}</h6>
                                    <div class="row">
                                        <div class="col-md-3 mb-4">
                                            <div class="adm-upload-box" id="guardian-photo-preview" onclick="document.getElementById('guardian-photo-input').click()">
                                                <i class="fa fa-camera"></i>
                                                <span>{{ __('Upload Photo') }}</span>
                                            </div>
                                            <input type="file" name="guardian_image" id="guardian-photo-input" class="d-none" accept="image/*" onchange="previewProfile(this, 'guardian-photo-preview')">
                                        </div>
                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-3">
                                                    <label>{{ __('Guardian First Name') }} <span class="text-danger">*</span></label>
                                                    <input type="text" name="guardian_first_name" class="form-control" required>
                                                </div>
                                                <div class="form-group col-md-6 mb-3">
                                                    <label>{{ __('Guardian Last Name') }} <span class="text-danger">*</span></label>
                                                    <input type="text" name="guardian_last_name" class="form-control" required>
                                                </div>
                                                <div class="form-group col-md-6 mb-3">
                                                    <label>{{ __('Guardian Mobile') }} <span class="text-danger">*</span></label>
                                                    <input type="text" name="guardian_mobile" class="form-control" required>
                                                </div>
                                                <div class="form-group col-md-6 mb-3">
                                                    <label>{{ __('Guardian Email') }} <span class="text-danger">*</span></label>
                                                    <input type="email" name="guardian_email" class="form-control" required placeholder="Used for login">
                                                </div>
                                                <div class="form-group col-md-6 mb-3">
                                                    <label>{{ __('Guardian Gender') }} <span class="text-danger">*</span></label>
                                                    <select name="guardian_gender" class="form-control" required>
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 3: Academic -->
                            <div class="tab-pane fade" id="step-3">
                                <div class="adm-form-card">
                                    <h6><i class="fa fa-graduation-cap text-primary"></i> {{ __('Enrollment Details') }}</h6>
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-4">
                                            <label>{{ __('Select Class') }} <span class="text-danger">*</span></label>
                                            <select name="class_id" class="form-control" required style="height:auto; font-size:1.1rem; padding:1rem;">
                                                <option value="">-- {{ __('Choose Class & Medium') }} --</option>
                                                @foreach ($classes as $class)
                                                    <option value="{{ $class->id }}">{{ $class->name.' '. $class->medium->name.' '.($class->stream->name ?? '')}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    @if(count($extraFields))
                                        <h6 class="mt-4"><i class="fa fa-plus-circle text-primary"></i> {{ __('Other Information') }}</h6>
                                        <div class="row">
                                            @foreach ($extraFields as $key => $data)
                                                <input type="hidden" name="extra_fields[{{ $key }}][form_field_id]" value="{{ $data->id }}">
                                                <div class="form-group col-md-6 mb-3">
                                                    @if($data->type != 'radio' && $data->type != 'checkbox')
                                                        <label>{{ $data->name }} {{ $data->is_required ? '*' : '' }}</label>
                                                    @endif

                                                    @if($data->type == 'text')
                                                        <input type="text" name="extra_fields[{{ $key }}][data]" class="form-control" placeholder="{{ $data->name }}" {{ $data->is_required ? 'required' : '' }}>
                                                    @elseif($data->type == 'number')
                                                        <input type="number" name="extra_fields[{{ $key }}][data]" class="form-control" {{ $data->is_required ? 'required' : '' }}>
                                                    @elseif($data->type == 'dropdown')
                                                        <select name="extra_fields[{{ $key }}][data]" class="form-control" {{ $data->is_required ? 'required' : '' }}>
                                                            <option value="">Select {{ $data->name }}</option>
                                                            @foreach($data->default_values as $val)
                                                                <option value="{{ $val }}">{{ $val }}</option>
                                                            @endforeach
                                                        </select>
                                                    @elseif($data->type == 'textarea')
                                                        <textarea name="extra_fields[{{ $key }}][data]" class="form-control" rows="2" {{ $data->is_required ? 'required' : '' }}></textarea>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Step 4: Documents -->
                            <div class="tab-pane fade" id="step-4">
                                <div class="adm-form-card">
                                    <h6 class="mb-3"><i class="fa fa-file-text text-primary"></i> {{ __('Academic Documents') }} <span class="text-danger">*</span></h6>
                                    <div class="adm-upload-zone" onclick="document.getElementById('student-docs-input').click()">
                                        <i class="fa fa-cloud-upload"></i>
                                        <p>{{ __('Drag & Drop or Click to upload files') }}</p>
                                        <span class="text-muted small">{{ __('(Birth Certificate, Previous Marksheets, etc.)') }}</span>
                                        <input type="file" name="student_documents[]" id="student-docs-input" multiple class="d-none" onchange="handleFileSelect(this, 'academic-preview')">
                                    </div>
                                    <div id="academic-preview" class="adm-file-preview-grid mt-3"></div>
                                </div>

                                <div class="adm-form-card">
                                    <h6 class="mb-3"><i class="fa fa-id-card text-primary"></i> {{ __('Guardian Documents') }} <span class="text-danger">*</span></h6>
                                    <div class="adm-upload-zone" onclick="document.getElementById('guardian-docs-input').click()">
                                        <i class="fa fa-id-card-o"></i>
                                        <p>{{ __('Drag & Drop or Click to upload files') }}</p>
                                        <span class="text-muted small">{{ __('(Aadhar Card, Pan Card, etc.)') }}</span>
                                        <input type="file" name="guardian_documents[]" id="guardian-docs-input" multiple class="d-none" onchange="handleFileSelect(this, 'guardian-preview')">
                                    </div>
                                    <div id="guardian-preview" class="adm-file-preview-grid mt-3"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Navigation -->
                        <div class="adm-form-footer">
                            <button type="button" class="adm-btn-secondary d-none" id="btn-prev-step">
                                <i class="fa fa-arrow-left"></i> {{ __('Previous') }}
                            </button>
                            <div class="ms-auto d-flex gap-3">
                                <button type="button" class="adm-btn-nav" id="btn-next-step">
                                    {{ __('Save & Continue') }} <i class="fa fa-arrow-right"></i>
                                </button>
                                <button type="submit" class="adm-btn-nav d-none" id="btn-submit-admission" style="background: #10b981;">
                                    <i class="fa fa-check-circle"></i> {{ __('Finish & Enroll') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('/assets/js/sweetalert2.all.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var currentStep = 1;
            var totalSteps = 4;

            function updateUI(step) {
                // Update Tabs
                $('.tab-pane').removeClass('show active');
                $('#step-' + step).addClass('show active');

                // Update Stepper
                $('.adm-step-item').each(function() {
                    var s = $(this).data('step');
                    $(this).removeClass('active completed');
                    if (s < step) $(this).addClass('completed');
                    if (s === step) $(this).addClass('active');
                });

                $('.adm-step-line').each(function(index) {
                    if (index + 1 < step) $(this).addClass('active');
                    else $(this).removeClass('active');
                });

                // Update Buttons
                if (step === 1) $('#btn-prev-step').addClass('d-none');
                else $('#btn-prev-step').removeClass('d-none');

                if (step === totalSteps) {
                    $('#btn-next-step').addClass('d-none');
                    $('#btn-submit-admission').removeClass('d-none');
                } else {
                    $('#btn-next-step').removeClass('d-none');
                    $('#btn-submit-admission').addClass('d-none');
                }
                
                // Scroll to top of form
                $('html, body').animate({ scrollTop: $(".adm-v3-container").offset().top - 100 }, 300);
            }

            $('#btn-next-step').click(function() {
                // Basic Validation for current step
                var valid = true;
                $('#step-' + currentStep + ' [required]').each(function() {
                    if (!$(this).val()) {
                        $(this).addClass('is-invalid');
                        valid = false;
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                if (valid && currentStep < totalSteps) {
                    currentStep++;
                    updateUI(currentStep);
                }
            });

            $('#btn-prev-step').click(function() {
                if (currentStep > 1) {
                    currentStep--;
                    updateUI(currentStep);
                }
            });

            // Form Submit Interception
            $('#online-admission-form').on('submit', function(e) {
                if (!this.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                    Swal.fire('Error', 'Please fill all required fields.', 'error');
                }
            });
        });

        // File Helpers (Outside document ready for global access)
        window.previewProfile = function(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var preview = document.getElementById(previewId);
                    preview.style.backgroundImage = 'url(' + e.target.result + ')';
                    preview.style.backgroundSize = 'cover';
                    preview.style.backgroundPosition = 'center';
                    
                    // Hide icon and span
                    var children = preview.children;
                    for (var i = 0; i < children.length; i++) {
                        children[i].style.display = 'none';
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        };

        window.handleFileSelect = function(input, previewId) {
            const files = input.files;
            const previewContainer = document.getElementById(previewId);
            
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const item = document.createElement('div');
                    item.className = 'adm-file-preview-item';
                    
                    let icon = 'fa-file-o';
                    if (file.type.includes('image')) icon = 'fa-file-image-o';
                    if (file.type.includes('pdf')) icon = 'fa-file-pdf-o';
                    
                    item.innerHTML = `
                        <div class="adm-file-remove" onclick="this.parentElement.remove()"><i class="fa fa-times"></i></div>
                        <i class="fa ${icon}"></i>
                        <p title="${file.name}">${file.name}</p>
                    `;
                    previewContainer.appendChild(item);
                };
                reader.readAsDataURL(file);
            }
        };
    </script>
@endsection
