<?php
set_time_limit(0); // устанавливаем неограниченное время выполнения скрипта

$i  =   0;
$j  =   0;
$tlimit = 60; // лимит времени повторного запроса к одному апи

$g = array( // массив прокси серверов
    'bmapi.fh2web.com?u=http://www.google.com/search?pws=0&safe=off&num=100&start=0&as_qdr=all&q=',
    'x3m-bymer.comyr.com?u=http://www.google.com/search?pws=0&safe=off&num=100&start=0&as_qdr=all&q=',
    'akyrilov.byethost10.com?u=http://www.google.com/search?pws=0&safe=off&num=100&start=0&as_qdr=all&q=',
    'www.allplaces.biz/in.php?u=http://www.google.com/search?pws=0&safe=off&num=100&start=0&as_qdr=all&q='
);

$fres = 'REZZZZZZZZZ.txt';
while (true == true){
    $fdata = process_file('new'); // берем данные из первого файла из папки new
    if(!$fdata){
        print "[core] : sleep\n";
        sleep(5);
        continue;
    }
    foreach($fdata['data'] as $k=>$v){
        $i++;
        $url = getUrl($v, $fdata['add'])."\n";
        $c = get_content($url);

        if(strstr($c, "<a href=\"/url?q=")){
            $d = getLinks($c);
            print join("\n", $d);
        } else {
            print $c."\n";
        }

        $timeout = ceil($tlimit/count($g));
        print "\n[core] : $i sleep $timeout\n";

        sleep($timeout);
    }
}

function getUrl($key, $add) // получить ссылку для запроса апи
{
    global $g, $j;
    $q = trim("$key $add");
    $url = $g[$j].urlencode($q);
    if($j>=(count($g)-1)) $j = 0;
    else $j++;
    print "\n[getUrl] : $url\n";
    return $url;
}

function getLinks($str) // парсинг ссылок гугла
{
    $regex = '/<\s*h3 class="r"[^>]*>(.*?)<\/h3>/';
    preg_match_all($regex, $str, $matches, PREG_SET_ORDER);
    $res = array();
    foreach($matches as $v){
        $n = substr($v[1], 0, strrpos($v[1], "&amp;sa=U"));
        $url = str_replace("<a href=\"/url?q=","",$n);
        $url = urldecode($url);
        array_push($res, $url);
    }

    return $res;
}
 
function get_content($url) // загрузка контента
{
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

function process_file($path) //получить данные из файла
{
    $flist = array();
    foreach (glob("$path/*") as $filename) {
        if($filename) array_push($flist, $filename);
    }
    $f	= array_pop($flist);
    if(!$f) return null;
    $farr_tmp	= file_get_contents($f);
    if(!$farr_tmp) return null;
    $farr = json_decode($farr_tmp, true);
    return $farr;
}