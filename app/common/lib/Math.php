<?php

declare(strict_types=1);

namespace app\common\lib;

class Math
{
    /**
     * 生成随机浮点数并保留两位小数点
     *
     * @param $min 随机返回最小值
     * @param $max 随机范围最大值
     */
    public static function randFloat($min = 0, $max = 1)
    {
        $rand = $min + mt_rand() / mt_getrandmax() * ($max - $min);
        return floatval(number_format($rand, 2));
    }

    /**
     * 阿拉伯数字转为中文数字
     *
     * @param int $num
     */
    public static function numToWord(int $num)
    {
        $chiNum = array('零', '一', '二', '三', '四', '五', '六', '七', '八', '九');
        $chiUni = array('', '十', '百', '千', '万', '十', '百', '千', '亿');
        $chiStr = '';
        $num_str = (string)$num;
        $count = strlen($num_str);
        $last_flag = true; //上一个 是否为0
        $zero_flag = true; //是否第一个
        $temp_num = null; //临时数字
        $chiStr = ''; //拼接结果
        if ($count == 2) { //两位数
            $temp_num = $num_str[0];
            $chiStr = $temp_num == 1 ? $chiUni[1] : $chiNum[$temp_num] . $chiUni[1];
            $temp_num = $num_str[1];
            $chiStr .= $temp_num == 0 ? '' : $chiNum[$temp_num];
        } else if ($count > 2) {
            $index = 0;
            for ($i = $count - 1; $i >= 0; $i--) {
                $temp_num = $num_str[$i];
                if ($temp_num == 0) {
                    if (!$zero_flag && !$last_flag) {
                        $chiStr = $chiNum[$temp_num] . $chiStr;
                        $last_flag = true;
                    }

                    if ($index == 4 && $temp_num == 0) {
                        $chiStr = "万" . $chiStr;
                    }
                } else {
                    if ($i == 0 && $temp_num == 1 && $index == 1 && $index == 5) {
                        $chiStr = $chiUni[$index % 9] . $chiStr;
                    } else {
                        $chiStr = $chiNum[$temp_num] . $chiUni[$index % 9] . $chiStr;
                    }
                    $zero_flag = false;
                    $last_flag = false;
                }
                $index++;
            }
        } else {
            $chiStr = $chiNum[$num_str[0]];
        }
        return $chiStr;
    }
}
