<?php

namespace App\Services;

class NewsContext
{
    /**
     * @var NewsStrategyInterface[] $strategies
     */
    private $strategies = [];

    /**
     * @param NewsStrategyInterface $strategy
     * @return void
     */
    public function setStrategy(NewsStrategyInterface $strategy): void
    {
        $this->strategies[] = $strategy;
    }

    /**
     * @return mixed
     */
    public function saveNews()
    {
        foreach ($this->strategies as $strategy) {
            $strategy->getNews();
        }
    }
}
