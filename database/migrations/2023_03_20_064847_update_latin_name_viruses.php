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
        Schema::table('viruses', function (Blueprint $table) {
            // update latin_name column to nullable
            $table->string('latin_name')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('viruses', function (Blueprint $table) {
            // revert latin_name column to not nullable
            $table->string('latin_name')->nullable(false)->change();
        });
    }
};
