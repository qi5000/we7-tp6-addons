<?php

declare(strict_types=1);

namespace app\common\logic;

use app\common\lib\storage\Factory;

/**
 * 上传文件公共逻辑层
 */
class Upload
{
    /**
     * 上传图片
     */
    public static function image(string $name)
    {
        return Factory::upload($name);
    }

    /**
     * 上传微信商户号证书
     */
    public static function cert(string $name)
    {
        return Factory::upload($name, 'cert', true);
    }
}
