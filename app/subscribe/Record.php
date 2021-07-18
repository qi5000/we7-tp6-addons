<?php

declare(strict_types=1);

namespace app\subscribe;

use think\facade\Log;
use think\facade\Event;

class Record
{
    /**
     * 订阅消息
     *
     * @param array $data
     * 
     * @example event('Subscribe', $data);
     */
    // public function onSubscribe($data)
    // {
    //     Log::record(json_encode($data, JSON_UNESCAPED_UNICODE), 'subscribe');
    // }

    public function message(array $data)
    {
        $data = encode($data);
        Log::record($data, 'message');
    }

    // public function subscribe(Event $event)
    // {
    //     // $event->listen('message', [$this, 'message']);
    // }
}
