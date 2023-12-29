<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('perfil.index');
    }

    public function store(Request $request)
    {
        //modificamos el request
        //en vez de usar add en laravel existe merge
        $request->merge(['username' => Str::slug($request->username)]);
        
        $this->validate($request,[
            //si guardamos sin cambiar nuestro usuario con este código es posible
            'username' => ['required','unique:users,username,'.auth()->user()->id,'min:3','max:20','not_in:twitter,editar-perfil']
        ]);

        if($request->imagen)
        {
            $imagen = $request->file('imagen');

            //uuid genera un id unico para cada imagen que se sube a la base de datos
            $nombreImagen = Str::uuid().".".$imagen->extension();
    
            //Image::make ---- esta es la clase que permite crear una imagen de intervention/Image
            $imagenServidor = Image::make($imagen);
    
            $imagenServidor->fit(1000,1000);
    
            $imagenPath = public_path("perfiles").'/'.$nombreImagen;
            $imagenServidor->save($imagenPath);
        }

        //Guardar cambios
        $usuario = User::find(auth()->user()->id);

        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;
        $usuario->save();


        return redirect()->route('posts.index', $usuario->username);
    }
}
