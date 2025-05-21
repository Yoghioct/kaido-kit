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
        Schema::table('customer_specialists', function (Blueprint $table) {
            $table->renameColumn('doctor_titles', 'specialist_title');
        });
    }

    public function down(): void
    {
        Schema::table('customer_specialists', function (Blueprint $table) {
            $table->renameColumn('specialist_title', 'doctor_titles');
        });
    }
};
