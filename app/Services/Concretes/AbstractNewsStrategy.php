<?php

namespace App\Services\Concretes;

use App\Models\Author;
use App\Models\Category;
use App\Models\Source;
use App\Services\NewsStrategyInterface;
use Illuminate\Support\Facades\Http;

abstract class AbstractNewsStrategy implements NewsStrategyInterface
{
    /**
     * @return mixed
     */
    abstract public function getNews();

    /**
     * @param array $parameters
     * @param string $url
     * @return array
     */
    protected function getRequest(array $parameters, string $url): array
    {
        $req = Http::get($url, $parameters);

        if (!$req->ok()) {
            return [];
        }

        return $req->json();
    }

    /**
     * @param string $author
     * @return int
     */
    protected function authorFindOrCreate(string $authorName): int
    {
        $author = Author::where('name', $authorName)->first();

        if ($author) {
            return $author->id;
        }

        $author = Author::firstOrCreate([
            'name' => $authorName
        ]);

        return $author->id;
    }

    /**
     * @param string $category
     * @return int
     */
    protected function categoryFindOrCreate(string $categoryName): int
    {
        $category = Category::where('name', $categoryName)->first();

        if ($category) {
            return $category->id;
        }

        $category = Category::firstOrCreate([
            'name' => $categoryName
        ]);

        return $category->id;
    }

    /**
     * @param string $source
     * @return int
     */
    protected function sourceFindOrCreate(string $sourceName): int
    {
        $source = Source::where('name', $sourceName)->first();

        if ($source) {
            return $source->id;
        }

        $source = Source::firstOrCreate([
            'name' => $sourceName
        ]);

        return $source->id;
    }
}
