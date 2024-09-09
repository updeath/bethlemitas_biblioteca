<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Classification;
use App\Models\editorial;
use App\Models\Author;
use App\Models\Book_statu;
use App\Models\Activity;
use App\Models\Book_location;
use Illuminate\Http\Request;
use App\Exports\InventoryExport;
use App\Imports\InventoryImport;
use Maatwebsite\Excel\Facades\Excel;
// use App\Imports\InventoryImport;
use Illuminate\Support\Facades\Log;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $query = Inventory::where('amount', '>', 0);

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('author', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        $inventory = $query->paginate(50);

        return view("home.inventory.index", compact("inventory"));
    }

    public function listing_discards(Request $request)
    {
        
        $query = Inventory::where('amount_descarted', '>', 0);

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('author', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        $inventory = $query->paginate(50);

        return view("home.roleOut.index", compact("inventory"));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classifications = Classification::orderBy('clasifPGC')->get();
        $editorials = editorial::orderBy('name_editorial')->get();
        $authors = Author::orderBy('name_author')->get();
        $book_status = Book_statu::all();
        $activities = Activity::orderBy('activity_occupation')->get();
        $book_location = Book_location::all();
        return view("home.inventory.create", compact('classifications', 'editorials', 'authors', 'book_status' , 'activities', 'book_location'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'isbn' => 'required|string',
            'clasifpgc' => 'required|integer',
            'title' => 'required|string',
            'author' => 'required|integer',
            'amount' => 'required|integer|min:1',
            'editorial' => 'required|integer',
            'publication_date' => 'required|date',
            'book_status' => 'required|integer',
            'location' => 'required|integer',
            'activite' => 'required|integer',
            'donado' => 'nullable|integer',
        ]);

        $book = new Inventory();
        $book->ISBN = $request->input('isbn');
        $book->id_clasifPGC = $request->input('clasifpgc');
        $book->title = $request->input('title');
        $book->id_author = $request->input('author');
        $book->amount = $request->input('amount');
        $book->id_editorial = $request->input('editorial');
        $book->publication_date = $request->input('publication_date');
        $book->id_status = $request->input('book_status');
        $book->id_location = $request->input('location');
        $book->id_activity = $request->input('activite');
        if ($request->input('donado') > $request->input('amount')){
            return redirect()->back()->with('error', 'La cantidad de libro donados superas a la cantidad total de libros.');
        } else {
            $book->amount_donated = $request->input('donado');
            $book->save();

            return redirect()->back()->with('success', 'Registro agregado exitosamente.');
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Inventory $Inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id) 
    {
        // Obtener el inventario por su ID
        $inventory = Inventory::findOrFail($id);
        $classifications = Classification::orderBy('clasifPGC')->get();
        $editorials = editorial::orderBy('name_editorial')->get();
        $authors = Author::orderBy('name_author')->get();
        $book_status = Book_statu::all();
        $activities = Activity::orderBy('activity_occupation')->get();
        $book_location = Book_location::all();

        // Retornar la vista de edición con el inventario
        return view('home.inventory.edit', compact('inventory', 'classifications', 'editorials', 'authors', 'book_status' , 'activities', 'book_location'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $book = Inventory::find($id);

        $request->validate([
            'isbn' => 'required|string',
            'clasifpgc' => 'required|integer',
            'title' => 'required|string',
            'author' => 'required|integer',
            'amount' => 'required|integer|min:1',
            'editorial' => 'required|integer',
            'publication_date' => 'required|date',
            'book_status' => 'required|integer',
            'location' => 'required|integer',
            'activite' => 'required|integer',
            'donado' => 'nullable|integer',
        ]);

        $book->ISBN = $request->isbn;
        $book->id_clasifPGC = $request->clasifpgc;
        $book->title = $request->title;
        $book->id_author = $request->author;
        $book->amount = $request->amount;
        $book->id_editorial = $request->editorial;
        $book->publication_date = $request->publication_date;
        $book->id_status = $request->book_status;
        $book->id_location = $request->location;
        $book->id_activity = $request->activite;
        if ($request->input('amount') < $request->input('donado')) {
            return redirect()->back()->with('error', 'La cantidad de libro donados superas a la cantidad total de libros.');
        }else {
            $book->amount_donated = $request->donado;
                    // Si los datos son diferentes se actualiza
            if ($book->isDirty()) {
                $book->update();
                return redirect()->back()->with('success', 'Libro actualizado correctamente.');
            } else {
                return redirect()->back()->with('info', 'No se realizó ninguna actualización.');
            }
        }
        


    }

    /**
     * Remove the specified resource from storage.
     */
    public function descarted(Request $request, $bookId)
    {
        // // Registrar el valor de $userId para depuración
        // Log::info('Valor de $userId: ' . $bookId);
        // // Mostrar temporalmente el valor de $userId en la interfaz de usuario
        // return response()->json(['userId' => $bookId]);

        $book = Inventory::find($bookId);

        $request->validate([
            'amount_descarted' => 'required|integer',
        ]);

        $cantBook = $book->amount;
        $BookDescarted = $request->amount_descarted;
        $cantBookDescarted = $book->amount_descarted;
        if ($cantBookDescarted == null) {
            $cantBookDescarted = 0;
        } else {
            $cantBookDescarted = $book->amount_descarted;
        };
        $newCantBook = $cantBook - $BookDescarted;

        $book->amount = $newCantBook;
        $book->amount_descarted = $BookDescarted + $cantBookDescarted;

         // Si los datos son diferentes se actualiza
        if(empty($BookDescarted)){
            return redirect()->back()->with('info', 'No se descartó ningún libro.');
        }
        elseif ($book->isDirty()) {
            $book->update();
            return redirect()->back()->with('success', 'Libro descartado correctamente.');
        } 
        

    }
    public function exportInventario()
    {
        $fileName = 'Inventario.xlsx';
        Excel::store(new InventoryExport, $fileName);

        return response()->download(storage_path('app/' . $fileName));
    }

    public function importInventario(Request $request)
    {
        $request->validate([
            'excelFile' => 'required|mimes:xlsx,csv',
        ]);

        try {
            $file = $request->file('excelFile');
            Excel::import(new InventoryImport, $file);
            return redirect()->back()->with('success', 'Importación Exitosa');
        } catch (\Exception $eh) {
            return redirect()->back()->with('error', 'Importación Erronea');
        }
    }
    

    public function inventory_restore($id)
    {
        $donation = Inventory::findOrFail($id);

       

        // Eliminar el libro de la lista de donaciones
        $donation->delete();

        return redirect()->back()->with('success', 'Libro descartado exitosamente.');
    }

}
