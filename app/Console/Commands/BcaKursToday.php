<?php

namespace App\Console\Commands;

use Illuminate\Support\Arr;
use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;

class BcaKursToday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:bca-kurs-today';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'BCA Kurs';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->dataSource = 'https://www.bca.co.id/id/informasi/kurs';
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $bcaKursContentToday = file_get_contents($this->dataSource);
            $crawler = new Crawler($bcaKursContentToday);
            $bcaKursTableToday = $crawler->filterXPath('//*[@id="scrolling-table"]/table');
            print_r($bcaKursTableToday->nodeName());
            die;
            // $mataUangColumn = $bcaKursTableToday->filter('//*[@id="scrolling-table"]/table/thead');
            // Log::debug(print_r($bcaKursTableToday, true)); die;
            // $example = $bcaKursTableToday->filter('thead');
            foreach ($bcaKursTableToday as $key => $value) {
                $columnHeader = explode(' ', $value->textContent);
                print_r($value->textContent);
                die;
            }
            print_r($bcaKursTableToday);
            die;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
