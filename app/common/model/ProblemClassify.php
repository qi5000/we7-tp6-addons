<?php

declare(strict_types=1);

namespace app\common\model;

/**
 * 常见问题分类
 */
class ProblemClassify extends MicroEngine
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
     * 一对多关联
     * 问题分类关联常见问题
     */
    public function problem()
    {
        return $this->hasMany(Problem::class, 'classify_id', 'id');
    }
}
