<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;

use App\Models\DataSourceLookup;

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

        try {
            $this->dataSource = DataSourceLookup::getKursBCAToday();
        } catch(\Exception $e) {
            Log::info($e->getMessage());
        }
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $dataSource = $this->dataSource;
            if (empty($dataSource)) {
                $this->error("\nData source not found!\n");
                die;
            }
            $bcaKursContentToday = file_get_contents($this->dataSource);
            $crawler = new Crawler($bcaKursContentToday);
            $bcaKursTableToday = $crawler->filterXPath('//*[@id="scrolling-table"]/table');
            $tbody = $bcaKursTableToday->filter('tbody');
            
            $tr = $tbody->filter('tr');
            
            $example = [];
            $paragraphData = $tr->filter('p');
            foreach ($paragraphData as $key => $value) {
                $example[] = $value->nodeValue;
            }

            // Expected result
            // [
            //     [
            //         'mata_uang' => 'USD',
            //         'e_rate_beli' => '15.180,00',
            //         'e_rate_jual' => '15.200,00',
            //         'tt_counter_beli' => '15.200,00',
            //         'tt_counter_jual' => '15.200,00',
            //         'bank_notes_beli' => '15.200,00',
            //         'bank_notes_jual' => '15.200,00',
            //     ],
            //     [
            //         'mata_uang' => 'SGD',
            //         'e_rate_beli' => '15.180,00',
            //         'e_rate_jual' => '15.200,00',
            //         'tt_counter_beli' => '15.200,00',
            //         'tt_counter_jual' => '15.200,00',
            //         'bank_notes_beli' => '15.200,00',
            //         'bank_notes_jual' => '15.200,00',
            //     ],
            // ]

            $result = [];
            for ($i = 0; $i < count($example); $i++) { 
                $result[$i] = [
                    'mata_uang' => $example[$i],
                    'e_rate_beli' => $example[$i++]
                ];
                // if ($i % 7 == 0) {
                //     $result[$i] = $example[$i];
                // }
            }

            print_r($result);
            die;

            $firstCol = $tr->filter('.first-col');
            $firstColSpan = $firstCol->filter('span');
            $firstColSpanParagraph = $firstColSpan->filter('p');
            
            $mataUang = [];
            foreach ($firstColSpanParagraph as $key => $value) {
                $mataUang[] = $value->nodeValue;
            }


            print_r($mataUang);
            die;
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
