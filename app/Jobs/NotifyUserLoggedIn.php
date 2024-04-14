<?php

namespace App\Jobs;

use App\Models\Visitor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyUserLoggedIn implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __invoke()
    {
        Visitor::create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'date' => date('Y-m-d'),
        ]);

        logger()->info('User logged in', [
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'date' => date('Y-m-d'),
        ]);
    }
}
