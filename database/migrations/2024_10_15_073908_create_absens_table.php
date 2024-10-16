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
        Schema::create('absens', function (Blueprint $table) {
            $table->bigIncrements('id_absen');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id_user')->on('users');
            $table->unsignedBigInteger('shift_id');
            $table->foreign('shift_id')->references('id_shift')->on('shifts');
            $table->string('foto');
            $table->string('latitude');
            $table->string('longitude');
            $table->enum('status', ['on_time', 'late', 'not_come'])->default('on_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absens');
    }
};
