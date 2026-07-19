<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('q');

        $posts = collect();
        $pages = collect();

        if ($keyword) {
            $posts = Post::query()
                ->published()
                ->where(function ($q) use ($keyword) {
                    $q->where('title', 'like', "%{$keyword}%")
                        ->orWhere('content', 'like', "%{$keyword}%");
                })
                ->latest('published_at')
                ->take(10)
                ->get();

            $pages = Page::query()
                ->published()
                ->where(function ($q) use ($keyword) {
                    $q->where('title', 'like', "%{$keyword}%")
                        ->orWhere('content', 'like', "%{$keyword}%");
                })
                ->take(5)
                ->get();
        }

        return view('search.results', compact('keyword', 'posts', 'pages'));
    }
}
