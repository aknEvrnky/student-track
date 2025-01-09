<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subject extends Model
{
    /** @use HasFactory<\Database\Factories\SubjectFactory> */
    use HasFactory;

    protected $fillable = ['title', 'course_id', 'sort_order'];

    protected $with = ['courseTypes'];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function courseTypes(): BelongsToMany
    {
        return $this->BelongsToMany(CourseType::class)->withTimestamps();
    }
}
