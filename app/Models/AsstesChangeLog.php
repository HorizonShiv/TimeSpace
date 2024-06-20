<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class AsstesChangeLog extends Model
{
    use SoftDeletes;
    public $table = 'assets_change_log';
    protected $fillable = [
        'assets_id',
        'user_id',
        'date',
        'type',
        'time',
    ];

    public function AssetParameters()
    {
        return $this->belongsTo(AssetParameters::class, 'assets_id', 'id');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    use HasFactory;
}
