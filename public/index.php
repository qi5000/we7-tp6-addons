<?php
// +----------------------------------------------------------------------
// | 微擎 ThinkPHP 6.0 框架
// +----------------------------------------------------------------------
// | Author: 辰风沐阳 <23426945@qq.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]
namespace think;

require __DIR__ . '/../vendor/autoload.php';

// 执行HTTP应用并响应
$http = (new App())->http;

$mobule = substr(basename(__FILE__), 0, strrpos(basename(__FILE__), '.') );
$response = $http->name($mobule)->run();

$response->send();

$http->end($response);
