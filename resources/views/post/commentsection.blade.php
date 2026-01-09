@extends('layouts.layout')

@section('content')

<style>
    .post-detail-card {
        animation: fadeInUp 0.5s ease-out;
    }

    .comment-item {
        animation: slideInLeft 0.4s ease-out;
        animation-fill-mode: both;
        padding: 16px;
        margin-bottom: 12px;
        background: rgba(26, 35, 71, 0.4);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .comment-item:nth-child(1) { animation-delay: 0.1s; }
    .comment-item:nth-child(2) { animation-delay: 0.15s; }
    .comment-item:nth-child(3) { animation-delay: 0.2s; }
    .comment-item:nth-child(4) { animation-delay: 0.25s; }
    .comment-item:nth-child(5) { animation-delay: 0.3s; }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .comment-item:hover {
        background: rgba(26, 35, 71, 0.6);
        border-color: var(--accent-blue);
        transform: translateX(4px);
    }

    .comment-username {
        color: var(--accent-blue);
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 8px;
    }

    .comment-text {
        color: var(--text-primary);
        line-height: 1.5;
        margin: 0;
    }

    .section-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--border-color), transparent);
        margin: 24px 0;
    }

    .comment-form-section {
        animation: fadeIn 0.6s ease-out;
        margin-top: 24px;
    }

    .comment-form textarea {
        min-height: 100px;
        resize: vertical;
    }

    .stats-bar {
        display: flex;
        gap: 20px;
        padding: 16px 0;
        border-top: 1px solid var(--border-color);
        border-bottom: 1px solid var(--border-color);
        margin: 16px 0;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--text-secondary);
        font-weight: 600;
    }

    .stat-item i {
        color: var(--accent-blue);
    }

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

    .comments-header {
        background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .no-comments {
        text-align: center;
        padding: 40px;
        color: var(--text-secondary);
    }

    .no-comments i {
        font-size: 48px;
        margin-bottom: 16px;
        opacity: 0.3;
    }

    /* Like Button Animation for Comment Page */
    .like-btn-detail {
        position: relative;
        overflow: hidden;
    }

    .like-btn-detail.liked {
        background: linear-gradient(135deg, #ef4444, #f97316) !important;
        border-color: #ef4444 !important;
        color: white !important;
    }

    .like-btn-detail i {
        transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    .like-btn-detail:hover i {
        transform: scale(1.3);
    }

    .like-btn-detail:active i {
        transform: scale(0.8);
    }

    @keyframes heartBurst {
        0% { transform: scale(1); }
        15% { transform: scale(1.3); }
        30% { transform: scale(0.9); }
        45% { transform: scale(1.15); }
        60% { transform: scale(0.95); }
        75% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    .like-btn-detail.animating i {
        animation: heartBurst 0.6s ease-out;
    }

    .heart-particle {
        position: absolute;
        pointer-events: none;
        font-size: 12px;
        animation: particleFloat 1s ease-out forwards;
    }

    @keyframes particleFloat {
        0% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
        100% {
            opacity: 0;
            transform: translateY(-50px) scale(0.5);
        }
    }

    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(239, 68, 68, 0.6);
        transform: scale(0);
        animation: ripple-animation 0.6s ease-out;
        pointer-events: none;
    }

    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
</style>

<a href="/" class="back-button">
    <i class="fas fa-arrow-left"></i>
    Kembali
</a>

<div class="card p-4 mb-4 post-detail-card">
    
    {{-- POST HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="username">
            <i class="fas fa-user-circle"></i>
            {{ $post->username }}
        </div>
        <small style="color: var(--text-secondary);">
            <i class="far fa-clock me-1"></i>
            {{ $post->created_at->diffForHumans() }}
        </small>
    </div>

    {{-- POST CONTENT --}}
    <div class="post-content mb-3">
        {{ $post->content }}
    </div>

    {{-- MEDIA --}}
    @if($post->media)
        <div class="mb-3">
            @if($post->media_type === 'image')
                <img src="{{ asset('storage/'.$post->media) }}" 
                     class="img-fluid rounded w-100" 
                     style="max-height: 500px; object-fit: cover;">
            @else
                <video src="{{ asset('storage/'.$post->media) }}" 
                       controls 
                       class="w-100 rounded" 
                       style="max-height: 500px;"></video>
            @endif
        </div>
    @endif

    {{-- STATS BAR --}}
    <div class="stats-bar">
        <div class="stat-item">
            <i class="fas fa-heart"></i>
            <span>{{ $post->likes->count() }} Likes</span>
        </div>
        <div class="stat-item">
            <i class="fas fa-comment"></i>
            <span>{{ $post->comments->count() }} Komentar</span>
        </div>
    </div>

    {{-- ACTION BUTTONS --}}
    <div class="d-flex gap-2 mt-3">
        {{-- LIKE --}}
        <form action="{{ route('post.like', $post->id) }}" method="POST" class="flex-grow-1 like-form-detail">
            @csrf
            <button class="btn btn-outline-primary w-100 like-btn-detail" type="submit">
                <i class="fas fa-heart me-2"></i>
                Like
            </button>
        </form>

        {{-- DELETE POST (PEMILIK SAJA) --}}
        @if(($post->session_id && $post->session_id === session('anon_session_id')) || (auth()->check() && auth()->user()->name === $post->username))
            <form action="{{ route('post.delete', $post->id) }}" method="POST"
                  onsubmit="return confirm('Hapus post ini?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-outline-danger">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        @endif
    </div>
</div>

{{-- COMMENTS SECTION --}}
<div class="card p-4">
    <h5 class="comments-header mb-4">
        <i class="fas fa-comments me-2"></i>
        Komentar ({{ $post->comments->count() }})
    </h5>

    {{-- COMMENTS LIST --}}
    @forelse($post->comments as $comment)
        <div class="comment-item">
            <div class="comment-username">
                <i class="fas fa-user"></i>
                {{ $comment->username }}
            </div>
            <p class="comment-text">{{ $comment->comment }}</p>
            <small style="color: var(--text-secondary); font-size: 12px;">
                <i class="far fa-clock me-1"></i>
                {{ $comment->created_at->diffForHumans() }}
            </small>
        </div>
    @empty
        <div class="no-comments">
            <i class="fas fa-comment-slash"></i>
            <p>Belum ada komentar. Jadilah yang pertama!</p>
        </div>
    @endforelse

    <div class="section-divider"></div>

    {{-- COMMENT FORM --}}
    <div class="comment-form-section">
        <h6 class="mb-3" style="color: var(--accent-blue);">
            <i class="fas fa-edit me-2"></i>
            Tulis Komentar
        </h6>
        <form action="{{ route('post.comment', $post->id) }}" method="POST">
            @csrf
            <textarea 
                name="comment" 
                class="form-control mb-3" 
                placeholder="Tulis komentar Anda di sini..."
                required></textarea>
            <button class="btn btn-primary w-100">
                <i class="fas fa-paper-plane me-2"></i>
                Kirim Komentar
            </button>
        </form>
    </div>
</div>

<script>
    // Like Button Animation for Detail Page
    const likeForm = document.querySelector('.like-form-detail');
    if (likeForm) {
        likeForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const button = this.querySelector('.like-btn-detail');
            const icon = button.querySelector('i');
            
            // Add burst animation
            button.classList.add('animating');
            setTimeout(() => button.classList.remove('animating'), 600);
            
            // Create ripple effect
            const ripple = document.createElement('span');
            ripple.classList.add('ripple');
            const rect = button.getBoundingClientRect();
            ripple.style.width = ripple.style.height = Math.max(rect.width, rect.height) + 'px';
            ripple.style.left = '50%';
            ripple.style.top = '50%';
            ripple.style.transform = 'translate(-50%, -50%) scale(0)';
            button.appendChild(ripple);
            setTimeout(() => ripple.remove(), 600);
            
            // Create floating particles
            for (let i = 0; i < 8; i++) {
                const particle = document.createElement('span');
                particle.classList.add('heart-particle');
                particle.innerHTML = '❤️';
                const angle = (Math.PI * 2 * i) / 8;
                const distance = 40;
                particle.style.left = (Math.cos(angle) * distance + button.offsetWidth / 2) + 'px';
                particle.style.top = (Math.sin(angle) * distance + button.offsetHeight / 2) + 'px';
                button.appendChild(particle);
                setTimeout(() => particle.remove(), 1000);
            }
            
            // Toggle liked state
            button.classList.toggle('liked');
            
            // Update stats
            const statsLikes = document.querySelector('.stats-bar .stat-item:first-child span');
            const currentCount = parseInt(statsLikes.textContent);
            const isLiked = button.classList.contains('liked');
            statsLikes.textContent = isLiked ? (currentCount + 1) + ' Likes' : Math.max(0, currentCount - 1) + ' Likes';
            
            // Submit form
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': this.querySelector('[name="_token"]').value,
                    'Accept': 'application/json',
                },
                body: new FormData(this)
            });
        });
    }
</script>

@endsection