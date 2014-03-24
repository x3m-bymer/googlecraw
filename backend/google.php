<?php
//require_once 'GoogleSearchCrawler.class.php';

$i=0;
//$crawler = new GoogleSearchCrawler();
$fres = 'REZZZZZZZZZ.txt';
set_time_limit(0);
$f	= 'store.txt';
$tlimit = 60;
$farr	=	@file($f);
if(empty( $farr )){
	print "File ".$f." not found";
	exit();
}
$add = 'inurl:".php?id="';
$g = array(
'bmapi.fh2web.com?u=http://www.google.com/search?pws=0&safe=off&num=100&start=0&as_qdr=all&q=',
'x3m-bymer.comyr.com?u=http://www.google.com/search?pws=0&safe=off&num=100&start=0&as_qdr=all&q=',
'akyrilov.byethost10.com?u=http://www.google.com/search?pws=0&safe=off&num=100&start=0&as_qdr=all&q=',
'www.allplaces.biz/in.php?u=http://www.google.com/search?pws=0&safe=off&num=100&start=0&as_qdr=all&q='
);
$ud = array();
$j = 0;
foreach($farr as $k=>$v){
$i++;
$url = $g[$j].urlencode(trim($v)." ".$add);
print "==================\n";
print $url."\n";
print "==================\n";
if($j>=(count($g)-1)){
	$j = 0;
} else {
	$j++;
}
 $c = get_content($url);
 if(strstr($c, "<a href=\"/url?q=")){
 $d = getLinks($c);
 foreach($d as $k=>$v){
	$n = substr($v[1], 0, strrpos($v[1], "&amp;sa=U"));
	$url = str_replace("<a href=\"/url?q=","",$n);
	$parse = parse_url($url);
	$url = urldecode($url);
	print $url."\n";
	if(!array_key_exists($parse['host'], $ud)){
		$ud[$parse['host']]="";
		//print_r($d);
		file_put_contents($fres,$url."\r\n",FILE_APPEND);
	} 
 }
 } else {
    print $c."\n";
 }
 print $i;
 sleep(ceil($tlimit/count($g)));
}

function getLinks($str){
		$regex = '/<\s*h3 class="r"[^>]*>(.*?)<\/h3>/';
		preg_match_all($regex, $str, $matches, PREG_SET_ORDER);
		return $matches;
}
 
function get_content($url){
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT,5000);
$curl_scraped_page = curl_exec($ch);
curl_close($ch);

return $curl_scraped_page;
}