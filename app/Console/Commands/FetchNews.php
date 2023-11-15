<?php

namespace App\Console\Commands;

use App\Services\Concretes\GuardianStrategy;
use App\Services\Concretes\NewsApiStrategy;
use App\Services\Concretes\NewYorkTimesStrategy;
use App\Services\NewsContext;
use Illuminate\Console\Command;

class FetchNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /**
         * @var NewsContext $newsService
         */
        $newsService = app()->make(NewsContext::class);

        $newsService->setStrategy(new NewsApiStrategy());
        $newsService->setStrategy(new GuardianStrategy());
        $newsService->setStrategy(new NewYorkTimesStrategy());

        $newsService->saveNews();

        $this->info('Done!');
    }
}
