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

        // Drop old tables if they exist
        Schema::dropIfExists('doctors');
        Schema::dropIfExists('specialists');

        Schema::create('customer_specialists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('doctor_titles');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('customer_titles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('prefix_title')->nullable();
            $table->string('full_name');
            $table->string('suffix_title')->nullable();
            $table->foreignId('customer_specialist_id')
                ->nullable() // ← tambahkan ini
                ->constrained('customer_specialists')
                ->onDelete('set null');

            $table->foreignId('customer_title_id')
                ->nullable() // ← tambahkan ini juga
                ->constrained('customer_titles')
                ->onDelete('set null');

            $table->boolean('is_kpdm')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });


        if (!Schema::hasTable('regions')) {
            Schema::create('regions', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->timestamps();
                $table->softDeletes();
            });
        }

        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->foreignId('region_id')
                ->nullable() // ← tambahkan ini
                ->constrained('regions')
                ->onDelete('set null');

            $table->timestamps();
            $table->softDeletes();
        });

        if (!Schema::hasTable('outlet_groups')) {
            Schema::create('outlet_groups', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->timestamps();
                $table->softDeletes();
            });
        }

        Schema::create('outlets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            // $table->foreignId('outlet_group_id')->constrained('outlet_groups')->onDelete('set null')->nullable();

            $table->foreignId('outlet_group_id')
                ->nullable() // ← tambahkan ini
                ->constrained('outlet_groups')
                ->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });

        if (!Schema::hasTable('outlet_affiliations')) {
            Schema::create('outlet_affiliations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('outlet_id')->nullable()->constrained('outlets')->onDelete('set null')->nullable();
                $table->foreignId('branch_id')->nullable()->constrained('branches')->onDelete('set null')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        Schema::create('customer_affiliations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('set null')->nullable();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->onDelete('set null')->nullable();
            $table->foreignId('outlet_id')->nullable()->constrained('outlets')->onDelete('set null')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

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
