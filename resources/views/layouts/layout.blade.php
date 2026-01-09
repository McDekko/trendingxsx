<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TrendixSX')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --bg-primary: #0a0e27;
            --bg-secondary: #141b3a;
            --bg-card: #1a2347;
            --accent-blue: #00d4ff;
            --accent-purple: #6366f1;
            --text-primary: #e8eaed;
            --text-secondary: #9ca3af;
            --border-color: #2d3752;
        }

        * {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            background: linear-gradient(135deg, var(--bg-primary) 0%, #0d1b2a 100%);
            color: var(--text-primary);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            overflow-x: hidden;
            margin: 0;
            padding: 0;
            position: relative;
        }

        /* Video Background */
        .video-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -2;
            overflow: hidden;
            pointer-events: none;
        }

        .video-background video {
            position: absolute;
            top: 50%;
            left: 50%;
            min-width: 100vw;
            min-height: 100vh;
            width: auto;
            height: auto;
            transform: translate(-50%, -50%);
            object-fit: cover;
            opacity: 0.25;
            filter: blur(2px) brightness(0.6);
        }

        /* Overlay gradient untuk blend dengan UI */
        .video-background::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.5) 0%, rgba(13, 27, 42, 0.5) 100%);
            pointer-events: none;
            z-index: 1;
        }

        /* Animated Background Overlay */
        body::before {
            content: '';
            position: fixed;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 50% 50%, rgba(0, 212, 255, 0.03) 0%, transparent 50%);
            animation: rotate 20s linear infinite;
            z-index: -1;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* Main Layout */
        .main-container {
            display: grid;
            grid-template-columns: 300px 1fr 350px;
            gap: 20px;
            max-width: 1600px;
            margin: 0 auto;
            padding: 20px;
            min-height: 100vh;
        }

        /* LEFT SIDEBAR */
        .left-sidebar {
            position: sticky;
            top: 20px;
            height: fit-content;
        }

        .logo-section {
            background: linear-gradient(135deg, rgba(26, 35, 71, 0.8) 0%, rgba(20, 27, 58, 0.8) 100%);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 30px 20px;
            text-align: center;
            margin-bottom: 20px;
            position: relative;
            overflow: hidden;
        }

        .logo-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(transparent,
                    rgba(0, 212, 255, 0.1),
                    transparent 30%);
            animation: rotate 4s linear infinite;
        }

        .logo-container {
            position: relative;
            z-index: 1;
            margin-bottom: 20px;
        }

        .logo-img {
            width: 120px;
            height: 120px;
            object-fit: contain;
            filter: drop-shadow(0 0 20px rgba(0, 212, 255, 0.5));
            animation: logoFloat 3s ease-in-out infinite;
        }

        @keyframes logoFloat {

            0%,
            100% {
                transform: translateY(0px);
                filter: drop-shadow(0 0 20px rgba(0, 212, 255, 0.5));
            }

            50% {
                transform: translateY(-10px);
                filter: drop-shadow(0 0 30px rgba(0, 212, 255, 0.8));
            }
        }

        .logo-glow {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 150px;
            height: 150px;
            background: radial-gradient(circle, rgba(0, 212, 255, 0.3), transparent 70%);
            animation: pulse 2s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: translate(-50%, -50%) scale(1);
                opacity: 0.5;
            }

            50% {
                transform: translate(-50%, -50%) scale(1.2);
                opacity: 0.8;
            }
        }

        .tagline {
            position: relative;
            z-index: 1;
            font-size: 14px;
            color: var(--text-secondary);
            font-style: italic;
            margin-bottom: 20px;
        }

        .stats-grid {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .stat-box {
            background: rgba(0, 212, 255, 0.1);
            border: 1px solid rgba(0, 212, 255, 0.3);
            border-radius: 12px;
            padding: 15px;
            text-align: center;
        }

        .stat-number {
            font-size: 24px;
            font-weight: 700;
            background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 12px;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* CENTER CONTENT */
        .center-content {
            background: rgba(20, 27, 58, 0.4);
            backdrop-filter: blur(10px);
            border-left: 1px solid var(--border-color);
            border-right: 1px solid var(--border-color);
            padding: 20px;
            min-height: 100vh;
        }

        /* RIGHT SIDEBAR */
        .right-sidebar {
            position: sticky;
            top: 20px;
            height: fit-content;
        }

        .sidebar-card {
            background: linear-gradient(135deg, rgba(26, 35, 71, 0.8) 0%, rgba(20, 27, 58, 0.8) 100%);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 20px;
            position: relative;
            overflow: hidden;
        }

        .sidebar-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--accent-blue), transparent);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {

            0%,
            100% {
                left: -100%;
            }

            50% {
                left: 100%;
            }
        }

        .sidebar-card h6 {
            color: var(--accent-blue);
            font-weight: 700;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .trending-item {
            padding: 12px;
            margin-bottom: 8px;
            background: rgba(0, 212, 255, 0.05);
            border: 1px solid rgba(0, 212, 255, 0.2);
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .trending-item:hover {
            background: rgba(0, 212, 255, 0.15);
            border-color: var(--accent-blue);
            transform: translateX(5px);
        }

        .trending-keyword {
            color: var(--accent-blue);
            font-weight: 600;
            display: block;
            margin-bottom: 4px;
        }

        .trending-count {
            font-size: 12px;
            color: var(--text-secondary);
        }

        .hot-post {
            padding: 12px;
            margin-bottom: 12px;
            background: rgba(239, 68, 68, 0.05);
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .hot-post:hover {
            background: rgba(239, 68, 68, 0.15);
            border-color: #ef4444;
            transform: scale(1.02);
        }

        .hot-post-user {
            font-size: 12px;
            color: var(--accent-blue);
            font-weight: 600;
            margin-bottom: 4px;
        }

        .hot-post-content {
            font-size: 13px;
            color: var(--text-primary);
            margin-bottom: 6px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .hot-post-stats {
            font-size: 11px;
            color: var(--text-secondary);
            display: flex;
            gap: 10px;
        }

        .activity-item {
            padding: 10px;
            margin-bottom: 8px;
            border-left: 2px solid var(--accent-blue);
            background: rgba(0, 212, 255, 0.05);
            border-radius: 4px;
            font-size: 13px;
            animation: slideInRight 0.5s ease-out;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .activity-user {
            color: var(--accent-blue);
            font-weight: 600;
        }

        .activity-time {
            font-size: 11px;
            color: var(--text-secondary);
            display: block;
            margin-top: 4px;
        }

        /* Cards */
        .card {
            background: linear-gradient(135deg, rgba(26, 35, 71, 0.8) 0%, rgba(20, 27, 58, 0.8) 100%);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            color: var(--text-primary);
            overflow: hidden;
            position: relative;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--accent-blue), transparent);
            animation: shimmer 3s infinite;
        }

        .card:hover {
            border-color: var(--accent-blue);
            box-shadow: 0 8px 30px rgba(0, 212, 255, 0.2);
            transform: translateY(-2px);
        }

        /* Buttons */
        .btn {
            border-radius: 12px;
            font-weight: 600;
            padding: 10px 20px;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-outline-primary {
            border: 1px solid var(--accent-blue);
            color: var(--accent-blue);
            background: transparent;
        }

        .btn-outline-primary:hover {
            background: var(--accent-blue);
            color: white;
            box-shadow: 0 4px 15px rgba(0, 212, 255, 0.4);
            transform: translateY(-2px);
        }

        .btn-outline-secondary {
            border: 1px solid var(--text-secondary);
            color: var(--text-secondary);
            background: transparent;
        }

        .btn-outline-secondary:hover {
            background: var(--text-secondary);
            color: var(--bg-primary);
            transform: translateY(-2px);
        }

        .btn-outline-danger {
            border: 1px solid #ef4444;
            color: #ef4444;
            background: transparent;
        }

        .btn-outline-danger:hover {
            background: #ef4444;
            color: white;
            transform: translateY(-2px);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple));
            border: none;
            box-shadow: 0 4px 15px rgba(0, 212, 255, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 212, 255, 0.6);
        }

        /* FAB Button */
        .fab-button {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: white;
            text-decoration: none;
            box-shadow: 0 8px 25px rgba(0, 212, 255, 0.5);
            animation: fabPulse 2s infinite;
            z-index: 1000;
        }

        @keyframes fabPulse {

            0%,
            100% {
                box-shadow: 0 8px 25px rgba(0, 212, 255, 0.5);
            }

            50% {
                box-shadow: 0 8px 35px rgba(0, 212, 255, 0.8);
            }
        }

        .fab-button:hover {
            transform: scale(1.1) rotate(90deg);
            box-shadow: 0 10px 35px rgba(0, 212, 255, 0.8);
        }

        /* Form Controls */
        .form-control {
            background: rgba(26, 35, 71, 0.6);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(26, 35, 71, 0.9);
            border-color: var(--accent-blue);
            color: var(--text-primary);
            box-shadow: 0 0 20px rgba(0, 212, 255, 0.3);
        }

        .form-control::placeholder {
            color: var(--text-secondary);
        }

        /* Images & Videos */
        img,
        video {
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        img:hover,
        video:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 30px rgba(0, 212, 255, 0.3);
        }

        /* Links */
        a {
            color: var(--accent-blue);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        a:hover {
            color: var(--accent-purple);
            text-decoration: none;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-primary);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple));
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--accent-blue);
        }

        /* Mobile Responsive */
        @media (max-width: 1400px) {
            .main-container {
                grid-template-columns: 280px 1fr 320px;
            }
        }

        @media (max-width: 1200px) {
            .main-container {
                grid-template-columns: 1fr 350px;
            }

            .left-sidebar {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .main-container {
                grid-template-columns: 1fr;
                padding: 10px;
            }

            .right-sidebar {
                display: none;
            }

            .center-content {
                border-left: none;
                border-right: none;
            }
        }

        .search-box {
            margin-bottom: 20px;
        }

        .search-box input {
            background: rgba(26, 35, 71, 0.6);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            border-radius: 25px;
            padding: 12px 20px;
            width: 100%;
            transition: all 0.3s ease;
        }

        .search-box input:focus {
            background: rgba(26, 35, 71, 0.9);
            border-color: var(--accent-blue);
            box-shadow: 0 0 20px rgba(0, 212, 255, 0.3);
            outline: none;
        }

        .search-box input::placeholder {
            color: var(--text-secondary);
        }
    </style>
</head>

<body>

    {{-- VIDEO BACKGROUND --}}
    <div class="video-background">
        <video autoplay muted loop playsinline preload="auto">
            <source src="{{ asset('images/background.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>

    <div class="main-container">

        {{-- LEFT SIDEBAR --}}
        <aside class="left-sidebar">
            {{-- LOGO SECTION --}}
            <div class="logo-section">
                <div class="logo-container">
                    <div class="logo-glow"></div>
                    <img src="{{ asset('images/logo.png') }}" alt="TXS Logo" class="logo-img">
                </div>
                <div class="tagline">
                    "Where Trends Come Alive"
                </div>
                <div class="stats-grid">
                    <div class="stat-box">
                        <div class="stat-number" id="totalPosts">0</div>
                        <div class="stat-label">Posts</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-number" id="totalUsers">0</div>
                        <div class="stat-label">Users</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-number" id="totalLikes">0</div>
                        <div class="stat-label">Likes</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-number" id="onlineNow">0</div>
                        <div class="stat-label">Online</div>
                    </div>
                </div>
            </div>
        </aside>

        {{-- CENTER CONTENT --}}
        <main class="center-content">
            {{-- SEARCH BOX --}}
            <div class="search-box">
                <form action="{{ route('search') }}" method="GET">
                    <input type="text" name="q" placeholder="🔍 Cari postingan..." value="{{ request('q') }}"
                        required>
                </form>
            </div>

            @yield('content')
        </main>

        {{-- RIGHT SIDEBAR --}}
        <aside class="right-sidebar">

            {{-- TRENDING REALTIME --}}
            <div class="sidebar-card">
                <h6>
                    <i class="fas fa-fire-alt"></i>
                    Trending Now
                </h6>
                <div id="trendingList">
                    @php
                        $trendingTopics = \App\Models\TrendingTopic::orderByDesc('post_count')->take(8)->get();
                    @endphp
                    @if ($trendingTopics->count() > 0)
                        @foreach ($trendingTopics as $index => $topic)
                            <a href="/trending/{{ $topic->keyword }}"
                                class="trending-item text-decoration-none d-block">
                                <span class="trending-keyword">#{{ $topic->keyword }}</span>
                                <span class="trending-count">{{ $topic->post_count }} posts</span>
                            </a>
                        @endforeach
                    @else
                        <div class="text-center text-secondary py-3">
                            <i class="fas fa-hashtag mb-2" style="font-size: 24px; opacity: 0.3;"></i>
                            <p class="mb-0" style="font-size: 13px;">Belum ada trending</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- ===================== --}}
            {{-- HOT POSTS (DISATUKAN) --}}
            {{-- UI: CODE PERTAMA --}}
            {{-- DATA: CODE KEDUA --}}
            {{-- ===================== --}}
            <div class="sidebar-card">
                <h6>
                    <i class="fas fa-bolt"></i>
                    Hot Posts
                </h6>
                <div id="hotPosts">
                    @php
                        $hotPosts = \App\Models\Post::withCount(['likes', 'comments'])
                            ->orderByDesc('likes_count')
                            ->take(5)
                            ->get();
                    @endphp

                    @if ($hotPosts->count() > 0)
                        @foreach ($hotPosts as $post)
                            <a href="/post/{{ $post->id }}" class="hot-post text-decoration-none d-block">
                                <div class="mb-2 p-2 rounded" style="background: rgba(255,255,255,0.05);">
                                    <strong>{{ $post->username }}</strong><br>
                                    {{ Str::limit($post->content, 50) }}<br>
                                    ❤️ {{ $post->likes_count }}
                                </div>
                            </a>
                        @endforeach
                    @else
                        <div class="text-center text-secondary py-3">
                            <i class="fas fa-fire-alt mb-2" style="font-size: 24px; opacity: 0.3;"></i>
                            <p class="mb-0" style="font-size: 13px;">Belum ada post</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- ACTIVITY FEED --}}
            <div class="sidebar-card">
                <h6>
                    <i class="fas fa-stream"></i>
                    Recent Activity
                </h6>
                <div id="activityFeed">
                    @php
                        $recentActivities = \App\Models\Post::latest()->take(6)->get();
                    @endphp
                    @if ($recentActivities->count() > 0)
                        @foreach ($recentActivities as $activity)
                            <div class="activity-item">
                                <span class="activity-user">{{ $activity->username }}</span> posted
                                <span class="activity-time">{{ $activity->created_at->diffForHumans() }}</span>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center text-secondary py-3">
                            <i class="fas fa-inbox mb-2" style="font-size: 24px; opacity: 0.3;"></i>
                            <p class="mb-0" style="font-size: 13px;">Belum ada aktivitas</p>
                        </div>
                    @endif
                </div>
            </div>

        </aside>

    </div>

    {{-- FAB BUTTON --}}
    <a href="{{ route('post.create') }}" class="fab-button">
        <i class="fas fa-plus"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const video = document.querySelector('.video-background video');
            if (video) {
                video.play().catch(function(error) {
                    console.log('Video autoplay was prevented:', error);
                });
            }
        });

        function animateCounter(element, target) {
            let current = 0;
            const increment = target / 50;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    element.textContent = target;
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(current);
                }
            }, 30);
        }

        window.addEventListener('DOMContentLoaded', () => {
            animateCounter(document.getElementById('totalPosts'), {{ \App\Models\Post::count() }});
            animateCounter(document.getElementById('totalUsers'),
                {{ \DB::table('posts')->distinct('username')->count('username') }});
            animateCounter(document.getElementById('totalLikes'), {{ \App\Models\Like::count() }});
            animateCounter(document.getElementById('onlineNow'), Math.floor(Math.random() * 50) + 10);
        });

        setInterval(() => {
            // Tambahkan AJAX call untuk update activity feed
        }, 30000);
    </script>
</body>

</html>
