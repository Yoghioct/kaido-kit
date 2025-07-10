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
        Schema::create('product_group_clusters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('product_group_cluster_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_group_cluster_id')->constrained('product_group_clusters')->onDelete('cascade');
            $table->foreignId('product_group_id')->constrained('product_groups')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });

        // Update team_affiliations to reference clusters instead of individual product groups
        Schema::table('team_affiliations', function (Blueprint $table) {
            $table->dropForeign(['product_group_id']);
            $table->dropColumn('product_group_id');
            $table->foreignId('product_group_cluster_id')->nullable()->constrained('product_group_clusters')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('team_affiliations', function (Blueprint $table) {
            $table->dropForeign(['product_group_cluster_id']);
            $table->dropColumn('product_group_cluster_id');
            $table->foreignId('product_group_id')->nullable()->constrained('product_groups')->onDelete('set null');
        });

        Schema::dropIfExists('product_group_cluster_items');
        Schema::dropIfExists('product_group_clusters');
    }
};
