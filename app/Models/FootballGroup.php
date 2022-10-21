<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FootballGroup extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';

    protected $table = 'football_groups';

    protected $primaryKey = 'id';

    protected $guarded = ['*'];

    /**
     * Get group name.
     * 
     * @param  String       $key
     * @param  String|Array $fieldName
     * @return String
     */
    public static function getGroupName(String $key, $fieldName)
    {
        if (isEmpty($key)) {
            return customResponse(true, 400, 'Key tidak boleh kosong!');
        }
        return self::where('key', '=', $key)
            ->select($fieldName)
            ->first();
    }

    /**
     * Get group name.
     * 
     * @param  String       $key
     * @param  String|Array $fieldName
     * @return String
     */
    public static function getGroupId(String $key)
    {
        if (isEmpty($key)) {
            return customResponse(true, 400, 'Key tidak boleh kosong!');
        }
        $footballGroup = self::where('key', '=', $key)
            ->select('id')
            ->first();
        $footballGroupId = Arr::get($footballGroup, 'id');
        if (isEmpty($key)) {
            return customResponse(true, 404, 'Football group ID tidak ditemukan!');
        }
        return $footballGroupId;
    }
}
