<?php

namespace app\components\qrcode;

require 'phpqrcode.php';

/**
 * 生成二维码
 *
 * @filename buildCode.php 
 * @encoding UTF-8
 * @author xxh <xxh44@qq.com>
 * @version 1.0.0
 * @datetime 2015-8-17 19:38:06
 */
class buildCode {

    /**
     * 生成普通二维码
     * 
     * @param type $text            二维码内容
     * @param type $outFile         保存图片名
     * @param type $size            生成图片大小，默认为6
     * @param type $margin          二维码外围白边宽度
     * @param type $level           容错级别，默认为L,可填值 L M Q H
     * @return type
     */
    public static function code($text, $outFile, $size = 6, $margin = 2, $level = 'L') {
        QRcode::png($text, $outFile, $level, $size, $margin);
        return $outFile;
    }

    /**
     * 生成中间带LOGO的二维码
     * 
     * @param type $text            二维码内容
     * @param type $outFile         保存图片名
     * @param type $logo            LOGO图片位置
     * @param type $size            生成图片大小，默认为6
     * @param type $margin          二维码外围白边宽度
     * @param type $level           容错级别，默认为L,可填值 L M Q H
     * @return type
     */
    public function logoCode($text, $outFile, $logo, $size = 6, $margin = 2, $level = 'L') {
        $qrcode_path = self::code($text, $outFile, $size, $margin, $level);
        if ($logo !== FALSE) {
            $qrcode_path = imagecreatefromstring(file_get_contents($qrcode_path));
            $logo = imagecreatefromstring(file_get_contents($logo));
            $QR_width = imagesx($qrcode_path);          //二维码图片宽度
            $QR_height = imagesy($qrcode_path);         //二维码图片高度
            $logo_width = imagesx($logo);               //logo图片宽度
            $logo_height = imagesy($logo);              //logo图片高度
            $logo_qr_width = $QR_width / 5;
            $scale = $logo_width / $logo_qr_width;
            $logo_qr_height = $logo_height / $scale;
            $from_width = ($QR_width - $logo_qr_width) / 2;
            //重新组合图片并调整大小
            imagecopyresampled($qrcode_path, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
            imagepng($qrcode_path, $outFile);
        }
        return $outFile;
    }
}
