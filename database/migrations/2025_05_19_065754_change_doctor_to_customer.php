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
        // Create new tables
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('prefix_title')->nullable();       // gelar_depan
            $table->string('full_name');
            $table->string('suffix_title')->nullable();       // gelar_belakang
            $table->string('specialist_id')->nullable();
            $table->string('title_id')->nullable();           // jabatan
            $table->boolean('is_kpdm')->default(false);       // 0 = doctor, 1 = KPDM
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('customer_specialists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('customer_titles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('outlets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('customer_affiliations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->foreignId('outlet_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        // Drop old tables if they exist
        Schema::dropIfExists('doctors');
        Schema::dropIfExists('specialists');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop new tables
        Schema::dropIfExists('customer_affiliations');
        Schema::dropIfExists('outlets');
        Schema::dropIfExists('customer_title');
        Schema::dropIfExists('customer_specialist');
        Schema::dropIfExists('branches');
        Schema::dropIfExists('customers');

        // Recreate old tables
        Schema::create('doctors', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->primary();
            $table->string('code')->unique();
            $table->string('name');
            $table->enum('gender', ['male', 'female']);
            $table->boolean('is_active')->default(true);
            $table->integer('specialist_id')->constrained('specialists')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('specialists', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->primary();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
