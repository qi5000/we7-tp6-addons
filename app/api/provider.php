<?php

// 容器Provider定义文件

return [
    // JWT 功能封装
    'jwt' => app\api\lib\JwtAuth::class,
    // 自定义异常处理机制
    'think\exception\Handle' => Exception\ApiExceptionHandle::class,
];
