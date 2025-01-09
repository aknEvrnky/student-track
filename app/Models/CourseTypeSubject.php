<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CourseTypeSubject extends Pivot
{
    protected $fillable = [
        'course_id',
        'subject_id',
    ];
}
