<?php

namespace App\Console\Commands;

use App\Enums\NewsSourcesEnum;
use App\Services\NewsContext;
use Illuminate\Console\Command;

class FetchNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-news {--source=} {--list}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        try {
            $list = $this->option('list');

            $availableSources = NewsSourcesEnum::getAvailableSources();

            if ($list) {
                $this->info(sprintf('Available sources: %s', implode(', ', $availableSources)));
                die;
            }

            /**
             * @var NewsContext $newsService
             */
            $newsService = app()->make(NewsContext::class);

            $sources = $this->option('source');

            if ($sources) {
                $sources = explode(',', $sources);

                // Get the intersection of the provided sources
                $matchedSources = array_intersect($sources, NewsSourcesEnum::getAvailableSources());

                if (empty($matchedSources)) {
                    $this->error('Invalid source(s) provided');
                    die;
                }

                foreach ($matchedSources as $source) {
                    $this->info('Fetching news from ' . $source);

                    // Set the strategy for each matched source
                    $newsService->setStrategy(NewsSourcesEnum::from($source)->getSource());
                }
            } else {
                // If no source is provided, fetch news from all available sources
                foreach ($availableSources as $source) {
                    $this->info(sprintf('Fetching news from %s', $source));

                    $newsService->setStrategy(NewsSourcesEnum::from($source)->getSource());
                }
            }

            $newsService->saveNews();

            $this->info('News sent to queue, please wait for the process to finish');
        } catch (\Exception $e) {
            $this->error(sprintf('Error while fetching news: %s', $e->getMessage()));
        }
    }
}
