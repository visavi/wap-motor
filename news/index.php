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

show_title('partners.gif', 'Новости сайта');

$file = file(DATADIR."news.dat");
$file = array_reverse($file);
$total = count($file);   

if ($total>0){
 
if ($start < 0 || $start > $total){$start = 0;}
if ($total < $start + $config['postnews']){ $end = $total; }
else {$end = $start + $config['postnews']; }
for ($i = $start; $i < $end; $i++){

$data = explode("|",$file[$i]);

echo '<div class="b"><img src="../images/img/files.gif" alt="image" /> ';
echo '<b>'.$data[0].'</b><small> ('.date_fixed($data[3]).')</small></div>';
echo '<div>'.bb_code($data[1]).'<br />';
echo 'Разместил: <a href="../pages/anketa.php?uz='.$data[4].'&amp;'.SID.'"> '.nickname($data[4]).' </a><br />';
echo '<a href="komm.php?id='.(int)$data[5].'&amp;'.SID.'">Комментарии</a> ';

$countkomm = counter_string(DATADIR."datakomm/$data[5].dat");
echo '('.(int)$countkomm.')</div>';
}

page_jumpnavigation('index.php?', $config['postnews'], $start, $total);
page_strnavigation('index.php?', $config['postnews'], $start, $total);

} else {show_error('Новостей еще нет!');}

echo '<br /><br /><img src="../images/img/rss.gif" alt="image" /> <a href="rss.php?'.SID.'">RSS подписка</a><br />'; 
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a>'; 

include_once ("../themes/".$config['themes']."/foot.php");
?>
