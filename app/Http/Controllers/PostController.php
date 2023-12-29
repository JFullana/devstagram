<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    //
    public function __construct()
    {
        //sirve para autenticar  antes de que ejecute cualquier función 
        //sino esta autenticado redirige a login??******************************
        $this->middleware('auth')->except(['show', 'index']);
    }
    public function index(User $user)
    {
        //posts de un usuario
        $posts = Post::where('user_id', $user->id)->latest()->paginate(20);

       return view('dashboard',[
        'user' => $user,
        'posts' => $posts
       ]);
    }
    //"create" permite visualizar el formulario
    public function create()
    {
        return view('posts.create');
    }
    //"store" permite guardar en la base de datos
    public function store(Request $request)
    {
        $this->validate($request,[
            'titulo' =>'required|max:255',
            'descripcion' =>'required',
            'imagen' => 'required'
        ]);

        // Post::create([
        //     'titulo' => $request->titulo,
        //     'descripcion' => $request->descripcion,
        //     'imagen' => $request-> imagen,
        //     'user_id' => auth()->user()->id
        // ]);

        //otra forma de crear registros
        // $post = new Post();
        // $post->titulo = $request->titulo;
        // $post->descripcion = $request->descripcion;
        // $post->imagen = $request-> imagen;
        // $post->user_id = auth()->user()->id;
        // $post->save();

        //Otra forma de crear registros con las relaciones entre tablas
        /*
        Usuario que esta autenticado: $request->user()
        Acceso a la relación que se ha creado con el método posts de la clase User: $request->user()->posts()
        Crear el registro de esa relación: $request->user()->posts()->create()
        */
        $request->user()->posts()->create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request-> imagen,
            'user_id' => auth()->user()->id
        ]);

        return redirect()->route('posts.index', auth()->user()->username);
    }

    //Hay que pasar $user aunque no se use en la función, ya que, en la llamada a esta función se le pasa el username
    public function show(User $user, Post $post)
    {
           
        return view('posts.show', [
            'post'=> $post,
            'user' => $user
        ]);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();

        //eliminar imagen
        $imagen_path = public_path('uploads/'.$post->imagen);

        if(File::exists($imagen_path))
        {
            unlink($imagen_path);
        }
        return redirect()->route('posts.index', auth()->user()->username);
    }
}
