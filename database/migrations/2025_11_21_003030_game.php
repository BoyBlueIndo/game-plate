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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('genres_id')->constrained('genres')->onDelete('cascade');
            $table->string('publisher');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->longText('description');
            $table->string('price')->default('0');
            $table->string('image')->nullable();
            $table->string('game_link')->nullable();
            $table->text('comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
