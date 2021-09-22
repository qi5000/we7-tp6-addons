<?php

declare(strict_types=1);

namespace app\common\logic;

use liang\MicroEngine;
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
     * 绝对路径图片
     *
     * @param string $name
     */
    public static function root(string $name)
    {
        $result = Factory::upload($name, 'image', true);
        $array = $result->getData();
        if ($array['code'] != 200) return $result;
        if (isset($array['data'])) {
            // 多图片上传
            $domain = [];
            foreach ($array['data'] as $value) {
                $domain[] = MicroEngine::getUrlByRoot($value);
            }
            $array['domain'] = $domain;
        } else {
            $array['domain'] = MicroEngine::getUrlByRoot($array['url']);
        }
        return json($array);
    }

    /**
     * 上传微信商户号证书
     */
    public static function cert(string $name)
    {
        return Factory::upload($name, 'cert', true);
    }
}
