<?php

namespace Database\Seeders;

use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\FootballGroup;

class FootballWorldCupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $footballGroups = [
            [
                'key' => 'world_cup_group_a',
                'name' => 'Group A',
            ],
            [
                'key' => 'world_cup_group_b',
                'name' => 'Group B',
            ],
            [
                'key' => 'world_cup_group_c',
                'name' => 'Group C',
            ],
            [
                'key' => 'world_cup_group_d',
                'name' => 'Group D',
            ],
            [
                'key' => 'world_cup_group_e',
                'name' => 'Group E',
            ],
            [
                'key' => 'world_cup_group_f',
                'name' => 'Group F',
            ],
            [
                'key' => 'world_cup_group_g',
                'name' => 'Group G',
            ],
            [
                'key' => 'world_cup_group_h',
                'name' => 'Group H',
            ],
        ];
        DB::connection('pgsql')->transaction(function () use ($footballGroups) {
            try {
                foreach ($footballGroups as $key => $value) {
                    $key = Arr::get($value, 'key');
                    FootballGroup::updateOrCreate(['key' => $key], $value);
                }
            } catch (\Exception $e) {
                return $e;
            }
        });
    }
}
