<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return response()->json(Post::all(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
    
        $post = Post::create($validated);
    
        return response()->json([
            'message' => 'Data Store Successfully',
            'data' => $post
        ], 201);
    }
    
    public function show(Post $post)
    {
        return response()->json($post, 200);
    }
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
        ]);

        $post->update($validated);

        return response()->json($post, 200);
    }
    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json(null, 204);
    }
}
