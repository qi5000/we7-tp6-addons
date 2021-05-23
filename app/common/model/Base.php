<?php

declare(strict_types=1);

namespace app\common\model;

use think\model\concern\SoftDelete;

/**
 * 全局基础模型
 * 
 * @mixin \think\Model
 */
class Base extends \think\Model
{
    // 软删除
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    // +------------------------------------------------
    // | 公共查询范围
    // +------------------------------------------------

    /**
     * 根据user_id字段查询数据
     */
    public function scopeUid($query, $value)
    {
        $query->where('user_id', $value);
    }

    /**
     * 根据merch_id字段查询数据
     */
    public function scopeMid($query, $value)
    {
        $query->where('merch_id', $value);
    }

    /**
     * 根据type字段查询数据
     */
    public function scopeType($query, $value)
    {
        $query->where('type', $value);
    }

    /**
     * 根据status字段查询数据
     */
    public function scopeStatus($query, $value)
    {
        $query->where('status', $value);
    }

    /**
     * 封装常用排序规则
     * 先根据sort降序排列,再根据id字段降序排列
     */
    public function scopeOrder($query)
    {
        $query->order('sort', 'desc')->order('id', 'desc');
    }
}
