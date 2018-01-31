<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Naux\Mail\SendCloudTemplate;

class SendcloudMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $zbs;
    public $zfpzs;

    public function __construct($zbs,$zfpzs)
    {
        $this->zbs = $zbs;
        $this->zfpzs = $zfpzs;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('tawenxi@qq.com')->cc('630465505@qq.com')
        ->markdown('emails.sendcloud') // 可使用 from、subject、view 、text 、 markdown和 attach 来配置邮件的内容和发送
        ->with([
                'zbs' => $this->zbs,
                'zfpzs' => $this->zfpzs,
        ]);//带参数，通过with方法，具体的参数可以通过依赖注入获得
    }

/**

    TODO:
    - 
    - 这一点Sendto暂时无用处

 */

    public function sendTo($template, $email, array $data)
    {
        $content = new SendCloudTemplate($template, $data);

        \Mail::raw($content, function ($message) use ($email){
        $message->from('tawenxi@qq.com', 'tawenxi');
        $message->to($email);
        });
    }
}
