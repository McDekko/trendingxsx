<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\TrendingTopic;
use Illuminate\Http\Request;

class TrendingController extends Controller
{
    /* =========================
     * GENERATE ANON NAME (ALWAYS RANDOM)
     * ========================= */
    private function generateAnonUsername()
    {
        $prefix = ['Anon', 'Ghost', 'Shadow', 'Silent', 'Mystic', 'Hidden'];

        return $prefix[array_rand($prefix)].rand(1000, 9999);
    }

    /* =========================
     * TIMELINE
     * ========================= */
    public function index()
    {
        $trending = TrendingTopic::where('post_count', '>=', 5)
            ->orderByDesc('post_count')
            ->take(10)
            ->get();

        $posts = Post::with(['likes', 'comments'])
            ->latest()
            ->get();

        return view('home', compact('trending', 'posts'));
    }

    /* =========================
     * FORM CREATE POST
     * ========================= */
    public function create()
    {
        return view('post.create');
    }

    /* =========================
     * SIMPAN POST (ANON NEW NAME)
     * ========================= */
    public function store(Request $request)
    {
        // Generate atau ambil session ID untuk track ownership
        if (! session()->has('anon_session_id')) {
            session(['anon_session_id' => uniqid('anon_', true)]);
        }

        $username = $this->generateAnonUsername();

        $request->validate([
            'content' => 'required|string',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,webm,mkv|max:20480',
        ]);

        $mediaPath = null;
        $mediaType = null;

        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $mediaPath = $file->store('media', 'public');

            $extension = strtolower($file->getClientOriginalExtension());

            $videoExtensions = ['mp4', 'mkv', 'mov', 'webm'];

            $mediaType = in_array($extension, $videoExtensions)
                ? 'video'
                : 'image';
        }

        $post = Post::create([
            'username' => $username,
            'content' => $request->content,
            'media' => $mediaPath,
            'media_type' => $mediaType,
            'session_id' => session('anon_session_id'),
        ]);

        /* TRENDING +3 */
        $words = array_unique(preg_split('/\s+/', strtolower($request->content)));

        foreach ($words as $word) {
            $word = trim($word, '.,!?()[]{}');
            if (strlen($word) < 4) {
                continue;
            }

            $topic = TrendingTopic::firstOrCreate(
                ['keyword' => $word],
                ['post_count' => 0]
            );

            $topic->increment('post_count', 3);
        }

        return redirect()->route('home');
    }

    /* =========================
     * DETAIL POST
     * ========================= */
    public function postDetail($id)
    {
        $post = Post::with(['likes', 'comments'])->findOrFail($id);

        return view('post.commentsection', compact('post'));
    }

    /* =========================
     * DELETE POST (NO OWNER CHECK)
     * ========================= */
    public function destroy($id)
    {
        Post::findOrFail($id)->delete();

        return redirect()->route('home');
    }

    /* =========================
     * LIKE (ANON RANDOM)
     * ========================= */
    public function like($id)
    {
        $username = $this->generateAnonUsername();

        $like = Like::firstOrCreate([
            'post_id' => $id,
            'username' => $username,
        ]);

        if ($like->wasRecentlyCreated) {
            $post = Post::find($id);

            $words = array_unique(preg_split('/\s+/', strtolower($post->content)));
            foreach ($words as $word) {
                $word = trim($word, '.,!?()[]{}');
                if (strlen($word) < 4) {
                    continue;
                }

                TrendingTopic::where('keyword', $word)
                    ->increment('post_count', 1);
            }
        }

        return back();
    }

    /* =========================
     * COMMENT (ANON RANDOM)
     * ========================= */
    public function comment(Request $request, $id)
    {
        $username = $this->generateAnonUsername();

        $request->validate([
            'comment' => 'required|string',
        ]);

        Comment::create([
            'post_id' => $id,
            'username' => $username,
            'comment' => $request->comment,
        ]);

        $post = Post::find($id);

        $words = array_unique(preg_split('/\s+/', strtolower($post->content)));
        foreach ($words as $word) {
            $word = trim($word, '.,!?()[]{}');
            if (strlen($word) < 4) {
                continue;
            }

            TrendingTopic::where('keyword', $word)
                ->increment('post_count', 2);
        }

        return back();
    }

    /* =========================
     * SHOW TRENDING BY KEYWORD
     * ========================= */
    public function show($keyword)
    {
        // Ambil postingan yang mengandung keyword
        $posts = Post::with(['likes', 'comments'])
            ->where('content', 'LIKE', '%'.$keyword.'%')
            ->latest()
            ->get();

        // Ambil daftar trending untuk sidebar
        $trending = TrendingTopic::orderByDesc('post_count')
            ->take(10)
            ->get();

        // Ambil HOT POSTS berdasarkan jumlah like
        $hotPosts = Post::withCount('likes')
            ->orderByDesc('likes_count')
            ->take(5)
            ->get();

        return view('home', compact('posts', 'trending', 'hotPosts'));
    }

    /* =========================
     * SEARCH POSTS
     * ========================= */
    public function search(Request $request)
    {
    $query = $request->input('query', '');

        $posts = [];

        // Only search if query is not empty
        if (!empty(trim($query))) {
            $posts = Post::with(['likes', 'comments'])
                ->where('content', 'LIKE', '%'.$query.'%')
                ->latest()
                ->get();
        }

        // Ambil daftar trending untuk sidebar
        $trending = TrendingTopic::orderByDesc('post_count')
            ->take(10)
            ->get();

        // Ambil HOT POSTS berdasarkan jumlah like
        $hotPosts = Post::withCount('likes')
            ->orderByDesc('likes_count')
            ->take(5)
            ->get();

        return view('home', compact('posts', 'trending', 'hotPosts'));
    }
}
