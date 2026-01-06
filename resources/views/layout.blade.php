<!DOCTYPE html>
<html>
<head>
    <title>trendingxsx</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background:#000; color:#fff }
        .card { background:#111; border:1px solid #222 }
        a { color:#1DA1F2; text-decoration:none }
        textarea { resize:none }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-black border-bottom">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="/">trendingxsx</a>
        <form action="/search" class="d-flex">
            <input class="form-control bg-dark text-white" name="q" placeholder="Search">
        </form>
    </div>
</nav>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            @yield('content')
        </div>

        <div class="col-md-4">
            <div class="card p-3">
                <h5>🔥 Trending</h5>
                @foreach(\App\Models\TrendingTopic::orderByDesc('post_count')->take(10)->get() as $t)
                    <a href="/trending/{{ $t->keyword }}">#{{ $t->keyword }}</a><br>
                @endforeach
            </div>
        </div>
    </div>
</div>

</body>
</html>
