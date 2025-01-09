<?php

use App\Models\Course;
use App\Models\Publisher;
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
        Schema::create('book_resources', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignIdFor(Publisher::class);
            $table->foreignIdFor(Course::class);
            $table->integer('published_year')->nullable();
            $table->string('isbn')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_resources');
    }
};
