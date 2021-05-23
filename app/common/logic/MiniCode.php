<?php

// +-------------------------------------------------------
// | 生成小程序码逻辑层
// +-------------------------------------------------------

declare(strict_types=1);

namespace app\common\logic;

use app\common\lib\easywechat\MiniProgram;

class MiniCode
{
    /**
     * 首页小程序码
     */
    public static function index(array $param)
    {
        $type = 'index'; //小程序码存放目录
        $path = config('page.index'); //小程序首页路径
        return app(MiniProgram::class)->miniCode($path, $param, $type);
    }
}
