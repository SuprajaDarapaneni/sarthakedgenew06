<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Traits\DateFormatTrait;


class FeesType extends Model
{
    use HasFactory, DateFormatTrait;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'school_id',
        'parent_id',
    ];


    public function fees_class()
    {
        return $this->hasMany(FeesClassType::class, 'fees_type_id');
    }

    /** Child components of this fee type */
    public function components()
    {
        return $this->hasMany(FeesType::class, 'parent_id');
    }

    /** Parent fee type (null for root types) */
    public function parent()
    {
        return $this->belongsTo(FeesType::class, 'parent_id');
    }

    public function scopeOwner($query)
    {
        if (Auth::user()) {
            if (Auth::user()->hasRole('Super Admin')) {
                return $query;
            }

            if (Auth::user()->hasRole('School Admin') || Auth::user()->hasRole('Teacher')) {
                return $query->where('school_id', Auth::user()->school_id);
            }

            if (Auth::user()->hasRole('Student')) {
                return $query->where('school_id', Auth::user()->school_id);
            }

            if (Auth::user()->school_id) {
                return $query->where('school_id', Auth::user()->school_id);
            }
        }

        return $query;
    }

    public function session_years_trackings()
    {
        return $this->hasMany(SessionYearsTracking::class, 'modal_id', 'id')->where('modal_type', 'App\Models\FeesType');
    }

    public function getCreatedAtAttribute()
    {
        return $this->formatDateValue($this->getRawOriginal('created_at'));
    }

    public function getUpdatedAtAttribute()
    {
        return $this->formatDateValue($this->getRawOriginal('updated_at'));
    }
}
