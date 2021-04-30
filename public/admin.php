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

// 获取当前文件名
$mobule = substr(basename(__FILE__), 0, strrpos(basename(__FILE__), '.') );

// 入口文件绑定应用
// 当前文件名作为应用名
$response = $http->name($mobule)->run();

$response->send();

$http->end($response);
