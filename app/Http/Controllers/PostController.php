<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    public function index_api()
    {
        try {
            // Obtener todos los posts con sus comentarios
            $posts = Post::with('comments')->get();
            return response()->json($posts);
        } catch (\Exception $e) {
            // Manejo de errores si hay un problema al obtener los datos
            Log::error('Error while fetching posts with comments:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Error fetching posts with comments.'], 500);
        }
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        try {
            Log::alert($request);
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Se agregan los formatos jpeg, png y jpg
                'description' => 'required|string',
            ]);

            // Subir la imagen al sistema de archivos
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('public/images');
                $imageUrl = Storage::url($imagePath);
                $validatedData['image'] = $imageUrl;
            }
            $validatedData['time_creation'] = now();
            // Crear el post con los datos validados
            $post = Post::create($validatedData);

            return response()->json(['success' => true, 'message' => '¡Post creado correctamente!']);
        } catch (QueryException $e) {
            // Si hay una excepción de consulta (por ejemplo, violación de restricción única)
            Log::error('QueryException in store method: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Ha ocurrido un error al crear el post. Por favor, inténtalo de nuevo más tarde.'], 500);
        } catch (\Exception $e) {
            // Cualquier otra excepción
            Log::error('Exception in store method: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Ha ocurrido un error inesperado. Por favor, inténtalo de nuevo más tarde.'], 500);
        }
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        try {
            $post = Post::findOrFail($id);
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'image' => 'image|mimes:jpeg,png,jpg|max:2048', // Se agregan los formatos jpeg, png y jpg
                'description' => 'required|string',
            ]);

            // Actualizar los datos del post
            $post->title = $validatedData['title'];
            $post->description = $validatedData['description'];

            // Actualizar la imagen si se proporciona una nueva
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('public/images');
                $imageUrl = Storage::url($imagePath);
                $post->image = $imageUrl;
            }

            // Guardar los cambios
            $post->save();

            return redirect()->route('posts.index')->with('success', '¡Post actualizado correctamente!');
        } catch (\Exception $e) {
            // Cualquier excepción
            Log::error('Exception in update method: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Ha ocurrido un error al actualizar el post. Por favor, inténtalo de nuevo más tarde.']);
        }
    }


    public function destroy($id)
    {
        try {
            $post = Post::findOrFail($id);

            // Extraer la ruta de la imagen del post y eliminarla del almacenamiento
            if ($post->image) {
                $imagePath = str_replace('/storage', 'public', $post->image);
                Storage::delete($imagePath);
            }

            // Eliminar el post de la base de datos
            $post->delete();

            return redirect()->route('posts.index')->with('success', 'La noticia ha sido eliminada correctamente.');
        } catch (\Exception $e) {
            // Manejo de errores si hay un problema al eliminar el post
            Log::error('Error while deleting post:', ['message' => $e->getMessage()]);
            return redirect()->route('posts.index')->with('error', 'Error al eliminar la noticia. Por favor, inténtalo de nuevo más tarde.');
        }
    }


    public function show_api($id)
    {
        $post = Post::with('comments')->findOrFail($id);
        return response()->json($post);
    }


    public function like(Post $post)
    {
        $post->increment('likes');
        return response()->json(['message' => 'Liked!']);
    }

    public function like_api($id)
    {
        $post = Post::findOrFail($id);
        $post->increment('likes');

        return response()->json(['message' => 'Post liked successfully', "status" => true]);
    }

    public function dislike_api($id)
    {
        $post = Post::findOrFail($id);
        if ($post->likes > 0) {
            $post->decrement('likes');
        }

        return response()->json(['message' => 'Disliked!', "status" => true]);
    }
}
