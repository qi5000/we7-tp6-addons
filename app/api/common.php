<?php

// +----------------------------------------------------------------------
// | api应用自定义函数
// +----------------------------------------------------------------------

/**
 * 给小程序前端提供图片
 */
function wxappImg($img)
{
    return request()->domain() . '/addons/' . module() . '/public/static/wxapp/' . $img;
}
