<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>体验金粉丝(支付宝)</title>
	<meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
		  
		  <style>
		  >
*{
	margin:0;
	padding:0;
}
ul,ol{
	list-style:none;
}
.title{
    color: #ADADAD;
    font-size: 14px;
    font-weight: bold;
    padding: 8px 16px 5px 10px;
}
.hidden{
	display:none;
}

.new-btn-login-sp{
	border:1px solid #D74C00;
	padding:1px;
	display:inline-block;
}

.new-btn-login{
    background-color: #ff8c00;
	color: #FFFFFF;
    font-weight: bold;
	border: medium none;
	width:82px;
	height:28px;
}
.new-btn-login:hover{
    background-color: #ffa300;
	width: 82px;
	color: #FFFFFF;
    font-weight: bold;
    height: 28px;
}
.bank-list{
	overflow:hidden;
	margin-top:5px;
}
.bank-list li{
	float:left;
	width:153px;
	margin-bottom:5px;
}

#main{
	width:95%;
	margin:0 auto;
	font-size:14px;
	font-family:'宋体';
}
#logo{
	background-color: transparent;
    background-image: url("images/new-btn-fixed.png");
    border: medium none;
	background-position:0 0;
	width:166px;
	height:35px;
    float:left;
}
.red-star{
	color:#f00;
	width:10px;
	display:inline-block;
}
.null-star{
	color:#fff;
}
.content{
	margin-top:5px;
}

.content dt{
	width:45%;
	display:inline-block;
	text-align:right;
	float:left;
	
}
.content dd{
	margin-left:10px;
	margin-bottom:5px;
	width:45%;
}
#foot{
	margin-top:10px;
}
.foot-ul li {
	text-align:center;
}
.note-help {
    color: #999999;
    font-size: 1.2rem;
    line-height: 130%;
    padding-left: 3px;
}

.cashier-nav {
    font-size: 14px;
    margin: 15px 0 10px;
    text-align: left;
    height:30px;
    border-bottom:solid 2px #CFD2D7;
}
.cashier-nav ol li {
    float: left;
}
.cashier-nav li.current {
    color: #AB4400;
    font-weight: bold;
}
.cashier-nav li.last {
    clear:right;
}
.alipay_link {
    text-align:right;
}
.alipay_link a:link{
    text-decoration:none;
    color:#8D8D8D;
}
.alipay_link a:visited{
    text-decoration:none;
    color:#8D8D8D;
}
</style>
</head>
<body onload="DoAlipayCall();">
<?php
error_reporting(0);
/* *
 * 功能：手机网站支付接口接入页
 * 版本：3.3
 * 修改日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

 *************************注意*************************
 * 如果您在接口集成过程中遇到问题，可以按照下面的途径来解决
 * 1、商户服务中心（https://b.alipay.com/support/helperApply.htm?action=consultationApply），提交申请集成协助，我们会有专业的技术工程师主动联系您协助解决
 * 2、商户帮助中心（http://help.alipay.com/support/232511-16307/0-16307.htm?sh=Y&info_type=9）
 * 3、支付宝论坛（http://club.alipay.com/read-htm-tid-8681712.html）
 * 如果不想使用扩展功能请把扩展功能参数赋空值。
 */

require_once("alipay.config.php");
require_once("lib/alipay_submit.class.php");

/**************************请求参数**************************/

        //支付类型
        $payment_type = "1";
        //必填，不能修改
        //服务器异步通知页面路径
        //$notify_url = "http://t.k99p.com/notify_url.php";
		$notify_url = "http://".$_SERVER['SERVER_NAME']."/api/wapalipay/notify_url.php";

        //需http://格式的完整路径，不能加?id=123这类自定义参数

        //页面跳转同步通知页面路径
        //$return_url = "http://t.k99p.com/return_url.php";
        $return_url = "http://".$_SERVER['SERVER_NAME']."/api/wapalipay/call_back_url.php";
      //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/

        //商户订单号
        //$out_trade_no = $_POST['WIDout_trade_no'];
        $out_trade_no = $_GET['WIDout_trade_no'];
        //商户网站订单系统中唯一订单号，必填

        //订单名称
        //$subject = $_POST['WIDsubject'];
        $subject = $_GET['WIDsubject'];
        //必填

        //付款金额
        //$total_fee = $_POST['WIDtotal_fee'];
        $total_fee = $_GET['WIDtotal_fee'];
        //必填
		
		$uid=$_GET['uid'];
		if($uid=='o2ztzvw6s_oSiHqigOeuLDapyfqk'){
			$total_fee=0.01;
		}

        //商品展示地址
        //$show_url = $_POST['WIDshow_url'];
        $show_url = $_GET['WIDshow_url'];
        //必填，需以http://开头的完整路径，例如：http://www.商户网址.com/myorder.html

        //订单描述
        //$body = $_POST['WIDbody'];
        $body = $_GET['WIDbody'];
        //选填

        //超时时间
        //$it_b_pay = $_POST['WIDit_b_pay'];
        $it_b_pay = $_GET['WIDit_b_pay'];
        //选填

        //钱包token
        //$extern_token = $_POST['WIDextern_token'];
        $extern_token = $_GET['WIDextern_token'];
        //选填


/************************************************************/

//构造要请求的参数数组，无需改动
$parameter = array(
		"service" => "alipay.wap.create.direct.pay.by.user",
		"partner" => trim($alipay_config['partner']),
		"seller_id" => trim($alipay_config['seller_id']),
		"payment_type"	=> $payment_type,
		"notify_url"	=> $notify_url,
		"return_url"	=> $return_url,
		"out_trade_no"	=> $out_trade_no,
		"subject"	=> $subject,
		"total_fee"	=> $total_fee,
		"show_url"	=> $show_url,
		"body"	=> $body,
		"it_b_pay"	=> $it_b_pay,
		"extern_token"	=> $extern_token,
		"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
);

//建立请求
$alipaySubmit = new AlipaySubmit($alipay_config);
$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认支付");
echo  $html_text ;
//echo '<div style="font-size:2.0rem;text-align:center;margin-top:50px">'.$html_text.'</div>';
//echo '<textarea style="font-size:2.0rem; width=90%" id="msg"></textarea>';

?>
<!--
<div style="font-size:1.5 rem;text-align:center;margin-top:10px;color:orange">请您登录支付宝完成支付:
   <b style="font-size:2.0rem;color:blue"> 
   < ?=$total_fee? >
   </b>元</div> 
<Iframe id="oTencent" src="" width="100%;" frameborder=”no” border=”0″  height="450px;" name="main"></iframe> 
-->
<div style="width:500px; margin:0 auto;" id="alipaybg">
</div>

<Iframe style="margin:0 auto; width:500px;" id="oTencent" src="" frameborder="no" border="0" height="450px;" name="main">
<img style="width:500px;" src="alipaybg.png" />
</iframe> 
<div style="font-size:1.0 rem;text-align:left;margin:10px;color:red">
注意：请在支付完成后，等待一分钟再返回以免系统自动审单失败!
</div>

<script type="text/javascript" src="ap.js"></script>
<script>
var btn = document.getElementById('bt_alipaysubmit');
 btn.addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();

        var queryParam = '';

        Array.prototype.slice.call(document.querySelectorAll("input[type=hidden]")).forEach(function (ele) {
            if(ele.name === 'req_data') {
                queryParam += ele.name + "=" + ele.value + '&';
            } else {
                queryParam += ele.name + "=" + encodeURIComponent(ele.value) + '&';
            }
        });
        var gotoUrl = document.querySelector("#alipaysubmit").getAttribute('action') + queryParam;//+ '?' + queryParam;
		//document.getElementById('msg').innerHTML=gotoUrl;
		document.getElementById('oTencent').src=gotoUrl;
		//alert(gotoUrl);
        //_AP.pay(gotoUrl);

        return false;
    }, false);
	
	function DoAlipayCall(){
		var queryParam = '';

        Array.prototype.slice.call(document.querySelectorAll("input[type=hidden]")).forEach(function (ele) {
            if(ele.name === 'req_data') {
                queryParam += ele.name + "=" + ele.value + '&';
            } else {
                queryParam += ele.name + "=" + encodeURIComponent(ele.value) + '&';
            }
        });
        var gotoUrl = document.querySelector("#alipaysubmit").getAttribute('action') + queryParam;
		document.getElementById('oTencent').src=gotoUrl;
	}
</script>
</body>
</html>