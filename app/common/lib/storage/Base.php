<?php

// +----------------------------------------------------------------------
// | 文件存储封装类
// +----------------------------------------------------------------------
// | Author: liang <23426945@qq.com>
// +----------------------------------------------------------------------

namespace app\common\lib\storage;

use app\common\lib\easywechat\MiniProgram;
use liang\MicroEngine;
use app\validate\Upload;

abstract class Base
{
    protected $msg   = 200;  //上传成功状态码
    protected $fault = 201;  //上传失败状态码

    /**
     * 文件上传统一方法
     *
     * @param string $name  文件字段域
     * @param string $scene 上传验证场景
     */
    abstract function upload(string $name, string $scene);

    // +------------------------------------------------
    // | 设置文件存储目录
    // +------------------------------------------------

    /**
     * 本地存储
     * 文件存储在本地服务器
     */
    public function localPath()
    {
        return \think\facade\Filesystem::getDiskConfig('w7', 'root');
    }

    /**
     * 云存储
     */
    public function storagePath()
    {
        return MicroEngine::getCloudStoragePath();
    }

    // +------------------------------------------------
    // | 上传文件中需要的功能方法
    // +------------------------------------------------

    /**
     * 返回文件在云存储中的存放路径
     */
    public function buildSaveName($file)
    {
        // 生成随机文件名
        $filename = sha1(date('YmdHis', time()) . uniqid() . mt_rand(1, 1e9)) . '.' . $file->getOriginalExtension();
        // 在云存储中的存放路径
        return $this->storagePath() . '/' . $filename;
    }

    /**
     * 判断是否有上传文件
     * 
     * @param $name 文件域字段名
     */
    public function checkUpload(string $name, string $scene)
    {
        try {
            $file = request()->file($name);
            if (!$file) throw new \Exception('没有文件上传');
        } catch (\Exception $e) {
            return $this->fail($e->getMessage());
        }
        if (is_array($file)) {
            // 多文件上传
            $error = [];
            $success = [];
            foreach ($file as $value) {
                try {
                    // 上传验证
                    validate(Upload::class)->scene($scene)->check([$scene => $value]);
                    if (!app(MiniProgram::class)->checkImage($value->getRealPath())) {
                        fault('系统检测到图片内包含非法内容');
                    }
                    $success[] = $value;
                } catch (\Exception $e) {
                    $error[] = [
                        'file'    => $value->getOriginalName(),
                        'message' => $e->getMessage(),
                    ];
                }
            }
            return compact('success', 'error');
        } else {
            // 单文件上传
            try {
                // 上传验证
                validate(Upload::class)->scene($scene)->check([$scene => $file]);
            } catch (\Exception $e) {
                return $this->fail($e->getMessage());
            }
            if (!app(MiniProgram::class)->checkImage($file->getRealPath())) {
                return $this->fail('系统检测到图片内包含非法内容');
            }
            return $file;
        }
    }

    // +------------------------------------------------
    // | 文件上传接口统一返回值
    // +------------------------------------------------

    /**
     * 多文件上传
     *
     * @param array  $data
     * @param string $msg
     * @param array  $error
     */
    public function data(array $data, array $error = [], string $msg = '上传成功')
    {
        $code = $this->msg;
        return json((compact('code', 'msg', 'data', 'error')));
    }

    /**
     * 上传成功
     */
    public function msg(string $url, string $msg = '上传成功')
    {
        $code = $this->msg;
        return json(compact('code', 'msg', 'url'));
    }

    /**
     * 上传失败
     */
    public function fail(string $msg = '上传失败')
    {
        $code = $this->fault;
        return json(compact('code', 'msg'));
    }
}
