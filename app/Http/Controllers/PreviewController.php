<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use Illuminate\View\View;

class PreviewController extends Controller
{
    public function page(Page $page): View
    {
        return view('pages.show', [
            'page' => $page,
            'preview' => true,
        ]);
    }

    public function post(Post $post): View
    {
        $post->load('author');

        $relatedPosts = Post::query()
            ->published()
            ->whereKeyNot($post)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('posts.show', [
            'post' => $post,
            'relatedPosts' => $relatedPosts,
            'preview' => true,
        ]);
    }
}
