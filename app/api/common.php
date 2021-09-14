<?php

// +----------------------------------------------------------------------
// | api应用自定义函数
// +----------------------------------------------------------------------

use liang\MicroEngine;

/**
 * 给小程序前端提供图片
 */
function getWxappImg($img)
{
    if (MicroEngine::isMicroEngine()) {
        $mobule = MicroEngine::getModuleName();
        return request()->domain() . "/addons/{$mobule}/public/wxapp/" . $img;
    } else {
        return request()->domain() . "/wxapp/{$img}";
    }
}
