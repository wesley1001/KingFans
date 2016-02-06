<?php
class MemberAction extends CommonAction {
	
	function m_zf() {
		$this->display();
	}
	
     function m_zf_zfb_begin() {//支付宝开始支付
     	
     	$typezf=I('post.typezf',"",'htmlspecialchars');
     	$wxid=I('post.wxid',"",'htmlspecialchars');
     	$phone=I('post.phone',"",'htmlspecialchars');
     	
     	if(empty($typezf)||empty($phone))
     	{
     		$this->error("微信号，手机号，必须填写，谢谢！");
     		return ;
     	}
     	
     	$order=M("order");
     	$map=array();
     	$map["orderid"]=date("Ymdhis",time()).$_SESSION["id"]."001";
     	$map["user_id"]=$_SESSION["id"];
     	$map["totalprice"]=0.01;
     	if($typezf=="zfb")
     	{
     	$map["pay_style"]='支付宝';
     	}
     	else if($typezf=="wx"){
     	$map["pay_style"]='微信支付';
     	}else{
     	    $this->error("支付类别错误，谢谢！");
     		return ;
     	}
     	//$orderData=$order->where("  user_id='".$map["user_id"]."' and pay_status in(8,1)")->find();
     	
     	//if($orderData)
     	//{
     	//    $this->error("你已经购买，不能再次购买，谢谢！");
     	//	return ;
     //	}
     	
     	$map["pay_status"]=0;
     	$map["note"]='';
     	$map["order_status"]=0;
     	$map["time"]= date("Y-m-d H:i:s",time());
     	$map["cartdata"]='';
     	$map["order_info"]='金粉丝测试';
     	$map["address"]='';
     	$map["phone"]=$phone;
     	$map["shouhuoname"]='';
     	$map["XID"]=0;
     	
     	$flag=$order->add($map);
     	
     	if($flag){
     		if($typezf=="zfb"){
     		//$this->redirect("http://www.k99p.com/api/wapalipay/alipayapi.php","",1,"正在连接支付宝");
     		header("Location:http://www.k99p.com/api/wapalipay/alipayapi.php?WIDout_trade_no=".$map["orderid"]."&WIDsubject=".$map["order_info"]."&WIDtotal_fee=".$map["totalprice"]."&WIDshow_url=".urlencode("http://www.k99p.com")."&WIDbody=".$map["order_info"]."&WIDit_b_pay=&WIDextern_token=");
     		return ;
     		}else if($typezf=="wx"){
     			$map["totalprice"]=$map["totalprice"]*100;
     			header("Location:http://www.k99p.com/api/wxpayapi/example/native.php?WIDout_trade_no=".$map["orderid"]."&WIDsubject=".$map["order_info"]."&WIDtotal_fee=".$map["totalprice"]."&WIDshow_url=".urlencode("http://www.k99p.com")."&WIDbody=".$map["order_info"]."&WIDit_b_pay=&WIDextern_token=");
     		return ;
     	}
     	}else{
     		$this->error("支付错误，请重试，谢谢！");
     	}
     	
     	
	}
	
  
	function hufeng() {
		//import ( 'Pageajax', APP_PATH . 'Common', '.class.php' );
		$_SESSION["an"] = "hufeng";
		$this->display();
	}
	
    function family() {
		//import ( 'Pageajax', APP_PATH . 'Common', '.class.php' );
		$_SESSION["an"] = "family";
		$this->display();
	}
	
  function family_fragment() {
		//import ( 'Pageajax', APP_PATH . 'Common', '.class.php' );
			import ( 'Pageajax', APP_PATH . 'Common', '.class.php' );
		
		 $kw=I('get.kw',"",'htmlspecialchars');
    $nowPage = I ( 'get.p',1, 'intval' );
    $Data = M(); // 实例化Data数据对象
    $sql="";
    $sql2="";
    $map=array();
    $mapPage=array();
    if(!empty($kw))
    {
    	$mapPage["kw"]=$kw;
    	//$j_array=array();
    	//$j_array['nickname']=$kw;
    	
    	//print_r($j_array);
    	//$kwok=json_encode($kw);
    //	print_r($kwok);
    	//$jstr=json_encode($j_array);
    	//str_replace('"nickname"','',)
    	//print_r(array(json_encode($j_array)));
    	//$okstr=str_replace('"','',$kwok);
    	//print_r($okstr);
    	$sql2=" and  ( address like '%".$kw."%')  ";
    }
    $sql = "select count(*) as c from wemall_user 
      where  (l_id='".$_SESSION["id"]."'  or l_b='".$_SESSION["id"]."' or l_c='".$_SESSION["id"]."')  " . $sql2;
    
    
   // $count      = $Data->where($map)->count();// 查询满足要求的总记录数
   $count = $Data->query ( $sql );
   $count=$count [0] ["c"];
    $Page       = new Pageajax($count,5,$mapPage);// 实例化分页类 传入总记录数
   
    // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
    //$nowPage = isset($_GET['p'])?$_GET['p']:1;
   // $list = $Data->where($map)->order(' id desc ')->page($nowPage.','.$Page->listRows)->select();
   $list = $Data->query ( "select wemall_user.* from wemall_user
      where   (l_id='".$_SESSION["id"]."'  or l_b='".$_SESSION["id"]."' or l_c='".$_SESSION["id"]."')  " . $sql2 . " order by " . 'id ' . " desc limit " . (($nowPage - 1) * $Page->listRows) . "," . $Page->listRows );
    $show       = $Page->show();// 分页显示输出
    $this->assign('page',$show);// 赋值分页输出
    $this->assign('list',$list);// 赋值数据集
		
		$this->display();
	}
	
	function hufeng_fragment() {
		import ( 'Pageajax', APP_PATH . 'Common', '.class.php' );
		
		 $kw=I('get.kw',"",'htmlspecialchars');
    $nowPage = I ( 'get.p',1, 'intval' );
    $Data = M(); // 实例化Data数据对象
    $sql="";
    $sql2="";
    $map=array();
    $mapPage=array();
    if(!empty($kw))
    {
    	$mapPage["kw"]=$kw;
    	//$j_array=array();
    	//$j_array['nickname']=$kw;
    	
    	//print_r($j_array);
    	//$kwok=json_encode($kw);
    //	print_r($kwok);
    	//$jstr=json_encode($j_array);
    	//str_replace('"nickname"','',)
    	//print_r(array(json_encode($j_array)));
    	//$okstr=str_replace('"','',$kwok);
    	//print_r($okstr);
    	$sql2=" and  ( address like '%".$kw."%')  ";
    }
    $sql = "select count(*) as c from wemall_user 
      where   codeimg <>'0'   " . $sql2;
    
    
   // $count      = $Data->where($map)->count();// 查询满足要求的总记录数
   $count = $Data->query ( $sql );
   $count=$count [0] ["c"];
    $Page       = new Pageajax($count,5,$mapPage);// 实例化分页类 传入总记录数
   
    // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
    //$nowPage = isset($_GET['p'])?$_GET['p']:1;
   // $list = $Data->where($map)->order(' id desc ')->page($nowPage.','.$Page->listRows)->select();
   $list = $Data->query ( "select wemall_user.* from wemall_user
      where  codeimg <>'0'   " . $sql2 . " order by " . 'id ' . " desc limit " . (($nowPage - 1) * $Page->listRows) . "," . $Page->listRows );
    $show       = $Page->show();// 分页显示输出
    $this->assign('page',$show);// 赋值分页输出
    $this->assign('list',$list);// 赋值数据集
		
		$this->display();
	}
	
	function index() {
		   
		    $usersresult = R ( "Api/Api/getuser", array (
					$_SESSION["uid"] 
			) );
			$where = array();
			$where ["status"] = 0;
			$where ["level_id"] = $usersresult['id'];
			$start_price = M ( "Order_level" )->where($where)->sum('price');
			
			$where = array();
			$where ["status"] = 1;
			$where ["level_id"] = $usersresult['id'];
			$over_price = M ( "Order_level" )->where($where)->sum('price');
			
			$where = array();
			$where ["status"] = 2;
			$where ["level_id"] = $usersresult['id'];
			$confirm_price = M ( "Order_level" )->where($where)->sum('price');
			
			$where = array();
			$where ["status"] = 3;
			$where ["level_id"] = $usersresult['id'];
			$add_over_price = M ( "Order_level" )->where($where)->sum('price');
			
			$where = array();
			$where ["status"] = 0;
			$where ["uid"] = $usersresult['id'];
			$get_start_price = M ( "Tx_record" )->where($where)->sum('price');
			
			$where = array();
			$where ["status"] = 1;
			$where ["uid"] = $usersresult['id'];
			$get_end_price = M ( "Tx_record" )->where($where)->sum('price');
			
			$start_price = $start_price>0 ? $start_price : 0;
			$over_price = $over_price>0 ? $over_price : 0;
			$confirm_price = $confirm_price>0 ? $confirm_price : 0;
			$add_over_price = $add_over_price>0 ? $add_over_price : 0;
			$get_end_price = $get_end_price>0 ? $get_end_price : 0;
			$get_start_price = $get_start_price>0 ? $get_start_price : 0;
			
			$all_price = $start_price+$over_price+confirm_price+add_over_price;
			
			$all_price = bcadd($start_price, $over_price, 2);
			$all_price = bcadd($all_price, $confirm_price, 2);
			$all_price = bcadd($all_price, $add_over_price, 2);
			
			
			$this->assign ( "start_price", $start_price );
			$this->assign ( "over_price", $over_price );
			$this->assign ( "confirm_price", $confirm_price );
			$this->assign ( "add_over_price", $add_over_price );
			$this->assign ( "get_start_price", $get_start_price );
			$this->assign ( "get_end_price", $get_end_price );
			$this->assign ( "all_price", $all_price );//佣金
			$_SESSION["all_price"]=$all_price;
			$this->assign ( "users", $usersresult );
			
			/***
			$type_a_url = 'http://' . $_SERVER ['SERVER_NAME']. U('App/Member/member_info',array('type'=>1,'id'=>$usersresult['id']));
			$type_b_url = 'http://' . $_SERVER ['SERVER_NAME']. U('App/Member/member_info',array('type'=>2,'id'=>$usersresult['id']));
			$type_c_url = 'http://' . $_SERVER ['SERVER_NAME']. U('App/Member/member_info',array('type'=>3,'id'=>$usersresult['id']));
			$this->assign ( "type_a_url", $type_a_url );
			$this->assign ( "type_b_url", $type_b_url );
			$this->assign ( "type_c_url", $type_c_url );
			***/
			
			$all_cnt = $usersresult['a_cnt']+$usersresult['b_cnt']+$usersresult['c_cnt'];
			$this->assign ( "all_cnt", $all_cnt );
			
			$where = array();
			$where ["uid"] = $usersresult['id'];
			$tx_record = M ( "Tx_record" )->where($where)->select();

			$this->assign ( "tx_record", $tx_record );
			
			if($usersresult['member']==1 && (empty($usersresult['ticket']) || empty($usersresult['url'])))
			{
				//$this->add_member($usersresult['id'],$usersresult['uid']);
			}
			
			$where = array();
			$where ["level_id"] = $usersresult['id'];
			$all_buy = M ( "Order_level" )->where($where)->count();
			
			$where = array();
			$where ["status"] = 0;
			$where ["level_id"] = $usersresult['id'];
			$all_over_buy = M ( "Order_level" )->where($where)->count();
			
			$all_start_buy = $all_buy - $all_over_buy;//已付款
			
			$this->assign ( "all_buy", $all_start_buy );//已付款
			$this->assign ( "all_over_buy", $all_over_buy );//未付款
			$this->assign ( "all_count_buy", $all_buy );//总付款
			
			//营业额
			/*$result = M ( "Good" )->find ();
			$all_buy_price = $result['price']*$all_buy;
			$this->assign ( "all_buy_price", $all_buy_price );*/
			$db = new Model();
            $ALL_COUNT = $db->query("SELECT sum(`totalprice`) as total FROM `wemall_order_level` inner join `wemall_order` on `wemall_order_level`.`order_id` =  `wemall_order`.`orderid` where `level_id`=$usersresult[id]");
			$all_buy_price = empty($ALL_COUNT[0]['total']) ? 0 : $ALL_COUNT[0]['total'];
			$this->assign ( "all_buy_price", $all_buy_price );//销售额
			$_SESSION["all_buy_price"]=$all_buy_price;
			
			$_SESSION["price"]=$usersresult['price'];
			
			$this->orderlist=M("order")->where("user_id=". $usersresult['id'])->limit(0,5)->order(" id desc")->select();
			$this->familylist=M("user")->where("l_id=".$usersresult['id'])->limit(0,7)->order(" id desc")->select();
			
			//推荐人
		//	$l_name = $this->get_l_info($usersresult['l_id']);
		//	$l_name = $l_name['nickname'];
		//	$l_name = !empty($l_name) ? $l_name : ''.$message_name.'';
		//	$this->assign ( "l_name", $l_name );
			
			
		//	$ticket = R ( "Api/Api/ticket", array (
		//			$usersresult 
		//	) );
			
		//	$this->assign ( "ticket", $ticket['ticket'] );
			
		//	$this->assign ( "dongjia_time", $this->dongjia_time );
			
		//	$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.'g=App&m=Member&a=register&mid='.$usersresult['id'];
		//	$this->assign ( "member_url", $url );
		
		
		
		$this->display();
	}
	
	function order() {
		$_SESSION["an"] = "order";
			import ( 'Pageajax', APP_PATH . 'Common', '.class.php' );
		
		 $kw=I('get.kw',"",'htmlspecialchars');
    $nowPage = I ( 'get.p',1, 'intval' );
    $Data = M(); // 实例化Data数据对象
    $sql="";
    $sql2="";
    $map=array();
    $mapPage=array();
    if(!empty($kw))
    {
    	$mapPage["kw"]=$kw;
    	$j_array=array();
    	$j_array['nickname']=$kw;
    	
    	//print_r($j_array);
    	$kwok=json_encode($kw);
    //	print_r($kwok);
    	//$jstr=json_encode($j_array);
    	//str_replace('"nickname"','',)
    	//print_r(array(json_encode($j_array)));
    	$okstr=str_replace('"','',$kwok);
    	//print_r($okstr);
    	$sql2=" and  ( cartdata like '%".$okstr."%')  ";
    }
    $sql = "select count(*) as c from wemall_order 
      where  user_id=".$_SESSION["id"]."  " . $sql2;
    
    
   // $count      = $Data->where($map)->count();// 查询满足要求的总记录数
   $count = $Data->query ( $sql );
   $count=$count [0] ["c"];
   $Page = new Pageajax($count,5,$mapPage);// 实例化分页类 传入总记录数
   
    // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
    // $nowPage = isset($_GET['p'])?$_GET['p']:1;
    // $list = $Data->where($map)->order(' id desc ')->page($nowPage.','.$Page->listRows)->select();
      $list = $Data->query ( "select* from wemall_order
      where   user_id=".$_SESSION["id"]."  "  . $sql2 . " order by " . 'id ' . " desc limit " . (($nowPage - 1) * $Page->listRows) . "," . $Page->listRows );
    $show       = $Page->show();// 分页显示输出
    $this->assign('page',$show);// 赋值分页输出
    $this->assign('list',$list);// 赋值数据集
		$this->display();
	}

	function index2() {
		$uid = $_GET['uid'];
		$where = array('uid'=>$uid);
		$users = M("User")->where($where)->find();

		$this->assign("users",$users);
		if ( empty($users) ) {
			exit('未查到该用户信息');
		}
		if ( IS_POST ) {
				
			if (!$_POST['login']) {
				$this->error("请输入用户名");
				exit;
			}else {
				$map['login'] = $_POST['login'];
				$map['uid'] = array('neq',$_GET['uid']);
				$check = M("User")->where($map)->find();
				if (!empty($check)) {
					$this->error("该用户名已存在！请重新输入");
					exit;
				}
			}

			if (!$_POST['password']) {
				unset($_POST['password']);
			}else {
				$_POST['password'] = md5($_POST['password']);
			}

			import ( 'ORG.Net.UploadFile' );
			$upload = new UploadFile (); // 实例化上传类
			$upload->maxSize = 3145728; // 设置附件上传大小
			$upload->allowExts = array (
					'jpg',
					'gif',
					'png',
					'jpeg',
					'xlsx',
					'xls'
			); // 设置附件上传类型
			$upload->savePath = './Public/Uploads/';
			$wx_info = array();
			$wx_info = json_decode($users['wx_info'],true);
			if (! $upload->upload ()) { // 上传错误提示错误信息
				$wx_info['nickname'] = $_POST['login'];
				$_POST['wx_info'] = json_encode($wx_info);
			} else { 
				$info = $upload->getUploadFileInfo ();
				$path = $upload->savePath.$info[0]['savename'];
				$wx_info['nickname'] = $_POST['login'];
				$wx_info['headimgurl'] = $path;
				$_POST['wx_info'] = json_encode($wx_info);
			}
			M("User")->where($where)->save($_POST);
			$this->success("保存成功！",U('App/Index/member',array("uid"=>$users['uid'])) );
			exit;
		}

		$this->display("./default/Index/member_index");
	}


	function login1() {
		if ( IS_POST ) {
			if (!$_POST['login']) {
				$this->error("请输入用户名");
				exit;
			}
			if (!$_POST['password']) {
				$this->error("请输入登陆密码");
				exit;
			}

			$thisUser = M("User")->where(array('login'=>$_POST['login']))->find();
			if (empty($thisUser)) {
				$this->error("用户名不存在！");
				exit;
			}else {
				if ($thisUser['password'] == md5($_POST['password'])) {
					$_SESSION["uid"] = $thisUser['uid'];
					
					$this->success("登陆成功！",U('App/Index/member',array("uid"=>$thisUser['uid'])) );exit;
				}else {
					$this->error("密码错误！");
					exit;
				}
			}
		}
		
		$this->display("./default/Index/member_login");
	}
	
	
	function logout() {
		unset($_SESSION["uid"]);
	     unset($_SESSION);
         session_destroy();
		$this->success("退出登录！",U('Home/Index/index'));
		exit;
	}

	function register() {
		if ( IS_POST ) {
			if (!$_POST['login']) {
				$this->error("请输入用户名");
				exit;
			}else {
				$map['login'] = $_POST['login'];
				$check = M("User")->where($map)->find();
				if (!empty($check)) {
					$this->error("该用户名已存在！请重新输入");
					exit;
				}
			}
			if (!$_POST['password']) {
				$this->error("请输入登陆密码");
				exit;
			}
			$_POST['uid'] = rand();
			$_POST['password'] = md5($_POST['password']);
			$id = M("User")->add($_POST);
			$new_user_id = $id;
			$user = array();
			$user['uid'] = $id;
			$wx_info = json_encode(array('nickname'=>$map['login'],'subscribe_time'=>time()));
			$user['wx_info'] = $wx_info;
			
			if($_GET['mid']){
				$m = M ( "User" );
				include dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/Public/Conf/button_config.php'; 
				$where = array();
				$where["id"] = (int)$_GET['mid'];
				$results = $m->where($where)->find ();
				
				if(!empty($results['id']))
				{
					import ( 'Wechat', APP_PATH . 'Common/Wechat', '.class.php' );
			$config = M ( "Wxconfig" )->where ( array (
					"id" => "1" 
			) )->find ();
			
			$options = array (
					'token' => $config ["token"], // 填写你设定的key
					'encodingaeskey' => $config ["encodingaeskey"], // 填写加密用的EncodingAESKey
					'appid' => $config ["appid"], // 填写高级调用功能的app id
					'appsecret' => $config ["appsecret"], // 填写高级调用功能的密钥
					'partnerid' => $config ["partnerid"], // 财付通商户身份标识
					'partnerkey' => $config ["partnerkey"], // 财付通商户权限密钥Key
					'paysignkey' => $config ["paysignkey"]  // 商户签名密钥Key
					);
					$weObj = new Wechat ( $options );
				
					$user ["l_id"] = $results['id'];
					
					//增加分销人
					$a_info = array();
					$a_info['id'] = $results['id'];
					$a_info['a_cnt'] = $results['a_cnt']+1;
					$user_id = M ( "User" )->save ( $a_info );
					
					if(strlen($results['uid'])>10)
					{
						$data = array();
						$data['touser'] = $results['uid'];
						$data['msgtype'] = 'text';
						$data['text']['content'] = '【'.$map[login].'】通过分享链接，成为您的'.$message_name.'家族成员！';
						$weObj->sendCustomMessage($data);
					}
					
					if($results['l_id'])//b jibie
					{
						$where = array();
						$where["id"] = $results['l_id'];
						$b_results = $m->where($where)->find ();
						
						if(!empty($b_results))
						{
							$b_info = array();
							$b_info['id'] = $b_results['id'];
							$b_info['b_cnt'] = $b_results['b_cnt']+1;
							$user_id = M ( "User" )->save ( $b_info );
							
							$user["l_b"] = $b_results['id'];
							
							if(strlen($b_results['uid'])>10)
							{
								$data = array();
								$data['touser'] = $b_results["uid"];
								$data['msgtype'] = 'text';
								$data['text']['content'] = '【'.$map[login].'】通过分享链接，成为您的'.$message_name.'家族成员！';
								$weObj->sendCustomMessage($data);
							}
							
							if($b_results['l_id'])//c jibie
							{
								$where = array();
								$where["id"] = $b_results['l_id'];
								$c_results = $m->where($where)->find ();
								
								if(!empty($c_results))
								{
									$c_info = array();
									$c_info['id'] = $c_results['id'];
									$c_info['c_cnt'] = $c_results['c_cnt']+1;
									$user_id = M ( "User" )->save ( $c_info );
									
									$user["l_c"] = $c_results['id'];
									
									if(strlen($c_results['uid'])>10)
									{
										$data = array();
										$data['touser'] = $c_results["uid"];
										$data['msgtype'] = 'text';
										$data['text']['content'] = '【'.$map[login].'】通过分享链接，成为您的'.$message_name.'家族成员！';
										$weObj->sendCustomMessage($data);
									}
								}
							}
						}
					}
				}
			}
			
			M("User")->where($map)->save($user);
			$_SESSION["uid"] = $new_user_id;
			$this->success("登陆成功！",U('App/Index/member',array("uid"=>$id)));exit;
			
		}
		$this->display("./default/Index/member_register");
	}
	
}