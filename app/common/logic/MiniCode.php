<?php

// +-------------------------------------------------------
// | 生成小程序码逻辑层
// +-------------------------------------------------------

declare(strict_types=1);

namespace app\common\logic;

use app\common\lib\easywechat\MiniProgram;

/**
 * 小程序
 */
class MiniCode
{
    /**
     * 首页小程序码()
     */
    public static function index()
    {
        $param = 'index'; // 小程序码场景值
        return app(MiniProgram::class)->miniCode('index', $param, '');
    }

    /**
     * 活动详情页小程序码
     *
     * @param array $param 页面参数
     */
    public static function detail(array $param)
    {
        return app(MiniProgram::class)->miniCode('detail', $param, 'activity');
    }
}
