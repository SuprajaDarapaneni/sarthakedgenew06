<?php

namespace App\Http\Controllers;

use App\Repositories\Attendance\AttendanceInterface;
use App\Repositories\ClassSection\ClassSectionInterface;
use App\Repositories\Student\StudentInterface;
use App\Services\CachingService;
use App\Services\ResponseService;
use App\Services\SessionYearsTrackingsService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Leave\LeaveInterface;
use App\Models\Leave;
use Illuminate\Support\Str;
use Throwable;

class AttendanceController extends Controller
{

    private AttendanceInterface $attendance;
    private ClassSectionInterface $classSection;
    private StudentInterface $student;
    private CachingService $cache;
    private LeaveInterface $leave;
    private SessionYearsTrackingsService $sessionYearsTrackingsService;

    public function __construct(AttendanceInterface $attendance, ClassSectionInterface $classSection, StudentInterface $student, CachingService $cachingService, SessionYearsTrackingsService $sessionYearsTrackingsService, LeaveInterface $leave)
    {
        $this->attendance = $attendance;
        $this->classSection = $classSection;
        $this->student = $student;
        $this->cache = $cachingService;
        $this->sessionYearsTrackingsService = $sessionYearsTrackingsService;
        $this->leave = $leave;
    }


    public function index()
    {
        ResponseService::noFeatureThenRedirect('Attendance Management');
        ResponseService::noAnyPermissionThenRedirect(['class-teacher', 'attendance-list']);
        $classSections = $this->classSection->builder()->ClassTeacher()->with('class', 'class.stream', 'section', 'medium')->get();
        return view('attendance.index', compact('classSections'));
    }


    public function view()
    {
        ResponseService::noFeatureThenRedirect('Attendance Management');
        ResponseService::noAnyPermissionThenRedirect(['class-teacher', 'attendance-list']);
        $class_sections = $this->classSection->builder()->ClassTeacher()->with('class', 'class.stream', 'section', 'medium')->get();
        $sessionYears = \App\Models\SessionYear::owner()->pluck('name', 'id');
        $currentSessionYear = $this->cache->getDefaultSessionYear();
        return view('attendance.view', compact('class_sections', 'sessionYears', 'currentSessionYear'));
    }

    public function getAttendanceData(Request $request)
    {
        ResponseService::noFeatureThenRedirect('Attendance Management');
        $response = $this->attendance->builder()->select('type')->where(['date' => date('Y-m-d', strtotime($request->date)), 'class_section_id' => $request->class_section_id])->pluck('type')->first();
        return response()->json($response);
    }

    public function store(Request $request)
    {
        ResponseService::noFeatureThenRedirect('Attendance Management');
        ResponseService::noAnyPermissionThenRedirect(['class-teacher', 'attendance-create', 'attendance-edit']);
        $request->validate([
            'class_section_id' => 'required',
            'date' => 'required',
        ]);
        try {
            DB::beginTransaction();
            $attendanceData = array();
            $sessionYear = $this->cache->getDefaultSessionYear();
            $student_ids = array();
            foreach ($request->attendance_data as $value) {
                $data = (object) $value;
                $attendanceData[] = array(
                    "id" => $data->id,
                    'class_section_id' => $request->class_section_id,
                    'student_id' => $data->student_id,
                    'session_year_id' => $sessionYear->id,
                    'type' => $request->holiday ?? $data->type,
                    'date' => date('Y-m-d', strtotime($request->date)),
                );

                if ($data->type == 0) {
                    $student_ids[] = $data->student_id;
                }
            }
            $this->attendance->upsert($attendanceData, ["id"], ["class_section_id", "student_id", "session_year_id", "type", "date"]);

            DB::commit();

            if ($request->absent_notification) {
                $user = $this->student->builder()->whereIn('user_id', $student_ids)->pluck('guardian_id');
                $date = Carbon::parse(date('Y-m-d', strtotime($request->date)))->format('F jS, Y');
                $title = 'Absent';
                $body = 'Your child is absent on ' . $date;
                $type = "attendance";

                send_notification($user, $title, $body, $type);
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
                ResponseService::logErrorResponse($e, "Attendance Controller -> Store method");
                ResponseService::errorResponse();
            }
        }
    }

    public function show(Request $request)
    {
        ResponseService::noFeatureThenRedirect('Attendance Management');
        ResponseService::noAnyPermissionThenRedirect(['class-teacher', 'attendance-list']);

        //        $offset = $request->input('offset', 0);
        //        $limit = $request->input('limit', 10);
        $sort = $request->input('sort', 'roll_number');
        $order = $request->input('order', 'ASC');
        $search = $request->input('search');

        $class_section_id = $request->class_section_id;
        $date = date('Y-m-d', strtotime($request->date));
        $sessionYear = $this->cache->getDefaultSessionYear();

        $attendanceData = array();
        $total = 0;

        $attendanceQuery = $this->attendance->builder()->with('user.student')->where(['date' => $date, 'class_section_id' => $class_section_id, 'session_year_id' => $sessionYear->id])->whereHas('user', function ($q) {
            $q->whereNull('deleted_at');
        })->whereHas('user.student', function ($q) use ($sessionYear) {
            $q->where('session_year_id', $sessionYear->id);
        });

        if ($date != '' && $attendanceQuery->count() > 0) {
            $attendanceQuery->when($search, function ($query) use ($search) {
                $query->where('id', 'LIKE', "%$search%")->orWhereHas('user', function ($q) use ($search) {
                    $q->whereRaw("concat(users.first_name,' ',users.last_name) LIKE '%" . $search . "%'");
                });
            })->where('date', $date)->whereHas('user.student', function ($q) use ($sessionYear) {
                $q->where('session_year_id', $sessionYear->id);
            });

            $total = $attendanceQuery->count();
            $attendanceData = $attendanceQuery->get();
        } else if ($class_section_id) {
            $studentQuery = $this->student->builder()->where('session_year_id', $sessionYear->id)->where('class_section_id', $class_section_id)->with('user')
                ->whereHas('user', function ($q) {
                    $q->whereNull('deleted_at');
                })
                ->when($search, function ($query) use ($search) {
                    $query->where('id', 'LIKE', "%$search%")->orWhereHas('user', function ($q) use ($search) {
                        $q->whereRaw("concat(users.first_name,' ',users.last_name) LIKE '%" . $search . "%'")->where('deleted_at', NULL);
                    });
                })->where('session_year_id', $sessionYear->id)->where('class_section_id', $class_section_id);

            $total = $studentQuery->count();
            // $studentQuery->orderBy($sort, $order)->skip($offset)->take($limit);
            $studentQuery->orderBy($sort, $order);
            $attendanceData = $studentQuery->get();
        }

        $rows = [];
        $no = 1;

        foreach ($attendanceData as $row) {
            $type = $row->type ?? NULL;
            // TODO : understand this code
            $rows[] = [
                'id' => $attendanceQuery->count() ? $row->id : null,
                'no' => $no,
                'student_id' => $attendanceQuery->count() ? $row->student_id : $row->user_id,
                'user_id' => $attendanceQuery->count() ? $row->student_id : $row->user_id,
                'admission_no' => $row->user ? ($row->user->student->admission_no ?? '') : ($row->admission_no ?? ''),
                'roll_no' => $row->user ? ($row->user->student->roll_number ?? '') : ($row->roll_number ?? ''),
                'name' => '<input type="hidden" value="' . ($row->student_id ? $row->user_id : 'null') . '" name="attendance_data[' . $no . '][id]"><input type="hidden" value="' . ($row->student_id ?? $row->user_id) . '" name="attendance_data[' . $no . '][student_id]">' . ($row->user->first_name ?? '') . ' ' . ($row->user->last_name ?? ''),
                'type' => $type,
            ];
            $no++;
        }

        $bulkData['total'] = $total;
        $bulkData['rows'] = $rows;

        return response()->json($bulkData);
    }


    public function attendance_show(Request $request)
    {
        ResponseService::noFeatureThenRedirect('Attendance Management');
        ResponseService::noAnyPermissionThenRedirect(['class-teacher', 'attendance-list']);

        $offset = request('offset', 0);
        $limit = request('limit');
        $sort = request('sort', 'student_id');
        $order = request('order', 'ASC');
        $search = request('search');
        $attendanceType = request('attendance_type');

        $class_section_id = request('class_section_id');
        $date = date('Y-m-d', strtotime(request('date')));

        $validator = Validator::make($request->all(), ['class_section_id' => 'required', 'date' => 'required',]);
        if ($validator->fails()) {
            ResponseService::errorResponse($validator->errors()->first());
        }

        $sessionYear = $this->cache->getDefaultSessionYear();

        $sql = $this->attendance->builder()->where(['date' => $date, 'class_section_id' => $class_section_id])->with('user.student', 'class_section.class', 'class_section.section')
            ->where(function ($query) use ($search) {
                $query->when($search, function ($query) use ($search) {
                    $query->where(function ($query) use ($search) {
                        $query->where('id', 'LIKE', "%$search%")
                            ->orwhere('student_id', 'LIKE', "%$search%")
                            ->orWhereHas('user', function ($q) use ($search) {
                                $q->whereRaw("concat(first_name,' ',last_name) LIKE '%" . $search . "%'")
                                    ->orwhere('first_name', 'LIKE', "%$search%")
                                    ->orwhere('last_name', 'LIKE', "%$search%");
                            })->orWhereHas('user.student', function ($q) use ($search) {
                                $q->where('admission_no', 'LIKE', "%$search%")
                                    ->orwhere('id', 'LIKE', "%$search%")
                                    ->orwhere('user_id', 'LIKE', "%$search%")
                                    ->orwhere('roll_number', 'LIKE', "%$search%");
                            });
                    });
                });
            })
            ->when($attendanceType != null, function ($query) use ($attendanceType) {
                $query->where('type', $attendanceType);
            });
        $sql = $sql->whereHas('user.student', function ($q) use ($sessionYear) {
            $q->where('session_year_id', $sessionYear->id);
        });
        $total = $sql->count();

        $sql->orderBy($sort, $order);

        if ($limit) {
            if ($offset >= $total && $total > 0) {
                $lastPage = floor(($total - 1) / $limit) * $limit; // calculate last page offset
                $offset = $lastPage;
            }
            $sql->skip($offset)->take($limit);
        }

        $res = $sql->get();

        // Fetch cumulative stats for all students in this session year to avoid N+1
        $studentIds = $res->pluck('student_id')->toArray();
        $cumulativeStats = $this->attendance->builder()
            ->whereIn('student_id', $studentIds)
            ->where('session_year_id', $sessionYear->id)
            ->select(
                'student_id',
                DB::raw('count(case when type = 1 then 1 end) as present_days'),
                DB::raw('count(case when type = 0 then 1 end) as absent_days'),
                DB::raw('count(case when type = 2 then 1 end) as leave_days')
            )
            ->groupBy('student_id')
            ->get()
            ->keyBy('student_id');

        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $no = 1;

        foreach ($res as $row) {
            $tempRow = $row->toArray();
            $tempRow['no'] = $no++;

            $stats = $cumulativeStats->get($row->student_id);
            $present = $stats->present_days ?? 0;
            $absent = $stats->absent_days ?? 0;
            $leave = $stats->leave_days ?? 0;
            $totalDaysMarked = $present + $absent;
            $percentage = $totalDaysMarked > 0 ? round(($present / $totalDaysMarked) * 100, 2) : 0;

            $tempRow['present_days'] = $present;
            $tempRow['absent_days'] = $absent;
            $tempRow['leave_days'] = $leave;
            $tempRow['attendance_percentage'] = $percentage;
            $tempRow['name'] = $row->user->full_name;
            $tempRow['class_section'] = ($row->class_section->class->name ?? '') . ' ' . ($row->class_section->section->name ?? '');

            if ($percentage >= 90)
                $tempRow['attendance_status'] = 'Good';
            elseif ($percentage >= 75)
                $tempRow['attendance_status'] = 'Warning';
            else
                $tempRow['attendance_status'] = 'Low';

            $rows[] = $tempRow;
        }
        $bulkData['rows'] = $rows;
        return response()->json($bulkData);
    }

    public function monthWiseIndex()
    {
        ResponseService::noFeatureThenRedirect('Attendance Management');
        ResponseService::noAnyPermissionThenRedirect(['class-teacher', 'attendance-list']);
        $class_sections = $this->classSection->builder()->ClassTeacher()->with('class', 'class.stream', 'section', 'medium')->get();

        return view('attendance.month_wise', compact('class_sections'));
    }

    public function monthWiseShow(Request $request)
    {
        ResponseService::noFeatureThenRedirect('Attendance Management');
        ResponseService::noAnyPermissionThenRedirect(['class-teacher', 'attendance-list']);

        $sessionYear = $this->cache->getDefaultSessionYear();
        $sql = $this->student->builder()->with('user')->whereHas('attendance', function ($q) use ($request, $sessionYear) {
            $q->where('class_section_id', $request->class_section_id)
                ->whereMonth('date', $request->month)
                ->where('session_year_id', $sessionYear->id);
        })->orderBy('roll_number', 'ASC');

        $total = $sql->count();

        $res = $sql->get();
        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();


        $month = $request->month;
        $date = Carbon::create(null, $month, 1);

        foreach ($res as $row) {
            $studentAttendance = ['full_name' => $row->user->full_name, 'roll_number' => $row->roll_number];

            for ($day = 1; $day <= $date->daysInMonth; $day++) {
                $currentDate = $date->copy()->day($day)->format('Y-m-d');
                $attendance = $row->attendance()->where('student_id', $row->user_id)->where('date', $currentDate)->first();
                $studentAttendance["day_$day"] = $attendance ? $attendance->type : null;

            }
            $tempRow[] = $studentAttendance;
            $rows = $tempRow;
        }
        $bulkData['rows'] = $rows;
        return response()->json($bulkData);

    }
    public function getStats(Request $request)
    {
        ResponseService::noFeatureThenRedirect('Attendance Management');
        $classSectionId = $request->class_section_id;
        $date = $request->date ? date('Y-m-d', strtotime($request->date)) : date('Y-m-d');
        $sessionYear = $this->cache->getDefaultSessionYear();

        // Total Students
        $studentQuery = $this->student->builder()->where('session_year_id', $sessionYear->id);
        if ($classSectionId) {
            $studentQuery->where('class_section_id', $classSectionId);
        }
        $totalStudents = $studentQuery->count();

        // Present, Absent
        $attendanceQuery = $this->attendance->builder()->where(['date' => $date, 'session_year_id' => $sessionYear->id]);
        if ($classSectionId) {
            $attendanceQuery->where('class_section_id', $classSectionId);
        }

        $present = (clone $attendanceQuery)->where('type', 1)->count();
        $absent = (clone $attendanceQuery)->where('type', 0)->count();

        // On Leave
        $leaveCount = Leave::where('school_id', Auth::user()->school_id)
            ->where('status', 1) // Approved
            ->whereDate('from_date', '<=', $date)
            ->whereDate('to_date', '>=', $date);

        if ($classSectionId) {
            $leaveCount->whereHas('user.student', function ($q) use ($classSectionId) {
                $q->where('class_section_id', $classSectionId);
            });
        }
        $onLeave = $leaveCount->count();

        // Avg Attendance % for the selected class/section for the current month
        $month = date('m', strtotime($date));
        $year = date('Y', strtotime($date));

        $monthAttendanceCount = $this->attendance->builder()
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->where('session_year_id', $sessionYear->id);

        if ($classSectionId) {
            $monthAttendanceCount->where('class_section_id', $classSectionId);
        }

        $totalPresentInMonth = (clone $monthAttendanceCount)->where('type', 1)->count();
        $totalMarkedInMonth = (clone $monthAttendanceCount)->whereIn('type', [0, 1])->count();

        $avgAttendance = $totalMarkedInMonth > 0 ? round(($totalPresentInMonth / $totalMarkedInMonth) * 100, 2) : 0;

        return response()->json([
            'total_students' => $totalStudents,
            'present' => $present,
            'absent' => $absent,
            'on_leave' => $onLeave,
            'avg_attendance' => $avgAttendance
        ]);
    }

    public function getAnalytics(Request $request)
    {
        ResponseService::noFeatureThenRedirect('Attendance Management');
        $classSectionId = $request->class_section_id;
        $sessionYear = $this->cache->getDefaultSessionYear();

        // A. Monthly Trends (Line Chart) - Last 6 months
        $monthlyTrends = [];
        for ($i = 5; $i >= 0; $i--) {
            $monthDate = Carbon::now()->subMonths($i);
            $month = $monthDate->month;
            $year = $monthDate->year;
            $monthName = $monthDate->format('M');

            $query = $this->attendance->builder()
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->where('session_year_id', $sessionYear->id);

            if ($classSectionId) {
                $query->where('class_section_id', $classSectionId);
            }

            $present = (clone $query)->where('type', 1)->count();
            $total = (clone $query)->whereIn('type', [0, 1])->count();
            $percentage = $total > 0 ? round(($present / $total) * 100, 2) : 0;

            $monthlyTrends[] = [
                'month' => $monthName,
                'percentage' => $percentage
            ];
        }

        // B. Class-wise Attendance (Bar Chart)
        $classWise = [];
        $classes = $this->classSection->builder()->ClassTeacher()->with('class', 'section')->get();
        foreach ($classes as $class) {
            $query = $this->attendance->builder()
                ->where('class_section_id', $class->id)
                ->where('session_year_id', $sessionYear->id);

            $present = (clone $query)->where('type', 1)->count();
            $total = (clone $query)->whereIn('type', [0, 1])->count();
            $percentage = $total > 0 ? round(($present / $total) * 100, 2) : 0;

            $classWise[] = [
                'name' => $class->full_name,
                'percentage' => $percentage
            ];
        }

        // C. Attendance Distribution & Low Attendance Alert
        $distribution = ['excellent' => 0, 'average' => 0, 'low' => 0];
        $lowAttendanceStudents = [];

        $students = $this->student->builder()->where('session_year_id', $sessionYear->id);
        if ($classSectionId) {
            $students->where('class_section_id', $classSectionId);
        } else {
            // If admin, maybe just take top classes or limit students for performance
            // For now, let's take all and see performance.
        }
        $students = $students->with('user', 'class_section.class', 'class_section.section')->get();

        foreach ($students as $student) {
            $query = $this->attendance->builder()
                ->where('student_id', $student->user_id)
                ->where('session_year_id', $sessionYear->id);

            $present = (clone $query)->where('type', 1)->count();
            $total = (clone $query)->whereIn('type', [0, 1])->count();
            $percentage = $total > 0 ? round(($present / $total) * 100, 2) : 0;

            if ($percentage >= 90)
                $distribution['excellent']++;
            elseif ($percentage >= 75)
                $distribution['average']++;
            else {
                $distribution['low']++;
                if ($percentage < 75 && count($lowAttendanceStudents) < 10) {
                    $lowAttendanceStudents[] = [
                        'name' => $student->user->full_name,
                        'class' => $student->class_section->full_name ?? '',
                        'percentage' => $percentage,
                        'present' => $present,
                        'absent' => $total - $present
                    ];
                }
            }
        }

        return response()->json([
            'monthly_trends' => $monthlyTrends,
            'class_wise' => $classWise,
            'distribution' => $distribution,
            'low_attendance' => $lowAttendanceStudents
        ]);
    }
}
