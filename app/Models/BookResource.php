<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BookResource extends Model
{
    /** @use HasFactory<\Database\Factories\BookResourceFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'published_year',
        'isbn',
        'publisher_id',
        'course_id',
    ];

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function solvedQuestionRecords(): HasMany
    {
        return $this->hasMany(SolvedQuestionRecord::class);
    }
}
