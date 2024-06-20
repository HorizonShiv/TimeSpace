<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdvertisementType extends Model
{
    use SoftDeletes;
    public $table = 'advertisement_type';
    protected $fillable = [
        'category_master_id',
        'publisher_master_id',
        'name',
    ];

    public function PublisherMaster()
    {
        return $this->belongsTo(PublisherMaster::class,'publisher_master_id','id');
    }

    public function CategoryMaster()
    {
        return $this->belongsTo(CategoryMaster::class,'category_master_id','id');
    }

    // public function FlightConnection()
    // {
    //     return $this->hasMany(FlightConnection::class, 'category', 'category_master_id');
    // }



    use HasFactory;
}
