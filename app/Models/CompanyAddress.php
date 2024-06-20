<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyAddress extends Model
{
    public $table = 'company_address';
    protected $fillable = [
        'company_id',
        'address1',
        'address2',
        'country',
        'state',
        'postal_code',
    ];


    use HasFactory;
}
