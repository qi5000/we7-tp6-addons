<?php

namespace think;

require __DIR__ . '/vendor/autoload.php';

// 执行HTTP应用并响应
$http = (new App())->http->run();

\app\common\logic\Notify::main();
