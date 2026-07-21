<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Redirect;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::query()
            ->published();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%");
        }

        $posts = $query->latest('published_at')->paginate(12);

        return view('posts.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = Post::query()
            ->with('author')
            ->where('slug', $slug)
            ->published()
            ->first();

        if (! $post) {
            $redirect = Redirect::where('old_path', '/berita/'.$slug)
                ->where('is_active', true)
                ->first();

            abort_if(! $redirect, 404);

            return redirect($redirect->new_path, $redirect->status_code);
        }

        $relatedPosts = Post::query()
            ->published()
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('posts.show', compact('post', 'relatedPosts'));
    }
}
