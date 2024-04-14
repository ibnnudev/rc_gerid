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
        Schema::table('samples', function (Blueprint $table) {
            // check if province_id and regency_id column exists
            if (! Schema::hasColumn('samples', 'province_id')) {
                $table->unsignedBigInteger('province_id')->nullable();
            }

            if (! Schema::hasColumn('samples', 'regency_id')) {
                $table->unsignedBigInteger('regency_id')->nullable();
            }

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('samples', function (Blueprint $table) {
            $table->dropForeign('samples_province_id_foreign');
            $table->dropForeign('samples_regency_id_foreign');

            $table->dropColumn('province_id');
            $table->dropColumn('regency_id');
        });
    }
};
