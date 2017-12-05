<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Model\Respostory\GetSqlResult;
use App\Model\Respostory\Http;
use App\Model\Tt\Data;
use App\Model\Respostory\Getsqzb;
use App\Model\Respostory\Guzzle;



class PullZfpz implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Data;

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
    public function handle(Guzzle $guzzle,GetSqlResult $getdetail)
    {

        $zb_data = $guzzle->get_ZB();
        $collection = collect($zb_data);
        $collection = $collection->map(function ($item) {
        \App\Model\Zb::updateOrCreate(['ZBID' => $item['ZBID']], $item);
        });

        $zfpzdatas = $getdetail->getdata($this->zfpz, [
            ["'20170101'", "'20170801'"], //每年修改
            ["'20170821'", "to_char(sysdate,'yyyymmdd')"],
        ]);
        foreach ($zfpzdatas as $zfpzdata) {
            \App\Model\Zfpz::updateOrCreate(['PDH' => $zfpzdata['PDH']], $zfpzdata);
        }
        info('SUCCESS-更新收支指标成功');          
    }
}
