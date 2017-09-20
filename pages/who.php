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
require_once "../includes/header.php";
include_once "../themes/".$config['themes']."/index.php";

if (isset($_GET['start'])) {$start = (int)$_GET['start'];} else {$start = 0;}

echo '<img src="../images/img/partners.gif" alt="image" /> <b>Кто-где</b><br /><br />';

$file = file(DATADIR."who.dat");
$file = array_reverse($file);

$total = count($file);

if ($start < 0 || $start > $total){$start = 0;}
if ($total < $start + $config['showuser']){ $end = $total; }
else {$end = $start + $config['showuser']; }
for ($i = $start; $i < $end; $i++){

$data = explode("|",$file[$i]);

$cu = round(SITETIME-$data[3]);

if ($cu<600) {$tm='<span style="color:#00ff00">Oнлайн</span>';}
if ($cu>=600) {$tm = round($cu/60).' мин. назад';}
if ($cu>=3600) {$tm = round($cu/3600).' час. назад';}
if ($cu>=86400) {$tm = round($cu/3600/24).' дн. назад';}

echo '<div class="b"><img src="../images/img/chel.gif" alt="image" /> <b><a href="../pages/anketa.php?uz='.$data[0].'">'.nickname($data[0]).'</a></b> ('.$tm.')</div>';

echo 'Находится: '.user_position($data[1]).'<br />';
echo 'Переходов: '.(int)$data[2].'<br />';
}

page_jumpnavigation('who.php?', $config['showuser'], $start, $total);
page_strnavigation('who.php?', $config['showuser'], $start, $total);

echo'<br /><br /><img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a>';
include_once "../themes/".$config['themes']."/foot.php";
?>
