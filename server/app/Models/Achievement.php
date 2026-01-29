<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasUuids, HasFactory;

    protected $table = 'achievements';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;


    protected $fillable = [
        'name',
        'description',
        'badge_icon_url',
        'threshold'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_achievements', 'achievement_id', 'user_id')
            ->withPivot('unlocked_at')
            ->withTimestamps();
    }
}
