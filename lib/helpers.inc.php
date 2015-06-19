<?php

//

require_once 'lib/parsedown.inc.php';

// Embed a CSS file
function html_css($f,$rel="stylesheet"){
	echo '<link rel="'.$rel.'" type="text/css" href="'.SITE_URL.'/templates/'.TEMPLATE.'/css/'.$f.'" />';
}

// Embed a shared Javascript file
function html_js($f){
	echo '<script type="text/javascript" src="'.SITE_URL.'/js/'.$f.'"></script>';
}

// Embed a theme Javsacript file
function html_theme_js($f){
	echo '<script type="text/javascript" src="'.SITE_URL.'/templates/'.TEMPLATE.'/js/'.$f.'"></script>';
}

// Add page meta tags
function html_meta(){
	global $document;
	if(!$document['meta']['title']){
		$ptitle = SITE_NAME;
		$ptitlelong = $ptitle;
	}else{
		$ptitle = $document['meta']['title'];
		$ptitlelong = SITE_NAME.' &gt; '.$ptitle;
	}
	if(!$document['meta']['description']){
		$pdescrip = SITE_DESCRIPTION;
	}else{
		$pdescrip = $document['meta']['description'];
	}
	if(!$document['meta']['keywords']){
		$pkeywords = SITE_KEYWORDS;
	}else{
		$pkeywords = $document['meta']['keywords'];
	}
	if(!$document['meta']['author']){
		$pauthor = SITE_AUTHOR;
	}else{
		$pauthor = $document['meta']['author'];
	}
	if(!$document['meta']['robots']){
		$robots = 'INDEX,FOLLOW';
	}else{
		$robots = $document['meta']['robots'];
	}
	if(!$document['meta']['ogimage']){
		$ogimage = SITE_URL.'/templates/'.TEMPLATE.'/img/og.jpg';
	}else{
		$ogimage = SITE_URL.$document['meta']['ogimage'];
	}
	$purl = SITE_URL.$_SERVER['REQUEST_URI'];
	
	echo '<title>'.$ptitlelong.'</title>';
	echo '<meta charset="utf-8">';
	echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
	echo '<meta name="description" content="'.$pdescrip.'">';
	echo '<meta name="keywords" content="'.$pkeywords.'">';
	echo '<meta name="author" content="'.$pauthor.'">';
	echo '<meta name="ROBOTS" content="'.$robots.'">';
	echo '<meta property="og:site_name" content="'.SITE_NAME.'">';
	echo '<meta property="og:title" content="'.$ptitle.'">';
	echo '<meta property="og:type" content="article">';
	echo '<meta property="og:image" content="'.$ogimage.'">';
	echo '<meta property="og:description" content="'.$pdescrip.'">';
	echo '<meta property="og:locale" content="'.LOCALE.'">';
	echo '<meta property="og:url" content="'.$purl.'">';
	echo '<meta name="twitter:site" content="@'.TWITTER_HANDLE.'">';
	echo '<meta name="twitter:title" content="'.SITE_NAME.'">';
	echo '<meta name="twitter:description" content="'.$ptitle.' - '.$pdescrip.'">';
	echo '<meta name="twitter:url" content="'.$purl.'">';
	echo '<meta name="twitter:image" content="'.$ogimage.'">';
}

// Create a first level menu
function menu($showhome=true,$showtop=true){
	global $route;
	$list = scandir('content');
	$newlist = array();
	for($a=0;$a<count($list);$a++){
		if(!is_dir('content/'.$list[$a]) || $list[$a]=='.' || $list[$a]=='..' || $list[$a]=='errors'){
			if(substr($list[$a],-3,3)==".md" || substr($list[$a],-3,3)==".MD"){
				if($list[$a] != 'index.md') $newlist[] = substr($list[$a],0,-3);
			}
		}else{
			$newlist[] = $list[$a];
		}
	}
	//print_r($newlist);
	echo '<ul>';
	if($showtop){
		echo '<li><a href="#top">Top</a></li>';
	}
	if($showhome){
		if(count($route)==1){
			$class = 'active';
		}else{
			$class = '';
		}
		echo '<li class="'.$class.'"><a href="'.SITE_URL.'">Home</a></li>';
	}
	for($a=0;$a<count($newlist);$a++){
		if($route[0]==$newlist[$a]){
			$class = 'active';
		}else{
			$class = '';
		}
		echo '<li class="'.$class.'"><a href="'.SITE_URL.'/'.$newlist[$a].'">'.ucfirst($newlist[$a]).'</a></li>';
	}
	echo '</ul>';
}

// Create a sub menu

// Format dates
function pretty_date($d,$length='medium'){
	$d = strtotime($d);
	if($length=='short'){		return date("F Y",$d); }
	if($length=='medium'){		return date("d F, Y",$d); }
	if($length=='long'){		return date("l, d F Y",$d); }
	if($length=='x-long'){		return date("l, d F Y - H:i a",$d); }
}

// Email link
function html_email($address=SITE_EMAIL){
	$address = '<'.$address.'>';
	$pd = new Parsedown();
	$md = $pd->text($address);
	return $md;
}

// List content within a section
function list_children($template="",$shownundated=false,$first=0,$count=PAGE_COUNT){
	global $route;
	global $qs;
	if(!$qs || $qs<0){
		$qs=$first;
	}else{
		$first=$qs;
	}
	$p = '';
	for($a=0;$a<count($route);$a++){
		$p = $p.'/'.$route[$a];
	}
	$list = scandir('content'.$p);
	$newlist = array();
	for($a=0;$a<count($list);$a++){
		if(!is_dir($list[$a]) && $list[$a]!='.' && $list[$a]!='..' && $list[$a]!='index.md' && $list[$a]!='.DS_Store'){
			$newlist[] = array();
			$newlist[count($newlist)-1]['file'] = $list[$a];
			$newlist[count($newlist)-1]['fc'] = file_get_contents('content'.$p.'/'.$list[$a], FILE_USE_INCLUDE_PATH);
			$temp = explode('*/',$newlist[count($newlist)-1]['fc']);
			$temp = explode("\n",$temp[0]);
			$meta = array();
			for($b=1;$b<count($temp)-1;$b++){
				$t = explode(": ",$temp[$b]);
				$newlist[count($newlist)-1][strtolower($t[0])] = $t[1];
			}
			unset($newlist[count($newlist)-1]['fc']);
		}
	}
	$sortArray = array(); 
	foreach($newlist as $article){ 
		foreach($article as $key=>$value){ 
			if(!isset($sortArray[$key])){ 
				$sortArray[$key] = array(); 
			} 
			$sortArray[$key][] = $value; 
		} 
	} 
	$orderby = "date"; //change this to whatever key you want from the array 
	array_multisort($sortArray[$orderby],SORT_DESC,$newlist); 
	if($template==''){
		echo '<ul>';
		for($a=$first;$a<$first+$count && $a<count($newlist);$a++){
			$article = $newlist[$a];
			if($shownundated || $article['date']){
				echo '<li>'.pretty_date($article['date']).': <a href="'.SITE_URL.$p.'/'.substr($article['file'],0,-3).'" title="'.$article['title'].'">'.$article['title'].'</a></li>';
			}
		}
		echo '</ul>';
	}else{
		//print_r($newlist);
		for($a=$first;$a<$first+$count && $a<count($newlist);$a++){
			$article = $newlist[$a];
			include $_SERVER['DOCUMENT_ROOT'].'/templates/'.TEMPLATE.'/'.$template;
		}
	}
	//pagingation
	if(count($newlist)>$count){
		$items = array();
		if($first == 0){
			$items[] = '<li class="disabled"><a href="#">&laquo;</a></li>';
			$items[] = '<li class="disabled"><a href="#">&lt;</a></li>';
		}else{
			$items[] = '<li class=""><a href="'.SITE_URL.$p.'" title="First page">&laquo;</a></li>';
			$items[] = '<li class=""><a href="'.SITE_URL.$p.'?'.($qs-$count).'" title="Previous page">&lt;</a></li>';
		}
		
		for($x=0;$x<ceil(count($newlist)/$count);$x++){
			if($x*$count==$first){
				$items[] = '<li class="active"><a href="">'.($x+1).'</a></li>';
			}else{
				$items[] = '<li><a title="Page '.($x+1).'" href="'.SITE_URL.$p.'?'.($x*$count).'">'.($x+1).'</a></li>';
			}
		}
		
		if($qs+$count >= count($newlist)){
			$items[] = '<li class="disabled"><a href="#">&gt;</a></li>';
			$items[] = '<li class="disabled"><a href="#">&raquo;</a></li>';
		}else{
			$items[] = '<li class=""><a href="'.SITE_URL.$p.'?'.($qs+$count).'" title="Next page">&gt;</a></li>';
			$items[] = '<li class=""><a href="'.SITE_URL.$p.'?'.(($x-1)*$count).'" title="Last page">&raquo;</a></li>';
		}
		
		echo '<div class="pagination"><ul>';
		foreach($items as $item){
			echo $item;
		}
		echo '</ul></div>';
		
	}
}

// Shortlist content within a section
function list_articles($section='blog',$count=5){
	$list = scandir('content/'.$section);
	$newlist = array();
	for($a=0;$a<count($list);$a++){
		if(!is_dir($list[$a]) && $list[$a]!='.' && $list[$a]!='..' && $list[$a]!='index.md' && $list[$a]!='.DS_Store'){
			$newlist[] = array();
			$newlist[count($newlist)-1]['file'] = $list[$a];
			$newlist[count($newlist)-1]['fc'] = file_get_contents('content/'.$section.'/'.$list[$a], FILE_USE_INCLUDE_PATH);
			$temp = explode('*/',$newlist[count($newlist)-1]['fc']);
			$temp = explode("\n",$temp[0]);
			$meta = array();
			for($b=1;$b<count($temp)-1;$b++){
				$t = explode(": ",$temp[$b]);
				$newlist[count($newlist)-1][strtolower($t[0])] = $t[1];
			}
			unset($newlist[count($newlist)-1]['fc']);
		}
	}
	$sortArray = array(); 
	foreach($newlist as $article){ 
		foreach($article as $key=>$value){ 
			if(!isset($sortArray[$key])){ 
				$sortArray[$key] = array(); 
			} 
			$sortArray[$key][] = $value; 
		} 
	} 
	$orderby = "date"; //change this to whatever key you want from the array 
	array_multisort($sortArray[$orderby],SORT_DESC,$newlist); 
	for($a=0;$a<$count && $a<count($newlist);$a++){
		echo '<li><a href="/'.$section.'/'.substr($newlist[$a]['file'],0,-3).'" title="'.$newlist[$a]['title'].'">'.$newlist[$a]['title'].'</a></li>';
	}
	if(count($newlist) > $count){
		echo '<li><a href="/'.$section.'" title="Read more...">Read more</a></li>';
	}
}

// Add pagination