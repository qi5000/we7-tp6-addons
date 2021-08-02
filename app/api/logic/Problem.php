<?php

declare(strict_types=1);

namespace app\api\logic;

use app\common\model\Problem as ModelProblem;
use app\common\model\ProblemClassify as ModelProblemClassify;

class Problem
{
    /**
     * 问题列表
     */
    public static function getLists($page, $limit): array
    {
        $model = ModelProblem::field('title,answer')->scope('sort');
        $count = $model->count();
        $list  = $model->page($page, $limit)->select();
        return compact('count', 'list');
    }

    /**
     * 问题列表(有分类)
     */
    public static function getClassifyLists($page, $limit): array
    {
        $model = ModelProblemClassify::with([
            'problem' => function ($query) {
                $query->field('id,classify_id,title,answer')
                    ->scope('sort')
                    ->visible(['title', 'answer']);
            }
        ])->field('id,name')->scope('sort');
        $count = $model->count();
        $list  = $model->page($page, $limit)->hidden(['id'])->select();
        return compact('count', 'list');
    }
}
