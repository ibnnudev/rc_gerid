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
        Schema::create('samples', function (Blueprint $table) {
            $table->id();
            $table->string('sample_code')->nullable();
            $table->unsignedBigInteger('viruses_id')->nullable();
            $table->string('gene_name')->nullable();
            $table->string('sequence_date')->nullable();
            $table->string('place')->nullable();
            $table->string('city')->nullable();
            $table->string('subdistrict')->nullable();
            $table->string('region')->nullable();
            $table->date('pickup_date')->nullable();
            $table->unsignedBigInteger('authors_id')->nullable();
            $table->unsignedBigInteger('genotipes_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('samples');
    }
};
