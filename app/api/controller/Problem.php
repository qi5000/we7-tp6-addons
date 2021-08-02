<?php

declare(strict_types=1);

namespace app\api\controller;

use app\api\logic\Problem as LogicProblem;

/**
 * 常见问题
 */
class Problem
{
    /**
     * 问题列表
     */
    public function getLists(int $page = 1, int $limit = 10)
    {
        $data = LogicProblem::getLists($page, $limit);
        return data($data, '问题列表');
    }

    /**
     * 问题列表(有分类)
     */
    public function getClassifyLists(int $page = 1, int $limit = 10)
    {
        $data = LogicProblem::getClassifyLists($page, $limit);
        return data($data, '问题列表');
    }
}
