<?php


namespace App\Utility;

/**
 * 通用工具类
 * Class CommonUtility
 * @package App\Utility
 */
class CommonUtility
{

    /**
     * 将数组中的key转下划线
     * 参考资料
     * https://www.jianshu.com/p/773fd334052f
     * https://segmentfault.com/q/1010000012115350
     * @param $data
     *
     */
    static function UnderlineCase(&$data) {
//        if(!is_array($data)) { return false;}
        array_map(function ($item) use (&$data) {
            $newKey = strtolower(preg_replace('/([a-z])([A-Z])/', "$1" . '_' . "$2", $item));
            $data[$newKey] = $data[$item];
            if($newKey != $item) {
                unset($data[$item]);
            }
        }, array_keys($data));
    }

}