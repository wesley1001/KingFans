<?php

function getCodimgName($url)
{
	$urlArr=explode('/', $url);
	if(count($urlArr)>0)
	return $urlArr[count($urlArr)-1];
	else 
	return '';
}

function json_decode_spnum($wx_info)
{
	$wx_info=json_decode($wx_info,true);
	if(count($wx_info)==1)
	 return $wx_info[0]['num'];
	 else 
	 return $wx_info['num'];
}


function json_decode_spname($wx_info)
{
	
	$wx_info=json_decode($wx_info,true);
	//$wx_info=array()[];
	if(count($wx_info)==1)
	 return $wx_info[0]['name'];
	 else 
	  return $wx_info['name'];
}

function json_decode_spprice($wx_info)
{
	$wx_info=json_decode($wx_info,true);
	if(count($wx_info)==1)
	 return $wx_info[0]['price'];
	 else
	  return $wx_info['price'];
}

function json_decode_nickname($wx_info)
{
	$wx_info=json_decode($wx_info,true);
	 return $wx_info['nickname'];
}

function json_decode_img($wx_info)
{
	$wx_info=json_decode($wx_info,true);
	 return $wx_info['headimgurl'];
}

function json_decode_city($wx_info)
{
	$wx_info=json_decode($wx_info,true);
	 return $wx_info['city'];
}

function json_decode_remark($wx_info)
{
	$wx_info=json_decode($wx_info,true);
	 return $wx_info['remark'];
}

/**
 * 其它版本
 * 使用方法：
 * $post_string = "app=request&version=beta";
 * request_by_other('http://facebook.cn/restServer.php',$post_string);
 */
function request_by_other($remote_server, $post_string)
{
	$context = array(
			'http' => array(
					'method' => 'POST',
					'header' => 'Content-type: application/x-www-form-urlencoded' .
					'\r\n'.'User-Agent : Jimmy\'s POST Example beta' .
					'\r\n'.'Content-length:' . strlen($post_string) + 8,
					'content' => 'mypost=' . $post_string)
	);
	$stream_context = stream_context_create($context);
	$data = file_get_contents($remote_server, false, $stream_context);
	return $data;
}
/**
 * Goofy 2011-11-30
 * getDir()去文件夹列表，getFile()去对应文件夹下面的文件列表,二者的区别在于判断有没有“.”后缀的文件，其他都一样
 */

//获取文件目录列表,该方法返回数组
function getDir($dir) {
	$dirArray[]=NULL;
	if (false != ($handle = opendir ( $dir ))) {
		$i=0;
		while ( false !== ($file = readdir ( $handle )) ) {
			//去掉"“.”、“..”以及带“.xxx”后缀的文件
			if ($file != "." && $file != ".." && !strpos($file,".") && $file != '.DS_Store') {
				$dirArray[$i]=$file;
				$i++;
			}
		}
		//关闭句柄
		closedir ( $handle );
	}
	return $dirArray;
}

//获取文件列表
function getFile($dir) {
	$fileArray[]=NULL;
	if (false != ($handle = opendir ( $dir ))) {
		$i=0;
		while ( false !== ($file = readdir ( $handle )) ) {
			//去掉"“.”、“..”以及带“.xxx”后缀的文件
			if ($file != "." && $file != ".."&&strpos($file,".")) {
				$fileArray[$i]="./imageroot/current/".$file;
				if($i==100){
					break;
				}
				$i++;
			}
		}
		//关闭句柄
		closedir ( $handle );
	}
	return $fileArray;
}

//调用方法getDir("./dir")……
function displayDir($str) {
	if (! is_dir ( $str ))
		die ( '不是一个目录！' );
	$files = array ();
	if ($hd = opendir ( $str )) {
		while ( $file = readdir ( $hd ) ) {
			if ($file != '.' && $file != '..') {
				if (is_dir ( $str . '/' . $file )) {
					$files [$file] = displayDir ( $str . '/' . $file );
				} else {
					$files [] = $file;
				}
			}
		}
	}
	return $files;
}
?>