<?php

declare(strict_types=1);

namespace app\admin\validate;

use think\Validate;

class Problem extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'classify_id' => 'require|number|gt:0',
        'title'       => 'require',
        'answer'      => 'require',
        'sort'        => 'require|number',
        'status'      => 'require|in:0,1',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [
        'classify_id.require' => '分类id不能为空',
        'classify_id.number'  => '分类id必须是数字',
        'classify_id.gt'      => '分类id必须大于0',
        'title.require'       => '问题不能为空',
        'answer.require'      => '回复不能为空',
        'sort.require'        => '排序值不能为空',
        'sort.number'         => '排序值必须是数字',
        'status.require'      => 'status不能为空',
        'status.in'           => 'status只能是0或1',
    ];
}
