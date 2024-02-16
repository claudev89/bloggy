<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use MongoDB\Driver\Session;

class PostController extends Controller
{
    const NUMBER_OF_ITEMS_PER_PAGE = 15;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::where('borrador', 0)->paginate(self::NUMBER_OF_ITEMS_PER_PAGE);
        return view('welcome', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $post = Post::create($request->validated());
        return redirect()->route('post.show', $post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->views++;
        $post->save();
        return view('posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('post.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        $post->update($request->validated());
        return redirect()->route('post.show', ['post' => $post]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $tituloPostEliminado = $post->titulo;

        $post->delete();

        Session::flash('mensaje', "Se ha eliminado el post '$tituloPostEliminado'.");

        return redirect()->route('post.index');
    }
}
