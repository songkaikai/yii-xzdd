<?php

namespace app\components;

use Yii;
use app\components\Skip32;

/**
 * 常用工具
 *
 * @filename Tool.php 
 * @encoding UTF-8 
 * @author xxh <xxh44@qq.com>
 * @version 1.0.0
 * @datetime 2016-3-23 10:32:39
 */
class Tool {

    /**
     * 数组转字符串
     * @param type $array
     * @return string
     */
    public static function arrayToString($array) {
        if (!is_array($array)) {
            return '';
        }
        $str = '';
        foreach ($array as $key => $val) {
            $str .= $key . ':' . $val . ',';
        }
        return $str;
    }

    /**
     * 记录测试日志
     * 
     * @param type $word        日志内容
     * @param type $type        类型   默认llpay
     */
    public static function log($word, $type = 'weixin') {
        if (is_array($word)) {
            $words = \yii\helpers\Json::encode($word);
        } else {
            $words = $word;
        }
        $fileName = date('Y-m-d') . '.log';
        $logFile = \Yii::getAlias('@app/log/' . $type . '/' . $fileName);
        $fp = fopen($logFile, "a");
        flock($fp, LOCK_EX);
        fwrite($fp, "执行日期：" . strftime("%Y-%m-%d %H:%M:%S", time()) . "\n" . $words . "\n\n");
        flock($fp, LOCK_UN);
        fclose($fp);
    }

    /*
     * 经典的概率算法， 
     * $proArr是一个预先设置的数组， 
     * 假设数组为：array(100,200,300，400)， 
     * 开始是从1,1000 这个概率范围内筛选第一个数是否在他的出现概率范围之内，  
     * 如果不在，则将概率空间，也就是k的值减去刚刚的那个数字的概率空间， 
     * 在本例当中就是减去100，也就是说第二个数是在1，900这个范围内筛选的。 
     * 这样 筛选到最终，总会有一个数满足要求。 
     * 就相当于去一个箱子里摸东西， 
     * 第一个不是，第二个不是，第三个还不是，那最后一个一定是。 
     * 这个算法简单，而且效率非常 高， 
     * 关键是这个算法已在我们以前的项目中有应用，尤其是大数据量的项目中效率非常棒。 
     */

    function get_rand($proArr) {
        $result = '';
        //概率数组的总概率精度   
        $proSum = array_sum($proArr);
        //概率数组循环   
        foreach ($proArr as $key => $proCur) {
            $randNum = mt_rand(1, $proSum);
            if ($randNum <= $proCur) {
                $result = $key;
                break;
            } else {
                $proSum -= $proCur;
            }
        }
        unset($proArr);
        return $result;
    }


    /**
     * 比较两个日期相差的天数
     * 
     * @param type $a   时间戳
     * @param type $b   时间戳
     * @return type
     */
    public function countDays($a, $b) {
        $a_dt = getdate($a);
        $b_dt = getdate($b);
        $a_new = mktime(12, 0, 0, $a_dt['mon'], $a_dt['mday'], $a_dt['year']);
        $b_new = mktime(12, 0, 0, $b_dt['mon'], $b_dt['mday'], $b_dt['year']);
        return round(abs($a_new - $b_new) / 86400);
    }

    //判断是否微信浏览器打开
    public static function isWeixin() {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            return true;
        }
        return false;
    }

    /**
     * 获取毫秒时间
     * 
     * @return type
     */
    public static function getMillisecond() {
        list($t1, $t2) = explode(' ', microtime());
        return (float) sprintf('%.0f', (floatval($t1) + floatval($t2)) * 1000);
    }

    /**
     * 获取订单号
     * 
     * @param type $memberId
     * @return type
     */
    public static function getOrderNo($memberId, $prex = ''){
        $data = time() + rand(10000, 99999) + $memberId;
        $orderNo = Skip32::encrypt(Yii::$app->params['encryKey'], $data);
        return $prex . str_pad($orderNo, 10, '0');
    }
}
