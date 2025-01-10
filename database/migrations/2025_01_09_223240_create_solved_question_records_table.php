<?php

use App\Models\BookResource;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('solved_question_records', function (Blueprint $table) {
            $table->id();
            $table->integer('number_of_solved_questions');
            $table->foreignIdFor(User::class, 'student_id');
            $table->foreignIdFor(Course::class);
            $table->foreignIdFor(BookResource::class);
            $table->date('solved_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solved_question_records');
    }
};
