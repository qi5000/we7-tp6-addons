<?php

use app\Request;

// 容器Provider定义文件
return [
    'think\Request'          => Request::class,
    // 'think\exception\Handle' => app\ExceptionHandle::class, // 默认异常处理类
    'think\exception\Handle' => liang\ApiExceptionHandle::class, // 自定义异常处理类
];
