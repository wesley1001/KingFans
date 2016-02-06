<?php
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);

require_once "../lib/WxPay.Api.php";
require_once "WxPay.NativePay.php";
require_once 'log.php';

//模式一
/**
 * 流程：
 * 1、组装包含支付信息的url，生成二维码
 * 2、用户扫描二维码，进行支付
 * 3、确定支付之后，微信服务器会回调预先配置的回调地址，在【微信开放平台-微信支付-支付配置】中进行配置
 * 4、在接到回调通知之后，用户进行统一下单支付，并返回支付信息以完成支付（见：native_notify.php）
 * 5、支付完成之后，微信服务器会通知支付成功
 * 6、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
 */
$notify = new NativePay();
$url1 = $notify->GetPrePayUrl("123456789");

//模式二
/**
 * 流程：
 * 1、调用统一下单，取得code_url，生成二维码
 * 2、用户扫描二维码，进行支付
 * 3、支付完成之后，微信服务器会通知支付成功
 * 4、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
 */
$input = new WxPayUnifiedOrder();
$input->SetBody("test");
$input->SetAttach("test");
$input->SetOut_trade_no($_GET['WIDout_trade_no']);//WxPayConfig::MCHID.date("YmdHis")

$input->SetTotal_fee($_GET['WIDtotal_fee']);
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 6000));
$input->SetGoods_tag("test");
$input->SetNotify_url("http://www.k99p.com/api/wxpayapi/deal/notify.php");
$input->SetTrade_type("NATIVE");
$input->SetProduct_id("123456789");
$result = $notify->GetPayUrl($input);
$url2 = $result["code_url"];
?>

<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" /> 
    <title>微信支付</title>
</head>
<body style="background:#e6e6e6; ">
	
	<div style=" background:#efefef; text-align:center; width:500px; height:100%; margin:0 auto; color:#556B2F; font-size:20px;">
    <img src="alipaybg.png" style="width:500px;"/>
    <span style="background:#000; display:block; text-align:center; width:500px; height:50px; line-height:50px; color:#fff; font-size:16px;">请使用微信扫描二维码支付</span>
    
    <img alt="微信二维码支付" src="http://www.k99p.com/api/wxpayapi/example/qrcode.php?data=<?php echo urlencode($url2);?>" style="width:250px;height:250px; margin:50px 0 20px 0;"/>
    
    <div style="background:#41c6ad url(/Public/home/m/images/back_home_icon.png) no-repeat 20% 50%; border-radius:6px; width:80%;line-height:3rem; margin:10px auto; font-size:2rem; padding:0.4rem 0; text-align:center;" class="weixin_btn">&nbsp;&nbsp;<a style="font-size:25px; text-decoration:none; color:#fff; " href="/index.php?g=Home&m=Index&a=index"  class="cfff"><span>返 回 首 页</span>
    </a></div>

    <div style="background:#41c6ad url(/Public/home/m/images/weixin_icon.png) no-repeat 20% 50%; border-radius:6px; width:80%;line-height:3rem; margin:0 auto; font-size:2rem; padding:0.4rem 0; text-align:center;" class="weixin_btn">&nbsp;&nbsp;<a style="font-size:25px; color:#fff; text-decoration:none; " href="#" class="cfff"><span>我已完成支付</span>
    </a></div>
    

    </div>
	
	
</body>
</html>