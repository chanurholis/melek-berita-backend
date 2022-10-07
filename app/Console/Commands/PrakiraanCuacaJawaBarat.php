<?php

namespace App\Console\Commands;

use App\Models\DataSourceLookup;
use Illuminate\Console\Command;

use App\Constants;
use Symfony\Component\DomCrawler\Crawler;

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
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $dataSource = DataSourceLookup::getEndpoint(Constants::PRAKIRAAN_CUACA_BMKG_JAWA_BARAT);
            $prakiraanCuacaJawaBarat = file_get_contents($dataSource);
            $crawler = new Crawler($prakiraanCuacaJawaBarat);
            print_r($crawler);
            die;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
