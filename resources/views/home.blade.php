@extends('layouts.layout')

@section('content')

{{-- ===================== --}}
{{-- TRENDING TOPIC --}}
{{-- ===================== --}}
@if(isset($trending))
<div class="card p-3 mb-3" style="background: #000;">
    <h5 class="mb-3">🔥 Trending</h5>

    <div class="d-flex flex-wrap gap-2">
        @foreach($trending as $topic)
            <a href="/trending/{{ $topic->keyword }}"
               class="badge bg-secondary text-decoration-none">
                #{{ $topic->keyword }} ({{ $topic->post_count }})
            </a>
        @endforeach
    </div>
</div>
@endif

{{-- ===================== --}}
{{-- JUDUL KONDISIONAL --}}
{{-- ===================== --}}
@if(isset($keyword))
    <h5 class="mb-3">#{{ $keyword }}</h5>
@elseif(isset($q))
    <h5 class="mb-3">Hasil pencarian: "{{ $q }}"</h5>
@endif

{{-- ===================== --}}
{{-- LIST POST --}}
{{-- ===================== --}}
@forelse($posts as $post)
    <div class="card p-3 mb-3">
        <b>{{ $post->username }}</b>
        <p>{{ $post->content }}</p>

        @if($post->media_type === 'image')
            <img src="{{ asset('storage/'.$post->media) }}" class="img-fluid rounded">
        @endif

        @if($post->media_type === 'video')
            <video controls class="w-100 rounded">
                <source src="{{ asset('storage/'.$post->media) }}">
            </video>
        @endif

        <div class="d-flex gap-3 mt-2">
            <form action="/like/{{ $post->id }}" method="POST">
                @csrf
                <button class="btn btn-sm btn-outline-primary">
                    ❤️ {{ $post->likes->count() }}
                </button>
            </form>

            <a href="/post/{{ $post->id }}" class="btn btn-sm btn-outline-secondary">
                💬 {{ $post->comments->count() }}
            </a>
        </div>
    </div>
@empty
    <p class="text-muted">Tidak ada postingan.</p>
@endforelse

@endsection
