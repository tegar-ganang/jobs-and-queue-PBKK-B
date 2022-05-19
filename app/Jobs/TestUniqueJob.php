<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TestUniqueJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $jobId = 'Job'; 

    public function __construct()
    {
        //
    }

    public function uniqueId()
    {
        return $this->jobId;
    }
   
    public function handle()
    {
        Log::info('Running job' ,['id' => $this->jobId] );
    }
}
