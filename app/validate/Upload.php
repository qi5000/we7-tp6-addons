<?php

declare(strict_types=1);

namespace app\validate;

use think\Validate;

/**
 * 文件上传验证
 */
class Upload extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'cert'  => 'require|filesize:2097152|fileExt:pem',
        'image' => 'require|filesize:2097152|fileExt:jpg,jpeg,png,gif',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [
        'cert.require'   => '没有图片上传',
        'cert.filesize'  => '证书文件大小不能超出2M',
        'cert.fileExt'   => '证书文件后缀错误',

        'image.require'  => '没有图片上传',
        'image.filesize' => '图片大小不能超出2M',
        'image.fileExt'  => '该图片类型后缀不支持',
    ];

    /**
     * 验证场景
     */
    protected $scene = [
        'cert'  => ['cert'],
        'image' => ['image'],
    ];
}
