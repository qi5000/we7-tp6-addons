<?php

declare(strict_types=1);

namespace app\admin\controller;

class Test
{
    public function index()
    {
        return success('后台接口访问成功');
        // return data([], 'success');
    }
}
