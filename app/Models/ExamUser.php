<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ExamUser extends Pivot
{
    protected $fillable = ['exam_id', 'user_id'];
}
