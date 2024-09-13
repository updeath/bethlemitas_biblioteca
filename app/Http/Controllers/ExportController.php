<?php

namespace App\Http\Controllers;

use App\Exports\DiscardsExport;
use App\Exports\DonatedExport;
use Illuminate\Http\Request;
use App\Exports\InventoryExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportInventory() {
        return Excel::download(new InventoryExport, 'Inventario.xlsx');
    }

    public function exportDonated() {
        return Excel::download(new DonatedExport, 'Donados.xlsx');
    }

    public function exportDiscards() {
        return Excel::download(new DiscardsExport, 'Descartes.xlsx');
    }
}
