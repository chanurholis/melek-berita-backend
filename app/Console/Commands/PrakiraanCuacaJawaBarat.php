<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Constants;
use Illuminate\Support\Arr;
use Symfony\Component\DomCrawler\Crawler;

use App\Models\DataSourceLookup;

class PrakiraanCuacaJawaBarat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:prakiraan-cuaca-jawa-barat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prakiraan Cuaca Jawa Barat';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->dataSource = DataSourceLookup::getEndpoint(Constants::PRAKIRAAN_CUACA_BMKG_JAWA_BARAT);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $prakiraanCuacaJawaBarat = file_get_contents($this->dataSource);
            $crawler = new Crawler($prakiraanCuacaJawaBarat);
            $dataXml = $crawler->filter('data');
            $forecastXml = $dataXml->filter('forecast');
            $issueXml = $forecastXml->filter('issue') ?? [];
            $timestampXml = $issueXml->filter('timestamp') ?? [];
            $yearXml = $issueXml->filter('year') ?? [];
            $monthXml = $issueXml->filter('month') ?? [];
            $dayXml = $issueXml->filter('day') ?? [];
            $hourXml = $issueXml->filter('hour') ?? [];
            $minuteXml = $issueXml->filter('minute') ?? [];
            $secondXml = $issueXml->filter('second') ?? [];

            // TODO: collect attributes
            $xmlAttributes = [
                'timestamp' => $timestampXml,
                'year' => $yearXml,
                'month' => $monthXml,
                'day' => $dayXml,
                'hour' => $hourXml,
                'minute' => $minuteXml,
                'second' => $secondXml,
            ];

            // TODO: create private method to get attributes
            $result = $this->getAttributes($xmlAttributes);
            
            print_r($result);
            die;
        } catch (\Throwable $th) {
            $this->error($th->getMessage());
        }
    }

    private function getAttributes($xmlAttributes)
    {
        $result = [];
        $timestamp = Arr::get($xmlAttributes, 'timestamp');
        $year = Arr::get($xmlAttributes, 'year');
        $month = Arr::get($xmlAttributes, 'month');
        $day = Arr::get($xmlAttributes, 'day');
        $hour = Arr::get($xmlAttributes, 'hour');
        $minute = Arr::get($xmlAttributes, 'minute');
        $second = Arr::get($xmlAttributes, 'second');

        if (count($timestamp) != 0) {
            foreach ($timestamp as $key => $value) {
                $result[$key]['timestamp'] = $value->nodeValue;
            }
        }

        if (count($year) != 0) {
            foreach ($year as $key => $value) {
                $result[$key]['year'] = $value->nodeValue;
            }
        }

        if (count($month) != 0) {
            foreach ($month as $key => $value) {
                $result[$key]['month'] = $value->nodeValue;
            }
        }

        if (count($day) != 0) {
            foreach ($day as $key => $value) {
                $result[$key]['day'] = $value->nodeValue;
            }
        }

        if (count($hour) != 0) {
            foreach ($hour as $key => $value) {
                $result[$key]['hour'] = $value->nodeValue;
            }
        }

        if (count($minute) != 0) {
            foreach ($minute as $key => $value) {
                $result[$key]['minute'] = $value->nodeValue;
            }
        }

        if (count($second) != 0) {
            foreach ($second as $key => $value) {
                $result[$key]['second'] = $value->nodeValue;
            }
        }

        print_r($result);
        die;

        return $result;
    }
}
