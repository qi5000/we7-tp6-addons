<?php

declare(strict_types=1);

namespace app\api\controller;

/**
 * 小程序客服消息
 */
class Message
{
    /**
     * 消息推送URL地址
     */
    public function reply()
    {
        // 读取系统配置的token
        $token = '123456';
        // 消息推送接入验证
        app('EasyWeChat')->checkSignature($token);
        // 客服消息自动回复逻辑处理
        \app\api\logic\Message::reply();
    }
}
