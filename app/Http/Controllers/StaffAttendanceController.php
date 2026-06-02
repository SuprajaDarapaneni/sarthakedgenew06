<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\SessionYear;
use App\Repositories\StaffAttendance\StaffAttendanceInterface;
use App\Repositories\Staff\StaffInterface;
use App\Services\CachingService;
use App\Services\ResponseService;
use App\Services\SessionYearsTrackingsService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Throwable;

class StaffAttendanceController extends Controller
{

    private StaffAttendanceInterface $staffAttendance;
    private StaffInterface $staff;
    private CachingService $cache;
    private SessionYearsTrackingsService $sessionYearsTrackingsService;

    public function __construct(StaffAttendanceInterface $staffAttendance, StaffInterface $staff, CachingService $cachingService, SessionYearsTrackingsService $sessionYearsTrackingsService)
    {
        $this->staffAttendance = $staffAttendance;
        $this->staff = $staff;
        $this->cache = $cachingService;
        $this->sessionYearsTrackingsService = $sessionYearsTrackingsService;
    }

    public function index()
    {
        ResponseService::noFeatureThenRedirect('Staff Attendance Management');
        ResponseService::noAnyPermissionThenRedirect(['staff-attendance-list']);

        return view('staff-attendance.index');
    }

    public function view()
    {
        ResponseService::noFeatureThenRedirect('Staff Attendance Management');
        ResponseService::noAnyPermissionThenRedirect(['staff-attendance-list']);

        return view('staff-attendance.view');
    }

    public function getAttendanceData(Request $request)
    {
        ResponseService::noFeatureThenRedirect('Staff Attendance Management');
        $response = $this->staffAttendance->builder()->select('type')->where(['date' => date('Y-m-d', strtotime($request->date))])->pluck('type')->first();
        return response()->json($response);
    }

    public function store(Request $request)
    {
        ResponseService::noFeatureThenRedirect('Staff Attendance Management');
        ResponseService::noAnyPermissionThenRedirect(['staff-attendance-create', 'staff-attendance-edit']);

        $request->validate([
            'date' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $attendanceData = array();
            $sessionYear = $this->cache->getDefaultSessionYear();
            $staff_ids = array();
            // dd($request->attendance_data);

            foreach ($request->attendance_data as $value) {
                $data = (object) $value;
                $attendanceData[] = array(
                    "id" => $data->id ?? null,
                    'staff_id' => $data->staff_id,
                    'session_year_id' => $sessionYear->id,
                    'type' => $request->holiday ?? $data->type,
                    'date' => date('Y-m-d', strtotime($request->date)),
                );

                if ($data->type == 0) {
                    $staff_ids[] = $data->staff_id;
                }
            }
            // dd($attendanceData);
            $this->staffAttendance->upsert($attendanceData, ["id"], ["staff_id", "session_year_id", "type", "date"]);

            DB::commit();

            if ($request->absent_notification && !empty($staff_ids)) {
                $date = Carbon::parse(date('Y-m-d', strtotime($request->date)))->format('F jS, Y');
                $title = 'Absent';
                $body = 'You are marked absent on ' . $date;
                $type = "attendance";
                if (!$request->holiday) {
                    send_notification($staff_ids, $title, $body, $type);
                }
            }

            ResponseService::successResponse('Data Stored Successfully');
        } catch (Throwable $e) {
            if (
                Str::contains($e->getMessage(), [
                    'does not exist',
                    'file_get_contents'
                ])
            ) {
                DB::commit();
                ResponseService::warningResponse("Data Stored successfully. But App push notification not send.");
            } else {
                DB::rollback();
                ResponseService::logErrorResponse($e, "Staff Attendance Controller -> Store method");
                ResponseService::errorResponse();
            }
        }
    }

    public function show(Request $request)
    {
        ResponseService::noFeatureThenRedirect('Staff Attendance Management');
        ResponseService::noAnyPermissionThenRedirect(['staff-attendance-list']);

        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'ASC');
        $search = $request->input('search');

        $date = date('Y-m-d', strtotime($request->date));

        $attendanceData = array();
        $total = 0;

        $attendanceQuery = $this->staffAttendance->builder()->with('user.staff')->where(['date' => $date])->whereHas('user', function ($q) {
            $q->whereNull('deleted_at');
        });

        if ($date != '' && $attendanceQuery->count() > 0) {
            $attendanceData = $attendanceQuery->orderBy($sort, $order)->get();
            // need to add $no to the attendanceData
            $no = 1;
            foreach ($attendanceData as $attendance) {
                $attendance->no = $no++;
            }
            $total = $attendanceData->count();
        } else {
            // Get all staff members for the current session year
            $staffMembers = $this->staff->builder()->with('user');
            if (!empty($search)) {
                $staffMembers->where('user_id', 'like', "%{$search}%");
                $staffMembers->orWhereHas('user', function ($q) use ($search) {
                    $q->where(function ($sub) use ($search) {
                        $sub->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%")
                            ->orWhereRaw("CONCAT(first_name, ' ', last_name) like ?", ["%{$search}%"]);
                    });
                });
            }
            $staffMembers = $staffMembers->get();
            $no = 1;
            foreach ($staffMembers as $staff) {
                $attendanceData[] = [
                    'id' => 'N/A',
                    'no' => $no++,
                    'staff_id' => $staff->user_id,
                    'user' => [
                        'full_name' => $staff->user->full_name,
                        'staff' => [
                            'id' => $staff->id,
                            'user_id' => $staff->user_id ?? '',
                        ]
                    ],
                    'type' => null,
                    'date' => $date
                ];
            }
            $total = count($attendanceData);
        }

        $data = [
            'total' => $total,
            'rows' => $attendanceData
        ];

        return response()->json($data);
    }

    public function attendance_show(Request $request)
    {
        ResponseService::noFeatureThenRedirect('Staff Attendance Management');
        ResponseService::noAnyPermissionThenRedirect(['staff-attendance-list']);

        $offset = request('offset', 0);
        $limit = request('limit');
        $sort = request('sort', 'staff_id');
        $order = request('order', 'ASC');
        $search = request('search');
        $attendanceType = request('attendance_type');

        $date = date('Y-m-d', strtotime(request('date')));

        $validator = Validator::make($request->all(), ['date' => 'required']);
        if ($validator->fails()) {
            ResponseService::errorResponse($validator->errors()->first());
        }

        $sessionYear = $this->cache->getDefaultSessionYear();

        $sql = $this->staffAttendance->builder()->where(['date' => $date, 'session_year_id' => $sessionYear->id])->with('user.staff');

        if ($attendanceType != null) {
            $sql = $sql->where('type', $attendanceType);
        }

        if ($search) {
            $sql = $sql->whereHas('user', function ($q) use ($search) {
                $q->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%')
                    ->orwhereRaw("concat(users.first_name,' ',users.last_name) LIKE '%" . $search . "%'")
                    ->orwhere('id', 'like', '%' . $search . '%');
            });
        }

        $total = $sql->count();
        $sql = $sql->orderBy($sort, $order);

        if ($limit) {
            if ($offset >= $total && $total > 0) {
                $lastPage = floor(($total - 1) / $limit) * $limit; // calculate last page offset
                $offset = $lastPage;
            }
            $sql = $sql->skip($offset)->take($limit);
        }

        $attendanceData = $sql->get();

        // Cumulative stats per staff member (avoids N+1)
        $staffIds = $attendanceData->pluck('staff_id')->toArray();
        $cumulativeStats = $this->staffAttendance->builder()
            ->whereIn('staff_id', $staffIds)
            ->where('session_year_id', $sessionYear->id)
            ->select(
                'staff_id',
                DB::raw('count(case when type = 1 then 1 end) as present_days'),
                DB::raw('count(case when type = 0 then 1 end) as absent_days'),
                DB::raw('count(case when type = 2 then 1 end) as leave_days')
            )
            ->groupBy('staff_id')
            ->get()
            ->keyBy('staff_id');

        $rows = [];
        $no   = 1;
        foreach ($attendanceData as $attendance) {
            $tempRow         = $attendance->toArray();
            $tempRow['no']   = $no++;
            $tempRow['name'] = $attendance->user->full_name ?? '';

            $stats       = $cumulativeStats->get($attendance->staff_id);
            $present     = $stats->present_days ?? 0;
            $absent      = $stats->absent_days  ?? 0;
            $leave       = $stats->leave_days   ?? 0;
            $totalMarked = $present + $absent;
            $percentage  = $totalMarked > 0 ? round(($present / $totalMarked) * 100, 2) : 0;

            $tempRow['present_days']          = $present;
            $tempRow['absent_days']           = $absent;
            $tempRow['leave_days']            = $leave;
            $tempRow['attendance_percentage'] = $percentage;

            if ($percentage >= 90)      $tempRow['attendance_status'] = 'Good';
            elseif ($percentage >= 75)  $tempRow['attendance_status'] = 'Warning';
            else                        $tempRow['attendance_status'] = 'Low';

            $rows[] = $tempRow;
        }

        $data = [
            'total' => $total,
            'rows'  => $rows,
        ];

        return response()->json($data);
    }

    // -------------------------------------------------------------------------
    // Analytics endpoints — power the Staff Attendance dashboard view
    // -------------------------------------------------------------------------

    public function getStats(Request $request)
    {
        ResponseService::noFeatureThenRedirect('Staff Attendance Management');

        $date        = $request->date ? date('Y-m-d', strtotime($request->date)) : date('Y-m-d');
        $sessionYear = $this->cache->getDefaultSessionYear();

        // Total active staff in this school
        $totalStaff = $this->staff->builder()->count();

        // Present / Absent on selected date
        $attendanceQuery = $this->staffAttendance->builder()
            ->where(['date' => $date, 'session_year_id' => $sessionYear->id]);

        $present = (clone $attendanceQuery)->where('type', 1)->count();
        $absent  = (clone $attendanceQuery)->where('type', 0)->count();

        // On Leave — approved leaves covering the selected date for staff users
        $staffUserIds = $this->staff->builder()->pluck('user_id')->toArray();
        $onLeave = Leave::where('school_id', Auth::user()->school_id)
            ->where('status', 1)
            ->whereDate('from_date', '<=', $date)
            ->whereDate('to_date', '>=', $date)
            ->whereHas('user', function ($q) use ($staffUserIds) {
                $q->whereIn('id', $staffUserIds);
            })
            ->count();

        // Avg attendance % for the current month
        $month = date('m', strtotime($date));
        $year  = date('Y', strtotime($date));

        $monthQuery          = $this->staffAttendance->builder()
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->where('session_year_id', $sessionYear->id);

        $totalPresentInMonth = (clone $monthQuery)->where('type', 1)->count();
        $totalMarkedInMonth  = (clone $monthQuery)->whereIn('type', [0, 1])->count();
        $avgAttendance       = $totalMarkedInMonth > 0
            ? round(($totalPresentInMonth / $totalMarkedInMonth) * 100, 2)
            : 0;

        return response()->json([
            'total_staff'    => $totalStaff,
            'present'        => $present,
            'absent'         => $absent,
            'on_leave'       => $onLeave,
            'avg_attendance' => $avgAttendance,
        ]);
    }

    public function getAnalytics(Request $request)
    {
        ResponseService::noFeatureThenRedirect('Staff Attendance Management');

        $sessionYear = $this->cache->getDefaultSessionYear();

        // A. Monthly Trends — last 6 months
        $monthlyTrends = [];
        for ($i = 5; $i >= 0; $i--) {
            $monthDate = Carbon::now()->subMonths($i);
            $query     = $this->staffAttendance->builder()
                ->whereMonth('date', $monthDate->month)
                ->whereYear('date', $monthDate->year)
                ->where('session_year_id', $sessionYear->id);

            $present    = (clone $query)->where('type', 1)->count();
            $total      = (clone $query)->whereIn('type', [0, 1])->count();
            $percentage = $total > 0 ? round(($present / $total) * 100, 2) : 0;

            $monthlyTrends[] = ['month' => $monthDate->format('M'), 'percentage' => $percentage];
        }

        // B. Role-wise Attendance
        $allStaff   = $this->staff->builder()->with('user', 'user.roles')->get();
        $roleGroups = [];
        foreach ($allStaff as $s) {
            $role = optional($s->user->roles->first())->name ?? 'Staff';
            $roleGroups[$role][] = $s->user_id;
        }
        $roleWise = [];
        foreach ($roleGroups as $role => $userIds) {
            $query      = $this->staffAttendance->builder()
                ->whereIn('staff_id', $userIds)
                ->where('session_year_id', $sessionYear->id);
            $present    = (clone $query)->where('type', 1)->count();
            $total      = (clone $query)->whereIn('type', [0, 1])->count();
            $percentage = $total > 0 ? round(($present / $total) * 100, 2) : 0;
            $roleWise[] = ['name' => $role, 'percentage' => $percentage];
        }

        // C. Distribution & Low Attendance Alerts
        $distribution       = ['excellent' => 0, 'average' => 0, 'low' => 0];
        $lowAttendanceStaff = [];

        foreach ($allStaff as $s) {
            $query      = $this->staffAttendance->builder()
                ->where('staff_id', $s->user_id)
                ->where('session_year_id', $sessionYear->id);
            $present    = (clone $query)->where('type', 1)->count();
            $total      = (clone $query)->whereIn('type', [0, 1])->count();
            $percentage = $total > 0 ? round(($present / $total) * 100, 2) : 0;

            if ($percentage >= 90)      $distribution['excellent']++;
            elseif ($percentage >= 75)  $distribution['average']++;
            else {
                $distribution['low']++;
                if (count($lowAttendanceStaff) < 10) {
                    $lowAttendanceStaff[] = [
                        'name'       => $s->user->full_name ?? '',
                        'role'       => optional($s->user->roles->first())->name ?? 'Staff',
                        'percentage' => $percentage,
                        'present'    => $present,
                        'absent'     => $total - $present,
                    ];
                }
            }
        }

        return response()->json([
            'monthly_trends' => $monthlyTrends,
            'role_wise'      => $roleWise,
            'distribution'   => $distribution,
            'low_attendance' => $lowAttendanceStaff,
        ]);
    }

    public function monthWiseIndex()
    {
        ResponseService::noFeatureThenRedirect('Staff Attendance Management');
        ResponseService::noAnyPermissionThenRedirect(['staff-attendance-list']);

        $sessionYears = SessionYear::pluck('name', 'id');
        return view('staff-attendance.month-wise', compact('sessionYears'));
    }

    public function monthWiseShow(Request $request, $user_id = null)
    {
        ResponseService::noFeatureThenRedirect('Staff Attendance Management');
        // ResponseService::noAnyPermissionThenRedirect(['staff-attendance-list']);
        $limit = request('limit');
        $offset = request('offset', 0);

        $sql = $this->staff->builder()->with('user')->whereHas('staffAttendance', function ($q) use ($request) {
            $q->whereMonth('date', $request->month)
                ->where('session_year_id', $request->session_year_id);
        })->orderBy('user_id', 'ASC');

        if ($user_id) {
            $sql = $sql->where('user_id', $user_id);
        }

        if ($request->search) {
            $sql = $sql->whereHas('user', function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->search . '%')
                    ->orWhere('last_name', 'like', '%' . $request->search . '%')
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE '%" . $request->search . "%'");
            });
        }

        $total = $sql->count();
        if ($limit) {
            if ($offset >= $total && $total > 0) {
                $lastPage = floor(($total - 1) / $limit) * $limit; // calculate last page offset
                $offset = $lastPage;
            }
            $sql = $sql->skip($offset)->take($limit);
        }
        $res = $sql->get();
        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();


        $month = $request->month;
        $date = Carbon::create(null, $month, 1);

        foreach ($res as $row) {
            $staffAttendance = ['full_name' => $row->user->full_name, 'user_id' => $row->user_id];

            for ($day = 1; $day <= $date->daysInMonth; $day++) {
                $currentDate = $date->copy()->day($day)->format('Y-m-d');
                $attendance = $row->staffAttendance()->where('staff_id', $row->user_id)->where('date', $currentDate)->first();
                $staffAttendance["day_$day"] = $attendance ? $attendance->type : null;

            }
            $tempRow[] = $staffAttendance;
            $rows = $tempRow;
        }
        $bulkData['rows'] = $rows;
        return response()->json($bulkData);
    }

    public function yourIndex()
    {
        ResponseService::noFeatureThenRedirect('Staff Attendance Management');

        $sessionYears = SessionYear::pluck('name', 'id');
        $sessionYear = $this->cache->getDefaultSessionYear();

        return view('staff-attendance.your-index', compact('sessionYears', 'sessionYear'));
    }
}