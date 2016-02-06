<?php
class IndexAction extends Action {
	function _initialize() {
		header("Content-type: text/html; charset=utf-8"); 
		if($_GET['debug'])
		{
		
		}
		else
		{
			$agent = $_SERVER['HTTP_USER_AGENT']; 
			if(!strpos($agent,"icroMessenger")) {
				//echo '请使用微信访问';exit;
			}
		}
		//$this->init();
	}
	
	public function index()
	{
	$user=M("user");
	$_SESSION['member'] = 0;
	$thisUser=$user->query ( "select wemall_user.* from wemall_user
      where   codeimg <>'0'    order by " . 'rand() ' . " desc limit " . ((1 - 1) * 16) . "," . 16 );
	$this->disUser=	$thisUser;
	$this->display();
		
	}
	

	
	
	
	 function loginwx() {
	 	if ($_GET['code']) {
	 		$code=$_GET['code'];
	 		$state=$_GET['state'];
	 		
	 		$wxlog=M("wxlog");
	 		$maplog=array();
	 		$maplog["wx"]=$code."$".$state."$".session_id();
	 		$maplog["created"]=time();
	 		$maplog["updated"]=time();
	 		$maplog["clientip"]=get_client_ip();
	 	
	 		$wxlog->add($maplog);
	 		
	 		if($state!=session_id())
	 		{
	 			$this->error("账号密码错误。");
	 			return ;
	 		}
	 		
	 		$config = M ( "Wxconfig" )->where ( array (
					"id" => "1" 
			) )->find ();
	 		import ( 'Wechat', APP_PATH . 'Common/Wechat', '.class.php' );
	 		import("ORG.Util.String");
	 		$options = array (
					'token' => $config ["token"], // 填写你设定的key
					'encodingaeskey' => $config ["encodingaeskey"], // 填写加密用的EncodingAESKey
					'appid' => 'wx7a69e5661221ff2b', // 填写高级调用功能的app id
					'appsecret' => 'df0da0670ffd9bf22acbfe2188bfd71c', // 填写高级调用功能的密钥
					'partnerid' => $config ["partnerid"], // 财付通商户身份标识
					'partnerkey' => $config ["partnerkey"], // 财付通商户权限密钥Key
					'paysignkey' => $config ["paysignkey"]  // 商户签名密钥Key
					);
			$weObj = new Wechat ( $options );
			
			$info = $weObj->getOauthAccessToken();
			if($info)
			{
			$maplog["wx"]=json_encode($info)."$".$weObj->errCode."$".$weObj->errMsg;
			$wxlog->add($maplog);
			
			$user=M("user");
			$thisUser=$user->where("uid='".$info["openid"]."'")->find();
	 		if($thisUser)
	 		{
	 		$_SESSION["uid"] = $thisUser['uid'];
					$_SESSION["username"] = $thisUser['username'];
					$_SESSION["time"] =String::msubstr( $thisUser['time'],0, 10,"utf-8",false);//$thisUser['time']; //strtotime( $thisUser['time']);
					$_SESSION["weixin"] = $thisUser['weixin'];
					$_SESSION["wx_info"]=json_decode($thisUser['wx_info'],true);
					$_SESSION["id"]=$thisUser['id'];
					$_SESSION["member"]=$thisUser['member'];	
	 		$this->success("登陆成功",U("Home/Member/index"));
	 		}else {
	 		  $wxData=	$weObj->getOauthUserinfo($info["access_token"], $info["openid"]);
	 		  $maplog["wx"]="获取用户".json_encode($wxData)."$".$weObj->errCode."$".$weObj->errMsg; 
	 		  $wxlog->add($maplog);
	 		  
	 		  if($wxData){
	 		  	$newUser=array();
	 		  	$newUser["uid"]=$wxData["openid"];
	 		  	$newUser["member"]=0;
	 		  	$newUser["ticket"]='';
	 		  	$newUser["username"]=$wxData["nickname"];
	 		  	$newUser["phone"]='';
	 		  	$newUser["weixin"]='';
	 		  	$newUser["password"]='';
	 		  	$newUser["address"]='province';
	 		  	$newUser["wx_info"]=json_encode($wxData);
	 		  	$newUser["price"]=0;
	 		  	$newUser["jifen"]=0;
	 		  	$newUser["time"]=date("Y-m-d h:i:sa",time());
	 		  	$newUser["url"]='';
	 		  	$newUser["l_id"]=0;
	 		  	$newUser["l_b"]=0;
	 		  	$newUser["l_c"]=0;
	 		  	$newUser["c_cnt"]=0;
	 		  	$newUser["b_cnt"]=0;
	 		  	$newUser["a_cnt"]=0;
	 		  	$newUser["login"]='';
	 		  	$newUser["email"]='';
	 		  	$newUser["Flag"]=0;
	 		  	$newUser["XID"]=0;
	 		  	$newUser["X_Price"]=0;
	 		  	
	 		  $flagid=	$user->add($newUser);
	 		  	if($flagid)
	 		  	{
	 		  	$_SESSION["uid"] = $wxData["openid"];
					$_SESSION["username"] = $thisUser['username'];
					$_SESSION["time"] =String::msubstr( $thisUser['time'],0, 10,"utf-8",false);// $thisUser['time']; //strtotime( $thisUser['time']);
					$_SESSION["weixin"] ='';
					$_SESSION["wx_info"]=$wxData;
					$_SESSION["id"]=$flagid;
					$_SESSION["member"]=0;
					$this->success("登陆成功",U("Home/Member/index"));
	 		  	}else{
	 		  		$this->error("扫描错误，请联系管理人员,谢谢",U("Home/Index/index"));
	 		  	}
	 		  	
	 		  }else{
	 		  	$this->error("扫描错误，请联系管理人员,谢谢",U("Home/Index/index"));
	 		  }
	 		}
			}else{
				$this->error("扫描错误，请联系管理人员,谢谢",U("Home/Index/index"));
			}
	 	}else{
	 		$this->error("你无权访问",U("Home/Index/index"));
	 	}
	 	
	 }
    
}