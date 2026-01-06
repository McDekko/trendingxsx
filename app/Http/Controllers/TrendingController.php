<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\TrendingTopic;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TrendingController extends Controller
{
    /**
     * =========================
     * HALAMAN UTAMA (TIMELINE)
     * =========================
     */
    public function index()
    {
        $trending = TrendingTopic::orderByDesc('post_count')
            ->take(10)
            ->get();

        $posts = Post::with(['likes', 'comments'])
            ->latest()
            ->get();

        return view('trending.index', compact('trending', 'posts'));
    }

    /**
     * =========================
     * DETAIL TRENDING TOPIC
     * =========================
     */
    public function show($keyword)
    {
        $posts = Post::with(['likes', 'comments'])
            ->where('content', 'like', "%{$keyword}%")
            ->latest()
            ->get();

        return view('trending.show', compact('posts', 'keyword'));
    }

    /**
     * =========================
     * DETAIL SATU POST (ALA X)
     * =========================
     */
    public function postDetail($id)
    {
        $post = Post::with(['likes', 'comments'])->findOrFail($id);

        return view('post.commentsection', compact('post'));
    }

    /**
     * =========================
     * SIMPAN POST BARU
     * =========================
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,mp4|max:20480'
        ]);

        $username = 'anon_' . Str::random(6);

        $mediaPath = null;
        $mediaType = null;

        if ($request->hasFile('media')) {
            $mediaPath = $request->file('media')->store('media', 'public');
            $mediaType = $request->file('media')->getClientOriginalExtension() === 'mp4'
                ? 'video'
                : 'image';
        }

        Post::create([
            'username'   => $username,
            'content'    => $request->content,
            'media'      => $mediaPath,
            'media_type' => $mediaType
        ]);

        /**
         * =========================
         * UPDATE TRENDING
         * =========================
         */
        $words = preg_split('/\s+/', strtolower($request->content));

        foreach ($words as $word) {
            $word = trim($word, "#.,!?()[]{}");

            if (strlen($word) > 3) {
                TrendingTopic::updateOrCreate(
                    ['keyword' => $word],
                    ['post_count' => \DB::raw('post_count + 1')]
                );
            }
        }

        return redirect()->back();
    }

    /**
     * =========================
     * LIKE POST
     * =========================
     */
    public function like($id)
    {
        Like::create([
            'post_id' => $id,
            'username' => 'anon_' . Str::random(5)
        ]);

        return back();
    }

    /**
     * =========================
     * KOMENTAR POST
     * =========================
     */
    public function comment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string'
        ]);

        Comment::create([
            'post_id' => $id,
            'username' => 'anon_' . Str::random(5),
            'comment' => $request->comment
        ]);

        return back();
    }

    /**
     * =========================
     * SEARCH GLOBAL
     * =========================
     */
    public function search(Request $request)
    {
        $q = $request->q;

        $posts = Post::with(['likes', 'comments'])
            ->where('content', 'like', "%{$q}%")
            ->latest()
            ->get();

        return view('search', compact('posts', 'q'));
    }
}
