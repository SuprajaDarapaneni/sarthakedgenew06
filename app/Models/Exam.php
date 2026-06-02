<?php

namespace App\Models;

use App\Traits\DateFormatTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Exam extends Model
{
    use HasFactory;
    use SoftDeletes;
    use DateFormatTrait;

    protected $fillable = [
        'name',
        'description',
        'exam_type', // 1: Offline, 2: Online
        'class_id', // Primary class (for backward compat)
        'session_year_id',
        'start_date',
        'end_date',
        'total_marks',
        'passing_marks',
        'publish',
        'status', // 0: Draft, 1: Scheduled
        'school_id',
        'last_result_submission_date'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $appends = ['exam_status', 'exam_status_name', 'has_timetable', 'class_name', 'type_name'];

    public function class()
    {
        return $this->belongsTo(ClassSchool::class, 'class_id')->withTrashed();
    }

    public function exam_classes()
    {
        return $this->hasMany(ExamClass::class, 'exam_id');
    }

    public function exam_class_sections()
    {
        return $this->hasMany(ExamClassSection::class, 'exam_id');
    }

    public function session_year()
    {
        return $this->belongsTo(SessionYear::class, 'session_year_id')->withTrashed();
    }

    public function marks()
    {
        return $this->hasManyThrough(ExamMarks::class, ExamTimetable::class, 'exam_id', 'exam_timetable_id')->orderBy('date');
    }

    public function timetable()
    {
        return $this->hasMany(ExamTimetable::class);
    }

    public function results()
    {
        return $this->hasMany(ExamResult::class, 'exam_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id')->withTrashed();
    }

    public function scopeOwner($query)
    {
        if (Auth::user()) {
            if (Auth::user()->school_id) {
                if (Auth::user()->hasRole('School Admin')) {
                    return $query->where('school_id', Auth::user()->school_id);
                }

                if (Auth::user()->hasRole('Teacher')) {
                    return $query->where('school_id', Auth::user()->school_id);
                }

                if (Auth::user()->hasRole('Student')) {
                    return $query->where('school_id', Auth::user()->school_id);
                }
                return $query->where('school_id', Auth::user()->school_id);
            }
            if (!Auth::user()->school_id) {
                if (Auth::user()->hasRole('Super Admin')) {
                    return $query;
                }
                if (Auth::user()->hasRole('Guardian')) {
                    $childId = request('child_id');
                    $studentAuth = Students::where('id', $childId)->first();
                    if ($studentAuth) {
                        return $query->where('school_id', $studentAuth->school_id);
                    }
                }
            }
        }
        return $query;
    }

    public function getExamStatusAttribute()
    {
        if ($this->status == 0 && !$this->timetable()->exists()) {
            return "0"; // Upcoming/Draft
        }

        $current_date = date('Y-m-d');

        // Use dates from exams table if available
        if ($this->getRawOriginal('start_date') && $this->getRawOriginal('end_date')) {
            $startDate = date('Y-m-d', strtotime($this->getRawOriginal('start_date')));
            $endDate = date('Y-m-d', strtotime($this->getRawOriginal('end_date')));

            if ($current_date < $startDate) {
                return "0"; // Upcoming
            } elseif ($current_date >= $startDate && $current_date <= $endDate) {
                return "1"; // Ongoing
            } else {
                return "2"; // Ended
            }
        }

        // Fallback to timetable
        if ($this->relationLoaded('timetable') || $this->timetable()->exists()) {
            $startDate = $this->timetable()->min('date');
            $endDate = $this->timetable()->max('date');

            if ($startDate && $endDate) {
                if ($current_date < $startDate) {
                    return "0"; // Upcoming
                } elseif ($current_date >= $startDate && $current_date <= $endDate) {
                    return "1"; // Ongoing
                } else {
                    return "2"; // Ended
                }
            }
        }

        return "0"; // Default
    }

    public function getExamStatusNameAttribute()
    {
        if ($this->status == 0) {
            return "Draft";
        }
        $status = $this->exam_status;
        if ($status == "0") {
            return "Upcoming";
        } elseif ($status == "1") {
            return "Ongoing";
        } else {
            return "Completed";
        }
    }

    public function getTypeNameAttribute()
    {
        return $this->exam_type == 2 ? 'Online' : 'Offline';
    }

    public function getHasTimetableAttribute()
    {
        return $this->timetable()->exists();
    }

    public function getPrefixNameAttribute()
    {
        return $this->name . ($this->class ? ' # ' . $this->class->name . ' - ' . $this->class->medium->name : '');
    }

    public function getClassNameAttribute()
    {
        if ($this->relationLoaded('class') && $this->class) {
            return $this->class->name . ' - ' . $this->class->medium->name;
        }
        // If multi-class, maybe return count
        if ($this->exam_classes()->exists()) {
            return $this->exam_classes()->count() . ' Classes';
        }
        return '';
    }

    public function getStartDateAttribute($value)
    {
        return $this->formatDateOnly($value);
    }

    public function getEndDateAttribute($value)
    {
        return $this->formatDateOnly($value);
    }

    public function getLastResultSubmissionDateAttribute($value)
    {
        if ($value) {
            return $this->formatDateOnly($value);
        }
        return null;
    }
}
