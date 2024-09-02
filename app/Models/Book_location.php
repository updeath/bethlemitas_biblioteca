<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book_location extends Model
{
    use HasFactory;

    protected $fillable = [
        'location',
    ];
}
