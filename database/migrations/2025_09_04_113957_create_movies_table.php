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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('original_title')->nullable();
            $table->string('release_year')->nullable();
            $table->string('duration_minutes')->nullable();
            $table->string('age_rating')->nullable();
            $table->text('description')->nullable();
            $table->string('trailer_url')->nullable();
            $table->string('poster_image')->nullable();
            $table->decimal('rating', 3, 2)->default(0);
            $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('set null');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('genre_movie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained('movies')->onDelete('cascade');
            $table->foreignId('genre_id')->constrained('genres')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
        Schema::dropIfExists('genre_movie');
    }
};
