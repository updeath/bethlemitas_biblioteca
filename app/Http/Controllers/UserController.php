<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{


    public function layout(){
        return view ('layout.homePage');
    }

    public function index_profile(){
        return view ('home.profile');
    }


    public function profile_update(Request $request) {
        $user = Auth::user(); // Obtiene los datos del usuario logueado
    
        // Validacion de los datos
        $request->validate([
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'required|min:6',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
    
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = $request->password;
    
        // Validar la foto
        if ($request->hasFile('image')) {
            $photo = $request->file('image');
            $filename = $user->id . '.' . $photo->getClientOriginalExtension();
            $destinationPath = 'img/photo';
            $photo->move(public_path($destinationPath), $filename);
            $user->image = $destinationPath . '/' . $filename;
        }
    
        // Si los datos son diferentes se actualiza
        if ($user->isDirty()){
            $user->update();
            return redirect()->back()->with('success', 'Perfil actualizado correctamente.');
        } else {
            return redirect()->back()->with('info', 'No se realizó ninguna actualización.');
        }
    }

}
