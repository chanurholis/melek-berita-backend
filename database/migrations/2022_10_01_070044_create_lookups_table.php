<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLookupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('lookups')) {
            Schema::create('lookups', function (Blueprint $table) {
                $table->id();
                $table->string('key')->unique()->nullable(false);
                $table->string('name')->nullable(false);
                $table->string('description')->nullable();
                $table->string('value')->nullable(false);
                $table->timestamps();
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lookups');
    }
}
