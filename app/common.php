<?php

// +----------------------------------------------------------------------
// | 全局公共函数
// +----------------------------------------------------------------------

/**
 * 操作成功
 *
 * @param string  $msg
 * @param integer $code
 */
function msg(string $msg = "", int $code = 0)
{
    throw new \Exception($msg, $code);
}

/**
 * 返回错误信息
 *
 * @param string  $msg
 * @param integer $code
 */
function fault(string $msg = "", int $code = 1)
{
    throw new \Exception($msg, $code);
}

/**
 * 返回数据
 *
 * @param array   $data
 * @param string  $msg
 * @param integer $code
 */
function data(array $data, string $msg = "获取成功", int $code = 0)
{
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
 * 生成指定长度的随机字符串
 *
 * @param integer $length
 * @return string 随机英文数字符串
 */
function getRandString(int $length)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}


// +----------------------------------------------------------------------
// | 微擎相关
// +----------------------------------------------------------------------

/**
 * 获取当前模块标识
 */
function module()
{
    global $_W;
    return $_W['current_module']['name'];
}

/**
 * 返回包含uniacid的数组
 * 
 * @param array $data 附加数据
 */
function uniacid(array $data = [])
{
    global $_W;
    return array_merge(['uniacid' => $_W['uniacid']], $data);
}

/**
 * 获取微擎平台uniacid
 */
function getUniacid()
{
    global $_W;
    return $_W['uniacid'];
}
