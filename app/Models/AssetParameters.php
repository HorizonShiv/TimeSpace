<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AssetParameters extends Model
{
    use SoftDeletes;
    public $table = 'assets_parameters';
    protected $fillable = [
        'campaign_id',
        'flight_connection_id',
        'assets_id',
        'flight_id',
        'ad_title',
        'conversion_location',
        'cta',
        'clickthrougn_url',
        'utm',
        'primary_text',
        'link_primary_text',
        'headline',
        'link_headline',
        'description',
        'link_description',
        'visuals',
        'status',
        'remark',
    ];

    public function AsstesChangeLog()
    {
        return $this->hasMany(AsstesChangeLog::class, 'assets_id', 'id');
    }

    public function FlightConnection()
    {
        return $this->belongsTo(FlightConnection::class, 'flight_connection_id', 'id');
    }

    public function Flight()
    {
        return $this->belongsTo(Flight::class, 'flight_id', 'id');
    }

    public function Assets()
    {
        return $this->belongsTo(Assets::class, 'assets_id', 'id');
    }

    public function Campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id', 'id');
    }

   
    use HasFactory;
}
