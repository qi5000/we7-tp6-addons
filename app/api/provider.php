<?php

// 容器Provider定义文件

return [
    // 自定义异常处理机制
    'think\exception\Handle' => Exception\ApiExceptionHandle::class,
];
