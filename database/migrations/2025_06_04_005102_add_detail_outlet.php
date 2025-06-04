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
        if (!Schema::hasTable('outlets')) {
            Schema::table('outlets', function (Blueprint $table) {
                $table->string('state')->nullable();
                $table->string('city')->nullable();
                $table->string('district')->nullable();
                $table->string('subdistrict')->nullable();
                $table->string('zip')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('outlets', function (Blueprint $table) {
            $table->dropColumn('state');
            $table->dropColumn('city');
            $table->dropColumn('district');
            $table->dropColumn('subdistrict');
            $table->dropColumn('zip');
        });
    }
};
