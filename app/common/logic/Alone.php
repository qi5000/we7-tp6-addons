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
}
