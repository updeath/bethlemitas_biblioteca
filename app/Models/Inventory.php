<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_clsifPGC',
        'title',
        'id_author',
        'amount',
        'id_editorial',
        'publication_date',
        'id_status',
        'id_location',
        'id_activity',
        'donated',
        'descarted',
    ];

    // Relación con la tabla classification
    public function classification()
    {
        return $this->belongsTo(Classification::class, 'id_clasifPGC');
    }

    // Relación con la tabla authors
    public function author()
    {
        return $this->belongsTo(Author::class, 'id_author');
    }

    // Relación con la tabla editorial
    public function editorial()
    {
        return $this->belongsTo(editorial::class, 'id_editorial');
    }

    // Relación con la tabla estado
    public function estado()
    {
        return $this->belongsTo(Book_statu::class, 'id_status');
    }

    // Relación con la tabla ubicacion
    public function ubicacion()
    {
        return $this->belongsTo(Book_location::class, 'id_location');
    }

    // Relación con la tabla actividad
    public function actividad()
    {
        return $this->belongsTo(Activity::class, 'id_activity');
    }

    // Otras relaciones...
}