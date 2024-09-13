<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classification;
use App\Models\editorial;
use App\Models\Author;
use Illuminate\Support\Facades\Log;

class CreationPanelController extends Controller
{
    public function newEditorial(Request $request)
    {
        $query = editorial::query();

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                  $q->where('name_editorial', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        $editorials = $query->orderBy('name_editorial', 'asc')->get();

        return view("creationPanel.newEditorial", compact('editorials'));
    }

    public function newAuthor(Request $request)
    {
        $query = Author::query();

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                  $q->where('name_author', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        $authors = $query->orderBy('name_author', 'asc')->get();

        return view("creationPanel.newAuthor", compact('authors'));
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

    public function storeEditorial(Request $request)
    {
        $request->validate([
            'name_editorial' => 'required|string|unique:editorials,name_editorial',
        ]);

        $editorial = new editorial();
        $editorial->name_editorial = $request->name_editorial;

        $editorial->save();

        return redirect()->back()->with('success', 'La editorial se ha añadido exitosamente.');
    }

    public function storeAuthor(Request $request)
    {
        $request->validate([
            'name_author' => 'required|string|unique:authors,name_author',
        ]);

        $author = new Author();
        $author->name_author = $request->name_author;

        $author->save();

        return redirect()->back()->with('success', 'El autor se ha añadido exitosamente.');
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


    public function updateEditorial(Request $request, $id) 
    {
        $editorial = editorial::find($id);

        $request->validate([
            'edit_name_editorial' => 'nullable|string',
        ]);

        $nameUnique = $request->edit_name_editorial;

        // Actualizar solo si el valor es diferente
        if ($request->filled('edit_name_editorial') && $request->edit_name_editorial != $editorial->name_editorial) {
            $name = editorial::firstWhere('name_editorial', $nameUnique);
            if(!$name) {
                $editorial->name_editorial = $request->edit_name_editorial;
            }  
        }

        // Comprobar si hubo cambios
        if ($editorial->isDirty()) {
            $editorial->save();
            return redirect()->back()->with('success', 'Editorial actualizada correctamente.');
        } else {
            return redirect()->back()->with('info', 'La editorial ya está registrada en la base de datos, o no se han realizado modificaciones en los campos.');
        }
    }

    public function updateAuthor(Request $request, $id) 
    {
        $author = Author::find($id);

        $request->validate([
            'edit_name_author' => 'nullable|string',
        ]);

        $nameUnique = $request->edit_name_author;

        // Actualizar solo si el valor es diferente
        if ($request->filled('edit_name_author') && $request->edit_name_author != $author->name_author) {
            $name = Author::firstWhere('name_author', $nameUnique);
            if(!$name) {
                $author->name_author = $request->edit_name_author;
            }  
        }

        // Comprobar si hubo cambios
        if ($author->isDirty()) {
            $author->save();
            return redirect()->back()->with('success', 'Autor actualizada correctamente.');
        } else {
            return redirect()->back()->with('info', 'El autor ya está registrada en la base de datos, o no se han realizado modificaciones en los campos.');
        }
    }
}