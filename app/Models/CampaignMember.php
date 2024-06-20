<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignMember extends Model
{
    use SoftDeletes;
    public $table = 'campaign_member';
    protected $fillable = [
        'campaign_id',
        'user_id',
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    use HasFactory;
}
