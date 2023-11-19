<?php

namespace App\Enums;

use App\Services\Concretes\GuardianStrategy;
use App\Services\Concretes\NewsApiStrategy;
use App\Services\Concretes\NewYorkTimesStrategy;
use App\Services\NewsStrategyInterface;

enum NewsSourcesEnum: string
{
    case GUARDIAN = 'guardian';
    case NEW_YORK_TIMES = 'new-york-times';
    case NEWS_API = 'news-api';

    /**
     * @return NewsStrategyInterface|\Exception
     * @throws \Exception
     */
    public function getSource(): NewsStrategyInterface|\Exception
    {
        return match ($this) {
            self::GUARDIAN => new GuardianStrategy(),
            self::NEW_YORK_TIMES => new NewYorkTimesStrategy(),
            self::NEWS_API => new NewsApiStrategy(),
            default => throw new \Exception('Unexpected match value'),
        };
    }

    /**
     * @return NewsSourcesEnum[]
     */
    public static function getAvailableSources(): array
    {
        return [
            self::GUARDIAN->value,
            self::NEW_YORK_TIMES->value,
            self::NEWS_API->value
        ];
    }

    public static function getSourceInstances(): array
    {
        return [
            new GuardianStrategy(),
            new NewYorkTimesStrategy(),
            new NewsApiStrategy()
        ];
    }
}
