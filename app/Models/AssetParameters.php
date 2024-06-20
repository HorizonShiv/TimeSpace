<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class AssetParameters extends Model
{
    use SoftDeletes;
    public $table = 'assets_parameters';
    protected $fillable = [
        'flight_connection_id',
        'assets_id',
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
    use HasFactory;
}
