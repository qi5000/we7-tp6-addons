<?php

declare(strict_types=1);

namespace app\index\controller;

use app\BaseController;

class Base extends BaseController
{
    public function index()
    {
        return view('list');
    }
}
