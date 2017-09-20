<?php
#-----------------------------------------------------#
#          ********* WAP-MOTORS *********             #
#              Made by  :  VANTUZ                     #
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

if (isset($_GET['start'])) {$start = (int)$_GET['start'];} else {$start = 0;}

show_title('motors.gif', 'Кто-откуда');

$file = file(DATADIR.'referer.dat');
$file = array_reverse($file);
$total = count($file);

if ($total>0){

if ($start < 0 || $start >= $total){$start = 0;}
if ($total < $start + $config['showref']){ $end = $total; }
else {$end = $start + $config['showref']; }
for ($i = $start; $i < $end; $i++){

$data = explode("|",$file[$i]);

echo '<div class="b"><img src="../images/img/online.gif" alt="image" /> '.($i+1).'. <b><a href="http://'.$data[0].'">'.$data[0].'</a></b> ('.date_fixed($data[2]).')</div>';
echo 'Переходов: '.$data[1].'<br />';
echo 'Последний IP: '.$data[3].'<br />';
}

page_jumpnavigation('referer.php?', $config['showref'], $start, $total);
page_strnavigation('referer.php?', $config['showref'], $start, $total);

} else {show_error('Переходов на сайт еще нет!');}

echo '<br /><img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>
