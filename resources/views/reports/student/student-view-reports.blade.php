@extends('layouts.master')

@section('title')
    {{ __('student_profile') }} - {{ $student->user->first_name }} {{ $student->user->last_name }}
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <h4 class="page-title mb-0 font-weight-bold">
            <i class="fa fa-user-circle-o mr-2 text-primary"></i> {{ __('student_profile') }}
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 bg-transparent p-0">
                <li class="breadcrumb-item"><a href="{{ route('reports.student.student-reports') }}">{{ __('student_reports') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('profile') }}</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <!-- Left Column : Profile + Info -->
        <div class="col-lg-3 col-md-4 grid-margin">
            {{-- Student avatar + quick actions --}}
            <div class="card student-profile-card mb-3">
                <div class="card-body text-center p-3">
                    <div class="student-avatar-wrapper mx-auto mb-3" style="width: 100px; height: 100px; background: #f3f4f6; border-radius: 50%; overflow: hidden; display: flex; align-items: center; justify-content: center; border: 2px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                        <img src="{{ $student->user->image ?? asset('assets/images/user.png') }}"
                             class="student-avatar"
                             style="width: 100%; height: 100%; object-fit: cover;"
                             alt="{{ $student->user->full_name ?? '' }}">
                    </div>
                    <h5 class="font-weight-bold mb-1 text-capitalize" style="font-size: 16px;">
                        {{ $student->user->first_name }} {{ $student->user->last_name }}
                    </h5>
                    <p class="text-muted small mb-3">{{ __('Admission No') }}: {{ $student->admission_no }}</p>

                    <div class="d-flex justify-content-center gap-1">
                        <a href="{{ route('students.create') }}" class="btn btn-xs btn-inverse-primary btn-icon mr-1" data-toggle="tooltip" title="{{ __('Edit') }}">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <a href="javascript:void(0)" class="btn btn-xs btn-inverse-danger btn-icon" data-toggle="tooltip" title="{{ __('Settings') }}">
                            <i class="fa fa-cog"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Basic information list --}}
            <div class="card student-info-card">
                <div class="card-header py-2">
                    <h6 class="mb-0">{{ __('basic_information') }}</h6>
                </div>
                <div class="card-body student-info-body">
                    <ul class="list-unstyled mb-0">
                        <li class="info-row">
                            <span class="label">{{ __('Class & Section') }}</span>
                            <span class="value">
                                {{ $student->class_section->class->name ?? '-' }}
                                @if($student->class_section?->section?->name)
                                    ({{ $student->class_section->section->name }})
                                @endif
                            </span>
                        </li>
                        <li class="info-row">
                            <span class="label">{{ __('Roll Number') }}</span>
                            <span class="value">{{ $student->roll_number ?? '-' }}</span>
                        </li>
                        <li class="info-row">
                            <span class="label">{{ __('dob') }}</span>
                            <span class="value">{{ $student->user->dob ?? '-' }}</span>
                        </li>
                        <li class="info-row">
                            <span class="label">{{ __('gender') }}</span>
                            <span class="value text-capitalize">{{ $student->user->gender ?? '-' }}</span>
                        </li>
                        <li class="info-row">
                            <span class="label">{{ __('admission_date') }}</span>
                            <span class="value">{{ $student->admission_date ?? '-' }}</span>
                        </li>
                        <li class="info-row">
                            <span class="label">{{ __('guardian') }}</span>
                            <span class="value">
                                {{ $student->guardian->first_name ?? '' }}
                                {{ $student->guardian->last_name ?? '' }}
                            </span>
                        </li>
                        <li class="info-row">
                            <span class="label">{{ __('guardian') . ' ' . __('mobile') }}</span>
                            <span class="value">{{ $student->guardian->mobile ?? '-' }}</span>
                        </li>
                        <li class="info-row">
                            <span class="label">{{ __('current_address') }}</span>
                            <span class="value text-truncate-2">
                                {{ $student->user->current_address ?: '-' }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Right Column : Dashboard Tabs + Analytics -->
        <div class="col-lg-9 col-md-8 grid-margin">
            <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                <div class="card-body p-0">
                    <div class="row no-gutters">
                        <!-- Left Sidebar Menu -->
                        <div class="col-md-3 border-right bg-light">
                            <div class="list-group list-group-flush vertical-report-menu" id="studentTab" role="tablist">
                                <a class="list-group-item list-group-item-action active py-3 px-4 border-0 mb-1" id="overview-tab" data-toggle="tab" href="#overview" role="tab">
                                    <i class="fa fa-dashboard mr-3 text-primary"></i> <strong>{{ __('Overview') }}</strong>
                                </a>
                                <a class="list-group-item list-group-item-action py-3 px-4 border-0 mb-1" id="academic-tab" data-toggle="tab" href="#academic" role="tab">
                                    <i class="fa fa-graduation-cap mr-3 text-primary"></i> <strong>{{ __('Academic') }}</strong>
                                </a>
                                <a class="list-group-item list-group-item-action py-3 px-4 border-0 mb-1" id="attendance-tab" data-toggle="tab" href="#attendance" role="tab">
                                    <i class="fa fa-calendar-check-o mr-3 text-primary"></i> <strong>{{ __('Attendance') }}</strong>
                                </a>
                                <a class="list-group-item list-group-item-action py-3 px-4 border-0 mb-1" id="fees-tab" data-toggle="tab" href="#fees" role="tab">
                                    <i class="fa fa-money mr-3 text-primary"></i> <strong>{{ __('Fees') }}</strong>
                                </a>
                                <a class="list-group-item list-group-item-action py-3 px-4 border-0" id="documents-tab" data-toggle="tab" href="#documents" role="tab">
                                    <i class="fa fa-file-text-o mr-3 text-primary"></i> <strong>{{ __('Documents') }}</strong>
                                </a>
                            </div>
                        </div>

                        <!-- Right Content Area -->
                        <div class="col-md-9 bg-white">
                            <div class="tab-content border-0 p-4" id="studentTabContent" style="min-height: 500px;">
                                {{-- Overview Dashboard --}}
                                <div class="tab-pane fade show active" id="overview" role="tabpanel">
                                    <div class="row">
                                        <!-- Attendance Summary -->
                                        <div class="col-lg-6 mb-4">
                                            <div class="card h-100 shadow-sm border">
                                                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                                                    <h6 class="mb-0 text-muted">{{ __('Attendance Report') }}</h6>
                                                    <span class="badge badge-primary">{{ $student->session_year->name ?? '' }}</span>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row align-items-center">
                                                        <div class="col-sm-5 text-center border-right">
                                                            <h3 class="text-primary mb-0 font-weight-bold" id="overview_attendance_percentage">100%</h3>
                                                            <small class="text-muted text-uppercase">{{ __('Present') }}</small>
                                                        </div>
                                                        <div class="col-sm-7">
                                                            <div class="d-flex justify-content-between mb-2">
                                                                <small class="text-muted">{{ __('Present Days') }}</small>
                                                                <span class="font-weight-bold" id="overview_attendance_present">-</span>
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <small class="text-muted">{{ __('Working Days') }}</small>
                                                                <span class="font-weight-bold" id="overview_attendance_total">-</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <small class="text-muted d-block mt-3 text-center">
                                                        <i class="fa fa-info-circle mr-1"></i> {{ __('Detailed charts are available in the Attendance tab.') }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Examination Summary -->
                                        <div class="col-lg-6 mb-4">
                                            <div class="card h-100 shadow-sm border">
                                                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                                                    <h6 class="mb-0 text-muted">{{ __('Examination Report') }}</h6>
                                                    <i class="fa fa-line-chart text-muted"></i>
                                                </div>
                                                <div class="card-body" id="overview_exam_body">
                                                    @if(isset($latestExam))
                                                        <h6 class="mb-2">{{ $latestExam->title }}</h6>
                                                        <div class="d-flex justify-content-between mb-1">
                                                            <small class="text-muted">{{ __('Total Marks') }}</small>
                                                            <span>{{ $latestExam->total_marks }}</span>
                                                        </div>
                                                        <div class="d-flex justify-content-between mb-2">
                                                            <small class="text-muted">{{ __('Obtained') }}</small>
                                                            <span class="text-success font-weight-bold">{{ $latestExam->obtained_marks }}</span>
                                                        </div>
                                                        <span class="badge badge-success">{{ __('Pass') }}</span>
                                                    @else
                                                        <div class="text-center py-3 text-muted">
                                                            <i class="fa fa-clipboard fa-2x mb-2"></i>
                                                            <p class="small mb-0">{{ __('No Exam Data') }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <!-- Fee Summary -->
                                        <div class="col-lg-6 mb-4">
                                            <div class="card h-100 shadow-sm border">
                                                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                                                    <h6 class="mb-0 text-muted">{{ __('Fee Report') }}</h6>
                                                    <i class="fa fa-credit-card text-muted"></i>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row mb-3">
                                                        <div class="col-4">
                                                            <p class="small text-muted mb-0">{{ __('Total') }}</p>
                                                            <h6 class="mb-0 font-weight-bold">{{ $feeSummary['total'] ?? '-' }}</h6>
                                                        </div>
                                                        <div class="col-4">
                                                            <p class="small text-muted mb-0">{{ __('Paid') }}</p>
                                                            <h6 class="mb-0 text-success font-weight-bold">{{ $feeSummary['paid'] ?? '-' }}</h6>
                                                        </div>
                                                        <div class="col-4">
                                                            <p class="small text-muted mb-0">{{ __('Due') }}</p>
                                                            <h6 class="mb-0 text-danger font-weight-bold">{{ $feeSummary['due'] ?? '-' }}</h6>
                                                        </div>
                                                    </div>
                                                    <span class="badge badge-pill badge-warning">{{ $feeSummary['status'] ?? __('Pending') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Simple Performance -->
                                        <div class="col-lg-6 mb-4">
                                            <div class="card h-100 shadow-sm border">
                                                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                                                    <h6 class="mb-0 text-muted">{{ __('Quick Stats') }}</h6>
                                                    <i class="fa fa-bolt text-muted"></i>
                                                </div>
                                                <div class="card-body text-center d-flex flex-column justify-content-center">
                                                    <h4 class="mb-1 text-primary">A+</h4>
                                                    <p class="small text-muted mb-0">{{ __('Overall Grade Point') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Academic Tab --}}
                                <div class="tab-pane fade" id="academic" role="tabpanel">
                                    <div class="academic-report-content py-2">
                                        @include('reports.student.exam-report-tab')
                                    </div>
                                </div>

                                {{-- Attendance Tab --}}
                                <div class="tab-pane fade" id="attendance" role="tabpanel">
                                    <div class="attendance-report-content py-2">
                                        @include('reports.student.attendance-report-tab', ['sessionYears' => $sessionYears])
                                    </div>
                                </div>

                                {{-- Fees Tab --}}
                                <div class="tab-pane fade" id="fees" role="tabpanel">
                                    <div class="fees-report-content py-2">
                                        @include('reports.student.fees-report-tab', ['studentFees' => $studentFees])
                                    </div>
                                </div>

                                 {{-- Documents Tab --}}
                                 <div class="tab-pane fade" id="documents" role="tabpanel">
                                     <div class="documents-report-content py-4">
                                         @php
                                             $docs = collect();
                                             
                                             // Extract files from extra fields
                                             if (isset($student->user->extra_student_details)) {
                                                 foreach ($student->user->extra_student_details as $field) {
                                                     if ($field->form_field->type == 'file' && $field->data) {
                                                         $docs->push((object)[
                                                             'name' => $field->form_field->name,
                                                             'url' => Storage::url($field->data),
                                                             'type' => 'Extra Field'
                                                         ]);
                                                     }
                                                 }
                                             }

                                             // Add files from user relation
                                             if (isset($student->user->file)) {
                                                 foreach ($student->user->file as $file) {
                                                     $docs->push((object)[
                                                         'name' => $file->file_name ?? __('file'),
                                                         'url' => $file->file_url,
                                                         'type' => 'System Attachment'
                                                     ]);
                                                 }
                                             }
                                         @endphp

                                         @if($docs->count() > 0)
                                             <div class="table-responsive">
                                                 <table class="table table-hover border">
                                                     <thead class="bg-light">
                                                         <tr>
                                                             <th>{{ __('ID') }}</th>
                                                             <th>{{ __('document_name') }}</th>
                                                             <th>{{ __('type') }}</th>
                                                             <th>{{ __('action') }}</th>
                                                         </tr>
                                                     </thead>
                                                     <tbody>
                                                         @foreach($docs as $index => $doc)
                                                             <tr>
                                                                 <td>{{ $index + 1 }}</td>
                                                                 <td class="font-weight-bold">{{ $doc->name }}</td>
                                                                 <td><span class="badge badge-outline-primary">{{ $doc->type }}</span></td>
                                                                 <td>
                                                                     <a href="{{ $doc->url }}" target="_blank" class="btn btn-xs btn-inverse-primary" title="{{ __('View') }}">
                                                                         <i class="fa fa-eye"></i>
                                                                     </a>
                                                                     <a href="{{ $doc->url }}" download class="btn btn-xs btn-inverse-success ml-1" title="{{ __('Download') }}">
                                                                         <i class="fa fa-download"></i>
                                                                     </a>
                                                                 </td>
                                                             </tr>
                                                         @endforeach
                                                     </tbody>
                                                 </table>
                                             </div>
                                         @else
                                             <div class="py-5 text-center text-muted">
                                                 <i class="fa fa-folder-open-o fa-3x mb-3"></i>
                                                 <p class="mb-1"><strong>{{ __('No Documents Found') }}</strong></p>
                                                 <small>{{ __('There are no academic or common student files for this profile.') }}</small>
                                             </div>
                                         @endif
                                     </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection

@section('style')
<style>
    .student-profile-card {
        border-radius: 16px;
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.06);
    }
    .student-avatar-wrapper {
        width: 110px;
        height: 110px;
        border-radius: 999px;
        margin: 0 auto;
        background: #e0ecff;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .student-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
    }
    .circle-icon-btn {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        color: #fff;
        margin: 0 4px;
    }
    .circle-icon-btn.btn-view { background: #8b9cf9; }
    .circle-icon-btn.btn-edit { background: #6fc1ff; }
    .circle-icon-btn.btn-delete { background: #ff9aa2; }

    .student-info-card {
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
    }
    .student-info-card .card-header {
        background: #f9fafb;
        border-bottom: 1px solid #edf2f7;
    }
    .student-info-body {
        max-height: 360px;
        overflow-y: auto;
    }
    .student-info-body .info-row {
        padding: 6px 0;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        flex-direction: column;
    }
    .student-info-body .info-row:last-child {
        border-bottom: none;
    }
    .student-info-body .label {
        font-size: 11px;
        text-transform: uppercase;
        color: #9ca3af;
        letter-spacing: .03em;
    }
    .student-info-body .value {
        font-size: 13px;
        color: #111827;
    }
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .dashboard-card {
        border-radius: 16px;
    }
    .dashboard-card .card-header {
        background: #f9fafb;
        border-bottom: 1px solid #edf2f7;
    }
    .attendance-donut .donut-circle {
        width: 96px;
        height: 96px;
        border-radius: 50%;
        background: conic-gradient(#4f46e5 0 75%, #e5e7eb 75% 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #111827;
        font-weight: 600;
        font-size: 18px;
    }
    .attendance-donut .donut-value {
        background: #fff;
        border-radius: 50%;
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 0 0 2px rgba(255,255,255,0.6);
    }
    .stat-pill {
        border-radius: 10px;
        padding: 6px 8px;
        background: #f3f4f6;
        display: flex;
        justify-content: space-between;
        font-size: 11px;
    }
    .stat-pill .label {
        color: #6b7280;
    }
    .stat-pill .value {
        font-weight: 600;
        color: #111827;
    }
    .stat-present { background: #e0f2fe; }
    .stat-absent { background: #fee2e2; }

    .performance-circle {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: conic-gradient(#22c55e 0 76%, #e5e7eb 76% 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .performance-circle .inner {
        width: 84px;
        height: 84px;
        border-radius: 50%;
        background: #fff;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .performance-circle .score {
        font-weight: 700;
        font-size: 20px;
    }

    .empty-illustration {
        max-width: 140px;
    }

    @media (max-width: 991.98px) {
        .student-info-body {
            max-height: none;
        }
    }
    .vertical-report-menu .list-group-item {
        background: transparent;
        color: #6c757d;
        transition: all 0.2s;
        display: flex;
        align-items: center;
    }
    .vertical-report-menu .list-group-item:hover {
        background: rgba(75, 73, 172, 0.05);
        color: #4b49ac;
    }
    .vertical-report-menu .list-group-item.active {
        background: #fff !important;
        color: #4b49ac !important;
        border-right: 4px solid #4b49ac !important;
        border-radius: 0;
        box-shadow: none;
    }
    .vertical-report-menu .list-group-item i {
        font-size: 1.2rem;
        width: 25px;
    }
    .tab-content {
        background: #fff;
    }
</style>
@endsection

@push('scripts')
<script>
    $(function () {
        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endpush

