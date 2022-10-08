<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLookupId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasColumn('data_source_lookups', 'lookup_id')) {
            Schema::table('data_source_lookups', function (Blueprint $table) {
                $table->integer('lookup_id')->nullable(false);
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
        if (Schema::hasColumn('data_source_lookups', 'lookup_id')) {
            Schema::dropColumns('data_source_lookups', 'lookup_id');
        }
    }
}
