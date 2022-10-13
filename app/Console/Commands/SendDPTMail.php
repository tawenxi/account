<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\ZbRepository;
use App\Repositories\ZfpzRepository;
use Carbon\Carbon;
use App\Mail\SendcloudMail;
use App\Jobs\SendDPTMailJob;

class SendDPTMail extends Command
{
    private $repository_zb;
    private $repository_zfpz;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendmail:dpt {days?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send email to me';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ZfpzRepository $repository_zfpz,
                                ZbRepository $repository_zb)
    {
        $this->repository_zfpz = $repository_zfpz;
        $this->repository_zb = $repository_zb;
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $headers = ['LR_RQ', 'ZY', 'JE'];
        $date = $this->argument('days')?
        str_replace('-', '', Carbon::parse("-{$this->argument('days')} days")->toDateString()):
        date("Ymd");
        $zbs = $this->repository_zb->orderBy('LR_RQ','desc')->findwhere([['LR_RQ','>=',$date]],$headers);
        $headers = ['QS_RQ', 'ZY', 'JE','SKR'];
        $zfpzs = $this->repository_zfpz->orderBy('QS_RQ','desc')->findwhere([['QS_RQ','>=',$date]],$headers);
        $useremail = 'meijiangcaizheng@163.com';

        //SendDPTMailJob::dispatch($zbs,$zfpzs);//要接模型而不能接收模型集合
        \Mail::to($useremail)->send(new SendcloudMail($zbs,$zfpzs)); //StarterMail为第3步创建的邮件类
    }
}
