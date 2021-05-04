<?php

declare(strict_types=1);

namespace app\common\model;

/**
 * 系统配置公共模型
 */
class Config extends MicroEngine
{
    // 设置json类型字段
    protected $json = ['value'];

    // 设置JSON数据返回数组
    protected $jsonAssoc = true;

    // +------------------------------------------------
    // | 查询范围
    // +------------------------------------------------

    /**
     * 根据key字段查询数据
     */
    public function scopeKey($query, $value)
    {
        $query->where('key', $value);
    }

    // +------------------------------------------------
    // | 模型事件
    // +------------------------------------------------

    /**
     * 新增前模型
     * 重写父类方法
     */
    public static function onBeforeInsert($model)
    {
        // 调用父类方法 追加uniacid
        parent::onBeforeInsert($model);
        // 当value是字符串时,框架没有对数据进行json编码处理,此时需要自己手动处理
        is_string($model->value) && $model->value = json_encode($model->value, JSON_UNESCAPED_UNICODE);
    }
}
