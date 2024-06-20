<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use SoftDeletes;
    public $table = 'campaign';
    protected $fillable = [
        'client_id',
        'campaign_name',
        'project_code',
        'image',
        'export_name',
        'budget',
    ];
    //
    public function CampaignLanguages()
    {
        return $this->hasMany(CampaignLanguages::class, 'campaign_id', 'id');
    }

    public function CampaignMember()
    {
        return $this->hasMany(CampaignMember::class, 'campaign_id', 'id');
    }
    public function User()
    {
        return $this->belongsTo(User::class, 'client_id', 'id');
    }

    public function Flight()
    {
        return $this->hasMany(Flight::class, 'campaign_id', 'id');
    }
    public function FlightConnection()
    {
        return $this->hasMany(FlightConnection::class, 'flight_id', 'id');
    }

    public function Assets()
    {
        return $this->hasMany(Assets::class, 'campaign_id', 'id');
    }


    use HasFactory;
}
