<?php
//通天科技（QQ120892620）提醒，该文件一定不要用记事本编辑，可用notepad++

	header('Content-Type:text/html; charset=utf-8');

	error_reporting(E_ALL & ~E_NOTICE);

	
	define('DB_HOST', 'localhost');
	define('DB_USER', 'kfans');
	define('DB_PWD', 'hf2015#$3890');
	define('DB_NAME', 'wxfx');
	define('DB_PREFIX', 'wemall_');
	define ('FENURL','http://t.k99p.com');		//加粉列url地址，不要加/

	

	$conn = @mysql_connect(DB_HOST, DB_USER, DB_PWD) or die('数据库链接失败：'.mysql_error());

	

	@mysql_select_db(DB_NAME) or die('数据库错误：'.mysql_error());

	

	@mysql_query('SET NAMES UTF8') or die('字符集错误：'.mysql_error());

?>