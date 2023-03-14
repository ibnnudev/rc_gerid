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
        // add is_active column to sample and citation table
        Schema::table('samples', function (Blueprint $table) {
            $table->boolean('is_active')->default(true);
        });

        Schema::table('citations', function (Blueprint $table) {
            $table->boolean('is_active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // drop is_active column from sample and citation table
        Schema::table('samples', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

        Schema::table('citations', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
};
