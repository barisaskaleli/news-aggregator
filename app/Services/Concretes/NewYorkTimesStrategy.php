<?php

namespace App\Services\Concretes;

use App\Models\Article;

class NewYorkTimesStrategy extends AbstractNewsStrategy
{
    public const SOURCE_ID = 3;

    private const API_URL = 'https://api.nytimes.com/svc/mostpopular/v2/emailed/7.json';

    /**
     * @return bool
     */
    public function getNews(): bool
    {
        $res = $this->getRequest([
            'api-key' => env('NYTIMES_API_KEY')
        ], self::API_URL);

        if (!isset($res['status']) && $res['status'] !== 'OK') {
            return false;
        }

        $news = $this->prepareNews($res['results']);

        return Article::insert($news);
    }

    /**
     * @param array $news
     * @return array
     */
    private function prepareNews(array $news)
    {
        $preparedNews = [];

        foreach ($news as $item) {
            $preparedNews[] = [
                'source_id' => self::SOURCE_ID,
                'title' => $item['title'],
                'source_url' => $item['url'],
                'image_url' => $item['media'][0]['media-metadata'][0]['url'],
                'published_at' => $item['published_date'],
                'author_id' => $this->AuthorfindOrCreate($item['byline']),
                'category_id' => $this->categoryFindOrCreate($item['section'])
            ];
        }

        return $preparedNews;
    }
}
