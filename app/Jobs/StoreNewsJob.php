<?php

namespace App\Jobs;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class StoreNewsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private array $news)
    {
        Log::info('Job Constructed', ['news' => $this->news]);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Article::create($this->news);
        } catch (\Exception $e) {
            Log::error('StoreNewsJob Job Failed', ['error' => $e->getMessage()]);
        }
    }
}
