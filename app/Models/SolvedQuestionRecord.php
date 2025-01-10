<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SolvedQuestionRecord extends Model
{
    /** @use HasFactory<\Database\Factories\SolvedQuestionRecordFactory> */
    use HasFactory;

    protected $fillable = [
        'number_of_solved_questions',
        'student_id',
        'course_id',
        'book_resource_id',
        'solved_at',
    ];

    protected $casts = [
        'solved_at' => 'date',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function bookResource(): BelongsTo
    {
        return $this->belongsTo(BookResource::class);
    }
}
