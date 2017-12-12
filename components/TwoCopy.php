<?php

namespace app\components;

use Yii;
use app\models\PublicRow;

/**
 * 二二复制顺排
 *
 * @filename ThreeCopy.php 
 * @encoding UTF-8 
 * @author xxh <xxh44@qq.com>
 * @version 1.0.0
 * @datetime 2016-12-15 7:52:25
 */
class TwoCopy {

    /**
     * 根据ID获取应排层数
     * 
     * @param type $id  数字
     */
    public static function getLayerById($id) {
        $layers = floor(log($id, 2)) + 1;
        return $layers;
    }

    /**
     * 获取指定层节点数量
     * 
     * @param type $layer
     */
    public static function getLayerNodes($layer) {
        return pow(2, $layer-1);
    }

    /**
     * 获取每层的开始节点
     * 
     * @param type $layer
     */
    public static function getLayerStartNode($layer) {
        return pow(2, $layer-1);
    }

    /**
     * 获取每层的结束节点
     * 
     * @param type $layer
     * @return type
     */
    public static function getLayerEndNode($layer) {
        return pow(2, $layer) - 1;
    }

    /**
     * 获取节点的位置
     * 
     * @param type $node
     */
    public static function getNodePosition($node) {
        $position = [
            'node' => $node,
            'parentNode' => 0,
            'leftNode' => $node%2==0 ? true : false,
            'rightNode' => $node%2==0 ? false : true,
            'layer' => 1,
        ];
        if ($node > 1) {
            $position['layer'] = self::getLayerById($node);
            $position['parentNode'] = floor($node / 2);
        }
        return $position;
    }

}
