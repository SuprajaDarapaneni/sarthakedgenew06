<?php

namespace App\Http\Controllers;

use App\Repositories\Medium\MediumInterface;
use App\Repositories\Subject\SubjectInterface;
use App\Rules\uniqueForSchool;
use App\Services\BootstrapTableService;
use App\Services\ResponseService;
use App\Services\CachingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Rules\MaxFileSize;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Throwable;

class SubjectController extends Controller
{
    private MediumInterface $medium;
    private SubjectInterface $subject;
    private CachingService $cache;

    public function __construct(MediumInterface $medium, SubjectInterface $subject, CachingService $cache)
    {
        $this->medium = $medium;
        $this->subject = $subject;
        $this->cache = $cache;
    }

    public function index()
    {
        ResponseService::noPermissionThenRedirect('subject-list');
        $mediums = $this->medium->builder()->orderBy('id', 'DESC')->get();
        $teachers = \App\Models\User::role('Teacher')->get();
        $classes = \App\Models\ClassSchool::owner()->with('medium', 'stream', 'shift')->get();
        $semesters = \App\Models\Semester::owner()->get();
        $shifts = \App\Models\Shift::owner()->where('status', 1)->get();
        $streams = \App\Models\Stream::owner()->get();

        $stats = [
            'total' => $this->subject->builder()->count(),
            'core' => $this->subject->builder()->where('type', 'Core')->count(),
            'elective' => $this->subject->builder()->where('type', 'Elective')->count(),
            'optional' => $this->subject->builder()->where('type', 'Optional')->count(),
        ];

        return response(view('subjects.index', compact('mediums', 'teachers', 'stats', 'classes', 'semesters', 'shifts', 'streams')));
    }

    public function show(Request $request)
    {
        ResponseService::noPermissionThenRedirect('subject-list');
        $offset = request('offset', 0);
        $limit = request('limit', 10);
        $sort = request('sort', 'id');
        $order = request('order', 'DESC');
        $search = $_GET['search'];
        $showDeleted = $request->show_deleted;

        $sql = $this->subject->builder()->with(['medium', 'teacher', 'class_subjects.class'])
            ->where(function ($query) use ($search) {
                $query->when($search, function ($q) use ($search) {
                    $q->where('id', 'LIKE', "%$search%")
                        ->orwhere('name', 'LIKE', "%$search%")
                        ->orwhere('code', 'LIKE', "%$search%")
                        ->orwhere('type', 'LIKE', "%$search%")->Owner();
                });
            })
            ->when(!empty($showDeleted), function ($q) {
                $q->onlyTrashed()->Owner();
            });
        if (!empty($_GET['medium_id'])) {
            $sql = $sql->where('medium_id', $_GET['medium_id']);
        }

        $total = $sql->count();
        if ($offset >= $total && $total > 0) {
            $lastPage = floor(($total - 1) / $limit) * $limit; // calculate last page offset
            $offset = $lastPage;
        }
        $sql = $sql->orderBy($sort, $order)->skip($offset)->take($limit);
        $res = $sql->get();

        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $no = 1;

        foreach ($res as $row) {
            if ($request->show_deleted) {
                //Show Restore and Hard Delete Buttons
                $operate = BootstrapTableService::restoreButton(route('subjects.restore', $row->id));
                $operate .= BootstrapTableService::trashButton(route('subjects.trash', $row->id));
            } else {
                //Show Edit and Soft Delete Buttons
                $operate = BootstrapTableService::editButton(route('subjects.update', $row->id));
                $operate .= BootstrapTableService::deleteButton(route('subjects.destroy', $row->id));
            }
            $tempRow = $row->toArray();
            $tempRow['no'] = $no++;
            $tempRow['type'] = trans($row->type);
            $tempRow['eng_type'] = $row->type;
            $tempRow['teacher_name'] = $row->teacher->full_name ?? '-';
            $tempRow['classes'] = $row->class_subjects->pluck('class.name')->unique()->implode(', ');
            $tempRow['class_ids'] = $row->class_subjects->pluck('class_id');
            $tempRow['semester_id'] = $row->class_subjects->first() ? $row->class_subjects->first()->semester_id : null;
            $tempRow['periods_per_week'] = $row->periods_per_week ?? '0';
            $tempRow['status_val'] = $row->status;
            $tempRow['created_at'] = $row->created_at;
            $tempRow['updated_at'] = $row->updated_at;
            $tempRow['operate'] = $operate;
            $rows[] = $tempRow;
        }

        $bulkData['rows'] = $rows;
        return response()->json($bulkData);
    }


    public function store(Request $request)
    {
        ResponseService::noPermissionThenSendJson('subject-create');
        $file_upload_size_limit = $this->cache->getSystemSettings('file_upload_size_limit');
        $validator = Validator::make($request->all(), [
            'medium_id' => 'required|numeric',
            'type' => 'required|in:Practical,Theory,Core,Elective,Optional',
            'name' => [
                'required',
                new uniqueForSchool('subjects', ['name' => $request->name, 'medium_id' => $request->medium_id, 'type' => $request->type])
            ],
            'bg_color' => 'nullable',
            'code' => [
                'nullable',
                new uniqueForSchool('subjects', ['code' => $request->code, 'medium_id' => $request->medium_id, 'type' => $request->type])
            ],
            'image' => ['nullable', 'mimes:jpg,jpeg,png,svg', new MaxFileSize($file_upload_size_limit)],
            'teacher_id' => 'nullable|numeric',
            'periods_per_week' => 'nullable|numeric',
            'class_id' => 'nullable|array',
            'class_id.*' => 'nullable|numeric',
            'semester_id' => 'nullable|numeric',
        ])->setAttributeNames(['bg_color' => 'Background Color']);

        if ($validator->fails()) {
            ResponseService::errorResponse($validator->errors()->first());
        }
        try {
            DB::beginTransaction();
            $data = $request->all();
            \Illuminate\Support\Facades\Log::info('Subject Create Request Data:', $data);
            if (empty($data['bg_color'])) {
                $data['bg_color'] = '#2E447E';
            }
            if (empty($data['image'])) {
                $data['image'] = 'subjects/default.png'; // Fallback
            }
            $subject = $this->subject->create($data);

            if (!empty($request->class_id)) {
                $classSubjects = [];
                foreach ($request->class_id as $classId) {
                    $classSubjects[] = [
                        'class_id' => $classId,
                        'subject_id' => $subject->id,
                        'type' => ($request->type == 'Core' || $request->type == 'Theory' || $request->type == 'Practical') ? 'Compulsory' : 'Elective',
                        'semester_id' => $request->semester_id,
                        'school_id' => Auth::user()->school_id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
                \App\Models\ClassSubject::insert($classSubjects);

                if ($request->teacher_id) {
                    $subjectTeachers = [];
                    foreach ($request->class_id as $classId) {
                        $classSections = \App\Models\ClassSection::where('class_id', $classId)->get();
                        foreach ($classSections as $cs) {
                            $classSubject = \App\Models\ClassSubject::where('class_id', $classId)->where('subject_id', $subject->id)->first();
                            if ($classSubject) {
                                $subjectTeachers[] = [
                                    'class_section_id' => $cs->id,
                                    'subject_id' => $subject->id,
                                    'teacher_id' => $request->teacher_id,
                                    'class_subject_id' => $classSubject->id,
                                    'school_id' => Auth::user()->school_id,
                                    'created_at' => now(),
                                    'updated_at' => now()
                                ];
                            }
                        }
                    }
                    if (!empty($subjectTeachers)) {
                        \App\Models\SubjectTeacher::insert($subjectTeachers);
                    }
                }
            }

            DB::commit();
            ResponseService::successResponse('Data Stored Successfully');
        } catch (Throwable $e) {
            DB::rollBack();
            ResponseService::logErrorResponse($e);
            ResponseService::errorResponse();
        }
    }

    public function update(Request $request, $id)
    {
        ResponseService::noPermissionThenSendJson('subject-edit');
        $validator = Validator::make($request->all(), [
            'medium_id' => 'required|numeric',
            'name' => [
                'required',
                new uniqueForSchool('subjects', ['name' => $request->name, 'medium_id' => $request->medium_id, 'type' => $request->type], $id)
            ],
            'code' => [
                'nullable',
                new uniqueForSchool('subjects', ['code' => $request->code, 'medium_id' => $request->medium_id, 'type' => $request->type], $id)
            ],
            'type' => 'required|in:Practical,Theory,Core,Elective,Optional',
            'bg_color' => 'nullable',
            'image' => 'mimes:jpg,jpeg,png,svg|max:2048|nullable',
            'teacher_id' => 'nullable|numeric',
            'periods_per_week' => 'nullable|numeric',
            'class_id' => 'nullable|array',
            'class_id.*' => 'nullable|numeric',
            'semester_id' => 'nullable|numeric',
        ])->setAttributeNames(['bg_color' => 'Background Color']);

        if ($validator->fails()) {
            ResponseService::errorResponse($validator->errors()->first());
        }

        try {
            DB::beginTransaction();
            $data = $request->all();
            if (empty($data['bg_color'])) {
                $data['bg_color'] = '#2E447E';
            }
            $this->subject->update($id, $data);

            // Sync Classes
            \App\Models\ClassSubject::where('subject_id', $id)->delete();
            \App\Models\SubjectTeacher::where('subject_id', $id)->delete();

            if (!empty($request->class_id)) {
                $classSubjects = [];
                foreach ($request->class_id as $classId) {
                    $classSubjects[] = [
                        'class_id' => $classId,
                        'subject_id' => $id,
                        'type' => ($request->type == 'Core' || $request->type == 'Theory' || $request->type == 'Practical') ? 'Compulsory' : 'Elective',
                        'semester_id' => $request->semester_id,
                        'school_id' => Auth::user()->school_id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
                \App\Models\ClassSubject::insert($classSubjects);

                if ($request->teacher_id) {
                    $subjectTeachers = [];
                    foreach ($request->class_id as $classId) {
                        $classSections = \App\Models\ClassSection::where('class_id', $classId)->get();
                        foreach ($classSections as $cs) {
                            $classSubject = \App\Models\ClassSubject::where('class_id', $classId)->where('subject_id', $id)->first();
                            if ($classSubject) {
                                $subjectTeachers[] = [
                                    'class_section_id' => $cs->id,
                                    'subject_id' => $id,
                                    'teacher_id' => $request->teacher_id,
                                    'class_subject_id' => $classSubject->id,
                                    'school_id' => Auth::user()->school_id,
                                    'created_at' => now(),
                                    'updated_at' => now()
                                ];
                            }
                        }
                    }
                    if (!empty($subjectTeachers)) {
                        \App\Models\SubjectTeacher::insert($subjectTeachers);
                    }
                }
            }

            DB::commit();
            ResponseService::successResponse('Data Updated Successfully');
        } catch (Throwable $e) {
            DB::rollBack();
            ResponseService::logErrorResponse($e);
            ResponseService::errorResponse();
        }
    }

    public function destroy($id)
    {
        ResponseService::noPermissionThenSendJson('subject-delete');
        try {
            $this->subject->deleteById($id);
            ResponseService::successResponse('Data Deleted Successfully');
        } catch (Throwable $e) {
            ResponseService::logErrorResponse($e);
            ResponseService::errorResponse();
        }
    }

    public function restore(int $id)
    {
        ResponseService::noPermissionThenSendJson('subject-delete');
        try {
            $this->subject->findOnlyTrashedById($id)->restore();
            ResponseService::successResponse("Data Restored Successfully");
        } catch (Throwable $e) {
            ResponseService::logErrorResponse($e);
            ResponseService::errorResponse();
        }
    }

    public function trash($id)
    {
        ResponseService::noPermissionThenSendJson('subject-delete');
        try {
            $this->subject->findOnlyTrashedById($id)->forceDelete();
            ResponseService::successResponse("Data Deleted Permanently");
        } catch (Throwable $e) {
            ResponseService::logErrorResponse($e, "Subject Controller -> Trash Method", 'cannot_delete_because_data_is_associated_with_other_data');
            ResponseService::errorResponse();
        }
    }
}
