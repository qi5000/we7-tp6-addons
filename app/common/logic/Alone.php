<?php

namespace app\common\logic;

use liang\MicroEngine;

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

    /**
     * 获取当前登陆的管理员昵称
     */
    public static function getAdminName()
    {
        if (MicroEngine::isMicroEngine()) {
            global $_W;
            return $_W['username'];
        } else {
            return 'admin';
        }
    }
}
