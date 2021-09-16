<?php

declare(strict_types=1);

namespace app\common\subscribe;

use think\facade\Log;
use think\facade\Event;

class Record
{
    public function message(array $data)
    {
        $data = encode($data);
        Log::write($data, 'message');
    }

    public function payment(array $data)
    {
        $data = encode($data);
        Log::write($data, 'payment');
    }

    // public function subscribe(Event $event)
    // {
    //     $event->listen('payment', [$this, 'payment']);
    // }
}
