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
            $table->foreign('viruses_id')->references('id')->on('viruses');
            $table->foreign('authors_id')->references('id')->on('authors');
            $table->foreign('genotipes_id')->references('id')->on('genotipes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('samples', function (Blueprint $table) {
            $table->dropForeign('samples_viruses_id_foreign');
            $table->dropForeign('samples_authors_id_foreign');
            $table->dropForeign('samples_genotipes_id_foreign');

            $table->dropColumn('viruses_id');
            $table->dropColumn('authors_id');
            $table->dropColumn('genotipes_id');
        });
    }
};
