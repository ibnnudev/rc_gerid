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
        Schema::table('slides', function (Blueprint $table) {
            $table->text('slug')->nullable()->after('title');
            $table->longText('video')->nullable()->after('content');
        });

        $slides = \App\Models\Slide::all();
        foreach ($slides as $slide) {
            $slide->slug = \Illuminate\Support\Str::slug($slide->title);
            $slide->save();
        }
    }

    public function down(): void
    {
        Schema::table('slides', function (Blueprint $table) {
            $table->dropColumn('slug');
            $table->dropColumn('video');
        });
    }
};
