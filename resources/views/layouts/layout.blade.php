<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'trendixsx')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #000000;
            color: #797979;
        }

        .app {
            max-width: fill-available;
            margin: auto;
            background-color: #121212;
            min-height: 100vh;
        }

        .post-image {
            height: 300px;
            background-color: #2a2a2a;
        }

        .bottom-nav {
            position: fixed;
            bottom: 0;
            width: 100%;
            max-width: fill-available;
            background: #292929;
            border-top: 1px solid #222;
        }
    </style>
</head>

<body>

    <div class="app">

        {{-- TOP BAR --}}
        <nav class="d-flex justify-content-between align-items-center p-3">
            <h5 class="mb-0">Social</h5>
            <div class="d-flex gap-3 fs-5">
                
        {{-- SEARCH --}}
        <form action="{{ route('search') }}" method="GET" class="d-flex flex-grow-1">
            <input
                type="text"
                name="q"
                class="form-control form-control-sm me-2"
                placeholder="Cari postingan..."
                value="{{ request('q') }}"
                required
            >
            <button class="btn btn-outline-light btn-sm">
                search
            </button>
        </form>
                {{-- <i class="fa-regular fa-square-plus"></i>
            <i class="fa-regular fa-heart"></i>
            <i class="fa-regular fa-paper-plane"></i> --}}
            </div>
        </nav>

        <div class="col-md-4">
            <div class="card p-3" style ="margin-bottom: 1rem; ">
                <h5>🔥 Trending</h5>
                @foreach (\App\Models\TrendingTopic::orderByDesc('post_count')->take(10)->get() as $t)
                    <a href="/trending/{{ $t->keyword }}">#{{ $t->keyword }}</a><br>
                @endforeach
            </div>
        </div>

        {{-- CONTENT --}}
        <main class="pb-5">
            @yield('content')
        </main>

    </div>

    {{-- BOTTOM NAV --}}
    <nav class="bottom-nav py-4">
           <div class="container center gap-2">
        {{-- TAMBAH POST --}}
    <a href="{{ route('post.create') }}"
       class="btn btn-primary rounded-circle position-absolute d-flex align-items-center justify-content-center"
       style="
            width:56px;
            height:56px;
            left:50%;
            top:-28px;
            transform:translateX(-50%);
            font-size:24px;
       ">
        +
    </a>


    </div>
</nav>


</body>

</html>
