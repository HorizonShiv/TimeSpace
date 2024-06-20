<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryMaster extends Model
{
    use SoftDeletes;
    public $table = 'category_master';
    protected $fillable = [
        'name',
    ];

    public function AdvertisementType()
    {
        return $this->belongsTo(AdvertisementType::class, 'id', 'category_master_id');
    }

    // public function PublisherMaster()
    // {
    //     return $this->hasMany(PublisherMaster::class, 'category_id', 'id');
    // }

    use HasFactory;
}
