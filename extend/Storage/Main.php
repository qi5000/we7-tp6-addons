<?php

namespace Storage;

/**
 * 本地存储
 */
class Main
{
    /**
     * 文件上传
     * 
     * return app(\Storage\Main::class)->upload('image');
     */
    public function upload(string $name, string $type = 'image')
    {
        // $config = [
        //     'type' => 1,
        //     'bucket' => 'chenduxiu',
        //     'domain' => 'https://test.itqaq.com',
        //     'accessKey' => 'l_OnndRIVj17ZwIKMOZBLorh5dK4BKI8WM0lRzoN',
        //     'secretKey' => '7fXF7wbOWcC5pUJKmGz3N8DU6ZB7u3eehDJWHFe7',
        // ];
        // return (new Kodo($config))->upload($name);

        $config = [
            'type' => 2,
            'bucket' => 'chenduxiu',
            'domain' => 'https://cdn.itqaq.com',
            'endpoint' => 'oss-cn-beijing.aliyuncs.com',
            'accessKey' => 'LTAI4G9Ta4i2UgVPjFKEFgnU',
            'secretKey' => 'QwqugGy9gEUoszjyuQy4G5ycgGaYO3',
        ];
        return (new AliYun($config))->upload($name);


        // $config = [
        //     'type' => 3,
        //     'bucket' => 'chenduxiu-1259508442',
        //     'domain' => 'https://cos2.itqaq.com',
        //     'region' => 'ap-beijing',
        //     'accessKey' => 'AKIDB9ZqvhMPO6WgFaQYBdSzG4fyA7pIjzyq',
        //     'secretKey' => 'ZHlytZz92mzwyiCSQ6EsFKCpJYX0uXuy',
        // ];
        // return (new Tencent($config))->upload($name);


        // app(\Storage\Main::class)->upload('file')
        // return (new Local())->upload($name);
    }

    /**
     * 测试上传
     * 
     *  // app(\Storage\Main::class)->test('file')
     */
    public function test(string $name)
    {
        // $config = [
        //     'type' => 1,
        //     'bucket' => 'chenduxiu',
        //     'domain' => 'https://test.itqaq.com',
        //     'accessKey' => 'l_OnndRIVj17ZwIKMOZBLorh5dK4BKI8WM0lRzoN',
        //     'secretKey' => '7fXF7wbOWcC5pUJKmGz3N8DU6ZB7u3eehDJWHFe7',
        // ];
        // return (new Kodo($config))->upload($name);

        $config = [
            'type' => 2,
            'bucket' => 'chenduxiu',
            'domain' => 'https://cdn.itqaq.com',
            'endpoint' => 'oss-cn-beijing.aliyuncs.com',
            'accessKey' => 'LTAI4G9Ta4i2UgVPjFKEFgnU',
            'secretKey' => 'QwqugGy9gEUoszjyuQy4G5ycgGaYO3',
        ];
        return (new AliYun($config))->upload($name);


        // $config = [
        //     'type' => 3,
        //     'bucket' => 'chenduxiu-1259508442',
        //     'domain' => 'https://cos2.itqaq.com',
        //     'region' => 'ap-beijing',
        //     'accessKey' => 'AKIDB9ZqvhMPO6WgFaQYBdSzG4fyA7pIjzyq',
        //     'secretKey' => 'ZHlytZz92mzwyiCSQ6EsFKCpJYX0uXuy',
        // ];
        // return (new Tencent($config))->upload($name);


        // app(\Storage\Main::class)->upload('file')
        // return (new Local())->upload($name);
    }
}
