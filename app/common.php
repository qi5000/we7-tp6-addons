<?php

// +----------------------------------------------------------------------
// | 全局公共函数
// +----------------------------------------------------------------------

/**
 * 操作成功
 *
 * @param string $msg
 * @param string $name
 */
function success(string $msg = "操作成功", $name = 'success')
{
    $code = config('code.' . $name);
    return json(compact('code', 'msg'));
}

/**
 * 返回操作结果
 *
 * @param string $msg
 * @param string $name
 */
function result(string $msg = "操作成功", $name = 'success')
{
    $code = is_numeric($name) ? $name : config('code.' . $name);
    return json(compact('code', 'msg'));
}

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
    $code  = is_numeric($name) ? $name : config('code.' . $name);
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


/**
 * 用于搜索器
 * 去掉数组空字符串,返回所有键
 *
 * @param array $where
 * @param array $keys
 */
function where_filter(array $where, &$keys)
{
    // 去掉数组里的空字符串和null
    $where = array_filter($where, function ($k) {
        return ($k === '' || $k === null) ? false : true;
    });
    // 拿到所有键
    $keys = array_keys($where);
    // 返回数组
    return $where;
}
