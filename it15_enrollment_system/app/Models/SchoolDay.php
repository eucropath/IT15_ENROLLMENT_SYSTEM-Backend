<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolDay extends Model
{
    protected $fillable = [
        'date',
        'day_type',
        'description',
        'is_school_day',
        'academic_year'
    ];

    protected $casts = [
        'date' => 'date',
        'is_school_day' => 'boolean'
    ];
}
