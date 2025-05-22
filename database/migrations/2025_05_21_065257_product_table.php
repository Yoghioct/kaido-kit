<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try {
            DB::beginTransaction();

            Schema::create('teams', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->softDeletes();
                $table->timestamps();
            });

            Schema::create('product_groups', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->integer('target_dfr')->nullable();
                $table->integer('target_profiling')->nullable();
                $table->integer('target_master_call_list')->nullable();
                $table->softDeletes();
                $table->timestamps();
            });

            Schema::create('team_affiliations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('team_id')->nullable()->constrained('teams')->onDelete('set null');
                $table->foreignId('product_group_id')->nullable()->constrained('product_groups')->onDelete('set null');
                $table->softDeletes();
                $table->timestamps();
            });

            Schema::create('product_sub_groups', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->foreignId('product_group_id')->nullable()->constrained('product_groups')->onDelete('set null');
                $table->softDeletes();
                $table->timestamps();
            });

            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->string('code')->unique();
                $table->string('name');
                $table->string('alias')->nullable();
                $table->foreignId('product_group_id')->nullable()->constrained('product_groups')->onDelete('set null');
                $table->foreignId('product_sub_group_id')->nullable()->constrained('product_sub_groups')->onDelete('set null');
                $table->softDeletes();
                $table->timestamps();
            });

            Schema::create('product_pricelists', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null');
                $table->decimal('price', 18, 2);
                $table->timestamp('effective_at')->nullable();
                $table->softDeletes();
                $table->timestamps();
            });

            Schema::create('product_indications', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->foreignId('product_group_id')->constrained('product_groups')->onDelete('cascade');
                $table->softDeletes();
                $table->timestamps();
            });

            Schema::create('product_competitors', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->foreignId('product_group_id')->constrained('product_groups')->onDelete('cascade');
                $table->softDeletes();
                $table->timestamps();
            });

            Schema::create('product_key_messages', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->foreignId('product_group_id')->constrained('product_groups')->onDelete('cascade');
                $table->softDeletes();
                $table->timestamps();
            });

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            DB::beginTransaction();

            // Drop tables in reverse order of dependencies
            Schema::dropIfExists('product_key_messages');
            Schema::dropIfExists('product_competitors');
            Schema::dropIfExists('product_indications');
            Schema::dropIfExists('product_pricelists');
            Schema::dropIfExists('products');
            Schema::dropIfExists('product_sub_groups');
            Schema::dropIfExists('team_affiliations');
            Schema::dropIfExists('product_groups');
            Schema::dropIfExists('teams');

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
};
