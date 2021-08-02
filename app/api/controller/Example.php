<?php

declare(strict_types=1);

namespace app\api\controller;

use app\api\logic\Subscribe;

/**
 * 使用示例
 */
class Example
{
    /**
     * 订阅消息
     */
    public function subscribe()
    {
        // 辰风沐阳小程序
        $openid = 'oNiWa5CB9VFKgr-TqssteGoieibY';
        // 发送订阅消息
        $data = Subscribe::demo($openid, ['id' => 1, 'uid' => 6]);
        return json($data);
    }
}
