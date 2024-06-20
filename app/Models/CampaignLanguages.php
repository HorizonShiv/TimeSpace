<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignLanguages extends Model
{
    use SoftDeletes;
    public $table = 'campaign_languages';
    protected $fillable = [
        'campaign_id',
        'language',
    ];

    use HasFactory;
}
