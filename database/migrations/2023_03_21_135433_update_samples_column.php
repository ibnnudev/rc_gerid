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
            // check if column citation_id exists
            if(!Schema::hasColumn('samples', 'citation_id')) {
                // add column citation_id
                $table->bigInteger('citation_id')->unsigned()->nullable()->after('genotipes_id');
            }
            // drop foreign key and column authors_id, check if column and foreign key exists
            if(Schema::hasColumn('samples', 'authors_id') ) {
                $table->dropForeign('samples_authors_id_foreign');
                $table->dropColumn('authors_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('samples', function (Blueprint $table) {
            // drop citation_id column
            $table->dropColumn('citation_id');
            // add authors_id column
            $table->bigInteger('authors_id')->unsigned()->nullable()->after('genotipes_id');
            $table->foreign('authors_id')->references('id')->on('authors');
        });
    }
};
