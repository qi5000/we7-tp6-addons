<?php

declare(strict_types=1);

namespace app\subscribe;

use think\facade\Log;

class Record
{
    /**
     * 订阅消息
     *
     * @param array $data
     * 
     * @example event('Subscribe', $data);
     */
    public function onSubscribe($data)
    {
        Log::record(json_encode($data, JSON_UNESCAPED_UNICODE), 'subscribe');
    }
}
