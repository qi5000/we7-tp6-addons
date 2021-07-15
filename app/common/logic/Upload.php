<?php

declare(strict_types=1);

namespace app\common\logic;

use app\common\lib\storage\Factory;
use liang\helper\MicroEngine;

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
     * 绝对路径图片
     *
     * @param string $name
     */
    public static function root(string $name)
    {
        $result = Factory::upload($name, 'image', true);
        $array = $result->getData();
        if ($array['code'] == 200) {
            $array['domain'] = MicroEngine::geImgUrlByRoot($array['url']);
            return json($array);
        } else {
            return $result;
        }
    }

    /**
     * 上传微信商户号证书
     */
    public static function cert(string $name)
    {
        return Factory::upload($name, 'cert', true);
    }
}
