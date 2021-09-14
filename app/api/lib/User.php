<?php

declare(strict_types=1);

namespace app\api\lib;

use app\common\lib\Filesystem;

class User
{
    /**
     * 用户头像本地化并返回可访问的图片地址
     * 
     * 推荐在用户更新信息时将头像做本地化处理
     *
     * @param string $openid  	微信用户openid
     * @param string $avatarUrl 微信头像URL地址
     */
    public static function avatarLocal(string $openid, string $avatarUrl)
    {
        $path = Filesystem::getLocalStoragePath('avatar');
        $access = Filesystem::getLocalStorageAccess('avatar');
        list($data, $code) = self::avatarLocalCurl($avatarUrl);
        if ($code !== 200) return '';
        // 把URL格式的图片转成base64_encode格式
        $imgBase64Code = "data:image/jpeg;base64," . base64_encode($data);
        $num = preg_match('/^(data:\s*image\/(\w+);base64,)/', $imgBase64Code, $result);
        if ($num == 0 || empty($result)) return '';
        // 头像存放目录不存在时自动创建目录
        file_exists($path) || mkdir($path, 0777, true);
        $type = $result[2]; //得到图片类型 png|jpg|gif
        $storage = "{$path}/{$openid}.{$type}";
        if (file_put_contents($storage, base64_decode(str_replace($result[1], '', $imgBase64Code)))) {
            return "{$access}/{$openid}.{$type}";
        } else {
            return '';
        }
    }

    /**
     * 发送CURL请求
     *
     * @param string $avatarUrl 微信头像URL
     */
    private static function avatarLocalCurl(string $avatarUrl)
    {
        $header = [
            'User-Agent: Mozilla/5.0 (Windows NT 6.1;Win64;x64;rv:45.0) Gecko/20100101 Firefox/45.0',
            'Accept-Language: zh-CN, zh;q = 0.8, en-US;q = 0.5, en;q = 0.3',
            'Accept-Encoding: gzip, deflate',
        ];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $avatarUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_ENCODING, 'gzip');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
        $data = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        return [$data, $code];
    }
}
