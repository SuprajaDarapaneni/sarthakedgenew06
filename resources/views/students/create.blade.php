@extends('layouts.master')

@section('title')
    {{ __('students') }}
@endsection

@section('css')
    <style>
        /* ── THEME COLORS (Matches Sidebar #162fac) ── */
        :root {
            --nb-primary: #162fac;
            --nb-primary-dark: #0f2190;
            --nb-primary-light: rgba(22, 47, 172, 0.1);
            --nb-text-muted: #64748b;
            --nb-bg-light: #f8fafc;
        }

        /* Wrapper */
        .adm-v3-wrapper {
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
            /* Ensure clickability */
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

        /* Stepper */
        .adm-stepper-container {
            background: var(--nb-bg-light);
            padding: 1.2rem 2rem;
            border-bottom: 1px solid #e8edf5;
        }

        .adm-stepper {
            display: flex !important;
            align-items: center;
            justify-content: center;
            max-width: 650px;
            margin: 0 auto;
            padding: 0;
            list-style: none;
        }

        .adm-step-item {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            position: relative;
            z-index: 1;
        }

        .adm-step-line {
            flex: 1;
            height: 2px;
            background: #cbd5e1;
            min-width: 40px;
            max-width: 100px;
            margin: 0 10px;
            transition: all 0.4s;
        }

        .adm-step-line.active {
            background: var(--nb-primary);
        }

        .adm-step-circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #ffffff;
            border: 2px solid #cbd5e1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 700;
            color: #94a3b8;
            transition: all 0.3s;
        }

        .adm-step-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #94a3b8;
            white-space: nowrap;
            transition: color 0.3s;
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

        /* Form Elements */
        .modal-body.adm-modal-body {
            background: var(--nb-bg-light);
            padding: 2rem;
        }

        .adm-nav-pills {
            background: #ffffff;
            padding: 6px;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            display: flex;
            gap: 4px;
            margin-bottom: 2rem;
        }

        .adm-nav-pills .nav-link {
            border: none !important;
            border-radius: 10px !important;
            text-align: center;
            font-size: 0.9rem;
            font-weight: 600;
            color: #64748b !important;
            padding: 0.7rem 0.5rem;
            background: transparent !important;
            transition: all 0.2s;
            flex: 1;
            cursor: pointer;
        }

        .adm-nav-pills .nav-link.active {
            background: var(--nb-primary) !important;
            color: #ffffff !important;
        }

        .adm-form-card {
            background: #ffffff;
            border-radius: 18px;
            padding: 1.8rem;
            border: 1px solid #e8edf5;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            margin-bottom: 1.5rem;
        }

        .adm-form-card h6 {
            font-size: 1.05rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1.5rem;
            padding-bottom: 0.8rem;
            border-bottom: 2px solid #f1f5f9;
        }

        /* Upload Zones */
        .adm-upload-zone {
            border: 2px dashed #cbd5e1;
            border-radius: 16px;
            padding: 2.5rem 1rem;
            text-align: center;
            background: #f8fafc;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }
        .adm-upload-zone:hover {
            border-color: var(--nb-primary);
            background: rgba(22, 47, 172, 0.05);
            transform: scale(1.01);
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
            grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
            gap: 1rem;
        }
        .adm-file-preview-item {
            position: relative;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.8rem;
            text-align: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.3s ease;
        }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
        
        .adm-file-preview-item i {
            font-size: 1.8rem;
            color: var(--nb-primary);
            margin-bottom: 0.5rem;
        }
        .adm-file-preview-item p {
            font-size: 0.75rem;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: #475569;
            font-weight: 500;
        }
        .adm-file-remove {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #ef4444;
            color: white;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            cursor: pointer;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
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

        .adm-form-card .form-control {
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            background: #fafafa;
            padding: 0.6rem 0.9rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .adm-form-card .form-control:focus {
            border-color: var(--nb-primary);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(22, 47, 172, 0.08);
        }

        /* Upload Box */
        .adm-upload-box {
            width: 100px;
            height: 110px;
            border: 2px dashed #cbd5e1;
            border-radius: 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            cursor: pointer;
            background: #ffffff;
            transition: all 0.3s;
            margin: 0 auto;
        }

        .adm-upload-box:hover {
            border-color: var(--nb-primary);
            background: var(--nb-primary-light);
        }

        /* Footer */
        .adm-modal-footer {
            background: #ffffff;
            padding: 1.2rem 2.5rem;
            border-top: 1px solid #e8edf5;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .adm-btn-secondary {
            background: #f1f5f9;
            color: #475569;
            border: none;
            padding: 0.7rem 1.4rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s;
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

        @media (max-width: 600px) {
            .adm-card-hero {
                padding: 3rem 1.5rem;
            }

            .adm-hero-title {
                font-size: 1.8rem;
            }

            .adm-step-label {
                display: none;
            }
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper adm-v3-wrapper">

        <div class="page-header">
            <h3 class="page-title">{{ __('manage') . ' ' . __('students') }}</h3>
        </div>

        <!-- Hero Card -->
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-6">
                <div class="adm-card-hero">
                    <div class="adm-hero-icon-box">
                        <i class="fa fa-user-plus"></i>
                    </div>
                    <h2 class="adm-hero-title">{{ __('Student Admissions') }}</h2>
                    <p class="adm-hero-desc">
                        {{ __('Register new students using our streamlined 4-step process. Complete details for personal, academic, and document verification.') }}
                    </p>

                    <!-- 
                            ADMISSION TRIGGER:
                            Using standard Bootstrap data-attributes for maximum reliability.
                        -->
                    <button type="button" class="adm-btn-primary" id="btn-trigger-admission">
                        <i class="fa fa-plus-circle"></i>
                        {{ __('Create Admission') }}
                    </button>

                    <div class="adm-features-row">
                        <div class="adm-feature"><i class="fa fa-check-circle"></i> <span>{{ __('Guided Setup') }}</span>
                        </div>
                        <div class="adm-feature-sep"></div>
                        <div class="adm-feature"><i class="fa fa-shield"></i> <span>{{ __('Secure Data') }}</span></div>
                        <div class="adm-feature-sep"></div>
                        <div class="adm-feature"><i class="fa fa-history"></i> <span>{{ __('Draft Support') }}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ════════════════ ADMISSION MODAL ════════════════ -->
    <!-- Moved to bottom of content to ensure it renders correctly outside restricted containers -->
    <div class="modal fade" id="admissionModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static"
        data-keyboard="false">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content adm-modal-content">

                <!-- Header -->
                <div class="modal-header adm-modal-header">
                    <div class="header-info">
                        <h5 style="color:#ffffff; margin:0;">{{ __('New Student Admission') }}</h5>
                        <p style="color:rgba(255,255,255,0.8); margin:0.2rem 0 0; font-size:0.85rem;">
                            {{ __('Please follow the steps below to complete enrollment') }}
                        </p>
                    </div>
                    <button type="button" class="adm-modal-close" data-dismiss="modal"
                        style="cursor:pointer;">&times;</button>
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
                            <div class="adm-step-label">{{ __('Guardian') }}</div>
                        </li>
                        <div class="adm-step-line" id="line-2"></div>
                        <li class="adm-step-item" data-step="3">
                            <div class="adm-step-circle">3</div>
                            <div class="adm-step-label">{{ __('Academic') }}</div>
                        </li>
                        <div class="adm-step-line" id="line-3"></div>
                        <li class="adm-step-item" data-step="4">
                            <div class="adm-step-circle">4</div>
                            <div class="adm-step-label">{{ __('Documents') }}</div>
                        </li>
                    </ul>
                </div>

                <!-- Body -->
                <div class="modal-body adm-modal-body">
                    <form id="admission-form" class="student-registration-form create-form" action="{{ route('students.store') }}"
                        method="POST" enctype="multipart/form-data" novalidate>
                        @csrf



                        <!-- Tab Pills -->
                        <div class="adm-nav-pills nav-tabs" role="tablist" style="pointer-events: none;">
                            <a class="nav-link active" data-toggle="tab" href="#step-1" data-s="1">{{ __('Personal') }}</a>
                            <a class="nav-link" data-toggle="tab" href="#step-2" data-s="2">{{ __('Guardian') }}</a>
                            <a class="nav-link" data-toggle="tab" href="#step-3" data-s="3">{{ __('Academic') }}</a>
                            <a class="nav-link" data-toggle="tab" href="#step-4" data-s="4">{{ __('Documents') }}</a>
                        </div>

                        <!-- Tab Content -->
                        <div class="tab-content">
                            <!-- Step 1: Personal -->
                            <div class="tab-pane fade show active" id="step-1">
                                <div class="adm-form-card">
                                    <h6>{{ __('Student Information') }}</h6>
                                    <div class="row">
                                        <div class="col-md-2 mb-4">
                                            <div class="adm-upload-box"
                                                onclick="document.getElementById('student-photo-input').click()">
                                                <i class="fa fa-camera"></i>
                                                <span>{{ __('Upload Photo') }}</span>
                                            </div>
                                            <input type="file" name="image" id="student-photo-input" class="d-none"
                                                accept="image/*" onchange="window.previewFile(this)">
                                        </div>
                                        <div class="col-md-10">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label>{{ __('First Name') }} *</label>
                                                    <input type="text" name="first_name" class="form-control" required
                                                        placeholder="Enter first name">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>{{ __('Last Name') }} *</label>
                                                    <input type="text" name="last_name" class="form-control" required
                                                        placeholder="Enter last name">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>{{ __('DOB') }} *</label>
                                                    <input type="text" name="dob"
                                                        class="form-control datepicker-popup-no-future" required
                                                        placeholder="dd-mm-yyyy" autocomplete="off">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>{{ __('Gender') }} *</label>
                                                    <select name="gender" class="form-control" required>
                                                        <option value="">Select Gender</option>
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="form-group col-md-12">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <label class="mb-0">{{ __('Current Address') }} *</label>
                                                <button type="button" class="btn btn-link p-0"
                                                    style="font-size: 0.8rem; font-weight: 700; color:var(--nb-primary);"
                                                    onclick="window.copyAddress()">{{ __('Copy to Permanent') }}</button>
                                            </div>
                                            <textarea name="current_address" id="current_address" class="form-control"
                                                rows="2" required></textarea>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>{{ __('Permanent Address') }} *</label>
                                            <textarea name="permanent_address" id="permanent_address" class="form-control"
                                                rows="2" required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2: Guardian -->
                            <div class="tab-pane fade" id="step-2">
                                <div class="row">
                                    <!-- Father Section -->
                                    <div class="col-md-6">
                                        <div class="adm-form-card">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h6>{{ __('Father\'s Details') }}</h6>
                                                <button type="button" class="btn btn-xs btn-outline-info" onclick="useAsGuardian('father')">{{ __('Set as Guardian') }}</button>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6"><label>{{ __('First Name') }}</label><input type="text" id="father_first_name" class="form-control"></div>
                                                <div class="form-group col-md-6"><label>{{ __('Last Name') }}</label><input type="text" id="father_last_name" class="form-control"></div>
                                                <div class="form-group col-md-12"><label>{{ __('Mobile') }}</label><input type="number" id="father_mobile" class="form-control"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Mother Section -->
                                    <div class="col-md-6">
                                        <div class="adm-form-card">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h6>{{ __('Mother\'s Details') }}</h6>
                                                <button type="button" class="btn btn-xs btn-outline-info" onclick="useAsGuardian('mother')">{{ __('Set as Guardian') }}</button>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6"><label>{{ __('First Name') }}</label><input type="text" id="mother_first_name" class="form-control"></div>
                                                <div class="form-group col-md-6"><label>{{ __('Last Name') }}</label><input type="text" id="mother_last_name" class="form-control"></div>
                                                <div class="form-group col-md-12"><label>{{ __('Mobile') }}</label><input type="number" id="mother_mobile" class="form-control"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="adm-form-card" id="primary-guardian-section">
                                    <h6 class="text-primary">{{ __('Primary Guardian (Login Account)') }}</h6>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label>{{ __('Guardian Email') }} * <small class="text-muted">({{ __('Used for login') }})</small></label>
                                            <select name="guardian_email_dropdown"
                                                class="guardian-search form-control select2"
                                                id="form-guardian-email"></select>
                                            <input type="hidden" name="guardian_email" id="guardian_email_hidden">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>{{ __('Guardian First Name') }} *</label>
                                            <input type="text" name="guardian_first_name" id="guardian_first_name"
                                                class="form-control" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>{{ __('Guardian Last Name') }} *</label>
                                            <input type="text" name="guardian_last_name" id="guardian_last_name"
                                                class="form-control" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>{{ __('Guardian Mobile') }} *</label>
                                            <input type="number" name="guardian_mobile" id="guardian_mobile"
                                                class="form-control remove-number-increment" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>{{ __('Guardian Gender') }} *</label>
                                            <select name="guardian_gender" id="guardian_gender" class="form-control"
                                                required>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 3: Academic -->
                            <div class="tab-pane fade" id="step-3">
                                <!-- Registration Details moved here -->
                                <div class="adm-form-card">
                                    <h6>{{ __('Enrollment Details') }}</h6>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>{{ __('Gr Number') }} *</label>
                                            <input type="text" name="admission_no" value="{{ $admission_no }}" readonly
                                                class="form-control">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>{{ __('Admission Date') }} *</label>
                                            <input type="text" name="admission_date" id="form-admission-date-2"
                                                class="form-control datepicker-popup-no-future" required autocomplete="off">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>{{ __('Session Year') }} *</label>
                                            <select name="session_year_id" class="form-control" required>
                                                @foreach($sessionYears as $year)
                                                    <option value="{{ $year->id }}" {{ $year->default == 1 ? 'selected' : '' }}>
                                                        {{ $year->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>{{ __('Class Section') }} *</label>
                                            <select name="class_section_id" class="form-control" required>
                                                <option value="">{{ __('Select Class') }}</option>
                                                @foreach($class_sections as $cs)
                                                    <option value="{{ $cs->id }}">{{ $cs->full_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="adm-form-card">
                                    <h6>{{ __('Additional Academic Fields') }}</h6>
                                    @if(count($extraFields->where('type','!=','file')))
                                        <div class="row">
                                            @foreach ($extraFields as $key => $data)
                                                @if($data->type != 'file')
                                                    <div class="form-group col-md-6">
                                                        <label>{{ $data->name }} {{ $data->is_required ? '*' : '' }}</label>
                                                        @if($data->type == 'text')
                                                            <input type="text" name="extra_fields[{{$key}}][data]" class="form-control" {{ $data->is_required ? 'required' : '' }}>
                                                        @elseif($data->type == 'number')
                                                            <input type="number" name="extra_fields[{{$key}}][data]" class="form-control" {{ $data->is_required ? 'required' : '' }}>
                                                        @elseif($data->type == 'dropdown')
                                                            <select name="extra_fields[{{$key}}][data]" class="form-control" {{ $data->is_required ? 'required' : '' }}>
                                                                <option value="">Select {{ $data->name }}</option>
                                                                @foreach($data->default_values as $val)
                                                                    <option value="{{ $val }}">{{ $val }}</option>
                                                                @endforeach
                                                            </select>
                                                        @elseif($data->type == 'textarea')
                                                            <textarea name="extra_fields[{{$key}}][data]" class="form-control" rows="2" {{ $data->is_required ? 'required' : '' }}></textarea>
                                                        @endif
                                                        <input type="hidden" name="extra_fields[{{$key}}][form_field_id]"
                                                            value="{{ $data->id }}">
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-muted text-center">{{ __('No extra academic fields defined.') }}</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Step 4: Documents -->
                            <div class="tab-pane fade" id="step-4">
                                <div class="adm-form-card">
                                    <h6 class="mb-3"><i class="fa fa-graduation-cap text-primary mr-2"></i>{{ __('Academic Documents') }} <span class="text-danger">*</span></h6>
                                    <div class="adm-upload-zone" id="academic-docs-zone" onclick="document.getElementById('student-docs-input').click()">
                                        <i class="fa fa-cloud-upload"></i>
                                        <p>{{ __('Drag & Drop or Click to upload files') }}</p>
                                        <span class="text-muted small">{{ __('(Birth Certificate, Previous Marksheets, etc.)') }}</span>
                                        <input type="file" name="student_documents[]" id="student-docs-input" multiple class="d-none" onchange="handleFileSelect(this, 'academic-preview')">
                                    </div>
                                    <div id="academic-preview" class="adm-file-preview-grid mt-3"></div>
                                </div>

                                <div class="adm-form-card">
                                    <h6 class="mb-3"><i class="fa fa-users text-primary mr-2"></i>{{ __('Guardian Documents') }} <span class="text-danger">*</span></h6>
                                    <div class="adm-upload-zone" id="guardian-docs-zone" onclick="document.getElementById('guardian-docs-input').click()">
                                        <i class="fa fa-id-card-o"></i>
                                        <p>{{ __('Drag & Drop or Click to upload files') }}</p>
                                        <span class="text-muted small">{{ __('(Aadhar Card, Pan Card, etc.)') }}</span>
                                        <input type="file" name="guardian_documents[]" id="guardian-docs-input" multiple class="d-none" onchange="handleFileSelect(this, 'guardian-preview')">
                                    </div>
                                    <div id="guardian-preview" class="adm-file-preview-grid mt-3"></div>
                                </div>

                                <div class="adm-form-card">
                                    <h6>{{ __('Additional Fields') }}</h6>
                                    @php $fileFields = $extraFields->where('type', 'file'); @endphp
                                    @if(count($fileFields))
                                        <div class="row">
                                            @foreach($fileFields as $key => $data)
                                                <div class="form-group col-md-6">
                                                    <label>{{ $data->name }} {{ $data->is_required ? '*' : '' }}</label>
                                                    <input type="file" name="extra_fields[{{$key}}][data]" class="form-control" {{ $data->is_required ? 'required' : '' }}>
                                                    <input type="hidden" name="extra_fields[{{$key}}][form_field_id]"
                                                        value="{{ $data->id }}">
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i class="fa fa-file-text-o mb-3" style="font-size: 3rem; color: #cbd5e1;"></i>
                                            <p class="text-muted">{{ __('No additional specific document fields required.') }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="modal-footer adm-modal-footer">
                            <button type="button" class="adm-btn-secondary d-none" id="btn-prev-step">
                                <i class="fa fa-arrow-left"></i> {{ __('Previous') }}
                            </button>
                            <div class="ml-auto d-flex gap-2">
                                <button type="button" class="adm-btn-secondary mr-2"
                                    id="btn-save-draft">{{ __('Save Draft') }}</button>
                                <button type="button" class="adm-btn-nav" id="btn-next-step">
                                    {{ __('Save & Continue') }} <i class="fa fa-arrow-right"></i>
                                </button>
                                <button type="submit" class="adm-btn-nav d-none" id="btn-submit-admission">
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

@section('script')
    <script>
        // Global Scope helper functions
        window.copyAddress = function () {
            jQuery('#permanent_address').val(jQuery('#current_address').val());
        };

        window.previewFile = function (input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    jQuery(input).prev('.adm-upload-box').css({
                        'background-image': 'url(' + e.target.result + ')',
                        'background-size': 'cover',
                        'background-position': 'center',
                        'border-style': 'solid'
                    }).find('i, span').hide();
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

        window.useAsGuardian = function (type) {
            if (type === 'father') {
                jQuery('#guardian_first_name').val(jQuery('#father_first_name').val());
                jQuery('#guardian_last_name').val(jQuery('#father_last_name').val());
                jQuery('#guardian_mobile').val(jQuery('#father_mobile').val());
                jQuery('#guardian_gender').val('male');
            } else {
                jQuery('#guardian_first_name').val(jQuery('#mother_first_name').val());
                jQuery('#guardian_last_name').val(jQuery('#mother_last_name').val());
                jQuery('#guardian_mobile').val(jQuery('#mother_mobile').val());
                jQuery('#guardian_gender').val('female');
            }
            // Optional: smooth scroll to primary section
            jQuery('.adm-modal-body').animate({
                scrollTop: jQuery('#primary-guardian-section').offset().top - 200
            }, 500);
        };

        jQuery(document).ready(function ($) {
            console.log("Admission Wizard Initialized (V3.7 - Stabilized)");

            // Datepicker Init with safety
            const initDatepickers = () => {
                if ($.fn.datepicker) {
                    $('#form-admission-date').datepicker({ format: 'dd-mm-yyyy', rtl: (typeof isRTL === 'function' ? isRTL() : false) }).datepicker('setDate', 'now');
                    $('.datepicker-popup-no-future').datepicker({ format: 'dd-mm-yyyy', rtl: (typeof isRTL === 'function' ? isRTL() : false) });
                }
            };
            initDatepickers();

            // Wizard Logic
            var currentStep = 1;
            var totalSteps = 4;

            function updateStepUI(step) {
                currentStep = step;

                // Update Pills and Tab Content
                var $links = $('.adm-nav-pills .nav-link');
                var $panes = $('.tab-pane');

                $links.removeClass('active');
                $panes.removeClass('show active');

                var $targetLink = $links.eq(step - 1);
                var $targetPane = $('#step-' + step);

                $targetLink.addClass('active');
                $targetPane.addClass('show active');

                // Trigger Bootstrap transition if available
                if (typeof $targetLink.tab === 'function') {
                    $targetLink.tab('show');
                }

                // Update Stepper
                $('.adm-step-item').each(function () {
                    var s = parseInt($(this).data('step'));
                    $(this).removeClass('active completed');
                    if (s < step) $(this).addClass('completed');
                    if (s === step) $(this).addClass('active');
                });

                // Update Lines
                for (var i = 1; i < totalSteps; i++) {
                    $('#line-' + i).toggleClass('active', i < step);
                }

                // Update Buttons
                $('#btn-prev-step').toggleClass('d-none', step === 1);
                $('#btn-next-step').toggleClass('d-none', step === totalSteps);
                $('#btn-submit-admission').toggleClass('d-none', step !== totalSteps);

                // Scroll to top of modal body safely
                var $modalBody = $('.adm-modal-body');
                if ($modalBody.length && $modalBody.is(':visible')) {
                    $modalBody.scrollTop(0);
                }
            }

            $('#btn-next-step').on('click', function () {
                if (currentStep < totalSteps) updateStepUI(currentStep + 1);
            });

            $('#btn-prev-step').on('click', function () {
                if (currentStep > 1) updateStepUI(currentStep - 1);
            });

            // Guardian email sync
            $(document).on('change', '.guardian-search', function () {
                $('#guardian_email_hidden').val($(this).val());
            });

            // Draft/Submit Support
            $('#btn-save-draft').on('click', function (e) {
                $('#admission-form').submit();
            });

            $('#admission-form').on('submit', function(e) {
                if ($(this).data('submitting')) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    return false;
                }
                $(this).data('submitting', true);
                var form = $(this);
                setTimeout(function() {
                    form.data('submitting', false);
                }, 2000); // Prevent any double submit within 2 seconds
            });

            // Manual trigger to avoid double initialization or conflicts
            $('#btn-trigger-admission').on('click', function () {
                $('#admissionModal').modal('show');
            });

            // Reset on close
            $('#admissionModal').on('hidden.bs.modal', function () {
                updateStepUI(1);
            });

            // Fix for select2 inside modal
            $('#admissionModal').on('shown.bs.modal', function () {
                $('.select2').each(function() {
                    let $this = $(this);
                    
                    if ($this.hasClass('guardian-search')) {
                        $this.select2({
                            dropdownParent: $('#admissionModal'),
                            tags: true, // Allow typing new email
                            placeholder: "Search or Enter Guardian Email",
                            minimumInputLength: 2,
                            ajax: {
                                url: baseUrl + '/guardian/search',
                                dataType: 'json',
                                delay: 250,
                                data: function (params) {
                                    return {
                                        email: params.term // Controller expects 'email' param
                                    };
                                },
                                processResults: function (response) {
                                    return {
                                        results: $.map(response.data, function (item) {
                                            return {
                                                text: item.email,
                                                id: item.email,
                                                first_name: item.first_name,
                                                last_name: item.last_name,
                                                mobile: item.mobile,
                                                gender: item.gender,
                                                image: item.image
                                            }
                                        })
                                    };
                                },
                                cache: true
                            },
                        }).on('select2:select', function (e) {
                            var data = e.params.data;
                            // If it's a found result (has first_name), auto-fill
                            if (data.first_name) {
                                $('#guardian_first_name').val(data.first_name);
                                $('#guardian_last_name').val(data.last_name);
                                $('#guardian_mobile').val(data.mobile);
                                $('#guardian_gender').val(data.gender);
                                $('#guardian_email_hidden').val(data.id);
                            } else {
                                // It's a new tag (new email)
                                $('#guardian_email_hidden').val(data.id);
                            }
                        });
                    } else {
                        $this.select2({
                            dropdownParent: $('#admissionModal')
                        });
                    }
                });
            });
        });
    </script>
@endsection