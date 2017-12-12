<?php

namespace app\components;

use yii\helpers\ArrayHelper;

/**
 * Description of Logistics
 *
 * @filename Logistics.php 
 * @encoding UTF-8 
 * @author xxh <xxh44@qq.com>
 * @version 1.0.0
 * @datetime 2016-12-9 23:20:40
 */
class Logistics {

    public $EBusinessID = 1270393;
    public $AppKey = '4df989ea-d463-47a2-8c6a-b3e13a2c867e';
    public $ReqURL = 'http://api.kdniao.cc/Ebusiness/EbusinessOrderHandle.aspx';

    /**
     * Json方式 查询订单物流轨迹
     */
    function getOrderTracesByJson($express, $express_no) {
        $requestData = "{'OrderCode':'','ShipperCode':'{$express}','LogisticCode':'{$express_no}'}";

        $datas = array(
            'EBusinessID' => $this->EBusinessID,
            'RequestType' => '1002',
            'RequestData' => urlencode($requestData),
            'DataType' => '2',
        );
        $datas['DataSign'] = $this->encrypt($requestData, $this->AppKey);
        $result = $this->sendPost($this->ReqURL, $datas);
        return json_decode($result, true);
    }

    /**
     *  post提交数据 
     * @param  string $url 请求Url
     * @param  array $datas 提交的数据 
     * @return url响应返回的html
     */
    private function sendPost($url, $datas) {
        $temps = array();
        foreach ($datas as $key => $value) {
            $temps[] = sprintf('%s=%s', $key, $value);
        }
        $post_data = implode('&', $temps);
        $url_info = parse_url($url);
        if (ArrayHelper::getValue($url_info, 'port', '') == '') {
            $url_info['port'] = 80;
        }
        $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
        $httpheader.= "Host:" . $url_info['host'] . "\r\n";
        $httpheader.= "Content-Type:application/x-www-form-urlencoded\r\n";
        $httpheader.= "Content-Length:" . strlen($post_data) . "\r\n";
        $httpheader.= "Connection:close\r\n\r\n";
        $httpheader.= $post_data;
        $fd = fsockopen($url_info['host'], $url_info['port']);
        fwrite($fd, $httpheader);
        $gets = "";
        $headerFlag = true;
        while (!feof($fd)) {
            if (($header = @fgets($fd)) && ($header == "\r\n" || $header == "\n")) {
                break;
            }
        }
        while (!feof($fd)) {
            $gets.= fread($fd, 128);
        }
        fclose($fd);

        return $gets;
    }

    /**
     * 电商Sign签名生成
     * @param data 内容   
     * @param appkey Appkey
     * @return DataSign签名
     */
    private function encrypt($data, $appkey) {
        return urlencode(base64_encode(md5($data . $appkey)));
    }

}
