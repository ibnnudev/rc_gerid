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
        Schema::table('genotipes', function (Blueprint $table) {
            $table->foreign('viruses_id')->references('id')->on('viruses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('genotipes', function (Blueprint $table) {
            $table->dropForeign('genotipes_viruses_id_foreign');
            $table->dropColumn('viruses_id');
        });
    }
};
