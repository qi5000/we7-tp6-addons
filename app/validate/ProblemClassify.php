<?php

declare(strict_types=1);

namespace app\validate;

use think\Validate;

/**
 * 常见问题分类
 */
class ProblemClassify extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'name'   => 'require',
        'sort'   => 'require|number',
        'status' => 'require|in:0,1',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [
        'name.require'   => '分类名称不能为空',
        'sort.require'   => '排序值不能为空',
        'sort.number'    => '排序值必须是数字',
        'status.require' => 'status不能为空',
        'status.in'      => 'status只能是0或1',
    ];
}
