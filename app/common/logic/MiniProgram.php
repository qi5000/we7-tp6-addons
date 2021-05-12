<?php

declare(strict_types=1);

namespace app\common\logic;

class MiniProgram
{
    // +---------------------------------------------------------------
    // | 小程序码场景
    // +---------------------------------------------------------------

    /**
     * 首页小程序码
     */
    public static function HomeMiniCode(array $param)
    {
        return app('MiniProgram')->miniCode(config('page.index'), $param, 'index');
    }
}
