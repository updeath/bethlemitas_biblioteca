<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Classification;
use Illuminate\Http\Request;
use App\Exports\InventoryExport;
use App\Imports\InventoryImport;
use Maatwebsite\Excel\Facades\Excel;
// use App\Imports\InventoryImport;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $query = Inventory::query();

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


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classifications = Classification::all();
        return view("home.inventory.create", compact('classifications'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'clasifpgc' => 'required|integer',
            'title' => 'required|string',
            'amount' => 'required|integer',
            'author' => 'required|string',
            'editorial' => 'required|string',
            'status' => 'required|in:well,regular,bad',
            'activite' => 'required|in:reference_material,investigation,teaching,consultation,languagues,reading',
            "category" => "required",
            'area' => 'required|string',
            "year" => "required|date_format:Y",
            "image" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048",
            "action" => "required|in:donaciones,descartaciones,inventario",
        ]);

        // Dependiendo de la acción seleccionada, guardar en la tabla correspondiente
       

        return redirect()->back()->with('success', 'Registro agregado exitosamente.');
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

        // Retornar la vista de edición con el inventario
        return view('home.inventory.edit', compact('inventory'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|string',
            'clasifpgc' => 'required|integer',
            'title' => 'required|string',
            'amount' => 'required|integer',
            'author' => 'required|string',
            'editorial' => 'required|string',
            'status' => 'required|in:well,regular,bad',
            'activite' => 'required|in:reference_material,investigation,teaching,consultation,languagues,reading',
            'area' => 'required|string',
            "year" => "required|date_format:Y",
            
        ]);

        $inventory = Inventory::findOrFail($id);

        $inventory->update($request->all());

        return redirect()->back()->with('success', 'Libro actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $Inventory)
    {
        $Inventory->delete();

        return redirect()->back()->with('delete', 'Eliminado exitosamente');
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
