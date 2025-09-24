<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('activity_type'); // 'movie_created', 'person_created', 'movie_rated', 'movie_favorited', 'friend_request_sent'
            $table->json('activity_data');
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
            $table->index('activity_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_activities');
    }
};
