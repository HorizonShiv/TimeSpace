<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use SoftDeletes;
    public $table = 'team';
    protected $fillable = [
        'team_type',
        'name',
    ];

    public function TeamMember()
    {
        return $this->hasMany(TeamMember::class);
    }
    use HasFactory;
}
