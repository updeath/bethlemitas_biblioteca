<?php

namespace App\Imports;

use App\Models\Invenotry;
use Maatwebsite\Excel\Concerns\ToModel;

class InvenotryImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        $statusMappingCategory = [
            'Libro' => 'libro',
            'Torno' => 'torno',
            'Cartilla' => 'cartilla',
            'Afiche' => 'afiche',
            'Folleto' => 'folleto',
            'Texto' => 'texto',
        ];

        $statusMappingStatus = [
            'Bueno' => 'well',
            'Regular' => 'regular',
            'Malo' => 'bad',
        ];

        $statusMappingActivitie = [
            'Material de referencia' => 'reference_material',
            'Investigación' => 'investigation',
            'Aprendizaje' => 'teaching',
            'Consultas' => 'consultation',
            'Lenguajes' => 'languagues',
            'Lectura' => 'reading',
        ];

        return (new Invenotry([
            'code' => $row[0] ?? 0,
            'title' => $row[1] ?? 'N/A',
            'author' => $row[2] ?? 'N/A',
            'editorial' => $row[3] ?? 'N/A',
            'amount' => $row[4] ?? 0,
            'category' =>  $statusMappingCategory[trim($row[5])] ?? 'N/A',
            'area' => $row[6] ?? 'N/A',
            'status' => $statusMappingStatus[trim($row[7])] ?? 'N/A',
            'clasifpgc' => $row[8] ?? 0,
            'activite' => $statusMappingActivitie[trim($row[9])] ?? 'N/A',
            'year' => $row[10] ?? 0,
        ]));
    }
}
