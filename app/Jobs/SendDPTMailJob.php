<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Carbon\Carbon;
use App\Mail\SendcloudMail;

class SendDPTMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $zbs;
    public $zfpzs;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($zbs, $zfpzs)
    {
        $this->zbs = $zbs;
        $this->zfpzs = $zfpzs;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $useremail = 'tawenxi@qq.com';
        \Mail::to($useremail)->send(new SendcloudMail($this->zbs,$this->zfpzs));
    }
}
