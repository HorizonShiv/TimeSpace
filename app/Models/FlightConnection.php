<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FlightConnection extends Model
{
    use SoftDeletes;
    public $table = 'flight_connection';
    protected $fillable = [
        'campaign_id',
        'flight_id',
        'language',
        'type',
        'location',
        'category_id',
        'ad_type',
        'tag',
    ];
    public function AssetParameters()
    {
        return $this->hasMany(AssetParameters::class, 'flight_connection_id', 'id');
    }

    public function AdvertisementType()
    {
        return $this->belongsTo(AdvertisementType::class, 'ad_type', 'id');
    }

    public function CategoryMaster()
    {
        return $this->belongsTo(CategoryMaster::class, 'category_id', 'id');
    }

    public function flight()
    {
        return $this->belongsTo(Flight::class, 'flight_id', 'id');
    }


    // public function AssestSetup()
    // {
    //     return $this->hasMany(AssestSetup::class, 'flight_connection_id', 'id');
    // }

    public function Assets()
    {
        return $this->hasMany(Assets::class, 'flight_connection_id', 'id');
    }


    use HasFactory;
}
