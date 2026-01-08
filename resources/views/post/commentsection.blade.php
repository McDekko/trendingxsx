@extends('layouts.layout')

@section('content')

<div class="card p-4 mb-4">
    <h5>{{ $post->username }}</h5>

    <p class="fs-5">{{ $post->content }}</p>

    @if($post->media)
        @if($post->media_type === 'image')
            <img src="{{ asset('storage/' . $post->media) }}" class="img-fluid rounded mt-3">
        @else
            <video controls class="w-100 mt-3">
                <source src="{{ asset('storage/' . $post->media) }}">
            </video>
        @endif
    @endif

    <div class="d-flex gap-3 mt-3">
        <form action="/like/{{ $post->id }}" method="POST">
            @csrf
            <button class="btn btn-outline-primary">
                ❤️ {{ $post->likes->count() }}
            </button>
        </form>
    </div>
</div>

<h5>Komentar</h5>

@forelse($post->comments as $comment)
    <div class="border-bottom py-2">
        <b>{{ $comment->username }}</b>
        <p>{{ $comment->comment }}</p>
    </div>
@empty
    <p class="text-muted">Belum ada komentar</p>
@endforelse

<form action="/comment/{{ $post->id }}" method="POST" class="mt-3">
    @csrf
    <textarea name="comment" class="form-control" required></textarea>
    <button class="btn btn-primary mt-2">Kirim</button>
</form>

@endsection
