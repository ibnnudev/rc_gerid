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
        Schema::create('cases', function (Blueprint $table) {
            $table->id();
            $table->integer('no')->nullable();
            $table->string('idkd')->nullable();
            $table->string('idkd_address')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->string('city')->nullable();
            $table->string('subdistrict')->nullable();
            $table->string('region')->nullable();
            $table->integer('count_of_cases')->nullable();
            $table->integer('age')->nullable();
            $table->string('age_group')->nullable();
            $table->string('sex')->nullable();
            $table->string('transmission')->nullable();
            $table->year('year')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cases');
    }
};
