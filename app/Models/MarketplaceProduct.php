<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketplaceProduct extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $fillable = [
        'title',
        'description',
        'price',
        'category',
        'image',
        'contact_info',
        'link',
        'status',
        'user_id',
        'school_id',
        'commission_percentage'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
