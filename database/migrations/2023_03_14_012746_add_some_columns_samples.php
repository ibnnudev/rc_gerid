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
            // check if province_id and regency_id columns exist
            if (!Schema::hasColumn('samples', 'province_id') && !Schema::hasColumn('samples', 'regency_id')) {
                // add province_id column and regency_id column
                $table->unsignedBigInteger('province_id')->nullable();
                $table->unsignedBigInteger('regency_id')->nullable();

                // add foreign key constraint for province_id column
                $table->foreign('province_id')->references('id')->on('provinces')->onDelete('cascade');

                // add foreign key constraint for regency_id column
                $table->foreign('regency_id')->references('id')->on('regencies')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('samples', function (Blueprint $table) {
            // drop foreign key constraint for province_id column
            $table->dropForeign('samples_province_id_foreign');

            // drop foreign key constraint for regency_id column
            $table->dropForeign('samples_regency_id_foreign');

            // drop province_id column and regency_id column
            $table->dropColumn('province_id');
            $table->dropColumn('regency_id');
        });
    }
};
