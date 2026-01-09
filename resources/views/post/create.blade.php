@extends('layouts.layout')

@section('content')
    <style>
        .back-button {
            margin-bottom: 20px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: rgba(26, 35, 71, 0.6);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            color: var(--accent-blue);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .back-button:hover {
            background: rgba(26, 35, 71, 0.9);
            border-color: var(--accent-blue);
            transform: translateX(-4px);
        }
    </style>

    <a href="/" class="back-button">
        <i class="fas fa-arrow-left"></i>
        Kembali
    </a>

    <div class="card p-3">


        <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <textarea name="content" class="form-control mb-2" rows="3" placeholder="Apa yang sedang terjadi?" required></textarea>

            <div class="d-flex justify-content-between align-items-center">
                <input type="file" name="media" class="form-control w-50">
                <button class="btn btn-primary">Post</button>
            </div>
        </form>
    </div>
@endsection
