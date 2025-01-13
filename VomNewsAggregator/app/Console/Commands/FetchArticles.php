<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FetchArticles extends Command
{
    protected $signature = 'fetch:articles';
    protected $description = 'Fetch Articles from selected news sources';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->fetchNewsAPI();
        $this->fetchGuardian();
        $this->fetchNYT();
    }

    private function saveArticles(array $articles, string $source)
    {
        $latestDate = DB::table('articles')
            ->where('source', $source)
            ->max('published_at');

        $newArticles = [];
        foreach ($articles as $article) {
            // Default key handling
            $guid = $article['guid'] ?? $article['id'] ?? $article['source']['id'] ?? 'Unknown';
            $category = $article['sectionName'] ?? $article['section'] ?? 'all';
            $thumbnail = $article['fields']['thumbnail'] ?? $article['urlToImage'] ?? $article['multimedia'][0]['url'] ?? 'https://pngimg.com/uploads/newspaper/newspaper_PNG9.png';
            $content= $article['content'] ?? $article['fields']['bodyText'] ?? 'None';
            $link = $article['link'] ?? $article['url'] ?? $article['webUrl'] ?? 'No URL';
            $author = $article['author'] ?? $article['fields']['byline'] ?? $article['byline'] ?? 'Unknown';
            $title = $article['title'] ?? $article['fields']['headline'] ?? 'No Title';
            $description = $article['description'] ?? $article['fields']['trailText'] ?? $article['abstract'] ?? 'No Description';
            $pubDate = $article['published_date'] ?? $article['webPublicationDate'] ?? $article['publishedAt'] ?? '1970-01-01T00:00:00Z';

            // Convert to string if title/description are arrays
            $title = is_array($title) ? implode('', $title) : $title;
            $description = is_array($description) ? implode('', $description) : $description;

            // Standardize publication date format
            $publishedAt = date('Y-m-d H:i:s', strtotime($pubDate));

            // Skip articles that are not newer than the latest date
            if ($latestDate && $publishedAt <= $latestDate) {
                continue;
            }

            //article array for insertion
            $newArticles[] = [
                'article_id' => $guid,
                'title' => $title,
                'source' => $source,
                'category' => $category,
                'description' => $description,
                'content' => $content,
                'url' => $link,
                'author' => $author,
                'thumbnail' => $thumbnail,
                'published_at' => $publishedAt,
            ];
        }

        // Insert all new articles in batch
        DB::table('articles')->insertOrIgnore($newArticles);
    }
    private function fetchNewsAPI()
    {
        $client = new Client();
        $response = $client->get('https://newsapi.org/v2/top-headlines', [
            'query' => [
                'apiKey' => env('NEWS_API_KEY'),
                'country' => 'us'
            ],
        ]);
        $data = json_decode($response->getBody(), true);
        $this->saveArticles($data['articles'], 'NewsAPI');
    }

    private function fetchGuardian()
    {
        $client = new Client();
        $response = $client->get('https://content.guardianapis.com/search', [
            'query' => [
                'api-key' => env('GURDIAN_API_KEY'),
                'show-fields' => 'all'
            ],
        ]);
        $data = json_decode($response->getBody(), true);
        $this->saveArticles($data['response']['results'], 'The Guardian');
    }

    private function fetchNYT()
    {
        $client = new Client();
        $response = $client->get('https://api.nytimes.com/svc/topstories/v2/home.json', [
            'query' => [
                'api-key' => env('NYT_KEY'),

            ],
        ]);
        $data = json_decode($response->getBody(), true);
        $this->saveArticles($data['results'], 'NewYork Times');
    }
}
