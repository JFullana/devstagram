<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    //
    public function index() 
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // dd($request);
        // dd($request->username);

        //modificar el request antes para poderlo validar correctamente
        //de dónde sale el método add() ************************************************************
        //$request->$request->add(['username' => Str::slug($request->username)]);

        //modificamos el request
        //en vez de usar add en laravel existe merge
        $request->merge(['username' => Str::slug($request->username)]);


        //validación:
        $this->validate($request, [
            'name' => 'required|max:30',
            'username' => 'required|unique:users|min:3|max:20',
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|confirmed|min:6'
        ]);

        //Dónde esta declarado el método create de la clase User? *************************************
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        //autenticar al usuario
        // auth()->attempt([
        //     'email' => $request->email,
        //     'password' => $request->password
        // ]);

        //otra forma de atutenticar
        auth()->attempt($request->only('email', 'password'));

        //redireccionar
        return redirect()->route('posts.index');
    }
}
