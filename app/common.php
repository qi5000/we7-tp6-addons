<?php

// +----------------------------------------------------------------------
// | 全局公共函数
// +----------------------------------------------------------------------

/**
 * 操作成功
 *
 * @param string  $msg
 * @param mixed   $name
 */
function msg(string $msg = "", $name = 'success')
{
    $code = is_numeric($name) ? $name : config('code.' . $name);
    throw new \Exception($msg, $code);
}

/**
 * 返回错误信息
 *
 * @param string  $msg
 * @param integer $code
 */
function fault(string $msg = "", $name = 'fault')
{
    $code = is_numeric($name) ? $name : config('code.' . $name);
    throw new \Exception($msg, $code);
}

/**
 * 返回数据
 *
 * @param array   $data
 * @param string  $msg
 * @param mixed   $code
 */
function data(array $data, string $msg = "获取成功", $name = 'success')
{
    $code = is_numeric($name) ? $name : config('code.' . $name);
    return json(compact('code', 'msg', 'data'));
}

// +----------------------------------------------------------------------
// | 功能相关
// +----------------------------------------------------------------------

/**
 * 获取分页参数
 *
 * @param integer $page  默认页码
 * @param integer $limit 默认每页数据条数
 * @return array
 * @example page(...page())
 */
function page(int $page = 1, int $limit = 10)
{
    return [input('page', 1, 'intval') ?? $page, input('limit', 10, 'intval') ?? $limit];
}
