<?php
require 'vendor/autoload.php';
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;
function GetBerita($url,$domain,$filter){
	$client = new Client(HttpClient::create(['verify_peer' => false, 'verify_host' => false]));
	$crawler = $client->request('GET', $url);
	$filename='berita.csv';
	$modetulis="a+";
	if($domain=='https://kerincitime.co.id'){
		$modetulis="w+";
	}
	$file = fopen($filename, $modetulis);
	if($domain=='https://kerincitime.co.id'){
		fputcsv($file, ['judul', 'link']);
	}
	for($i=1; $i<=5; $i++){
		$x=$i;
		if($url=='https://jambiekspres.co.id/daerah/kerinci'){
			$x=$i+2;
		}
		if($url=='https://jambi.tribunnews.com/jambi/kerinci' OR $url=='https://polreskerinci.jambi.polri.go.id/main'){
			$x=$i+1;
		}
		if($url=='https://www.kabarkerinci.com/' AND $i==2){
			continue;
		}
		$filter2=str_replace('xxx', $x, $filter);
		$xpathlink=$filter2.'/@href';
		$title=$crawler->filterXPath($filter2)->text();
		$link=$domain.$crawler->filterXPath($xpathlink)->text();
		$title=trim($title);
		fputcsv($file, [$title, $link]);
	}
}

$medias = [
	[
	'url'	=>'https://kerincitime.co.id/category/hot-news',
	'domain'	=>'https://kerincitime.co.id',
	'filter' =>'//*[@id="posts-container"]/li[xxx]/div/h2/a'
	],
	[
	'url'	=>'https://ampar.id/?s=kerinci',
	'domain'	=>'',
	'filter' =>"//article[xxx]/div[2]/h3[@class='jeg_post_title']//a"
	],
	[
	'url'	=>'https://jambiekspres.co.id/daerah/kerinci',
	'domain'	=>'',
	'filter' =>"//*[@id='wrapper']/section/div/div/div[1]/div[xxx]/div/div[2]/h3/a"
	],
	[
	'url'	=>'https://jambi.tribunnews.com/jambi/kerinci',
	'domain'	=>'',
	'filter' =>"//*[@id='latestul']/li[xxx]/*/h3/a"
	],
	[
	'url'	=>'https://www.sergap.co.id/category/jambi/kerinci/',
	'domain'	=>'',
	'filter' =>"//article[xxx]/div/div[2]/header/h2/a"
	],
	[
	'url'	=>'https://polreskerinci.jambi.polri.go.id/main',
	'domain'	=>'',
	'filter' =>"//div[@class='widget-articles']/ul/li[xxx]/div[2]/h4/a[1]"
	],
	[
	'url'	=>'https://jambione.com/daerah/kerinci',
	'domain'	=>'',
	'filter' =>"//*[@id='area']/ul/li[xxx]/div[2]/div/h3/a"
	],
	[
	'url'	=>'https://www.indojatipos.com/category/kerinci/',
	'domain'	=>'',
	'filter' =>"//article[xxx]/div[2]/header/h2/a"
	],
	[
	'url'	=>'https://jambiindependent.disway.id/search/kata/?c=kerinci',
	'domain'	=>'',
	'filter' =>"//section[@class='bottom-15']/div[xxx]/div[1]/h2/a"
	],
	[
	'url'	=>'https://gegeronline.co.id/?s=kerinci',
	'domain'	=>'',
	'filter' =>"//article[xxx]/div[2]/header/h2/a"
	],
];

foreach ($medias as $media) {
	GetBerita($media['url'],$media['domain'],$media['filter']);	
}



