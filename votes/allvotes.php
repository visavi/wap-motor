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
require_once ("../includes/start.php");
require_once ("../includes/functions.php");
require_once ("../includes/header.php");
include_once ("../themes/".$config['themes']."/index.php");

if (isset($_GET['start'])){$start = (int)$_GET['start'];} else {$start = 0;}

echo '<img src="../images/img/partners.gif" alt="image" /> <b>Все голосования</b><br /><br />';

if (file_exists(DATADIR."datavotes/allvotes.dat")){
$file = file(DATADIR."datavotes/allvotes.dat");
$file = array_reverse($file);
$total = count($file);    

if ($total>0){

if ($start < 0 || $start > $total){$start = 0;}
if ($total < $start + $config['allvotes']){ $end = $total; }
else {$end = $start + $config['allvotes']; }
for ($i = $start; $i < $end; $i++){

$data = explode("|",$file[$i]);

echo '<div class="b"><img src="../images/img/arhiv.gif" alt="image" /> <b>'.$data[0].'</b><br /></div>';
echo '<div>Результаты:<br />';

echo $data[1].'<br />';
echo $data[2].'<br />';
echo $data[3].'<br />';
if($data[4]!==""){echo $data[4].'<br />';}
if($data[5]!==""){echo $data[5].'<br />';}
if($data[6]!==""){echo $data[6].'<br />';}
if($data[7]!==""){echo $data[7].'<br />';}
if($data[8]!==""){echo $data[8].'<br />';}
if($data[9]!==""){echo $data[9].'<br />';}
if($data[10]!==""){echo $data[10].'<br />';}

echo '<b>Было опрошено: '.(int)$data[11].'</b></div>';
}

page_jumpnavigation('allvotes.php?', $config['allvotes'], $start, $total);
page_strnavigation('allvotes.php?', $config['allvotes'], $start, $total);

echo '<br /><br />Всего голосований: '.(int)$total.'<br />';

} else {echo '<img src="../images/img/reload.gif" alt="image" /> <b>Голосований еще нет!</b><br />';}
} else {echo '<img src="../images/img/reload.gif" alt="image" /> <b>Архив голосований еще не создан!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="index.php?'.SID.'">К голосованию</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a>'; 

include_once ("../themes/".$config['themes']."/foot.php");
?>
