<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public $withinTransaction = true;

    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number', 20)->nullable()->after('email');
        });

        Schema::create('positions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100)->unique();
            $table->unsignedBigInteger('parent_id')->nullable();

            $table->unsignedBigInteger('team_id');
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('region_id');

            $table->text('description')->nullable();
            $table->timestamps();

            // FK ke self (hirarki posisi)
            $table->foreign('parent_id')
                  ->references('id')
                  ->on('positions')
                  ->onUpdate('cascade')
                  ->onDelete('set null');

            $table->foreign('team_id')
                  ->references('id')
                  ->on('teams')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('branch_id')
                  ->references('id')
                  ->on('branches')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('region_id')
                  ->references('id')
                  ->on('regions')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });

        Schema::create('user_position_affiliations', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Relasi ke users
            $table->unsignedBigInteger('user_id');

            // Relasi ke positions
            $table->unsignedBigInteger('position_id');

            // // Relasi ke manager assignment (self reference)
            // $table->unsignedBigInteger('manager_assignment_id')->nullable();

            $table->date('start_date');
            $table->date('end_date')->nullable();

            $table->timestamps();

            // FK ke users.id
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            // FK ke positions.id
            $table->foreign('position_id')
                  ->references('id')
                  ->on('positions')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            // FK ke user_position_assignments.id (self)
            // $table->foreign('manager_assignment_id')
            //       ->references('id')
            //       ->on('user_position_assignments')
            //       ->onUpdate('cascade')
            //       ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom phone_number
            $table->dropColumn('phone_number');
        });

        Schema::dropIfExists('positions');
        Schema::dropIfExists('user_position_affiliations');

    }
};
