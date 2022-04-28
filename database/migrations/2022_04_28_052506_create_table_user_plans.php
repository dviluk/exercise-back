<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableUserPlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_plans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->uuid('plan_id');
            $table->integer('progress');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('plan_id')
                ->references('id')->on('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_plans');
    }
}
