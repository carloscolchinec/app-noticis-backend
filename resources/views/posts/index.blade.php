@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-6">Noticias</h1>
        <a href="{{ route('posts.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-6 inline-block">Crear Nueva Noticia</a>
        @if (count($posts) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($posts as $post)
                    <div class="rounded-lg shadow-md overflow-hidden">
                        <img src="{{ $post->image }}" class="w-full h-48 object-cover object-center" alt="{{ $post->title }}">
                        <div class="p-4">
                            <h2 class="text-xl font-semibold mb-2">{{ $post->title }}</h2>
                            <div class="text-gray-700 mt-2 overflow-hidden" style="max-height: 60px" id="text{{ $post->id_posts }}">
                                {!! $post->description !!}
                            </div>
                            {{-- Botones --}}
                            <div class="flex mt-2">
                                {{-- Botón de ver más --}}
                                @if (strlen($post->description) > 120)
                                    <button id="toggle{{ $post->id_posts }}" class="text-blue-500 focus:outline-none bg-gray-300 hover:bg-gray-400 py-2 px-4 rounded mr-2">Ver más</button>
                                @endif
                                <form action="{{ route('posts.destroy', $post->id_posts) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 ml-1 mr-1 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-block">Eliminar</button>
                                </form>
                                
                            
                                {{-- Botón de editar --}}
                                <a href="{{ route('posts.edit', $post->id_posts) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded inline-block">Editar</a>
                            
                            </div>
                            <p class="text-sm text-gray-500 mt-2">{{ $post->created_at ? $post->created_at->diffForHumans() : '' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>No se encontraron posts.</p>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @foreach ($posts as $post)
                var toggle{{ $post->id_posts }} = document.getElementById('toggle{{ $post->id_posts }}');
                var text{{ $post->id_posts }} = document.getElementById('text{{ $post->id_posts }}');

                toggle{{ $post->id_posts }}.addEventListener('click', function() {
                    text{{ $post->id_posts }}.style.maxHeight = text{{ $post->id_posts }}.style.maxHeight ? null : '60px';
                    this.textContent = text{{ $post->id_posts }}.style.maxHeight ? 'Ver menos' : 'Ver más';
                });
            @endforeach
        });
    </script>
@endsection
