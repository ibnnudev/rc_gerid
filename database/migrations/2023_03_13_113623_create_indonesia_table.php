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
        Schema::create('provinces', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('regencies', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('province_id');
            $table->string('name');
            $table->timestamps();

            $table->foreign('province_id')->references('id')->on('provinces');
        });

        Schema::create('districts', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('regency_id');
            $table->string('name');
            $table->timestamps();

            $table->foreign('regency_id')->references('id')->on('regencies');
        });

        Schema::create('villages', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('district_id');
            $table->string('name');
            $table->timestamps();

            $table->foreign('district_id')->references('id')->on('districts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('villages');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('regencies');
        Schema::dropIfExists('provinces');
    }
};
