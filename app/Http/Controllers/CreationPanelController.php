<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classification;
use Illuminate\Support\Facades\Log;

class CreationPanelController extends Controller
{
    public function newEditorial()
    {
        return view("creationPanel.newEditorial");
    }

    public function newAuthor()
    {
        return view("creationPanel.newAuthor");
    }

    public function newClassification(Request $request)
    {
        $query = Classification::query();

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                  $q->where('clasifPGC', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('name_classification', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        $classifications = $query->orderBy('clasifPGC', 'asc')->get();

        return view("creationPanel.newClassification", compact('classifications'));
    }

    //Creates
    public function storeClassification(Request $request)
    {
        $request->validate([
            'code_classification' => 'required|string|unique:classifications,clasifPGC',
            'name_classification' => 'required|string',
        ]);

        $classif = new Classification();
        $classif->clasifPGC = $request->code_classification;
        $classif->name_classification = $request->name_classification;

        $classif->save();

        return redirect()->back()->with('success', 'La clasificación se ha añadido exitosamente.');
    }


    //Updates

    public function updateClassification(Request $request, $id) 
    {
        $classification = Classification::find($id);

        $request->validate([
            'edit_code_classification' => 'nullable|string',
            'edit_name_classification' => 'nullable|string',
        ]);

        $idCode = $request->edit_code_classification;

        // Actualizar solo si el valor es diferente
        if ($request->filled('edit_code_classification') && $request->edit_code_classification != $classification->clasifPGC) {
            $code = Classification::firstWhere('clasifPGC', $idCode);
            if(!$code) {
                $classification->clasifPGC = $request->edit_code_classification;
            }  
        }

        if ($request->filled('edit_name_classification') && $request->edit_name_classification != $classification->name_classification) {
            $classification->name_classification = $request->edit_name_classification;
        }

        // Comprobar si hubo cambios
        if ($classification->isDirty()) {
            $classification->save();
            return redirect()->back()->with('success', 'Clasificación actualizada correctamente.');
        } else {
            return redirect()->back()->with('info', 'El código de clasificación PGC ya está registrado en la base de datos, o no se han realizado modificaciones en los campos de clasificación.');
        }
    }
}