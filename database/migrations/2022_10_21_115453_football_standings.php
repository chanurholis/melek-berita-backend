<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FootballStandings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql')->create('football_standings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->integer('play')->nullable(false)->default('0');
            $table->integer('win')->nullable(false)->default('0');
            $table->integer('draw')->nullable(false)->default('0');
            $table->integer('lost')->nullable(false)->default('0');
            $table->integer('win_goals')->nullable(false)->default('0');
            $table->integer('lost_goals')->nullable(false)->default('0');
            $table->string('goal_difference')->nullable(false)->default('+0');
            $table->integer('penalty')->nullable(false)->default('0');
            $table->integer('order');
            $table->boolean('is_world_cup');
            $table->unsignedInteger('football_group_id')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('pgsql')->dropIfExists('football_standings');
    }
}
