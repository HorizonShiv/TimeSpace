<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use SoftDeletes;
    public $table = 'team_member';
    protected $fillable = [
        'user_id',
        'team_id',
        'type',
    ];
    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // public function User()
    // {
    //     return $this->hasMany(User::class, 'id', 'user_id');
    // }

    public function Team()
    {
        return $this->belongsTo(Team::class);
    }
    use HasFactory;
}
