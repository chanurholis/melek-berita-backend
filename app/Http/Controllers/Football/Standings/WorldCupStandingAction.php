<?php

namespace App\Http\Controllers\Football\Standings;

use App\Http\Controllers\Controller;

use App\Constants;
use App\Models\FootballStanding;

class WorldCupStandingAction extends Controller
{
    public function __invoke()
    {
        $footballStandings = $this->getDataFootballStandings();
        return $footballStandings;
    }

    private function getDataFootballStandings()
    {
        $groupAStandings = FootballStanding::getWorldCupStandings(Constants::WORLD_CUP_GROUP_A) ?? [];
        $groupBStandings = FootballStanding::getWorldCupStandings(Constants::WORLD_CUP_GROUP_B) ?? [];
        $groupCStandings = FootballStanding::getWorldCupStandings(Constants::WORLD_CUP_GROUP_C) ?? [];
        $groupDStandings = FootballStanding::getWorldCupStandings(Constants::WORLD_CUP_GROUP_D) ?? [];
        $groupEStandings = FootballStanding::getWorldCupStandings(Constants::WORLD_CUP_GROUP_E) ?? [];
        $groupFStandings = FootballStanding::getWorldCupStandings(Constants::WORLD_CUP_GROUP_F) ?? [];
        $groupGStandings = FootballStanding::getWorldCupStandings(Constants::WORLD_CUP_GROUP_G) ?? [];
        $groupHStandings = FootballStanding::getWorldCupStandings(Constants::WORLD_CUP_GROUP_H) ?? [];
        return [
            'group_a' => $groupAStandings,
            'group_b' => $groupBStandings,
            'group_c' => $groupCStandings,
            'group_d' => $groupDStandings,
            'group_e' => $groupEStandings,
            'group_f' => $groupFStandings,
            'group_g' => $groupGStandings,
            'group_h' => $groupHStandings
        ];
    }
}
