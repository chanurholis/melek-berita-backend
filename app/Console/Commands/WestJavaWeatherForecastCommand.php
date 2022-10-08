<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Constants;
use App\Helpers\XmlToJsonHelper;
use App\Models\DataSourceLookup;
use App\Models\WestJavaWeatherForecast;

class WestJavaWeatherForecastCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:west-java-weather-forecast';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'West Java Weather Forecast';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->dataSource = DataSourceLookup::getEndpoint(Constants::WEST_JAVA_WEATHER_FORECAST);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $content = file_get_contents($this->dataSource);
            $result = XmlToJsonHelper::run($content);
            $save = WestJavaWeatherForecast::store($result);
            if ($save) {
                return $this->info("West Java weather forecast saved successfully!");
            } else {
                return $this->warn("West Java weather forecast failed to save!");
            }
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
    }
}
