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
        Schema::create('doctors', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->primary();
            $table->string('code')->unique();
            $table->string('name');
            $table->enum('gender', ['male', 'female']);
            $table->boolean('is_active')->default(true);
            $table->integer('specialist_id')->constrained('specialists')->cascadeOnDelete();
            // $table->foreignId('specialist_id')->constrained('specialists')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
