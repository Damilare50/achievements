<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAchievement extends Model
{
    protected $table = 'users_achievements';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'achievement_id',
        'unlocked_at'
    ];
}
