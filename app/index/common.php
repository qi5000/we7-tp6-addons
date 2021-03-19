<?php

// 后台管理系统
// index 应用公共文件

/**
 * 生成路由地址
 * @example u('index')
 * @example u('index/login')
 * @example u('index/login', ['id' => 1])
 */
function u(...$param)
{
	// 应用 模块 方法
	$app = app('http')->getName();
	$contro = request()->controller();
	$action = request()->action();
	// 微擎框架自带参数
	$weParam = request()->only(['c', 'a', 'eid', 'version_id'], 'get');
	// 路由参数
	$route = explode('/', $param[0]);
	switch ( count($route) ) {
		// u('index')
		case 1:
			// parse_name 控制器驼峰命名转为下划线分隔命名
			$path = ['', parse_name($contro), $route[0]];
			break;
		// u('index/index')
		case 2:
			// parse_name 控制器驼峰命名转为下划线分隔命名
			$path = ['', parse_name($route[0]), $route[1]];
			break;
	}
	$s = implode('/', $path);
	$url = request()->domain() . request()->baseFile() . '?' . queryString($weParam) . '&s=' . $s;
	if ( ! empty($param[1]) ) $url .= '&' . queryString($param[1]);
	return $url;
}

/**
 * 将数组数据转为查询字符串
 */
function queryString($data)
{
	$link = '';
	foreach ($data as $key => $value) {
		$link .= $key . '=' . $value . '&';
	}
	return rtrim($link, '&');
}