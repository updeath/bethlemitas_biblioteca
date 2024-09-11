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

    //Controlador para mostrar la vista del inventario
    public function index(Request $request)
    {
        $query = Inventory::where('amount', '>', 0);

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->join('authors', 'inventories.id_author', '=' , 'authors.id')
                    ->where(function ($q) use ($searchTerm) {
                        $q->where('inventories.title', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('authors.name_author', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        $inventory = $query->orderBy('title', 'asc')->paginate(50);

        return view("home.inventory.index", compact("inventory"));
    }

    //Controlador para mostrar la vista de los libros descartados
    public function listing_discards(Request $request)
    { 
        $query = Inventory::where('amount_descarted', '>', 0);

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->join('authors', 'inventories.id_author', '=' , 'authors.id')
                    ->where(function ($q) use ($searchTerm) {
                        $q->where('inventories.title', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('authors.name_author', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        $inventory = $query->orderBy('title', 'asc')->paginate(50);

        return view("home.roleOut.index", compact("inventory"));
    }

    //Controlador para mostrar la vista de los libros donados
    public function listing_donated(Request $request)
    {
        $query = Inventory::where('amount_donated', '>', 0);

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->join('authors', 'inventories.id_author', '=' , 'authors.id')
                    ->where(function ($q) use ($searchTerm) {
                        $q->where('inventories.title', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('authors.name_author', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        $inventory = $query->orderBy('title', 'asc')->paginate(50);

        return view("home.donations.listing", compact("inventory"));
    }
     
    //Controlador para mostrar la vista de crear nuevo registro
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

    //Controlador para crear nuevo registro
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

    //Controlador para mostrar la vista de editar libro
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
    
    //Controlador editar libro
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

    //Controlador para descartar libros
    public function descarted(Request $request, $bookId)
    {
        // // Registrar el valor de $userId para depuración
        // Log::info('Valor de $userId: ' . $bookId);
        // // Mostrar temporalmente el valor de $userId en la interfaz de usuario
        // return response()->json(['userId' => $bookId]);

        $book = Inventory::find($bookId);

        $request->validate([
            'amount_descarted' => 'nullable|integer',
            'amount_donated' => 'nullable|integer',
            'book_status' => 'nullable|integer',
        ]);

        $cantBook = $book->amount; //cantidad actual del total de libros
        $cantDonated = $book->amount_donated; //cantidad actual de libros donados
        $cantBookDescarted = $book->amount_descarted; //Cantidad actual de libros descartados

        $State_book = $request->book_status;
        $BookDescarted = $request->amount_descarted; //Se guarda el valor de libros no donados a desacartar
        $BookDonatedDescarted = $request->amount_donated; //Se guarda el valor de libros donados a desacartar
        if ($cantBookDescarted == null) { //Si el valor de la cantidad actual de libros descartados es null entonces ese valor pasa a ser 0
            $cantBookDescarted = 0;
        } else {
            $cantBookDescarted = $book->amount_descarted; //Sino simplemente toma el valor que hay
        };
        $newCantBook = $cantBook - ($BookDescarted + $BookDonatedDescarted); //La nueva cantidad es la resta de la cantidad total menos la cantidad de libros a descartar.
        $newCantBookDonated = $cantDonated - $BookDonatedDescarted;

        $book->amount = $newCantBook; //se guarda la nueva cantidad
        $book->amount_descarted = $BookDescarted + $cantBookDescarted + $BookDonatedDescarted; //la nueva cantidad de libros descartados es la cantidad actual mas la nueva cantidad que se esta desacrtando
        $book->amount_donated = $newCantBookDonated;
        $book->id_discard_reason = $State_book;
         // Si los datos son diferentes se actualiza
        if((empty($BookDescarted) && empty($BookDonatedDescarted)) || $State_book == ""){
            return redirect()->back()->with('info', 'No se descartó ningún libro. Asegurese de haber selecionado un motivo y haber puesto una cantidad a descartar valida');
        }
        elseif ($book->isDirty()) {
            $book->update();
            return redirect()->back()->with('success', 'Libro descartado correctamente.');
        } 
        

    }

    //Controlador para exportar
    public function exportInventario()
    {
        $fileName = 'Inventario.xlsx';
        Excel::store(new InventoryExport, $fileName);

        return response()->download(storage_path('app/' . $fileName));
    }

    //Controlador para importar
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
    
}