<?php

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
        Schema::create('awards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category');
            $table->timestamps();
        });

        Schema::create('award_person', function (Blueprint $table) {
            $table->id();
            $table->foreignId('award_id')->constrained('awards')->onDelete('cascade');
            $table->foreignId('person_id')->constrained('people')->onDelete('cascade');
            $table->foreignId('movie_id')->nullable()->constrained('movies')->onDelete('cascade');
        });

        Schema::create('award_movie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('award_id')->constrained('awards')->onDelete('cascade');
            $table->foreignId('movie_id')->constrained('movies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('awards');
        Schema::dropIfExists('award_person');
        Schema::dropIfExists('award_movie');
    }
};
