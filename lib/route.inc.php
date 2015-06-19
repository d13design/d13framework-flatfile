<?php

//

$url = $_SERVER['REQUEST_URI'];
$url = str_replace($path,'',$url);

$t = preg_split('[\\/]',$url,-1,PREG_SPLIT_NO_EMPTY);
$s = explode('?',$t[0]);

$route = array();
for($a=0;$a<count($t);$a++){
	$route[] = $t[$a];
}
unset($url,$t,$s,$a);
if(count($route)==0){
	$route[0] = 'index';
}else{
	$temp = explode("?",$route[count($route)-1]);
	$route[count($route)-1] = $temp[0];
	$qs = $temp[1];
}

$file = '';
for($a=0;$a<count($route);$a++){
	$file = $file.'/'.$route[$a];
}
if(!file_exists('content'.$file.'.md')){
	if(!file_exists('content'.$file.'/index.md')){
		$file = '/errors/404';
	}else{
		$file = $file.'/index';
	}
}

$file_content = file_get_contents('content'.$file.'.md', FILE_USE_INCLUDE_PATH);
$file_content = explode('*/',$file_content);

$page_meta = explode("\n",$file_content[0]);
$document = array();
$document['meta'] = array();
for($a=1;$a<count($page_meta)-1;$a++){
	$temp = explode(": ",$page_meta[$a]);
	$document['meta'][strtolower($temp[0])] = $temp[1];
}
if(!$document['meta']['template']) $document['meta']['template'] = 'default';

$Parsedown = new Parsedown();
$document['content'] = $Parsedown->text($file_content[1]);
unset($page_meta,$file_content);