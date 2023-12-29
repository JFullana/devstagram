<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
//Facades: son clases o funciones que solo tienen el propósito de hacer algo muy concreto
use Intervention\Image\Facades\Image;

class ImagenController extends Controller
{
    //
    public function store(Request $request)
    {

        $imagen = $request->file('file');

        //uuid genera un id unico para cada imagen que se sube a la base de datos
        $nombreImagen = Str::uuid().".".$imagen->extension();

        //Image::make ---- esta es la clase que permite crear una imagen de intervention/Image
        $imagenServidor = Image::make($imagen);

        $imagenServidor->fit(1000,1000);

        $imagenPath = public_path("uploads").'/'.$nombreImagen;
        $imagenServidor->save($imagenPath);
        //esta respuesta la recoge el evento succes de dropzone en app.js
        return response()->json(['imagen' => $nombreImagen]);
    }
}


