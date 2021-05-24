<?php

declare(strict_types=1);

namespace app\index\lib;

class Layui
{
    /**
     * 数据表格搜索
     *
     * @param string $fields
     */
    public static function search(string $fields)
    {
        $array = array_filter(explode(',', $fields));
        $build = [];
        foreach ($array as $v) {
            $key = trim($v);
            if (!empty($key)) $build[$key] = input($key, '', 'trim');
        }
        return $build;
    }

    /**
     * 数据表格
     *
     * @param [type] $msg   描述文字
     * @param [type] $count 数据总数
     * @param [type] $data  当前页数据
     * @param int    $code  状态码
     */
    public static function dataTable($msg, $count, $data, int $code = 0)
    {
        return json(compact('code', 'msg', 'count', 'data'));
    }
}
