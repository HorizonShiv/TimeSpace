<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublisherMaster extends Model
{
    use SoftDeletes;
    public $table = 'publisher_master';
    protected $fillable = [
        'category_id',
        'name',
    ];

    public function AdvertisementType()
    {
        return $this->hasMany(AdvertisementType::class, 'publisher_master_id', 'id');
    }

    public function CategoryMaster()
    {
        return $this->belongsTo(CategoryMaster::class, 'category_id', 'id');
    }

    use HasFactory;
}
