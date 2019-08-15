<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: lyy
// | 调用微信支付接口
// +----------------------------------------------------------------------
namespace api\wxapp\controller;

use cmf\controller\RestBaseController;
use Exception;
use JsApiPay;
use Log;
use WxPayConfig;


class WxPayController extends RestBaseController
{

    public function printf(){
        //①、获取用户openid
        try{

            $tools = new JsApiPay();
            $openId = $tools->GetOpenid();

            //②、统一下单
            $input = new WxPayUnifiedOrder();
            $input->SetBody("test");
            $input->SetAttach("test");
            $input->SetOut_trade_no("sdkphp".date("YmdHis"));
            $input->SetTotal_fee("1");
            $input->SetTime_start(date("YmdHis"));
            $input->SetTime_expire(date("YmdHis", time() + 600));
            $input->SetGoods_tag("test");
            $input->SetNotify_url("http://paysdk.weixin.qq.com/notify.php");
            $input->SetTrade_type("JSAPI");
            $input->SetOpenid($openId);
            $config = new WxPayConfig();
            $order = WxPayApi::unifiedOrder($config, $input);

            if($order){

            }
            $jsApiParameters = $tools->GetJsApiParameters($order);

            //获取共享收货地址js函数参数
            $editAddress = $tools->GetEditAddressParameters();
        } catch(Exception $e) {
            Log::ERROR(json_encode($e));
        }
    }
}
