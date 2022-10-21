<?php

namespace App\Models;

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
}
