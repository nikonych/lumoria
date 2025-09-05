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
        Schema::create('user_collections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->boolean('is_public')->default(false);
            $table->timestamps();
        });

        Schema::create('movie_user_collection', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_collection_id')->constrained('user_collections')->onDelete('cascade'); ##TODO
            $table->foreignId('movie_id')->constrained('movies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_collections');
        Schema::dropIfExists('movie_user_collection');
    }
};
