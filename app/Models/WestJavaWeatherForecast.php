<?php 

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class WestJavaWeatherForecast extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'west_java_weather_forecast';
    protected $guarded = [];

    public static function store($payload)
    {
        return $payload;

        return self::create($payload);
    }
}

?>