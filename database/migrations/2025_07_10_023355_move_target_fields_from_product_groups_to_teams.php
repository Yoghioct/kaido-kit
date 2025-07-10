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
        // Add target fields to teams table
        Schema::table('teams', function (Blueprint $table) {
            $table->integer('target_dfr')->nullable()->after('name');
            $table->integer('target_profiling')->nullable()->after('target_dfr');
            $table->integer('target_master_call_list')->nullable()->after('target_profiling');
        });

        // Remove target fields from product_groups table
        Schema::table('product_groups', function (Blueprint $table) {
            $table->dropColumn(['target_dfr', 'target_profiling', 'target_master_call_list']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add target fields back to product_groups table
        Schema::table('product_groups', function (Blueprint $table) {
            $table->integer('target_dfr')->nullable()->after('name');
            $table->integer('target_profiling')->nullable()->after('target_dfr');
            $table->integer('target_master_call_list')->nullable()->after('target_profiling');
        });

        // Remove target fields from teams table
        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn(['target_dfr', 'target_profiling', 'target_master_call_list']);
        });
    }
};
