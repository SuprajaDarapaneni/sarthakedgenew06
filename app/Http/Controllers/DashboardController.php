<?php

namespace App\Http\Controllers;

use App\Models\Addon;
use App\Models\Feature;
use App\Models\Package;
use App\Models\Task;
use App\Models\Holiday;
use App\Models\PaymentConfiguration;
use App\Repositories\Announcement\AnnouncementInterface;
use App\Repositories\ClassSchool\ClassSchoolInterface;
use App\Repositories\ClassSection\ClassSectionInterface;
use App\Repositories\Exam\ExamInterface;
use App\Repositories\Fees\FeesInterface;
use App\Repositories\FeesPaid\FeesPaidInterface;
use App\Repositories\Holiday\HolidayInterface;
use App\Repositories\Leave\LeaveInterface;
use App\Repositories\PaymentTransaction\PaymentTransactionInterface;
use App\Repositories\School\SchoolInterface;
use App\Repositories\SessionYear\SessionYearInterface;
use App\Repositories\Stream\StreamInterface;
use App\Repositories\Student\StudentInterface;
use App\Repositories\Subscription\SubscriptionInterface;
use App\Repositories\Timetable\TimetableInterface;
use App\Repositories\User\UserInterface;
use App\Services\CachingService;
use App\Services\SubscriptionService;
use Carbon\Carbon;
use dacoto\EnvSet\Facades\EnvSet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private UserInterface $user;
    private AnnouncementInterface $announcement;
    private SubscriptionInterface $subscription;
    private SchoolInterface $school;
    private LeaveInterface $leave;
    private HolidayInterface $holiday;
    private CachingService $cache;
    private ClassSchoolInterface $class;
    private TimetableInterface $timetable;
    private SubscriptionService $subscriptionService;
    private ExamInterface $exam;
    private SessionYearInterface $sessionYear;
    private StreamInterface $stream;
    private FeesInterface $fees;
    private FeesPaidInterface $feesPaid;
    private PaymentTransactionInterface $paymentTransaction;
    private ClassSectionInterface $classSection;
    private StudentInterface $student;

    public function __construct(UserInterface $user, AnnouncementInterface $announcement, SubscriptionInterface $subscription, SchoolInterface $school, LeaveInterface $leave, HolidayInterface $holiday, CachingService $cache, ClassSchoolInterface $class, TimetableInterface $timetable, SubscriptionService $subscriptionService, ExamInterface $exam, SessionYearInterface $sessionYear, StreamInterface $stream, FeesInterface $fees, FeesPaidInterface $feesPaid, PaymentTransactionInterface $paymentTransaction, ClassSectionInterface $classSection, StudentInterface $student)
    {
        // $this->middleware('auth');
        $this->user = $user;
        $this->announcement = $announcement;
        $this->subscription = $subscription;
        $this->school = $school;
        $this->leave = $leave;
        $this->holiday = $holiday;
        $this->cache = $cache;
        $this->class = $class;
        $this->timetable = $timetable;
        $this->subscriptionService = $subscriptionService;
        $this->exam = $exam;
        $this->sessionYear = $sessionYear;
        $this->stream = $stream;
        $this->fees = $fees;
        $this->feesPaid = $feesPaid;
        $this->paymentTransaction = $paymentTransaction;
        $this->classSection = $classSection;
        $this->student = $student;
    }

    public function index()
    {

        if ((Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('School Admin')) && Auth::user()->two_factor_enabled == 1 && !Auth::user()->two_factor_expires_at && Auth::user()->email != 'superadmin@gmail.com' && Auth::user()->email != 'demo@school.com') {
            $user = Auth::user();
            DB::table('users')->where('email', $user->email)->update(['two_factor_secret' => null, 'two_factor_expires_at' => null]);
            Auth::logout();
            return view('auth.login');
        }

        $teacher = $student = $parent = $teachers = $subscription = $prepiad_upcoming_plan = $prepiad_upcoming_plan_type = $check_payment = null;
        $boys = $girls = $license_expire = 0;
        $previous_subscriptions = array();
        $announcement = array();
        $holiday = array();
        $total_students = $male_students = $female_students = 0;
        $timetables = $classData = $fees_detail = array();
        $pending_admissions_count = $teachers_on_leave_today = $today_attendance_pct = $attendance_trend = $total_expected_fees = $total_collected_fees = 0;
        $staff_attendance_marked = false;
        $weekly_attendance_data = $recent_activities = array();
        $new_students_this_month = 0;
        $paymentConfiguration = '';
        $settings = app(CachingService::class)->getSystemSettings();
        $system_settings = $settings;
        // Default values for school dashboard enhanced UI variables
        $attendance_stats = ['present' => 0, 'total' => 0];
        $fees_collected_month = 0;
        $upcoming_events = collect();
        $attendance_trend = 0;
        $today_attendance_pct = 0;
        // Default values for variables only set in conditional blocks
        $super_admin = [];
        $classes_counter = $streams = $exams = 0;
        $class_names = $class_section_names = [];
        $sessionYear = collect();
        $server_configuration = [];
        $revenue_data = $subscription_growth = $revenue_trend = $revenue_distribution = [];
        $total_revenue = $mrr = $revenue_growth = $active_users = $ai_queries = $uptime = 0;
        $tasks = collect();
        $total_tasks = $completed_tasks = 0;

        // School Admin Dashboard
        if (Auth::user()->hasRole('School Admin') || Auth::user()->school_id) {
            // Counters
            $teacher = $this->user->builder()->role("Teacher")->count();
            $student = $this->student->builder()->count();
            $parent = $this->student->builder()->where('application_status', 1)->groupBy('guardian_id')->get()->count();

            // Total Boys
            $boys_count = $this->student->builder()
                ->whereHas('user', function ($q) {
                    $q->where('gender', 'male');
                })
                ->count();
            
            // Total Girls
            $girls_count = $this->student->builder()
                ->whereHas('user', function ($q) {
                    $q->where('gender', 'female');
                })
                ->count();

            if ($student > 0) {
                $boys = round((($boys_count * 100) / $student), 2);
                $girls = round(($girls_count * 100) / $student, 2);
                $total_students = $student;
            }
            $classes_counter = $this->class->builder()->count();
            $streams = $this->stream->builder()->count();
            // End Counters

            $subscription = $this->subscriptionService->active_subscription(Auth::user()->school_id);
            $schoolSettings = $this->cache->getSchoolSettings();

            if ($subscription) {
                $license_expire = Carbon::now()->diffInDays(Carbon::parse($subscription->end_date)) + 1;
            }

            $sessionYear = $this->sessionYear->builder()->select('id', 'name', 'default')->get();
            $paymentConfiguration = '';
            // For prepaid upcoming plans, please make the payment before your current subscription expires.
            if ($license_expire <= ($settings['current_plan_expiry_warning_days'] ?? 7) && $subscription) {
                if (isset($schoolSettings['auto_renewal_plan']) && $schoolSettings['auto_renewal_plan']) {
                    $next_plan_start_date = Carbon::parse($subscription->end_date)->addDay()->format('Y-m-d');

                    $prepiad_upcoming_plan = $this->subscription->builder()->with('package')->whereDate('start_date', $next_plan_start_date)->first();
                    // Create new entry or update existing record
                    // 1 => Already set upcoming plan update subscription
                    // 0 => Set current subscription plan as upcoming
                    $prepiad_upcoming_plan_type = 1;

                    if (!$prepiad_upcoming_plan) {
                        // Add current subscription in the upcoming subscription
                        $prepiad_upcoming_plan = $subscription;
                        $prepiad_upcoming_plan_type = 0;
                    }

                    // Please verify if you have already made the payment.
                    if ($prepiad_upcoming_plan->package->type == 0 && $subscription->id != $prepiad_upcoming_plan->id) {
                        $check_payment = $this->subscription->builder()->where('id', $prepiad_upcoming_plan->id)->whereHas('subscription_bill.transaction', function ($q) {
                            $q->where('payment_status', "succeed");
                        })->first();
                    }

                    DB::setDefaultConnection('mysql');
                    $paymentConfiguration = PaymentConfiguration::where('school_id', null)->where('status', 1)->first();
                    DB::setDefaultConnection('school');
                }
            }

            $previous_subscriptions = $this->subscription->builder()->with('subscription_bill.transaction')->get()->whereIn('status', [3, 4, 5]);

            $defaultSessionYear = $this->cache->getDefaultSessionYear();

            $holiday = $this->holiday->builder()->whereDate('date', '>=', Carbon::now()->format('Y-m-d'))->whereDate('date', '<=', $defaultSessionYear->end_date)->orderBy('date', 'ASC')->get();

            $announcement = $this->announcement->builder()->whereHas('announcement_class', function ($q) {
                $q->where('class_subject_id', null);
            })->limit(5)->orderBy('id', 'desc')->get();


            // Attendance graph
            $class_names = $this->class->builder()->with('medium', 'stream')->get()->pluck('full_name', 'id');

            $class_section_names = $this->classSection->builder()->with('class', 'medium', 'section')->get()->pluck('full_name', 'id');

            // Exam result
            $exams = $this->exam->builder()->groupBy('name')->get();

            // Fees Details
            $student_ids = $this->feesPaid->builder()->whereHas('fees', function ($q) use ($defaultSessionYear) {
                $q->where('session_year_id', $defaultSessionYear->id);
            })->has('compulsory_fee')->groupBy('student_id')->pluck('student_id');

            $unPaidFees = $this->user->builder()->role('Student')->whereNotIn('id', $student_ids)->count();

            $partialPaidFees = $this->feesPaid->builder()->whereHas('fees', function ($q) use ($defaultSessionYear) {
                $q->where('session_year_id', $defaultSessionYear->id);
            })->has('compulsory_fee')->where('is_fully_paid', 0)->groupBy('student_id')->get()->count();

            $fullPaidFees = $this->feesPaid->builder()->whereHas('fees', function ($q) use ($defaultSessionYear) {
                $q->where('session_year_id', $defaultSessionYear->id);
            })->has('compulsory_fee')->where('is_fully_paid', 1)->groupBy('student_id')->orderBy('id')->get()->count();

            if ($partialPaidFees == 0 && $fullPaidFees == 0) {
                $unPaidFees = 0;
            }

            $fees_detail = [
                'unPaidFees' => $unPaidFees,
                'partialPaidFees' => $partialPaidFees,
                'fullPaidFees' => $fullPaidFees,
            ];

            // Today's Attendance
            $today = Carbon::now()->format('Y-m-d');
            $yesterday = Carbon::yesterday()->format('Y-m-d');
            try {
                $attendance_stats = [
                    'present' => DB::connection('school')->table('attendances')->where('date', $today)->where('type', 1)->count(),
                    'total' => $student
                ];

                $yesterday_attendance = [
                    'present' => DB::connection('school')->table('attendances')->where('date', $yesterday)->where('type', 1)->count(),
                    'total' => $student
                ];
            } catch (\Exception $e) {
                $attendance_stats = ['present' => 0, 'total' => $student];
                $yesterday_attendance = ['present' => 0, 'total' => $student];
            }

            $today_attendance_pct = $student > 0 ? ($attendance_stats['present'] / $student) * 100 : 0;
            $yesterday_attendance_pct = $student > 0 ? ($yesterday_attendance['present'] / $student) * 100 : 0;
            $attendance_trend = $today_attendance_pct - $yesterday_attendance_pct;

            // Fee Collected This Month
            try {
                $fees_collected_month = DB::connection('school')->table('fees_paids')
                    ->whereMonth('date', Carbon::now()->month)
                    ->whereYear('date', Carbon::now()->year)
                    ->sum('amount');
            } catch (\Exception $e) {
                $fees_collected_month = 0;
            }

            // Additional Data for Enhanced UI
            $pending_admissions_count = $this->student->builder()->where('application_status', 0)->count();

            try {
                $staff_attendance_marked = DB::connection('school')->table('staff_attendances')->where('date', $today)->count() > 0;
            } catch (\Exception $e) {
                $staff_attendance_marked = false;
            }

            $new_students_this_month = $this->student->builder()
                ->whereMonth('admission_date', Carbon::now()->month)
                ->whereYear('admission_date', Carbon::now()->year)
                ->count();

            try {
                $teachers_on_leave_today = DB::connection('school')->table('leaves')
                    ->where('status', 1)
                    ->whereDate('from_date', '<=', $today)
                    ->whereDate('to_date', '>=', $today)
                    ->count();
            } catch (\Exception $e) {
                $teachers_on_leave_today = 0;
            }

            // Fee Collection Details
            try {
                $total_expected_fees = DB::connection('school')->table('fees')->sum('total_amount');
                $total_collected_fees = DB::connection('school')->table('fees_paids')->sum('amount');
            } catch (\Exception $e) {
                $total_expected_fees = 0;
                $total_collected_fees = 0;
            }

            // Weekly Attendance Data
            $weekly_attendance_data = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i)->format('Y-m-d');
                $day_name = Carbon::now()->subDays($i)->format('D');
                try {
                    $present = DB::connection('school')->table('attendances')->where('date', $date)->where('type', 1)->count();
                    $absent = DB::connection('school')->table('attendances')->where('date', $date)->where('type', 0)->count();
                } catch (\Exception $e) {
                    $present = 0;
                    $absent = 0;
                }
                $weekly_attendance_data[] = [
                    'day' => $day_name,
                    'present' => $present,
                    'absent' => $absent
                ];
            }

            // Recent Activities
            $recent_activities = collect();

            // Fee Payments
            try {
                $recent_fees = DB::connection('school')->table('fees_paids')
                    ->join('users', 'fees_paids.student_id', '=', 'users.id')
                    ->select('fees_paids.amount', 'users.first_name', 'users.last_name', 'fees_paids.created_at', DB::raw("'fee' as type"))
                    ->orderBy('fees_paids.id', 'desc')
                    ->limit(3)
                    ->get();
                foreach ($recent_fees as $f) {
                    $recent_activities->push([
                        'title' => 'Fee Payment Received',
                        'desc' => $f->first_name . ' ' . $f->last_name . ' paid ' . $settings['currency_symbol'] . number_format($f->amount),
                        'time' => Carbon::parse($f->created_at)->diffForHumans(),
                        'icon' => 'fa-credit-card',
                        'color' => 'success'
                    ]);
                }
            } catch (\Exception $e) {
                // fees_paids table may not exist
            }

            // New Admissions
            $recent_admissions = $this->student->builder()->with('user')->orderBy('id', 'desc')->limit(3)->get();
            foreach ($recent_admissions as $a) {
                $recent_activities->push([
                    'title' => 'New Admission',
                    'desc' => $a->user->full_name . ' enrolled',
                    'time' => Carbon::parse($a->created_at)->diffForHumans(),
                    'icon' => 'fa-user-plus',
                    'color' => 'primary'
                ]);
            }

            $recent_activities = $recent_activities->sortByDesc('time')->take(5);

            // Combined Upcoming Events & Holidays
            try {
                $upcoming_events = Holiday::where(function($q) {
                        $q->where('school_id', Auth::user()->school_id)
                          ->orWhere('school_id', 0)
                          ->orWhereNull('school_id');
                    })
                    ->whereDate('date', '>=', $today)
                    ->orderBy('date', 'asc')
                    ->limit(5)
                    ->get();
            } catch (Throwable $e) {
                \Log::error('Upcoming events query failed: ' . $e->getMessage());
                $upcoming_events = collect();
            }

            // Tasks
            $tasks = Task::owner()->orderBy('status', 'asc')->orderBy('id', 'desc')->limit(5)->get();
            $total_tasks = $tasks->count();
            $completed_tasks = $tasks->where('status', 1)->count();

        }

        // Super admin dashboard
        if (Auth::user()->hasRole('Super Admin') || !Auth::user()->school_id) {
            $school = $this->school->builder()->get();
            $total_school = $school->count();
            $active_school = $school->where('status', 1)->count();
            $deactive_school = $school->where('status', 0)->count();
            $packages = Package::where('is_trial', 0)->count();

            $super_admin = [
                'total_school' => $total_school,
                'active_schools' => $active_school,
                'inactive_schools' => $deactive_school,
                'total_packages' => $packages
            ];

            $paymentTransaction = $this->paymentTransaction->builder()->has('subscription_bill')->select(DB::raw('YEAR(MIN(created_at)) as min_year'))->value('min_year');

            if ($paymentTransaction) {
                $start_year = $paymentTransaction;
            } else {
                $start_year = Carbon::now()->format('Y');
            }

            $schools = $this->school->builder()->select('id', 'name', 'admin_id', 'logo')->with('user:id,first_name,last_name')->orderBy('id', 'DESC')->take(5)->get();
            $staffs = $this->user->builder()->select('id', 'first_name', 'last_name', 'image')->has('staff')->with('roles', 'support_school.school:id,name')->whereHas('roles', function ($q) {
                $q->where('custom_role', 1)->whereNot('name', 'Teacher');
            })->get();

            $addons = Addon::select('id', 'name', 'feature_id')->withCount('addon_subscription_count')->with('feature')->get();

            $labels = [];
            $data = [];
            foreach ($addons as $key => $addon) {
                $labels[] = $addon->feature->short_name;
                $data[] = $addon->addon_subscription_count_count;
            }
            $addon_graph = [
                $labels,
                $data
            ];

            $packages = Package::select('id', 'name')->where('is_trial', 0)->withCount('subscription')->get();

            $package_labels = [];
            $package_data = [];
            foreach ($packages as $key => $package) {
                $package_labels[] = $package->name;
                $package_data[] = $package->subscription_count;
            }
            $package_graph = [
                $package_labels,
                $package_data
            ];

            // Enhanced Super Admin Stats
            $total_revenue = $this->paymentTransaction->builder()->where('payment_status', 'succeed')->sum('amount');
            $current_month = Carbon::now()->month;
            $current_year = Carbon::now()->year;
            $today = Carbon::today();
            
            $mrr = $this->paymentTransaction->builder()
                ->where('payment_status', 'succeed')
                ->whereMonth('created_at', $current_month)
                ->whereYear('created_at', $current_year)
                ->sum('amount');
            
            $payments_today = $this->paymentTransaction->builder()
                ->where('payment_status', 'succeed')
                ->whereDate('created_at', $today)
                ->sum('amount');

            $last_month = Carbon::now()->subMonth()->month;
            $last_month_year = Carbon::now()->subMonth()->year;
            $last_month_revenue = $this->paymentTransaction->builder()
                ->where('payment_status', 'succeed')
                ->whereMonth('created_at', $last_month)
                ->whereYear('created_at', $last_month_year)
                ->sum('amount');
            
            $revenue_growth = $last_month_revenue > 0 ? (($mrr - $last_month_revenue) / $last_month_revenue) * 100 : 0;
            
            // Real stats
            $active_users = $this->user->builder()->where('status', 1)->count(); 
            $ai_queries = 0; // Set to actual tracking if available
            $uptime = "100%";

            $super_admin = array_merge($super_admin, [
                'total_revenue' => $total_revenue,
                'mrr' => $mrr,
                'payments_today' => $payments_today,
                'revenue_growth' => $revenue_growth,
                'active_users' => $active_users,
                'ai_queries' => $ai_queries,
                'uptime' => $uptime
            ]);

            // Charts Data
            // Subscription Growth (Last 6 months)
            $subscription_growth = [];
            for ($i = 5; $i >= 0; $i--) {
                $month = Carbon::now()->subMonths($i);
                $count = DB::table('subscriptions')
                    ->where('status', 1)
                    ->whereDate('start_date', '<=', $month->endOfMonth())
                    ->count();
                $subscription_growth[] = [
                    'month' => $month->format('M'),
                    'count' => $count
                ];
            }

            // Revenue Trend (Last 6 months)
            $revenue_trend = [];
            for ($i = 5; $i >= 0; $i--) {
                $month = Carbon::now()->subMonths($i);
                $rev = $this->paymentTransaction->builder()
                    ->where('payment_status', 'succeed')
                    ->whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->sum('amount');
                $revenue_trend[] = [
                    'month' => $month->format('M'),
                    'amount' => $rev
                ];
            }

            // Revenue Distribution
            $sub_revenue = $this->paymentTransaction->builder()->where('payment_status', 'succeed')->whereNotNull('order_id')->sum('amount'); 
            $addon_rev = $this->paymentTransaction->builder()->where('payment_status', 'succeed')->whereHas('addon_subscription')->sum('amount');
            
            $revenue_distribution = [
                'Subscriptions' => $sub_revenue,
                'Add-ons' => $addon_rev,
                'AI Revenue' => 0,
                'Marketplace' => 0 
            ];

            $super_admin['charts'] = [
                'subscription_growth' => $subscription_growth,
                'revenue_trend' => $revenue_trend,
                'revenue_distribution' => $revenue_distribution
            ];
        }

        // Timetable for Teacher
        if (Auth::user()->hasRole('Teacher')) {
            $date = Carbon::now();
            $fullDayName = $date->format('l');
            $timetables = $this->timetable->builder()
                ->whereHas('subject_teacher', function ($q) {
                    $q->where('teacher_id', Auth::user()->id);
                })
                ->where('day', $fullDayName)->orderBy('start_time', 'ASC')
                ->with('subject:id,name,type', 'class_section.class', 'class_section.section', 'class_section.medium')->get();
        }

        $all_vars = compact(
            'teacher',
            'parent',
            'student',
            'announcement',
            'teachers',
            'boys',
            'girls',
            'total_students',
            'license_expire',
            'subscription',
            'previous_subscriptions',
            'holiday',
            'classData',
            'prepiad_upcoming_plan',
            'prepiad_upcoming_plan_type',
            'check_payment',
            'sessionYear',
            'classes_counter',
            'streams',
            'exams',
            'fees_detail',
            'settings',
            'class_names',
            'paymentConfiguration',
            'system_settings',
            'class_section_names',
            'attendance_stats',
            'fees_collected_month',
            'upcoming_events',
            'pending_admissions_count',
            'staff_attendance_marked',
            'new_students_this_month',
            'teachers_on_leave_today',
            'today_attendance_pct',
            'attendance_trend',
            'total_expected_fees',
            'total_collected_fees',
            'weekly_attendance_data',
            'recent_activities',
            'super_admin',
            'tasks',
            'total_tasks',
            'completed_tasks'
        );

        if (Auth::user()->hasRole('Super Admin') || (Auth::user()->school_id == null && Auth::user()->hasRole('Admin'))) {
            $all_vars = array_merge($all_vars, compact('start_year', 'schools', 'staffs', 'addon_graph', 'package_graph', 'paymentConfiguration', 'server_configuration'));
            return view('dashboard', $all_vars);
        }

        if (Auth::user()->hasRole('Teacher')) {
            $all_vars = array_merge($all_vars, compact('timetables'));
            return view('teacher_dashboard', $all_vars);
        }

        return view('dashboard', $all_vars);
    }
}
