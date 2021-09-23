<?php

declare(strict_types=1);

namespace app\common\model;

/**
 * 常见问题
 */
class Problem extends MicroEngine
{
    // +------------------------------------------------
    // | 查询范围
    // +------------------------------------------------

    /**
     * 排序规则
     */
    public function scopeSort($query)
    {
        $query->order('sort', 'desc');
    }

    // +------------------------------------------------
    // | 模型关联
    // +------------------------------------------------

    /**
     * 一对一相对关联
     * 常见问题反向关联所属问题分类
     */
    public function classify()
    {
        return $this->belongsTo(ProblemClassify::class, 'classify_id', 'id');
    }
}
