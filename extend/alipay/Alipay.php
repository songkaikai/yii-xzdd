<?php

namespace app\extend\alipay;

use Yii;
use yii\base\Component;
use yii\helpers\Json;

require 'src/AopClient.php';
require 'src/request/AlipayTradeWapPayRequest.php';


/**
 * 支付宝支付控件
 *
 * @author Administrator
 */
class Alipay extends Component {

    /**
     * 应用ID
     * @var string 
     */
    public $appId;
   
    /**
     * 商户私钥
     * @var string 
     */
    public $rsaPrivateKey;
    
    /**
     * 支付宝公钥
     * @var string
     */
    public $alipayrsaPublicKey;
    
    /**
     * 签名算法类型，目前支持RSA2和RSA
     * @var string 
     */
    public $signType = 'RSA';
    
    /**
     * 请求使用的编码格式，如utf-8, gbk, gb2312等
     * @var string 
     */
    public $charset = 'utf-8';
    
    /**
     * 调用的接口版本，固定为：1.0
     * @var string 
     */
    public $version = '1.0';
    
    public function init() {
        if ($this->appId === null) {
            throw new InvalidConfigException('The appId property must be set.');
        } elseif ($this->rsaPrivateKey === null) {
            throw new InvalidConfigException('The rsaPrivateKey property must be set.');
        } elseif ($this->alipayrsaPublicKey === null) {
            throw new InvalidConfigException('The alipayrsaPublicKey property must be set.');
        }
    }
    
    /**
     * 生成支付签名
     * 
     * @param type $goodsName       产品名称
     * @param type $total           价格
     * @param type $orderNo         订单编号
     * @return type
     */
    public function tradeAppPay($goodsName, $total, $orderNo, $returnUrl, $notifyUrl,$httpmethod = "POST"){
        $aop = new \AopClient();
        $aop->gatewayUrl = "https://openapi.alipay.com/gateway.do";
        $aop->appId = $this->appId;
        $aop->rsaPrivateKey = $this->rsaPrivateKey;
        $aop->format = "json";
        $aop->charset = "UTF-8";
        $aop->signType = "RSA";
        $aop->alipayrsaPublicKey = $this->alipayrsaPublicKey;
        $request = new \AlipayTradeWapPayRequest();
        $body = [
            'subject' => $goodsName,
            'out_trade_no' => $orderNo,
            'total_amount' => $total,
            'product_code' => 'QUICK_MSECURITY_PAY',
        ];
        $bizcontent = Json::encode($body);
        $request->setNotifyUrl($notifyUrl);
        $request->setReturnUrl($returnUrl);
        $request->setBizContent($bizcontent);
        $response = $aop->pageExecute ($request, $httpmethod);
//        return $response;
        return htmlspecialchars($response);
    }

    /**
     * 验证通知数字签名
     * 
     * @param type $signData    POST过来的数据
     * @return type
     */
    public function notify($signData){
        $aop = new \AopClient();
        $aop->alipayrsaPublicKey = $this->alipayrsaPublicKey;
        $flag = $aop->rsaCheckV1($signData, NULL, $this->signType);
        return $flag;
    }
}
