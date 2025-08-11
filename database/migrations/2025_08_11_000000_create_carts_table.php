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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('jewelry_id')->constrained('jewelries')->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->decimal('price', 15, 2); // Giá tại thời điểm thêm vào giỏ hàng
            $table->timestamps();

            // Đảm bảo một user chỉ có một item cho mỗi jewelry
            $table->unique(['user_id', 'jewelry_id']);

            // Index để tối ưu hóa truy vấn
            $table->index(['user_id']);
            $table->index(['jewelry_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
