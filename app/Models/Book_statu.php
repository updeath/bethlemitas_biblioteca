<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book_statu extends Model
{
    use HasFactory;
    protected $fillable = [
        'state',
    ];
}
