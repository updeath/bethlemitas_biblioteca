<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donations extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'clasifpgc',
        'title',
        'amount',
        "category",
        'author',
        'editorial',
        'status',
        'activite',
        'area',
        'image',
        'year'
    ];


}
