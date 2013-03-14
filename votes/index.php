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

echo '<img src="../images/img/partners.gif" alt="image" /> <b>Голосование</b><br /><br />';

echo '<form action="vote.php?action=vote&amp;'.SID.'" method="post">';

if (file_exists(DATADIR."datavotes/votes.dat")){
$vfiles = file_get_contents(DATADIR."datavotes/votes.dat");

$vdata = explode("|",$vfiles);
$vcount = count($vdata); 

echo '<b>'.$vdata[0].'</b><br /><br />';

for ($i=1; $i<$vcount; $i++){
if ($vdata[$i]!=""){
echo '<input name="golos" type="radio" value="'.$i.'" /> '.$vdata[$i].'<br />';
}}

echo '<br /><input type="submit" value="Голосовать" /></form><hr />';

echo '<br /><img src="../images/img/reload.gif" alt="image" /> <a href="vote.php?'.SID.'">Посмотреть результаты</a>'; 

} else {echo '<b>Голосование еще не создано</b><br />';}

echo '<br /><img src="../images/img/arhiv.gif" alt="image" /> <a href="allvotes.php?'.SID.'">Архив голосований</a><br />'; 	
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a>'; 

include_once ("../themes/".$config['themes']."/foot.php");
?>
