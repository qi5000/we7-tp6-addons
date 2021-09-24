<?php
// +-----------------------------------------------------------
// | 全局自定义函数
// +-----------------------------------------------------------
// | Author: liang <23426945@qq.com>
// +-----------------------------------------------------------

use liang\MicroEngine;

// +-----------------------------------------------------------
// | 接口数据格式
// +-----------------------------------------------------------

/**
 * 操作成功
 *
 * @param string $msg
 * @param string $name
 */
function success(string $msg = "操作成功", $state = 'success')
{
    $code = config('code.' . $state);
    return json(compact('code', 'msg'));
}

/**
 * 操作失败、有错误发生
 *
 * @param string  $msg
 * @param integer $code
 */
function fault(string $msg = "", $state = 'fault')
{
    $code = config('code.' . $state);
    throw new \Exception($msg, $code);
}

/**
 * 返回数据
 *
 * @param array   $data
 * @param string  $msg
 * @param mixed   $code
 */
function data(array $data, string $msg = "获取成功", $state = 'success')
{
    $code = config('code.' . $state);
    return json(compact('code', 'msg', 'data'));
}

// +-----------------------------------------------------------
// | 功能相关
// +-----------------------------------------------------------

/**
 * 计算两点地理坐标之间的距离
 * 
 * @param  $longitude1 起点经度
 * @param  $latitude1  起点纬度
 * @param  $longitude2 终点经度 
 * @param  $latitude2  终点纬度
 * @param  $unit       单位 1:米 2:公里
 * @param  $decimal    精度 保留小数位数
 */
function getDistance($longitude1, $latitude1, $longitude2, $latitude2, $unit = 2, $decimal = 2)
{
    $EARTH_RADIUS = 6370.996; // 地球半径系数
    $PI = 3.1415926;

    $radLat1 = $latitude1 * $PI / 180.0;
    $radLat2 = $latitude2 * $PI / 180.0;

    $radLng1 = $longitude1 * $PI / 180.0;
    $radLng2 = $longitude2 * $PI / 180.0;

    $a = $radLat1 - $radLat2;
    $b = $radLng1 - $radLng2;

    $distance = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2)));
    $distance = $distance * $EARTH_RADIUS * 1000;

    if ($unit == 2) {
        $distance = $distance / 1000;
    }
    return round($distance, $decimal);
}

// +----------------------------------------------------------------------
// | 数据格式转换
// +----------------------------------------------------------------------

/**
 * 模型搜索器参数构造函数
 *
 * @param array $keys
 * @param array $where
 */
function where_filter(&$keys, array $where)
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

/**
 * 对数据进行json_encode编码并且中文不转码
 */
function encode($data)
{
    return json_encode($data, JSON_UNESCAPED_UNICODE);
}

/**
 * 将数组数据转为查询字符串
 */
function queryString($data)
{
    $link = '';
    foreach ($data as $key => $value) {
        $link .= $key . '=' . trim($value) . '&';
    }
    return rtrim($link, '&');
}

/**
 * 查询字符串转为数组
 * 
 * @param string $params
 */
function queryStringToArray(string $params)
{
    $data = []; // 附加参数
    $array = explode('&', $params);
    foreach ($array as $value) {
        $temp = explode('=', $value);
        $data[$temp[0]] = $temp[1];
    }
    return $data;
}

// +----------------------------------------------------------------------
// | 数据格式化
// +----------------------------------------------------------------------

/**
 * 将时间戳格式化为日期时间
 *
 * @param $timestamp
 * @param $format
 */
function formatTime($timestamp, $format = 'Y-m-d H:i:s')
{
    return $timestamp ? date($format, $timestamp) : '';
}

/**
 * 格式化金额
 */
function formatMoney($money)
{
    return floatval(sprintf('%.2f', $money));
}

// +----------------------------------------------------------------------
// | 其他自定义函数
// +----------------------------------------------------------------------

/**
 * 处理编辑器报红
 */
if (!function_exists('tablename')) {
    function tablename(string $table)
    {
    }
}

/**
 * 给小程序前端提供图片
 */
function appletImg($img)
{
    if (MicroEngine::isMicroEngine()) {
        $mobule = MicroEngine::getModuleName();
        return request()->domain() . "/addons/{$mobule}/public/wxapp/" . $img;
    } else {
        return request()->domain() . "/wxapp/{$img}";
    }
}

/**
 * 发布消息队列任务时使用
 * 用于topthink/think-queue
 * 
 * @param  string $class
 * @param  string $action
 * @return string app\queue\task@fire
 */
function getJob(string $class, string $action)
{
    return implode('@', [$class, $action]);
}
