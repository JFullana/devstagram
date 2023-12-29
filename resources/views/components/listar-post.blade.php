<div>
    @if($posts->count())
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

            @foreach ($posts as $post)
            <div>
                {{-- route model binding hace todas las comprobaciones necesarias, solo hay que pasar la variable --}}
                <a href="{{ route('posts.show', ['post' => $post, 'user' => $post->user]) }}">
                    <img src="{{asset('uploads').'/'.$post->imagen}}" alt="Imagen del post &quot;{{$post->titulo}}&quot;">
                </a>
            </div>
            @endforeach
        </div>

        <div class="my-10">
            {{$posts->links('pagination::tailwind')}}
        </div>
        
    @else
        <p class="text-center">No hay posts, sigue a alguien para poder mostrar sus posts</p>
    @endif

        {{-- Otra forma de hacer lo mismo con forelse --}}

        {{-- @forelse ($posts as $post )
            <h1>{{$post->titulo}}</h1>
        @empty
            <p>no hay posts</p>
        @endforelse --}}
</div>