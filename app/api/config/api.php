<?php

// +----------------------------------------------------------------------
// | JWT 配置
// +----------------------------------------------------------------------

return [
    'jwt' => [
        'iss'    => 'liang',   // 签发者
        'aud'    => 'liang',   // 接收者
        'exp'    => 864000,       // 过期时间,864000秒=10天
        'key'    => 'liang',      // 访问密钥
        'prefix' => 'jwt_',       // 缓存前缀
    ],
];
