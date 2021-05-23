<?php

// 容器Provider定义文件

return [
    // 自定义异常处理机制
    // 后台管理系统采用前后台分离时使用
    'think\exception\Handle' => Exception\ApiExceptionHandle::class,
];
