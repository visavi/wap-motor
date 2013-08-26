<?php
#-----------------------------------------------------#
#          ********* WAP-MOTORS *********             #
#             Made by   :  VANTUZ                     #
#               E-mail  :  visavi.net@mail.ru         #
#                 Site  :  http://pizdec.ru           #
#             WAP-Site  :  http://visavi.net          #
#                  ICQ  :  36-44-66                   #
#  Вы не имеете право вносить изменения в код скрипта #
#        для его дальнейшего распространения          #
#-----------------------------------------------------#	
require_once "../includes/start.php";
require_once "../includes/functions.php";

$arrtimehour = mktime(date("H",SITETIME), 0, 0, date("m",SITETIME), date("d",SITETIME), date("Y",SITETIME));

//-------------------- Хиты -----------------------//
if (file_exists(DATADIR."datacounter/24_hits.dat")){
$p24_hits = file(DATADIR."datacounter/24_hits.dat");

$hits24 = array();
$hits_data = array();

foreach($p24_hits as $val){
$hits = explode("|",$val);
$hits24[$hits[1]] = $hits[0];
}

for ($i=0, $tekhours=$arrtimehour; $i<24; $tekhours-=3600, $i++){

if (isset($hits24[$tekhours])){
$hits_data[] = $hits24[$tekhours];
} else {
$hits_data[] = 0;
}
}
$hits_data = array_reverse($hits_data);
}

//-------------------- Хосты -----------------------//
if (file_exists(DATADIR."datacounter/24_host.dat")){
$p24_host = file(DATADIR."datacounter/24_host.dat");

$host = array();
$host_data = array();

foreach($p24_host as $val){
$host = explode("|",$val);
$host24[$host[1]] = $host[0];
}

for ($i=0, $tekhours=$arrtimehour; $i<24; $tekhours-=3600, $i++){

if (isset($host24[$tekhours])){
$host_data[] = $host24[$tekhours];
} else {
$host_data[] = 0;
}
}
$host_data = array_reverse($host_data);
}

if (empty($hits_data)){$hits_data = array_fill(0, 24, 0);}
if (empty($host_data)){$host_data = array_fill(0, 24, 0);}

//--------------------------------------------------//
$max = 0;
$max_index = 0;
foreach ($hits_data as $index => $value){
	if ($value > $max){
		$max = $value;
		$max_index = $index;
	}
}

if ($max == 0) {$max = 1;}
// процентное соотношение хитов
$per_hit = array();
foreach ($hits_data as $value){
	$per_hit[] = $value*0.90/$max;
}
// процентное соотношение хостов
$per_host = array();
foreach ($host_data as $value){
	$per_host[] = $value*0.90/$max;
}
$img = @imageCreateFromGIF(BASEDIR.'images/img/counter24.gif');

// линейный 
$color1 = imageColorAllocate($img, 44,191,228);
$color2 = imageColorAllocate($img, 0,0,120);
$color_red = imageColorAllocate($img, 200,0,0);

$image = 47;
$coll = 4;
$x1 = 114;
$x2 = $x1 - 3;
$y1_hits = (int)($image - $image*$per_hit[0] + 7);
$y1_host = (int)($image - $image*$per_host[0] + 7);


$counth=count($hits_data);
if($counth>24){$counth=24;}

for($i=1;$i<$counth;$i++){
	// хиты
	$y2_hits = (int)($image - $image*$per_hit[$i] + 7);
	imageLine($img,$x1,$y1_hits,$x2,$y2_hits,$color1);
	
	// хосты 
	$y2_host = (int)($image - $image*$per_host[$i] + 7);
	imageLine($img,$x1,$y1_host,$x2,$y2_host,$color2);

	if ($hits_data[$i] != 0 && $i == $max_index){
		
imageTTFtext($img, 6, 0, $x2-17, $y2_hits-3, $color_red, BASEDIR."gallery/font/font.ttf","max");
imageTTFtext($img, 6, 0, $x2+2, $y2_hits-3, $color2, BASEDIR."gallery/font/font.ttf",$hits_data[$i]);
/* 
ImageString($img, 1, $x2-17,  $y2_hits-10, "max", $color_red);
ImageString($img, 1, $x2+2,  $y2_hits-10, $hits_data[$i], $color2);
*/

imageLine($img,$x2-1,$y2_hits-7,$x2-1,$y2_hits+42,$color_red);
}
	$y1_hits = $y2_hits;
	$y1_host = $y2_host;
	$x1 -= $coll;
	$x2 -= $coll;
}
Header("Content-type: image/gif");
ImageGIF($img);
ImageDestroy($img); 
?>
