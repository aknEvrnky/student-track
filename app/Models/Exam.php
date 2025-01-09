<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Exam extends Model
{
    /** @use HasFactory<\Database\Factories\ExamFactory> */
    use HasFactory;

    protected $fillable = ['title', 'start_at'];

    protected $casts = [
        'start_at' => 'datetime',
    ];

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'exam_user', 'exam_id', 'user_id')
            ->withTimestamps();
    }
}
