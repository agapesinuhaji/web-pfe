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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('order_uuid')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');        // pemesan
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('conselor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('schedule_id')->constrained('schedules')->onDelete('cascade');
            $table->foreignId('method_id')->constrained('conseling_methods')->onDelete('cascade');
            $table->decimal('price', 10, 2);
            $table->integer('unique_kode')->nullable(); // 3 digit
            $table->decimal('total', 10, 2);
            $table->foreignId('payment_method_id')->nullable();
            $table->enum('status', ['pending', 'payed', 'approved', 'progress' ,'selesai', 'overtime', 'pay fail']);
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
