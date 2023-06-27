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
        Schema::table('citations', function (Blueprint $table) {
            // drop foreign key and column samples_id
            // check it
            if(Schema::hasColumn('citations', 'samples_id') && Schema::hasColumn('citations', 'samples_id')) {
                $table->dropForeign('citations_samples_id_foreign');
                $table->dropColumn('samples_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('citations', function (Blueprint $table) {
            // add samples_id column
            $table->bigInteger('samples_id')->unsigned()->nullable()->after('id');
            $table->foreign('samples_id')->references('id')->on('samples');
        });
    }
};
