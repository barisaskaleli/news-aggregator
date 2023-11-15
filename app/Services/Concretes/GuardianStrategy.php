<?php

namespace App\Services\Concretes;

use App\Models\Article;
use Carbon\Carbon;

class GuardianStrategy extends AbstractNewsStrategy
{
    public const SOURCE_ID = 2;
    private const API_URL = 'https://content.guardianapis.com/search';
    private const AUTHOR_NAME = 'The Guardian';

    /**
     * @return bool
     */
    public function getNews(): bool
    {
        $res = $this->getRequest([
            'api-key' => env('GUARDIAN_API_KEY')
        ], self::API_URL);

        if (!isset($res['response']['status']) && $res['response']['status'] !== 'ok') {
            return false;
        }

        $news = $this->prepareNews($res['response']['results']);

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
                'title' => $item['webTitle'],
                'source_url' => $item['webUrl'],
                'image_url' => $item['blocks']['main']['elements'][0]['assets'][0]['file'] ?? null,
                'published_at' => Carbon::parse($item['webPublicationDate'])->format('Y-m-d H:i:s'),
                'author_id' => $this->authorFindOrCreate(self::AUTHOR_NAME),
                'category_id' => $this->categoryFindOrCreate($item['sectionName'])
            ];
        }

        return $preparedNews;
    }
}
