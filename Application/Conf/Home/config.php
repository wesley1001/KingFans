<?php
return array(
   
    'SHOW_PAGE_TRACE'           =>  0,//显示调试信息
    'TMPL_PARSE_STRING'         =>array(
			'__PUBLIC__' => '/Public/home',
			'__LIB__' => '/Public/lib',
            '__cfg_softname__' => '金粉丝',
            '__cfg_version__' => '1.0',
            '__cfg_index__' => 'www.k99p.com'
	),
	'COOKIE_PATH'       =>  '/',
	'COOKIE_EXPIRE'     => 3600*24*31,
	'PAGE_LIST_ROWS'    => 10,	// 每一屏显示的数量
	'HTML_CACHE_ON'     =>    true, // 开启静态缓存
    'HTML_CACHE_TIME'   =>    220,   // 全局静态缓存有效期（秒）
    'HTML_FILE_SUFFIX'  =>    '.shtml', // 设置静态缓存文件后缀
	'HTML_PATH'         => '/html',//静态缓存文件目录，HTML_PATH可任意设置，此处设为当前项目下新建的html目录
    //'HTML_CACHE_RULES'  =>     array(  // 定义静态缓存规则
    //'index:'=>array('Index/{:action}_{id}','600'),
     //),
     
     
     
     
     
     
     
     
     
     
     
     
     
     
);