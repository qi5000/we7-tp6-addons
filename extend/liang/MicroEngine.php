<?php

// +----------------------------------------------------------------------
// | 微擎 TP6.0 框架 微擎相关方法封装
// +----------------------------------------------------------------------
// | Author: liang <23426945@qq.com>
// +----------------------------------------------------------------------

namespace liang;

class MicroEngine
{
    /**
     * 检测当前是否在微擎框架中
     *
     * @return boolean true 微擎模块 false 脱离微擎,独立版
     */
    public static function isMicroEngine()
    {
        global $_W;
        return !empty($_W['uniacid']);
    }

    /**
     * 获取微擎模块标识
     */
    public static function getModuleName()
    {
        global $_W;
        return $_W['current_module']['name'] ?? '';
    }

    /**
     * 获取微擎平台 uniacid
     */
    public static function getUniacid()
    {
        global $_W;
        return $_W['uniacid'] ?? '';
    }

    /**
     * 返回包含微擎uniacid的数组
     * 
     * @param   $data 附加数据
     * @example uniacid();
     * @example uniacid($data);
     */
    public static function uniacid($data = null)
    {
        global $_W;
        $uniacid = self::isMicroEngine() ? ['uniacid' => $_W['uniacid']] : [];
        return is_null($data) ? $uniacid : array_merge($uniacid, $data);
    }

    /**
     * 获取小程序appid和开发者密钥
     */
    public static function getMiniProgramConfig()
    {
        if (self::isMicroEngine()) {
            global $_W;
            return [
                'appid'  => $_W['account']['key'],
                'secret' => $_W['account']['secret'],
            ];
        } else {
            return [];
        }
    }

    // +----------------------------------------------------------------------
    // | 文件存储相关
    // +----------------------------------------------------------------------

    /**
     * 获取本地文件存储目录(绝对路径)
     */
    public static function getLocalStorageDir()
    {
        if (self::isMicroEngine()) {
            return ATTACHMENT_ROOT . self::getModuleName() . '/' . self::getUniacid();
        } else {
            return public_path() . 'storage';
        }
    }

    /**
     * 获取本地文件访问前缀(Url前缀)
     */
    public static function getFileAccessPrefix()
    {
        if (self::isMicroEngine()) {
            return implode('/', [request()->domain(), 'attachment', self::getModuleName(), self::getUniacid(), '']);
        } else {
            return implode('/', [request()->domain(), 'storage', '']);
        }
    }

    /**
     * 获取云存储文件存放目录
     *
     * @param string $prefix 自定义存放目录前缀
     */
    public static function getCloudStoragePath(string $prefix = 'storage')
    {
        if (self::isMicroEngine()) {
            // 微擎
            return implode('/', [self::getModuleName(), self::getUniacid(), date('Ymd')]);
        } else {
            // 独立版
            return ($prefix ? $prefix . '/' : '') . date('Ymd');
        }
    }

    /**
     * 根据图片绝对路径地址转为URL地址
     *
     * @param string $root 图片绝对路径地址
     */
    public static function getUrlByRoot(string $root)
    {
        $domain = request()->domain();
        if (self::isMicroEngine()) {
            // 微擎
            $image = mb_substr($root, mb_strrpos($root, 'attachment'));
        } else {
            // 独立版
            $image = mb_substr($root, mb_strrpos($root, 'storage'));
        }
        return $domain . '/' . $image;
    }

    /**
     * 获取客服消息会话接口地址
     */
    public static function getMsgUrl()
    {
        $route = '/message/reply';
        $domain  = request()->domain();
        // 判断当前环境
        if (self::isMicroEngine()) {
            // 微信模块消息推送地址
            $uniacid = self::getUniacid();
            $module  = self::getModuleName();
            return "{$domain}/app/index.php?i={$uniacid}&c=entry&m={$module}&a=wxapp&do=api&s={$route}";
        } else {
            // 独立版消息推送地址
            return "{$domain}/api.php{$route}";
        }
    }
}
