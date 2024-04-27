<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::whereNull('parentCategory')->get();
        return view('welcome');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $categoryName)
    {
        $category = Category::where('name', $categoryName)->first();
        $childCategories = Category::where('parentCategory', $category->id)->get();
        $posts = $category->posts()->where('borrador', 0)->orderBy('created_at', 'desc')->get();
        foreach ($childCategories as $childCategory) {
            $posts = $posts->merge($childCategory->posts()->where('borrador', 0)->orderBy('created_at', 'desc')->get());
        }
        return view('welcome', ['posts' => $posts, 'categoryName' => $categoryName]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        Category::delete();
    }
}
