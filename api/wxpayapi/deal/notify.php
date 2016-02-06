<?php
ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);

require_once "../lib/WxPay.Api.php";
require_once '../lib/WxPay.Notify.php';
require_once 'log.php';

//初始化日志
$logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

class PayNotifyCallBack extends WxPayNotify
{
	//查询订单
	public function Queryorder($transaction_id)
	{
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
		Log::DEBUG("query:" . json_encode($result));
		if(array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS")
		{
			define('DB_HOST', 'localhost');
	define('DB_USER', 'kfans');
	define('DB_PWD', 'hf2015#$3890');
	define('DB_NAME', 'wxfx');
	define('DB_PREFIX', 'wemall_');
	define ('FENURL','http://t.k99p.com');		//加粉列url地址，不要加/

	

	$conn = @mysql_connect(DB_HOST, DB_USER, DB_PWD) or die('数据库链接失败：'.mysql_error());

	

	@mysql_select_db(DB_NAME) or die('数据库错误：'.mysql_error());

	

	@mysql_query('SET NAMES UTF8') or die('字符集错误：'.mysql_error());
	
	 
		    $result["name"]="微信扫码支付";	
		    $result["num"]=1;	
		    $result['total_fee']=intval($result['total_fee'])*0.01;	
		    $result["trade_status"]=$result['trade_state'];
		    $result["trade_no"]=$result['out_trade_no'];
		   
			$sql = " update wemall_order set pay_status=1,cartdata='".json_encode($result)."' where orderid='" . $result['out_trade_no'] . "' ";	
			 mysql_query ( $sql, $conn );	
			
			$sql = "select * from wemall_order where orderid='" . $result['out_trade_no'] . "' LIMIT 1";	
			$result = mysql_query ( $sql, $conn );				
			$row=mysql_fetch_row($result);	
			//Log::DEBUG("queryordersql:" .$sql);
			//Log::DEBUG("queryorder:" . json_encode($row));
			$sql = " update wemall_user set member=1 where id='" . $row["1"] . "' ";	
			//Log::DEBUG("querywemall_user:" .$sql);
			mysql_query ( $sql, $conn );	
			
			
			
			$url = 'http://' . "wx.k99p.com". '/index.php?g=App&m=PC_Web&a=payover_alipay&out_trade_no='.$result['out_trade_no'] .'&uid='.$row[1];		
			logResult($_POST['out_trade_no']."$".$url);
			$getfileresult= file_get_contents($url);
			
			mysql_close($conn);	
			return true;
		}
		return false;
	}
	
	//重写回调处理函数
	public function NotifyProcess($data, &$msg)
	{
		Log::DEBUG("call back:" . json_encode($data));
		$notfiyOutput = array();
		
		if(!array_key_exists("transaction_id", $data)){
			$msg = "输入参数不正确";
			return false;
		}
		//查询订单，判断订单真实性
		if(!$this->Queryorder($data["transaction_id"])){
			$msg = "订单查询失败";
			return false;
		}
		return true;
	}
}

Log::DEBUG("begin notify");
$notify = new PayNotifyCallBack();
$notify->Handle(false);
