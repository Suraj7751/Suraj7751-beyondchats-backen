<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;
use App\Models\Article;
use Illuminate\Support\Str;

class ScrapeBeyondChats extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'scrape:beyondchats';

    /**
     * The console command description.
     */
    protected $description = 'Scrape 5 oldest articles from BeyondChats blog';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Scraping BeyondChats blogs...');

        // 1️⃣ Fetch blog listing page
        $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'
            ])
            ->timeout(30)
            ->retry(3, 5000)
            ->get('https://beyondchats.com/blogs/');

        if (!$response->successful()) {
            $this->error('Failed to fetch blog listing page');
            return;
        }

        $crawler = new Crawler($response->body());

        // 2️⃣ Collect blog links
        $links = $crawler->filter('a')->each(function ($node) {
            return $node->attr('href');
        });

        $blogLinks = collect($links)
            ->filter(fn ($link) => $link && str_contains($link, '/blogs/'))
            ->unique()
            ->values();

        // Take last 5 (oldest)
        $blogLinks = $blogLinks->slice(-5);

        foreach ($blogLinks as $url) {

            $fullUrl = str_starts_with($url, 'http')
                ? $url
                : 'https://beyondchats.com' . $url;

            // Skip if already exists
            if (Article::where('source_url', $fullUrl)->exists()) {
                $this->line("Skipped (already exists): $fullUrl");
                continue;
            }

            // 3️⃣ Fetch individual blog page
            $blogResponse = Http::withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'
                ])
                ->timeout(30)
                ->retry(3, 5000)
                ->get($fullUrl);

            if (!$blogResponse->successful()) {
                $this->line("Failed to fetch: $fullUrl");
                continue;
            }

            $blogCrawler = new Crawler($blogResponse->body());

            // 4️⃣ Extract title safely
            $title = $blogCrawler->filter('h1')->count()
                ? $blogCrawler->filter('h1')->first()->text()
                : null;

            // 5️⃣ Extract content safely
            $content = $blogCrawler->filter('article')->count()
                ? $blogCrawler->filter('article')->text()
                : null;

            if (!$title || !$content) {
                $this->line("Skipped (missing content): $fullUrl");
                continue;
            }

            // 6️⃣ Save to database
            Article::create([
                'title' => $title,
                'slug' => Str::slug($title),
                'content' => trim($content),
                'source_url' => $fullUrl,
            ]);

            $this->info("Saved: $title");
        }

        $this->info('Scraping completed successfully.');
    }
}
