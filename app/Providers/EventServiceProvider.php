<?php

namespace App\Providers;

use App\Model\Zb;
use App\Model\Zfpz;
use App\Scopes\KJNDScope;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * 事情的发生有三种方式：
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],  
        //第一种最传统的方式：定义一个Event类和一个Listener类，然后event(new Event(参数))来点燃事件
        'MyEvent' => [
            'App\Listeners\MyListener@whenMyEvent',
        ],
        //\Event::fire('Mysubscribe','hello I am coming');
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Zb::addGlobalScope(new KJNDScope);
        Zfpz::addGlobalScope(new KJNDScope);
    }


    protected $subscribe = [
        'App\Listeners\UserEventSubscriber',
    ];
    //第三钟方法：定义一个事件订阅器，
}
