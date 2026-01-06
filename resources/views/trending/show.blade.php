@extends('layout')

@section('content')

<h4 class="mb-3">#{{ $keyword }}</h4>

@foreach($posts as $post)
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
@endforeach

@endsection
