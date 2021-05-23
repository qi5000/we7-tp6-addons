<?php

// +----------------------------------------------------------------------
// |  系统配置
// +----------------------------------------------------------------------

use think\helper\Str;
use app\common\lib\easywechat\MiniProgram;

return [

    // +-----------------------------------------------------
    // | 独立版配置
    // +-----------------------------------------------------

    // 小程序appid
    [
        'type'  => 'mini_program',
        'key'   => 'appid',
        'value' => '',
    ],
    // 小程序开发者密钥
    [
        'type'  => 'mini_program',
        'key'   => 'secret',
        'value' => '',
    ],

    // +-----------------------------------------------------
    // | 客服消息
    // +-----------------------------------------------------

    [
        'type'  => 'message',
        'key'   => 'msg_token',
        'value' => Str::random(20),
    ],
    [
        'type'  => 'message',
        'key'   => 'msg_url',
        'value' => MiniProgram::replyApi(),
    ],
];
