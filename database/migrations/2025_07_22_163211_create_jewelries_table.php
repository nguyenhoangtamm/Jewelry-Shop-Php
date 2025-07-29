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
        Schema::create('jewelries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->decimal('price', 10, 2)->nullable(); 
            $table->decimal('weight', 10, 2)->nullable(); 
            $table->string('main_stone', 100)->nullable(); 
            $table->string('sub_stone', 100)->nullable(); 
            $table->string('gender', 10)->nullable(); 
            $table->string('brand', 100)->nullable(); 
            $table->text('description')->nullable(); 
            $table->text('after_sales_policy')->nullable(); 
            $table->integer('stock')->nullable()->default(0); 
            $table->unsignedBigInteger('category_id')->nullable(); 
            $table->timestamps(); 
            $table->softDeletes(); 
            
            // Tạo foreign key constraint cho category_id
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            
            // Tạo index cho các cột thường được query
            $table->index('category_id');
            $table->index('is_deleted');
            $table->index('name');
            $table->index('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jewelries');
    }
};