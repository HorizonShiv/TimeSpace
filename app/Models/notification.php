<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class notification extends Model
{
    use SoftDeletes;
    public $table = 'notification';
    protected $fillable = [
        'campaign_id',
        'advertisement_id',
        'flight_connection_id',
        'flight_id',
        'assets_id',
        'user_id',
        'team_id',
        'status_from',
        'status_to',
        'remarks',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id', 'id');
    }

    public function flight()
    {
        return $this->belongsTo(Flight::class, 'flight_id', 'id');
    }

    public function AssetParameters()
    {
        return $this->belongsTo(AssetParameters::class, 'assets_id', 'id');
    }

    public function teamId()
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function flight_connection()
    {
        return $this->belongsTo(FlightConnection::class, 'flight_connection_id', 'id');
    }

    public function AdvertisementType()
    {
        return $this->belongsTo(AdvertisementType::class, 'advertisement_id', 'id');
    }


    use HasFactory;
}
