@extends('layouts.layout')

@section('content')

<div class="post-box">
    <p><strong>{{ $post->username }}</strong></p>
    <p>{{ $post->content }}</p>

    {{-- MEDIA --}}
    @if($post->media)
        @if($post->media_type === 'image')
            <img src="{{ asset('storage/'.$post->media) }}" width="350">
        @else
            <video src="{{ asset('storage/'.$post->media) }}" controls width="350"></video>
        @endif
    @endif

    {{-- DELETE POST (PEMILIK SAJA) --}}
    @if(($post->session_id && $post->session_id === session('anon_session_id')) || (auth()->check() && auth()->user()->name === $post->username))
        <form action="{{ route('post.delete', $post->id) }}" method="POST"
              onsubmit="return confirm('Hapus post ini?')">
            @csrf
            @method('DELETE')
            <button style="color:red">Hapus Post</button>
        </form>
    @endif

    <hr>

    {{-- LIKE --}}
    <form action="{{ route('post.like', $post->id) }}" method="POST">
        @csrf
        <button>❤️ {{ $post->likes->count() }}</button>
    </form>

    <hr>

    {{-- COMMENTS --}}
    @foreach($post->comments as $comment)
        <p>
            <strong>{{ $comment->username }}</strong> :
            {{ $comment->comment }}
        </p>
    @endforeach

    <hr>

    {{-- COMMENT FORM --}}
    <form action="{{ route('post.comment', $post->id) }}" method="POST">
        @csrf
        <textarea name="comment" required></textarea>
        <br>
        <button>Kirim</button>
    </form>
</div>

@endsection
