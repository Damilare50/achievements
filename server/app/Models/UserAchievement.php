<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class UserAchievement extends Model
{

    use HasUuids;

    protected $table = 'users_achievements';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'achievement_id',
        'unlocked_at'
    ];
}
