@extends('layout')

@section('content')

<div class="card p-3 mb-3">
    <form action="/post" method="POST" enctype="multipart/form-data">
        @csrf
        <textarea class="form-control bg-dark text-white mb-2" name="content" rows="3"
            placeholder="Apa yang sedang terjadi?"></textarea>
        <div class="d-flex justify-content-between">
            <input type="file" name="media" class="form-control form-control-sm bg-dark text-white w-50">
            <button class="btn btn-primary">Post</button>
        </div>
    </form>
</div>

@foreach(\App\Models\Post::latest()->get() as $post)
<div class="card p-3 mb-2">
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
