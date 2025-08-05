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
        Schema::create('jewelry_files', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('jewelry_id')->nullable(); 
            $table->unsignedBigInteger('file_id')->nullable(); 
            $table->tinyInteger('is_main')->default(0); // 1: file chính, 0: phụ
            $table->timestamps(); 
            $table->tinyInteger('is_deleted')->default(0); 
            
            // Tạo foreign key constraints
            $table->foreign('jewelry_id')->references('id')->on('jewelries')->onDelete('cascade');
            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
            
            // Tạo index cho các cột thường được query
            $table->index('jewelry_id');
            $table->index('file_id');
            $table->index('is_deleted');
            $table->index('is_main');
            
            // Tạo unique constraint để tránh trùng lặp jewelry_id + file_id
            $table->unique(['jewelry_id', 'file_id'], 'unique_jewelry_file');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jewelry_files');
    }
};