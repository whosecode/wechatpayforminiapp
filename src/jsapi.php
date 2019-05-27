<?php
/**
 *
 *微信小程序支付接口
 * 
 *调用方式
 *openid:openid
 *orderId:订单号
 *price:价格（元）
 *   WeChatPayForMiniApp('openid','orderId','price');
 **/
namespace thewings\wechatpayforminiapp;

// require_once 'config.php';

// require_once "lib/WxPay.Api.php";
// require_once "base/WxPay.JsApiPay.php";
// require_once "base/WxPay.Config.php";
//require_once 'base/log.php';

use thewings\wechatpayforminiapp\lib\WxPayApi;
use thewings\wechatpayforminiapp\lib\WxPayJsApiPay;
use thewings\wechatpayforminiapp\base\WxPayConfig;
use thewings\wechatpayforminiapp\base\Log;

class jsapi{

	

	public function __construct($arr)
	{
		
	}

	public function WeChatPayForMiniApp($openid, $orderId, $price)
	{
		//初始化日志
		// $logHandler= new CLogFileHandler("logs/".date('Y-m-d').'.log');
		// Log::Init($logHandler, 15);
		//①、获取用户openid
		$tools = new JsApiPay();
		//$openId = $tools->GetOpenid();

		//②、统一下单
		$input = new WxPayUnifiedOrder();
		$input->SetBody("支付");
		$input->SetOut_trade_no($orderId);
		$input->SetTotal_fee($price * 100);
		$input->SetTime_start(date("YmdHis"));
		$input->SetTime_expire(date("YmdHis", time() + 600));
		$input->SetNotify_url(NOTIFY_URL);
		$input->SetTrade_type("JSAPI");
		$input->SetOpenid($openid);
		$config = new WxPayConfig();
		$order = WxPayApi::unifiedOrder($config, $input);
		$jsApiParameters = $tools->GetJsApiParameters($order);
		return $jsApiParameters;
	}
}