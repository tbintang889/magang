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
        //
        Schema::create('number_sequences', function (Blueprint $table) {
            $table->id();
            $table->string('key'); // contoh: siswa-2025, invoice-2025-school-3
            $table->unsignedInteger('last_number')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('number_sequences');
    }
};
