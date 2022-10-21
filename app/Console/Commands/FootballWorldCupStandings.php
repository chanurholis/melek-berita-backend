<?php

/**
 * PHP version >= 7.0
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */

namespace App\Console\Commands;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Symfony\Component\DomCrawler\Crawler;

use App\Constants;
use App\Models\FootballGroup;
use App\Models\FootballStanding;

/**
 * Class FootballWorldCupStandings
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class FootballWorldCupStandings extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "generate:football-world-cup-standings";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Football World Cup Standings";

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function __construct()
    {
        parent::__construct();
        $this->dataSource = 'https://id.soccerway.com/international/world/world-cup/2022-qatar/group-stage/r49519/';
        $this->process = 'Generator Klasemen Piala Dunia';
        $this->groupIdStart = 13040;
        $this->groupIdEnd = 13048;
    }

    public function handle()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d H:i:s');
        echo "Date: $date\n";
        try {
            $crawler = new Crawler();
            $contents = curlGetContents($this->dataSource);
            $crawler->addHtmlContent($contents);
            $dirtyArray = [];
            while ($this->groupIdStart < $this->groupIdEnd) {
                $groupStandings = $crawler->filterXPath("//table[@data-group_id='$this->groupIdStart']/tbody/tr");
                $array = [];
                foreach ($groupStandings as $key => $value) {
                    // TODO: create array from string
                    $strRemovedLineBreak = preg_replace("/\r|\n/", '', $value->textContent);
                    $strTrim = trim($strRemovedLineBreak);
                    $arrResult = explode(' ', $strTrim);
                    // TODO: create dirty array
                    $arrStandings = [];
                    foreach ($arrResult as $keyResult => $valueResult) {
                        if (isEmpty($valueResult)) {
                            continue;
                        }
                        $arrStandings[] = $valueResult;
                    }
                    $array[] = $arrStandings;
                }
                foreach ($array as $key => $value) {
                    // 10 adalah jumlah absolute pada array klasemen
                    // Untuk validasi nama negara dengan 2 kata
                    if (count($value) > 10) {
                        $destruct = [
                            $value[0],
                            "$value[1] $value[2]",
                            $value[3],
                            $value[4],
                            $value[5],
                            $value[6],
                            $value[7],
                            $value[8],
                            $value[9],
                            $value[10],
                        ];
                        unset($array[$key]);
                        $array[] = $destruct;
                    }
                }
                $dirtyArray[] = $array;
                $this->groupIdStart++;
            }
            // TODO: mapping array groups
            $groups[] = [
                [
                    'group_name' => 'group_a',
                    'dirty_data' => $dirtyArray[0]
                ],
                [
                    'group_name' => 'group_b',
                    'dirty_data' => $dirtyArray[1]
                ],
                [
                    'group_name' => 'group_c',
                    'dirty_data' => $dirtyArray[2]
                ],
                [
                    'group_name' => 'group_d',
                    'dirty_data' => $dirtyArray[3]
                ],
                [
                    'group_name' => 'group_e',
                    'dirty_data' => $dirtyArray[4]
                ],
                [
                    'group_name' => 'group_f',
                    'dirty_data' => $dirtyArray[5]
                ],
                [
                    'group_name' => 'group_g',
                    'dirty_data' => $dirtyArray[6]
                ],
                [
                    'group_name' => 'group_h',
                    'dirty_data' => $dirtyArray[7]
                ],
            ];

            foreach ($groups[0] as $key => $value) {
                $groupName = Arr::get($value, 'group_name');
                $dirtyData = Arr::get($value, 'dirty_data', []);
                // TODO: check group name
                switch ($groupName) {
                    case 'group_a':
                        $footballGroupId = FootballGroup::getGroupId(Constants::WORLD_CUP_GROUP_A);
                        break;
                    case 'group_b':
                        $footballGroupId = FootballGroup::getGroupId(Constants::WORLD_CUP_GROUP_B);
                        break;
                    case 'group_c':
                        $footballGroupId = FootballGroup::getGroupId(Constants::WORLD_CUP_GROUP_C);
                        break;
                    case 'group_d':
                        $footballGroupId = FootballGroup::getGroupId(Constants::WORLD_CUP_GROUP_D);
                        break;
                    case 'group_e':
                        $footballGroupId = FootballGroup::getGroupId(Constants::WORLD_CUP_GROUP_E);
                        break;
                    case 'group_f':
                        $footballGroupId = FootballGroup::getGroupId(Constants::WORLD_CUP_GROUP_F);
                        break;
                    case 'group_g':
                        $footballGroupId = FootballGroup::getGroupId(Constants::WORLD_CUP_GROUP_G);
                        break;
                    case 'group_h':
                        $footballGroupId = FootballGroup::getGroupId(Constants::WORLD_CUP_GROUP_H);
                        break;
                    default:
                        return $this->error('Group name tidak ditemukan!');
                        break;
                }
                // TODO: create payloads
                $payloads = $this->createPayloads($dirtyData, $footballGroupId);
                // TODO: save world cup standings
                $this->saveWorldCupStandings($payloads);
            }
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * Create payloads.
     * 
     * @param  Array $groupStandings
     * @return Array
     */
    private function createPayloads($groupStandings, $footballGroupId)
    {
        if (isEmpty($groupStandings) || isEmpty($footballGroupId)) {
            return $this->error('Parameter createPayloads tidak sesuai!');
        }
        $finalArr = [];
        foreach ($groupStandings as $arr) {
            $finalArr[] = [
                'name' => $arr[1],
                'play' => $arr[2],
                'win' => $arr[3],
                'draw' => $arr[4],
                'lost' => $arr[5],
                'win_goals' => $arr[6],
                'lost_goals' => $arr[7],
                'goal_difference' => $arr[8],
                'penalty' => $arr[9],
                'order' => $arr[0],
                'is_world_cup' => true,
                'football_group_id' => $footballGroupId
            ];
        }
        return $finalArr;
    }

    /**
     * Save world cup standings.
     * 
     * @param  Array
     * @return String
     */
    private function saveWorldCupStandings($payloads)
    {
        DB::connection('pgsql')->transaction(function () use ($payloads) {
            try {
                foreach ($payloads as $key => $value) {
                    $name = Arr::get($value, 'name');
                    $save = FootballStanding::updateOrCreate(['name' => $name], $value);
                    if ($save) {
                        $this->info('Klasemen piala dunia berhasil disimpan!');
                    } else {
                        $this->error('Klasemen piala dunia gagal disimpan!');
                    }
                }
            } catch (\Exception $e) {
                return $this->error($e);
            }
        });
    }
}
