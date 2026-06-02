<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SystemSetting extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'data',
        'type',
    ];

    public $timestamps = false;
    protected $connection = 'mysql';

    public function getDataAttribute($value) {
        if (isset($this->attributes['type']) && $this->attributes['type'] == 'file') {
            return Storage::disk('public')->url($value);
        }

        return $value;
    }

}
