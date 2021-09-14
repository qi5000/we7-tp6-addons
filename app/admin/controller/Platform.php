<?php

declare(strict_types=1);

namespace app\admin\controller;

use app\common\logic\Platform as LogicPlatform;

class Platform
{
    /**
     * 平台信息数据表格
     *
     * @param integer $page
     * @param integer $limit
     */
    public function data(int $page = 1, int $limit = 10)
    {
        $data = LogicPlatform::getLists($page, $limit);
        return json(array_merge(['code' => 0, 'msg' => '平台信息'], $data));
    }

    /**
     * 切换绑定的平台
     *
     * @param integer $uniacid
     */
    public function bind(int $uniacid)
    {
        LogicPlatform::bind($uniacid);
        return success('切换绑定成功');
    }
}
