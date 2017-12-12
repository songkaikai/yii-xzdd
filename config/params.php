<?php

return array(
    'appName' => '血战到底',
    'user.apiTokenExpire' => 2 * 3600,
    'logo' => '@web/images/logo.png',
    'keywords' => '',
    'description' => '',
    'cacheDuration' => '-1',
    'pageSize' => '2',
    'goodsId' => 1,
//    'payUrl' => 'http://repay.dogobao.com',
    'alipayReturnUrl' => 'http://api.huichapu.cn/index',
    'encryKey' => '6123856789abcdef6288',   //加密KEY
    
    //默认密码
    'userDefaultPass' => '666666',
    //报单金额
    'registerMoney' => 58,
    //理财订单金额
    'licaiMoney' => 100,
    //每天最多购买数
    'dayMax' => 30,
    //会员每ID最多购买
    'memberMax' => 30,
    
    //开盘日期
    'shopBegin' => '2017-06-01',
    
    //提现比例
    'withDraw' => 0.75,
    
    //A网见点奖
    'jdjMoney' => [
        '1' => 2,
        '2' => 2,
        '3' => 2,
        '4' => 2,
        '5' => 2,
        '6' => 2,
        '7' => 2,
        '8' => 2,
        '9' => 2,
        '10' => 2,
        '11' => 2,
        '12' => 2,
    ],
    //B网见点奖
    'jdjMoneyB' => [
        '1' => 3,
        '2' => 3,
        '3' => 3,
        '4' => 3,
        '5' => 3,
        '6' => 3,
        '7' => 3,
        '8' => 3,
        '9' => 3,
        '10' => 3,
        '11' => 3,
        '12' => 3,
    ],
    //推荐奖
    'tjjMoney' => [
        '1' => 5,
        '2' => 3,
        '3' => 2,
        '4' => 1,
        '5' => 1,
    ],
    //分销收益
    'fxMoney' => [
        '1' => 5,
        '2' => 3,
        '3' => 2,
        '4' => 1,
        '5' => 1,
    ],
    'ldj' => [
        '1' => 0.05,
        '2' => 0.04,
        '3' => 0.03,
        '4' => 0.02,
        '5' => 0.01,
        '6' => 0.01,
        '7' => 0.01,
        '8' => 0.01,
        '9' => 0.01,
        '10' => 0.01,
    ],
    
    //运费
    'freight' => 20,
    
    //快递
    'express' => [
        'ZTO' => '中通快递',
        'YTO' => '圆通速递',
        'SF' => '顺丰快递',
        'HTKY' => '汇通快递',
        'EMS' => 'EMS',
        'HHTT' => '天天快递',
        'STO' => '申通快递',
        'YD' => '韵达快递',
        'YZPY' => '邮政平邮/小包',
    ],
    
    'nav' => '{
    "options": {
        "class": "nav navbar-nav navbar-right"
    },
    "items": [
        {
            "label": "首页",
            "url": [
                "/site/index"
            ]
        },
        {
            "label": "产品",
            "url": [
                "/products/list"
            ],
            "activeUrls": [
                "/products/index"
            ]
        },
        {
            "label": "新闻",
            "url": [
                "/news/list"
            ],
            "activeUrls": [
                "/news/index"
            ]
        },
        {
            "label": "下载",
            "url": [
                "/downloads/list"
            ],
            "activeUrls": [
                "/downloads/index"
            ]
        },
        {
            "label": "关于我们",
            "url": [
                "/site/about"
            ],
            "items": [
                {
                    "label": "企业荣誉",
                    "url": {
                        "0":"/site/page/honor", "id":"honor"
                    }
                }
            ]
        },
        {
            "label": "联系我们",
            "url": [
                "/site/contact"
            ]
        }
    ]
}',
);
