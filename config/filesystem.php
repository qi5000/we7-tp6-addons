<?php

// 消除编辑器常量未定义提示
defined('ATTACHMENT_ROOT') or define('ATTACHMENT_ROOT', '');

return [
    // 默认磁盘
    'default' => env('filesystem.driver', 'local'),
    // 磁盘列表
    'disks'   => [
        'local'  => [
            'type' => 'local',
            'root' => app()->getRuntimePath() . 'storage',
        ],
        'public' => [
            // 磁盘类型
            'type'       => 'local',
            // 磁盘路径
            'root'       => app()->getRootPath() . 'public/storage',
            // 磁盘路径对应的外部URL路径
            'url'        => '/storage',
            // 可见性
            'visibility' => 'public',
        ],
        // 更多的磁盘配置信息
        // 微擎的文件都应存放在
        'w7' => [
            // 磁盘类型
            'type'       => 'local',
            // 磁盘路径
            'root'       => ATTACHMENT_ROOT . module() . '/' . getUniacid(),
            // 磁盘路径对应的外部URL路径
            'url'        => implode('/', [request()->domain(), 'attachment', module(), getUniacid(), '']),
            // 可见性
            'visibility' => 'public',
        ],
        // 小程序码
        'miniCode' => [
            // 磁盘类型
            'type'       => 'local',
            // 磁盘路径
            'root'       => ATTACHMENT_ROOT . module() . '/' . getUniacid() . '/miniCode',
            // 磁盘路径对应的外部URL路径
            'url'        => implode('/', [request()->domain(), 'attachment', module(), getUniacid(), 'miniCode', '']),
        ],
    ],
];
