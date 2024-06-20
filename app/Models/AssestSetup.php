<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class AssestSetup extends Model
{
    use SoftDeletes;
    public $table = 'asset_setup';
    protected $fillable = [
        'campaign_id',
        'flight_id',
        'flight_connection_id',
        'category_id',
        'ad_type',
        'publisher_id',
        'advertisement_id',
        'ad_format',
        'ad_size',
        'ad_bleed',
        'ad_colour',
        'ad_kbs',
        'ad_duration',
        'ad_filetype',
        'ad_version',
        'ad_publisher_specs',
    ];

    public function AssetParameters()
    {
        return $this->hasMany(AssetParameters::class, 'assets_id', 'id');
    }

    public function AdvertisementType()
    {
        return $this->belongsTo(AdvertisementType::class, 'advertisement_id', 'id');
    }

    public function PublisherMaster()
    {
        return $this->belongsTo(PublisherMaster::class, 'publisher_id', 'id');
    }
    public function FlightConnection()
    {
        return $this->belongsTo(FlightConnection::class);
    }

    use HasFactory;
}
