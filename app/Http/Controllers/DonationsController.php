<?php

namespace App\Http\Controllers;

use App\Models\Donations;
use Illuminate\Http\Request;
use App\Models\DiscardedBook;
use App\Exports\DonationsExport;
use App\Imports\DonationsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Invenotry;

class DonationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request){
        $query = Donations::query();

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('author', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('code', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        $donations = $query->get();

        return view("home.donations.listing", compact("donations"));
    }

    public function index_table(Request $request)
{
    $query = Donations::query();

    if ($request->has('search')) {
        $searchTerm = $request->input('search');
        $query->where(function ($q) use ($searchTerm) {
            $q->where('code', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('title', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('author', 'LIKE', '%' . $searchTerm . '%');
        });
    }

    $donations = $query->paginate(2);

    return view("home.donations.table", compact("donations"));
}




    public function index_roleOut(){
        return view ('home.roleOut.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view("home.donations.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "code" => "required",
            "title" => "required",
            "author" => "required",
            "editorial" => "required",
            "amount" => "required|numeric|min:0",
            "category" => "required",
            'area' => 'required|in:sociales,literatura,religion,CienciaComputer,psicologia,politica,informacion,lenguas,Ciencianaturales,Informaciongeneral,Educacionsalud,historia,Cienciasalud,arte,ciencia,EconomiaPolitica,Aprendizaje,Biblias,Filosofía,ÉticaValores,Liderazgo,Educación,Cienciaspolíticaseconómicas,Atlasuniversal,Ingles,Fichasingles,Físicamatemática,Matemáticas,Diccionariosespañol,Diccionariosinglés,Química,Cienciasnaturalesbiología,Comportamientosalud,Ecología,Energía,medioambiente,Literaturamoderna,Literaturaantigua,Literaturainfantil',
            "status" => "required",
            "image" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048",
            "classification" => "required",
            "year" => "required|date_format:Y"
        ]);

        $data = [
            'code' => $request->code,
            'title' => $request->title,
            'author' => $request->author,
            'editorial' => $request->editorial,
            'amount' => $request->amount,
            'category' => $request->category,
            'area' => $request->area,
            'status' => $request->status,
            'classification' => $request->classification,
            'year' => $request->year
        ];

        // Validar la foto
        if ($request->hasFile('image')) {
            $photo = $request->file('image');
            $filename = time() . '.' . $photo->getClientOriginalExtension();
            $destinationPath = 'img/imgDonations';
            $photo->move(public_path($destinationPath), $filename);
            $imagePath = $destinationPath . '/' . $filename;

            // Agregar la ruta de la imagen al array $data
            $data['image'] = $imagePath;
        }

        // Crear la donación con los datos, incluida la ruta de la imagen
        Donations::create($data);

        return redirect()->back()->with('success', 'Donación creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Donations $donations)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Obtener la donación por su ID
        $donation = Donations::findOrFail($id);

        // Retornar la vista de edición con la donación
        return view('home.donations.edit', compact('donation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validar los campos como en el método store
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
        ]);

        // Obtener la donación por su ID
        $donation = Donations::findOrFail($id);

        // Actualizar los datos de la donación
        $donation->update([
            'code' => $request->code,
            'title' => $request->title,
            'author' => $request->author,
            'editorial' => $request->editorial,
            'amount' => $request->amount,
            'category' => $request->category,
            'area' => $request->area,
            'status' => $request->status,
            'classification' => $request->classification,
            'year' => $request->year,
        ]);

        // Validar y procesar la nueva imagen, si se proporciona
        if ($request->hasFile('image')) {
            $photo = $request->file('image');
            $filename = time() . '.' . $photo->getClientOriginalExtension();
            $destinationPath = 'img/imgDonations';
            $photo->move(public_path($destinationPath), $filename);
            $imagePath = $destinationPath . '/' . $filename;

            // Agregar la ruta de la imagen al modelo y guardar
            $donation->image = $imagePath;
            $donation->save();
        }

        // Redireccionar de nuevo a la vista de edición con un mensaje de éxito
        return redirect()->route('donations.edit', $donation->id)->with('success', 'Donación actualizada correctamente.');
    }

    public function restore($id)
    {
        $restore = DiscardedBook::findOrFail($id);

        // Guardar el libro descartado en la tabla de descartes
        Donations::create($restore->toArray());

        // Eliminar el libro de la lista de donaciones
        $restore->delete();

        return redirect()->back()->with('success', 'Libro Restaurado exitosamente.');
    }

    public function send_to_inventory($id)
    {
        // Encuentra la donación por su ID
        $donation = Donations::findOrFail($id);

        // Crea una nueva entrada en la tabla de inventario usando los datos de la donación
        Invenotry::create([
            'code' => $donation->code,
            'clasifpgc' => $donation->clasifpgc,
            'title' => $donation->title,
            'amount' => $donation->amount,
            'author' => $donation->author,
            'editorial' => $donation->editorial,
            'status' => $donation->status,
            'activite' => $donation->activite,
            'category' => $donation->category,
            'area' => $donation->area,
            'year' => $donation->year,
            // Ajusta los campos según tu modelo de inventario
        ]);

        // Elimina la donación de la lista de donaciones
        $donation->delete();

        return redirect()->back()->with('success', 'Libro enviado al inventario exitosamente.');
    }

    public function exportDonations()
    {
        $fileName = 'Donaciones.xlsx';
        Excel::store(new DonationsExport, $fileName);

        return response()->download(storage_path('app/' . $fileName));
    }

    public function importDonations(Request $request)
    {
        $request->validate([
            'excelFile' => 'required|mimes:xlsx,csv',
        ]);

        try {
            $file = $request->file('excelFile');
            Excel::import(new DonationsImport, $file);
            return redirect()->back()->with('success', 'Importación Exitosa');
        } catch (\Exception $eh) {
            return redirect()->back()->with('error', 'Importación Erronea');
        }
    }
}
