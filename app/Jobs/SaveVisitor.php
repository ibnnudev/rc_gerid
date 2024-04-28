<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SaveVisitor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $ipAddress;

    public function __construct($ipAddress)
    {
        $this->ipAddress = $ipAddress;
    }

    public function handle(): void
    {
        $ip = $this->ipAddress;

        $visitor = \App\Models\Visitor::where('ip_address', $ip)
            ->where('date', date('Y-m-d'))
            ->first();

        if ($visitor) {
            return;
        }

        $country_code = json_decode(file_get_contents("http://ipinfo.io/" . $ip))->country;

        $visitor = new \App\Models\Visitor();
        $visitor->ip_address = $this->ipAddress;
        $visitor->user_agent = request()->header('User-Agent');
        $visitor->date = date('Y-m-d');
        $visitor->country = $country_code;
        $visitor->save();
    }
}
