<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('business', 'slug')) {
            Schema::table('business', function (Blueprint $table) {
                $table->string('slug', 255)->nullable()->unique()->after('name');
            });
        }

        // Generate slugs for existing businesses (only for those without a slug)
        $businesses = DB::table('business')->whereNull('slug')->orWhere('slug', '')->get();
        foreach ($businesses as $business) {
            $baseSlug = Str::slug($business->name);
            $slug = $baseSlug;
            $counter = 1;

            // Ensure unique slug
            while (DB::table('business')->where('slug', $slug)->where('id', '!=', $business->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            DB::table('business')
                ->where('id', $business->id)
                ->update(['slug' => $slug]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('business', 'slug')) {
            Schema::table('business', function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        }
    }
};
