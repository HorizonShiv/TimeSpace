<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{

    public $table = 'company';
    protected $fillable = [
        'name',
        'number',
        'email',
        'url',
    ];


    use HasFactory;
}
