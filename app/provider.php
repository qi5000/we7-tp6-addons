<?php

use app\Request;

// 容器Provider定义文件
return [
    'think\Request'          => Request::class,
    // 系统默认异常处理类
    'think\exception\Handle' => app\ExceptionHandle::class,
    // 自定义异常处理类
    'think\exception\Handle' => Exception\ApiExceptionHandle::class,
    // EasyWeChat 微信支付功能封装
    'Payment' => app\common\lib\easywechat\Payment::class,
    // EasyWeChat 小程序功能封装
    'MiniProgram' => app\common\lib\easywechat\MiniProgram::class,
];
