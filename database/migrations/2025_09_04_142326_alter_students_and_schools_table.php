<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('student_number', 20)->unique()->nullable();
            $table->string('class', 10)->nullable();
            $table->enum('status', ['active', 'inactive', 'graduated'])->default('active');
        });

        Schema::table('schools', function (Blueprint $table) {
            $table->string('code', 10)->unique()->nullable();
            $table->string('region', 50)->nullable();
        });
    }

    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['student_number', 'class', 'status']);
        });

        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn(['code', 'region']);
        });
    }
};
