<?php
$buy_button = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.'g=App&m=Index&a=index_info&refresh=1';
$jiazu_button = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.'g=App&m=Index&a=member&refresh=1';
$newmenu = '{
		 "button":[
			{	
			  "type":"click",
			  "name":"疯狂加粉",
			  "key":"GET_UURL"
			},
			{
				"name":"家族中心",
				
				"sub_button":[
				{	
				   "name":"赚佣金",
				   "type":"view",
					"url":"http://mp.weixin.qq.com/s?__biz=MzAwNzU3NTc5MQ==&mid=206269322&idx=1&sn=95fdf15b6cec9f44cca0e29a5a7c2a77#rd"
				},
				{
				   "type":"click",
				   "name":"我的二维码",
				   "key":"GET_PIC"
				},
				{
				   "name":"我的家族中心",
				"type":"view",
				"url":"'.$jiazu_button.'"
				}]
				
				
				
		   },
		   {
			   "name":"我的助手",
			   
			    "sub_button":[
			    	{	
				   "name":"如何赚佣金",
				   "type":"view",
					"url":"http://mp.weixin.qq.com/s?__biz=MzAwNzU3NTc5MQ==&mid=206269322&idx=1&sn=95fdf15b6cec9f44cca0e29a5a7c2a77#rd"
				},
				{	
				   "name":"怎么加粉",
				   "type":"view",
					"url":"http://mp.weixin.qq.com/s?__biz=MzAwNzU3NTc5MQ==&mid=206273811&idx=1&sn=b242b2788fed7ffa4d45421be0f82ce1#rd"
				},
				{
				   "name":"常见问题",
				   "type":"click",
					"key":"GET_INFO"
				}]
		   }]
		}';		
		
$message_name = '众联星空';
$link_config = 'http://mp.weixin.qq.com/s?__biz=MzAwNzU3NTc5MQ==&mid=206269601&idx=1&sn=9c459d6057675fb97d34ff487d761e5a#rd';
$config_good_pic = 'http://mao.8208111.com/imgpublic/goodpic.png';
$headimgurl = 'http://mao.8208111.com/imgpublic/2weima.jpg';
?>