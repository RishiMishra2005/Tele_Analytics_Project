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
        Schema::create('user_data_mapping', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Assuming 'users' table has an 'id' column
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('data_plan_id'); // Assuming 'users' table has an 'id' column
            $table->foreign('data_plan_id')->references('id')->on('data_plan');
            $table->date('subs_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_data_mapping', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->dropForeign(['data_plan_id']);
            $table->dropColumn('data_plan_id');
        });
    }
};
