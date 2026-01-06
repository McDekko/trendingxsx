<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\TrendingTopic;

class TrendingSeeder extends Seeder
{
    public function run(): void
    {
        $topics = [
            'laravel', 'php', 'ai', 'openai', 'railway',
            'herd', 'sqlite', 'webdev', 'programming', 'startup'
        ];

        foreach ($topics as $topic) {
            TrendingTopic::create([
                'keyword' => $topic,
                'post_count' => 5
            ]);

            for ($i = 0; $i < 5; $i++) {
                Post::create([
                    'username' => 'anon_' . rand(1000,9999),
                    'content' => "Ini posting viral tentang #{$topic}",
                ]);
            }
        }
    }
}
