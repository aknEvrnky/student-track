<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseType extends Model
{
    /** @use HasFactory<\Database\Factories\CourseTypeFactory> */
    use HasFactory;

    protected $fillable = ['title'];
}
