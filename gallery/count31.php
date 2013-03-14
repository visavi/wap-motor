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

$arrtimeday = mktime(0, 0, 0, date("m",SITETIME), date("d",SITETIME), date("Y",SITETIME));

//-------------------- Хиты -----------------------//
if (file_exists(DATADIR."datacounter/31_hits.dat")){
$p31_hits = file(DATADIR."datacounter/31_hits.dat");

$hits31 = array();
$hits_data = array();

foreach($p31_hits as $val){
$hits = explode("|",$val);
$hits31[$hits[1]] = $hits[0];
}

for ($i=0, $tekhours=$arrtimeday; $i<31; $tekhours-=86400, $i++){

if (isset($hits31[$tekhours])){
$hits_data[] = $hits31[$tekhours];
} else {
$hits_data[] = 0;
}
}
$hits_data = array_reverse($hits_data);
}

//-------------------- Хосты -----------------------//
if (file_exists(DATADIR."datacounter/31_host.dat")){
$p31_host = file(DATADIR."datacounter/31_host.dat");

$host = array();
$host_data = array();

foreach($p31_host as $val){
$host = explode("|",$val);
$host31[$host[1]] = $host[0];
}

for ($i=0, $tekhours=$arrtimeday; $i<31; $tekhours-=86400, $i++){

if (isset($host31[$tekhours])){
$host_data[] = $host31[$tekhours];
} else {
$host_data[] = 0;
}
}
$host_data = array_reverse($host_data);
}

if (empty($hits_data)){$hits_data = array_fill(0, 31, 0);}
if (empty($host_data)){$host_data = array_fill(0, 31, 0);}

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
$img = imageCreateFromGIF(BASEDIR.'images/img/counter31.gif');

// линейный 
$color1 = imageColorAllocate($img, 44,191,228);
$color2 = imageColorAllocate($img, 0,0,120);
$color_red = imageColorAllocate($img, 200,0,0);

$image = 47;
$coll = 4;
$x1 = 138;
$x2 = $x1 - 3;
$y1_hits = (int)($image - $image*$per_hit[0] + 7);
$y1_host = (int)($image - $image*$per_host[0] + 7);


$counth=count($hits_data);
if($counth>31){$counth=31;}

for($i=1;$i<$counth;$i++){
	// хиты
	$y2_hits = (int)($image - $image*$per_hit[$i] + 7);
	imageLine($img,$x1,$y1_hits,$x2,$y2_hits,$color1);
	
	// хосты 
	$y2_host = (int)($image - $image*$per_host[$i] + 7);
	imageLine($img,$x1,$y1_host,$x2,$y2_host,$color2);
	
	if ($hits_data[$i] != 0 && $i == $max_index){

ImageString($img, 1, $x2-17,  $y2_hits-10, "max", $color_red);
ImageString($img, 1, $x2+2,  $y2_hits-10, $hits_data[$i], $color2);


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
