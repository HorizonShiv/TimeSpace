<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Thumbnails extends Model
{
    use SoftDeletes;
    public $table = 'Thumbnails';
    protected $fillable = [
        'campaign_id',
        'type',
        'thumbnail',
        'language',
    ];
    use HasFactory;
}
