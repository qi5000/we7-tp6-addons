<?php

namespace app\common\logic;

use liang\helper\MicroEngine;

class Alone
{
    /**
     * 获取小程序APPID和开发者密钥
     */
    public static function getMiniProgramConfig()
    {
        if (MicroEngine::isMicroEngine()) {
            $config = MicroEngine::getMiniProgramConfig();
        } else {
            $config = Config::getByType('mini_program');
        }
        return $config;
    }

    /**
     * 获取静态资源路径
     */
    public static function getStaticPath()
    {
        if (MicroEngine::isMicroEngine()) {
            return '/addons/' . MicroEngine::getModuleName() . '/public/static';
        } else {
            return '/static';
        }
    }
}
