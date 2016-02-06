<?php
/* *
 * 功能：支付宝服务器异步通知页面
 * 版本：3.3
 * 日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。


 *************************页面功能说明*************************
 * 创建该页面文件时，请留心该页面文件中无任何HTML代码及空格。
 * 该页面不能在本机电脑测试，请到服务器上做测试。请确保外部可以访问该页面。
 * 该页面调试工具请使用写文本函数logResult，该函数已被默认关闭，见alipay_notify_class.php中的函数verifyNotify
 * 如果没有收到该页面返回的 success 信息，支付宝会在24小时内按一定的时间策略重发通知
 */

require_once("alipay.config.php");
require_once("lib/alipay_notify.class.php");

//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyNotify();


define('DB_HOST', 'localhost');
	define('DB_USER', 'kfans');
	define('DB_PWD', 'hf2015#$3890');
	define('DB_NAME', 'wxfx');
	define('DB_PREFIX', 'wemall_');
	define ('FENURL','http://t.k99p.com');		//加粉列url地址，不要加/

	

	$conn = @mysql_connect(DB_HOST, DB_USER, DB_PWD) or die('数据库链接失败：'.mysql_error());

	

	@mysql_select_db(DB_NAME) or die('数据库错误：'.mysql_error());

	

	@mysql_query('SET NAMES UTF8') or die('字符集错误：'.mysql_error());


if(1==1) {//验证成功
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//请在这里加上商户的业务逻辑程序代

	
	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
	
    //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
	
	//商户订单号
	$out_trade_no = $_POST['out_trade_no'];

	//支付宝交易号
	$trade_no = $_POST['trade_no'];

	//交易状态
	$trade_status = $_POST['trade_status'];
	
	//logResult($_POST['out_trade_no']);
	//logResult($_POST['fieldname']);
	
	if (! empty ( $out_trade_no )) {
		    $map=array();
		    $map["name"]=$_POST['subject'];	
		    $map["num"]=1;	
		    $map["price"]=$_POST['total_fee'];	
		    $map["trade_status"]=$_POST['trade_status'];
		    $map["trade_no"]=$_POST['trade_no'];
		    $map["out_trade_no"]=$_POST['out_trade_no'];	
			$sql = " update wemall_order set pay_status=8,cartdata='".json_encode($map)."' where orderid='" . $out_trade_no . "' ";	
			$result = mysql_query ( $sql, $conn );	
			
			logResult($_POST['out_trade_no']."$单号保存成功$".$result);
			
			$sql = "select * from " . DB_PREFIX . "order where orderid='" . $out_trade_no . "' LIMIT 1";	
			$result = mysql_query ( $sql, $conn );				
			$row=mysql_fetch_row($result);	
			mysql_close($conn);	
			
			$sql = " update wemall_user set member=1 where id='" . $row[1] . "' ";	
			$result = mysql_query ( $sql, $conn );	
			
			
			
			$url = 'http://' . "wx.k99p.com". '/index.php?g=App&m=PC_Web&a=payover_alipay&out_trade_no='.$out_trade_no.'&uid='.$row[1];		
			logResult($_POST['out_trade_no']."$".$url);
			$getfileresult= file_get_contents($url);
			
			logResult($_POST['out_trade_no']."$回调wx.k99p.com$".$getfileresult);
	}


    if($_POST['trade_status'] == 'TRADE_FINISHED') {
		//判断该笔订单是否在商户网站中已经做过处理
			//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
			//如果有做过处理，不执行商户的业务程序
				
		//注意：
		//退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知

        //调试用，写文本函数记录程序运行情况是否正常
        //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
    }
    else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
		//判断该笔订单是否在商户网站中已经做过处理
			//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
			//如果有做过处理，不执行商户的业务程序
				
		//注意：
		//付款完成后，支付宝系统发送该交易状态通知

        //调试用，写文本函数记录程序运行情况是否正常
        //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
    }

	//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
	
        
	echo "success";		//请不要修改或删除
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
else {
    //验证失败
    echo "fail";

    //调试用，写文本函数记录程序运行情况是否正常
    //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
}
?>