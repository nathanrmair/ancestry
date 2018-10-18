<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Newsletter;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LoadCsvData extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (($handle = fopen("test1.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if (!\App\Newsletter::where('email', $data[0])->first()) {
                        \App\Newsletter::create(['email' => $data[0], 'subscribed' => 'yes']);
                        echo 'yes<br>';
                    }
            }
            fclose($handle);
        }
    }
}
