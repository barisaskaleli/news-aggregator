<?php

namespace App\Services\Concretes;

use App\Models\Article;
use Carbon\Carbon;

class NewsApiStrategy extends AbstractNewsStrategy
{
    public const SOURCE_ID = 2;
    private const API_URL = 'https://newsapi.org/v2/top-headlines';
    private const CATEGORIES = [
        'business',
        'entertainment',
        'general',
        'health',
        'science',
        'sports',
        'technology'
    ];

    /**
     * @return bool
     * @throws \Exception
     */
    public function getNews(): bool
    {
        $category = self::CATEGORIES[random_int(0, \count(self::CATEGORIES) - 1)];

        $res = $this->getRequest([
            'apiKey' => env('NEWS_API_KEY'),
            'country' => 'de',
            'category' => $category
        ], self::API_URL);

        if (!isset($res['status']) && $res['status'] !== 'ok') {
            return false;
        }

        $news = $this->prepareNews($res['articles'], $category);

        return $this->storeNewsThroughQueue($news);
    }

    /**
     * @param array $news
     * @param string $category
     * @return array
     */
    private function prepareNews(array $news, string $category)
    {
        $preparedNews = [];

        foreach ($news as $item) {
            $preparedNews[] = [
                'source_id' => $item['source']['name'] ? $this->sourceFindOrCreate($item['source']['name']) : self::SOURCE_ID,
                'title' => $item['title'],
                'content' => $item['content'] ?? null,
                'source_url' => $item['url'],
                'image_url' => $item['urlToImage'],
                'published_at' => Carbon::parse($item['publishedAt'])->format('Y-m-d H:i:s'),
                'author_id' => $this->authorFindOrCreate($item['author']),
                'category_id' => $this->categoryFindOrCreate($category)
            ];
        }

        return $preparedNews;
    }
}
