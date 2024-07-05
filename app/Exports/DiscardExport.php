<?php

namespace App\Exports;

use App\Models\DiscardedBook;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DiscardExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $inventario = DiscardedBook::all();

        $data = $inventario->map(function ($discard) {

            $statusMessage = '';

            switch ($discard->status) {
                case 'well':
                    $statusMessage = 'Bueno';
                    break;

                case 'bad':
                    $statusMessage = 'Malo';
                    break;

                default:
                    $statusMessage = $discard->status;
            }

            $activiteMessage = ''; 

            switch ($discard->activite) { 
                case 'reference_material':
                    $activiteMessage = 'Material de referencia'; 
                    break;

                case 'investigation':
                    $activiteMessage = 'Investigación'; 
                    break;

                case 'teaching':
                    $activiteMessage = 'Aprendizaje'; 
                    break;

                case 'consultation':
                    $activiteMessage = 'Consultas'; 
                    break;

                case 'languages':
                    $activiteMessage = 'Lenguajes'; 
                    break;

                case 'reading':
                    $activiteMessage = 'Lectura'; 
                    break;

                default:
                    $activiteMessage = $discard->activite;
            }

            return [
                'Codigo' => $discard->code,
                'Titulo' => $discard->title,
                'Autor' => $discard->author,
                'Editorial' => $discard->editorial,
                'Cantidad' => $discard->amount,
                'Categoria' => $discard->category,
                'Area' => $discard->area,
                'Estado del libro' => $statusMessage,
                'Clasificacion' => $discard->clasifpgc,
                'Actividad' => $activiteMessage, 
                'Año de Publicación' => $discard->year,
            ];
        });

        return $data;
    }


    public function headings(): array
    {
        return [
            'Codigo',
            'Titulo',
            'Autor',
            'Editorial',
            'Cantidad',
            'Categoria',
            'Area',
            'Estado del libro',
            'Clasificacion',
            'Actividad',
            'Año de Publicación'
        ];
    }
}






