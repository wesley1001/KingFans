<?php
class CommonAction extends Action {
	
  function _initialize() {
      
      	header("Content-type: text/html; charset=utf-8"); 
                if (!$_SESSION["uid"]) {
                    //跳转到认证网关
                   // redirect(PHP_FILE . C('USER_AUTH_GATEWAY'));
                   redirect("/index.php?g=Home&m=Index&a=index","2","请登陆");
                }
                // 没有权限 抛出错误
         
    }
	
    public function index(){
	$this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p></div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }
}