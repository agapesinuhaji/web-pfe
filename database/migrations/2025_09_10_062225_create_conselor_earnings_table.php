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
        Schema::create('counselor_earnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('counselor_id')->constrained('users')->onDelete('cascade'); 
            $table->foreignId('periode_id')->constrained('periodes')->onDelete('cascade'); 
            $table->decimal('amount', 15, 2)->default(0); // total pendapatan
            $table->decimal('biaya_admin', 15, 2)->default(0);
            $table->decimal('biaya_system', 15, 2)->default(0);
            $table->string('description')->nullable(); // catatan tambahan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conselor_earnings');
    }
};
