<?php

use liang\helper\MicroEngine;

return [
    'jwt' => [
        'iss'    => '', // 签发者
        'aud'    => '', // 接收者
        'exp'    => '', // 过期时间
        'key'    => '', // 访问密钥
        'prefix' => (MicroEngine::isMicroEngine() ? MicroEngine::getModuleName() : 'jwt') . '_', // 缓存前缀
    ],
];
