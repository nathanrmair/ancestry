<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Provider;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReIndexProviders extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Provider::deleteIndex();
        Provider::createIndex();
        Provider::putMapping($ignoreConflicts = true);
        Provider::addAllToIndex();
    }
}
