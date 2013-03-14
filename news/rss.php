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

header("Content-type:application/rss+xml; charset=utf-8");
echo '<?xml version="1.0" encoding="utf-8" ?>';
echo '<rss version="2.0"><channel>';
echo '<title>'.$config['title'].' News</title>';
echo '<link>'.$config['home'].'</link>';
echo '<description>Новости RSS - '.$config['title'].'</description>';
echo '<image><url>'.$config['logotip'].'</url>';
echo '<title>'.$config['title'].' News</title>';
echo '<link>'.$config['home'].'</link></image>';
echo '<language>ru</language>';
echo '<copyright>'.$config['copy'].'</copyright>';
echo '<managingEditor>'.$config['emails'].'</managingEditor>';
echo '<webMaster>'.$config['emails'].'</webMaster>';
echo '<lastBuildDate>'.date("r",SITETIME).'</lastBuildDate>';


$file = file(DATADIR."news.dat");
$file = array_reverse($file);

$total = count($file); 
   
if ($total>15) {$total = 15;}

for ($i=0;$i<$total;$i++){

$data = explode("|",$file[$i]);

$data[1] = bb_code($data[1]);
$data[1] = str_replace('../images/smiles',$config['home'].'/images/smiles',$data[1]);
$data[1] = htmlspecialchars($data[1]);

echo '<item><title>'.$data[0].'</title><link>'.$config['home'].'/news/komm.php?id='.$data[5].'</link>';
echo '<description>'.$data[1].' </description><author>'.$data[4].'</author>';
echo '<pubDate>'.date("r",$data[3]).'</pubDate><category>Новости</category><guid>'.$config['home'].'/news/komm.php?id='.$data[5].'</guid></item>';
}

echo '</channel></rss>';
?>