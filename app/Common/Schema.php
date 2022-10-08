<?php

namespace App\Common;

use Illuminate\Database\Schema\Builder;

class Schema extends Builder
{
    /**
     * Create a table from the schema if not exists.
     *
     * @param  string  $table
     * @return void
     */
    public static function createIfNotExists($table)
    {
        if (!self::hasTable($table)) {
            // TODO; create table if table does not exists
        }   
    }
}
