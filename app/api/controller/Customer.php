<?php

declare(strict_types=1);

namespace app\api\controller;

use app\common\logic\Config as ConfigLogic;

/**
 * 小程序客服消息
 */
class Customer
{
    /**
     * 消息推送URL地址
     */
    public function reply()
    {
        // 读取系统配置的客服消息token
        $token = ConfigLogic::getByKey('msg_token');
        // 消息推送接入验证
        app('MiniProgram')->checkSignature($token);
        // 客服消息自动回复逻辑处理
        \app\api\logic\Customer::reply();
    }
}