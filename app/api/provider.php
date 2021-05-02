<?php

// 容器Provider定义文件

return [
    // EasyWeChat 功能封装
    'EasyWeChat' => app\api\lib\EasyWeChat::class,
    // 自定义异常处理机制
    'think\exception\Handle' => Exception\ApiExceptionHandle::class,
];
