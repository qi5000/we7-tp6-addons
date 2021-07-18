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
 * 发生错误
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
 * 对数据进行json_encode编码并且中文不转码
 */
function encode($data)
{
    return json_encode($data, JSON_UNESCAPED_UNICODE);
}

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

/**
 * 用于构建模型搜索器参数
 * 去掉数组空字符串,返回所有键
 *
 * @param array $keys
 * @param array $where
 */
function where_filter(&$keys, array $where)
{
    // 使用示例
    // $where = where_filter($keys, $where);
    // ModelUser::withSearch($keys, $where)->select();

    // 去掉数组里的空字符串和null
    $where = array_filter($where, function ($k) {
        return ($k === '' || $k === null) ? false : true;
    });
    // 拿到所有键
    $keys = array_keys($where);
    // 返回数组
    return $where;
}
