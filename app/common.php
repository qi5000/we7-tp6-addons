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
 * 获取分页参数
 *
 * @param integer $page  默认页码
 * @param integer $limit 默认每页数据条数
 * @return array
 * @example page(...page())
 */
function page(int $page = 1, int $limit = 10)
{
    return [input('page', 1, 'intval') ?? $page, input('limit',10, 'intval') ?? $limit];
}