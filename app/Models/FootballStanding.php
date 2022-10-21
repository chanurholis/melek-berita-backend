<?php

namespace App\Models;

use App\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FootballStanding extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';

    protected $table = 'football_standings';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'play',
        'win',
        'lost',
        'win_goals',
        'lost_goals',
        'goal_difference',
        'penalty',
        'order',
        'is_world_cup',
        'football_group_id',
    ];

    public function footballGroups()
    {
        return $this->hasOne(FootballGroup::class, 'id', 'football_group_id');
    }

    /**
     * Get world cup standings.
     * 
     * @param  String $footballGroupKey
     * @return Object
     */
    public static function getWorldCupStandings(String $footballGroupKey)
    {
        $footballGroupId = FootballGroup::getGroupId($footballGroupKey);
        return self::with('footballGroups')
            ->where('is_world_cup', '=', true)
            ->where('football_group_id', '=', $footballGroupId)
            ->orderBy('order', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->get();
    }
}
