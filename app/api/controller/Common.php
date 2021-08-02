<?php

declare(strict_types=1);

namespace app\api\controller;

use app\common\lib\easywechat\MiniProgram;
use app\common\logic\Config as ConfigLogic;

class Common
{
    /**
     * 消息推送URL地址
     */
    public function message()
    {
        // 读取系统配置的客服消息token
        $token = ConfigLogic::getValueByKey('msg_token');
        // 客服消息自动回复、响应微信服务器
        app(MiniProgram::class)->response($token);
    }
}
