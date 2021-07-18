<?php

use app\Request;

// 容器Provider定义文件
return [
    'think\Request'          => Request::class,
    // 系统默认异常处理类
    // 'think\exception\Handle' => app\ExceptionHandle::class,
    // 自定义异常处理类
    'think\exception\Handle' => exception\ApiExceptionHandle::class,
];
