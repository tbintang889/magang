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
         Schema::table('teachers', function (Blueprint $table) {
            $table->string('teacher_number', 20)->unique()->nullable();
      
            $table->enum('status', ['active', 'inactive', 'graduated'])->default('active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn('teacher_number');
            $table->dropColumn('status');
        });
    }
};
