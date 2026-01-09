@extends('layouts.layout')

@section('content')

<div class="card p-3">
    <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <textarea
            name="content"
            class="form-control mb-2"
            rows="3"
            placeholder="Apa yang sedang terjadi?"
            required></textarea>

        <div class="d-flex justify-content-between align-items-center">
            <input type="file" name="media" class="form-control w-50">
            <button class="btn btn-primary">Post</button>
        </div>
    </form>
</div>

@endsection
