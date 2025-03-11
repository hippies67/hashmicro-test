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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pegawai');
            $table->string('email');
            $table->bigInteger('gajih', 8, 2);
            $table->unsignedBigInteger('departemen_id');
            $table->unsignedBigInteger('bonus_id')->nullable();
            $table->timestamps();

            $table->foreign('bonus_id')->references('id')->on('bonuses');
            $table->foreign('departemen_id')->references('id')->on('departemens');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
