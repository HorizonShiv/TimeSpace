<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Flight extends Model
{
    use SoftDeletes;
    public $table = 'flight';
    protected $fillable = [
        'campaign_id',
        'flight_count',
        'in_market_start_date',
        'in_market_end_date',
    ];

    public function FlightConnection()
    {
        return $this->hasMany(FlightConnection::class, 'flight_id', 'id');
    }

    public function Assets()
    {
        return $this->belongsTo(Assets::class, 'flight_id', 'id');
    }

    use HasFactory;
}
