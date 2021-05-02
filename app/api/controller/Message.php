<?php

declare(strict_types=1);

namespace app\api\controller;

use app\api\logic\Message as LogicMessage;

class Message
{
    /**
     * 消息推送URL地址
     */
    public function reply()
    {
        $token = '123456';
        LogicMessage::reply($token);
    }
}
