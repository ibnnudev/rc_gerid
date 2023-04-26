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
        Schema::create('import_requests', function (Blueprint $table) {
            $table->id();
            $table->longText('filename');
            $table->integer('status')->default(0); // 0 = waiting, 1 = accepted, 2 = rejected
            $table->integer('imported_by')->nullable();
            $table->integer('accepted_by')->nullable();
            $table->integer('rejected_by')->nullable();
            $table->longText('rejected_reason')->nullable();
            $table->longText('accepted_reason')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('import_requests');
    }
};
