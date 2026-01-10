@extends('layouts.layout')

@section('content')

    {{-- ===================== --}}
    {{-- TRENDING --}}
    {{-- ===================== --}}
    @if (isset($trending))
        <div class="card p-3 mb-3 bg-dark text-white">
            <h5 class="mb-3">🔥 Trending</h5>

            <div class="d-flex flex-wrap gap-2">
                @foreach ($trending as $topic)
                    <a href="/trending/{{ $topic->keyword }}"
                        class="badge bg-secondary text-decoration-none">
                        #{{ $topic->keyword }} ({{ $topic->post_count }})
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    {{-- ===================== --}}
    {{-- JUDUL --}}
    {{-- ===================== --}}
    @if (isset($keyword))
        <h5 class="mb-3">#{{ $keyword }}</h5>
    @elseif(isset($q))
        <h5 class="mb-3">Hasil pencarian: "{{ $q }}"</h5>
    @endif

    {{-- ===================== --}}
    {{-- LIST POST --}}
    {{-- ===================== --}}
    @forelse($posts as $post)
        <div class="card p-3 mb-3">

            {{-- USERNAME --}}
            <b>{{ $post->username }}</b>

            {{-- CONTENT --}}
            <p class="mt-2">
                {!! preg_replace(
                    '/#(\w+)/',
                    '<a href="/trending/$1" class="text-primary fw-bold">#$1</a>',
                    nl2br(e($post->content))
                ) !!}
            </p>

            {{-- MEDIA --}}
            @if ($post->media_type === 'image')
                <img src="{{ asset('storage/' . $post->media) }}"
                    class="img-fluid rounded mb-2">
            @endif

            @if ($post->media_type === 'video')
                <video controls class="w-100 rounded mb-2">
                    <source src="{{ asset('storage/' . $post->media) }}">
                </video>
            @endif

            {{-- ACTION BAR --}}
            <div class="d-flex align-items-center gap-3 mt-2">

                {{-- LIKE --}}
                <form action="/like/{{ $post->id }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-outline-primary">
                        ❤️ {{ $post->likes->count() }}
                    </button>
                </form>

                {{-- COMMENT --}}
                <a href="/post/{{ $post->id }}"
                    class="btn btn-sm btn-outline-secondary">
                    💬 {{ $post->comments->count() }}
                </a>

                {{-- DELETE (HANYA PEMILIK POST) --}}
                @if ($post->session_id && $post->session_id === session('anon_session_id'))
                    <form action="/post/{{ $post->id }}"
                        method="POST"
                        onsubmit="return confirm('Hapus postingan ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">
                            🗑
                        </button>
                    </form>
                @endif

            </div>
        </div>
    @empty
        <p class="text-muted">Tidak ada postingan.</p>
    @endforelse

@endsection
