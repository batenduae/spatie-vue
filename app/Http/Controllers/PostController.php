<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        Gate::authorize('post.view',Post::class);
        return Inertia::render('Posts/PostIndex',[
            'posts' => PostResource::collection(Post::all())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        Gate::authorize('post.create',Post::class);
        return Inertia::render('Posts/PostCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePostRequest $request): RedirectResponse
    {
        Gate::authorize('post.create',Post::class);
        Post::create($request->validated());
        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post): Response
    {
        Gate::authorize('post.edit',Post::class);
        return Inertia::render('Posts/PostEdit',[
            'post'  => new PostResource($post),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreatePostRequest $request, Post $post): RedirectResponse
    {
        Gate::authorize('post.edit',Post::class);
        $post->update($request->validated());
        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): RedirectResponse
    {
        Gate::authorize('post.delete',Post::class);
        $post->delete();
        return back();
    }
}
