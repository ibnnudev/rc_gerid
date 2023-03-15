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
        Schema::create('hiv_cases', function (Blueprint $table) {
            $table->id();
            $table->string('idkd')->nullable();
            $table->text('idkd_address')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->integer('regency_id')->nullable();
            $table->integer('district_id')->nullable();
            $table->integer('province_id')->nullable();
            $table->enum('region', ['Timur', 'Barat', 'Utara', 'Selatan', 'Pusat'])->nullable();
            $table->integer('count_of_cases')->nullable();
            $table->integer('age')->nullable();
            $table->string('age_group')->nullable();
            $table->integer('sex')->nullable();
            $table->integer('transmission_id')->nullable();
            $table->year('year')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hiv_cases');
    }
};
