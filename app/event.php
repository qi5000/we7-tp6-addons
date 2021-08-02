<?php
// 事件定义文件

return [
    'bind'      => [],
    // 事件监听
    'listen'    => [
        'AppInit'  => [],
        'HttpRun'  => [],
        'HttpEnd'  => [],
        'LogLevel' => [],
        'LogWrite' => [],
    ],
    // 事件订阅
    'subscribe' => [
        app\common\subscribe\Record::class,
    ],
];
