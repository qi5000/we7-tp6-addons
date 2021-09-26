<?php

declare(strict_types=1);

namespace app\admin\controller;

use app\admin\logic\Problem as LogicProblem;

// 验证器
use app\validate\Problem as ProblemValidate;
use app\validate\ProblemClassify as ProblemClassifyValidate;

/**
 * 常见问题
 */
class Problem
{
    /**
     * 获取常见问题列表
     *
     * @param array   $where
     * @param integer $page
     * @param integer $limit
     */
    public function getLists(array $where = [], int $page = 1, int $limit = 10)
    {
        $data = LogicProblem::getLists($where, $page, $limit);
        return data($data, '常见问题');
    }

    /**
     * 添加问题
     *
     * @param array $data
     */
    public function save(array $data)
    {
        validate(ProblemValidate::class)->check($data);
        LogicProblem::save($data);
        return success('添加成功');
    }

    /**
     * 编辑问题
     *
     * @param integer $id 问题id
     */
    public function read(int $id)
    {
        $data = LogicProblem::read($id);
        return data($data, '编辑问题');
    }

    /**
     * 更新问题
     *
     * @param integer $id   问题id
     * @param array   $data 更新的数据
     */
    public function update(int $id, array $data)
    {
        validate(ProblemValidate::class)->check($data);
        LogicProblem::update($id, $data);
        return success('修改成功');
    }

    /**
     * 删除问题
     *
     * @param int|array $id
     */
    public function delete($id)
    {
        LogicProblem::delete($id);
        return success('删除成功');
    }

    // +----------------------------------------------------------------
    // | 常见问题分类
    // +----------------------------------------------------------------

    /**
     * 获取问题分类列表
     *
     * @param array   $where
     * @param integer $page
     * @param integer $limit
     */
    public function getClassifyLists(array $where = [], int $page = 1, int $limit = 10)
    {
        $data = LogicProblem::getClassifyLists($where, $page, $limit);
        return data($data, '分类列表');
    }

    /**
     * 选择分类
     */
    public function selectClassify()
    {
        $data = LogicProblem::selectClassify();
        return data($data, '选择分类');
    }

    /**
     * 添加分类
     *
     * @param array $data
     */
    public function saveClassify(array $data)
    {
        validate(ProblemClassifyValidate::class)->check($data);
        LogicProblem::saveClassify($data);
        return success('添加成功');
    }

    /**
     * 编辑分类
     *
     * @param integer $id
     */
    public function readClassify(int $id)
    {
        $data = LogicProblem::readClassify($id);
        return data($data, '编辑分类');
    }

    /**
     * 更新分类
     *
     * @param integer $id
     * @param array   $data
     */
    public function updateClassify(int $id, array $data)
    {
        validate(ProblemClassifyValidate::class)->check($data);
        LogicProblem::updateClassify($id, $data);
        return success('修改成功');
    }

    /**
     * 删除分类
     *
     * @param int|array $id
     */
    public function deleteClassify($id)
    {
        LogicProblem::deleteClassify($id);
        return success('删除成功');
    }
}
