<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class GetPlayersJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private int $nextCursor;

    /**
     * Create a new job instance.
     */
    public function __construct(int $nextCursor)
    {
        $this->nextCursor = $nextCursor;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("message: 'GetPlayersJob started'", [$this->nextCursor]);
        Artisan::call(
            'app:populate-players-command',
            ['perPage' => $this->nextCursor]
        );
    }
}
