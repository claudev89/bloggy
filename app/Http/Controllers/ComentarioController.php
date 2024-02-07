<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComentarioRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Comentario;

class ComentarioController extends Controller
{
    public function index($postId)
    {
        $post = Post::findOrFail($postId);
        $comentarios = $post->comentarios;

        return view('comentarios.index', compact('comentarios'));
    }

    public function store($postID, ComentarioRequest $request)
    {
        // Encontrar el post
        $post = Post::findOrFail($postID);

        // Validar comentario y agregarlo al post
        $comentario = $post->comentarios()->create($request->validated());

        // Crear evento de comentario agregado
        event(new \App\Events\ComentarioCreado($comentario));

        // Redirigir al post
        return redirect()->back();
    }

    public function destroy(Comentario $comentario)
    {
        $comentario->delete();
        return redirect()->back();
    }
}
