<?php

use app\ExceptionHandle;
use app\Request;

// 容器Provider定义文件
return [
    'think\Request'          => Request::class,
    'think\exception\Handle' => ExceptionHandle::class,

    // EasyWeChat 微信支付功能封装
    'Payment' => app\common\lib\easywechat\Payment::class,
    // EasyWeChat 小程序功能封装
    'MiniProgram' => app\common\lib\easywechat\MiniProgram::class,
];
