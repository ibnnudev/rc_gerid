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
<<<<<<< HEAD
<<<<<<< HEAD
            if(Schema::hasColumn('citations', 'samples_id') ) {
=======
            if(Schema::hasColumn('citations', 'samples_id') && Schema::hasColumn('citations', 'samples_id')) {
>>>>>>> 48c9af499f3d981bf77566eee071402ea30161a0
=======
            if(Schema::hasColumn('citations', 'samples_id') && Schema::hasColumn('citations', 'samples_id')) {
>>>>>>> cb8289b (update)
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
