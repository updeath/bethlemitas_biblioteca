<?php

namespace App\Http\Controllers;

use App\Exports\DiscardExport;
use App\Imports\DiscardImport;
use App\Models\DiscardedBook;
use Illuminate\Http\Request;
use App\Models\Donations;
use Maatwebsite\Excel\Facades\Excel;

class DiscardedBookController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index_discard(Request $request){
        $query = DiscardedBook::query();

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('author', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('code', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        $discardedBooks = $query->get();

        return view('home.roleOut.index', compact('discardedBooks'));
    }


    public function index_table(Request $request){
        $query = DiscardedBook::query();

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('author', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('code', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        $discards = $query->paginate(50);

        return view("home.roleOut.table", compact("discards"));
    }



     
     public function discard($id)
     {
         $donation = Donations::findOrFail($id);
     
         // Guardar el libro descartado en la tabla de descartes
         DiscardedBook::create($donation->toArray());
     
         // Eliminar el libro de la lista de donaciones
         $donation->delete();
     
         return redirect()->back()->with('success', 'Libro descartado exitosamente.');
     }

     public function destroy(DiscardedBook $discardedBook)
     {
         $discardedBook->delete();
     
         return redirect()->back()->with('delete', 'Eliminado exitosamente');
     }

     public function exportDiscards()
    {
        $fileName = 'Descartes.xlsx';
        Excel::store(new DiscardExport, $fileName);

        return response()->download(storage_path('app/' . $fileName));
    }

    public function importDiscards(Request $request)
    {
        $request->validate([
            'excelFile' => 'required|mimes:xlsx,csv',
        ]);

        try {
            $file = $request->file('excelFile');
            Excel::import(new DiscardImport, $file);
            return redirect()->back()->with('success', 'Importación Exitosa');
        } catch (\Exception $eh) {
            return redirect()->back()->with('error', 'Importación Erronea');
        }
    }
}
