<?php

use App\Models\Subject;
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
        Schema::table('solved_question_records', function (Blueprint $table) {
            $table->foreignIdFor(Subject::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('solved_question_records', function (Blueprint $table) {
            $table->dropColumn('subject_id');
        });
    }
};