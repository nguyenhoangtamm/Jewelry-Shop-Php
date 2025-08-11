<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('jewelry_id');
            $table->timestamps();
            

            $table->unique(['user_id', 'jewelry_id']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('jewelry_id')->references('id')->on('jewelries')->onDelete('cascade');
            $table->index('user_id');
            $table->index('jewelry_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
