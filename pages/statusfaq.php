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

$text = file_get_contents(DATADIR."status.dat"); 
$udta = explode("|",$text);

echo'<img src="../images/img/partners.gif" alt="image" /> <b>Статусы пользователей</b><br /><br />';

echo 'В зависимости от вашей активности на сайте вы получаете определенный статус<br />';
echo 'При достижении определенного количества баллов ваш статус меняется на вышестоящий<br />Баллы-это сумма ваших посещений сайта, постов на форуме, чате, гостевой и пр.<br /><br />';
echo 'Самым активным юзерам администрация сайта может назначать особые статусы<hr />';

echo '0-4 баллов - '.$udta[0].'<br />';
echo '5-9 баллов - '.$udta[1].'<br />';
echo '10-19 баллов - '.$udta[2].'<br />';
echo '20-49 баллов - '.$udta[3].'<br />';
echo '50-99 баллов - '.$udta[4].'<br />';
echo '100-249 баллов - '.$udta[5].'<br />';
echo '250-499 баллов - '.$udta[6].'<br />';
echo '500-749 баллов - '.$udta[7].'<br />';
echo '750-999 баллов - '.$udta[8].'<br />';
echo '1000-1249 баллов - '.$udta[9].'<br />';
echo '1250-1499 баллов - '.$udta[10].'<br />';
echo '1500-1749 баллов - '.$udta[11].'<br />';
echo '1750-1999 баллов - '.$udta[12].'<br />';
echo '2000-2249 баллов - '.$udta[13].'<br />';
echo '2250-2499 баллов - '.$udta[14].'<br />';
echo '2500-2749 баллов - '.$udta[15].'<br />';
echo '2750-2999 баллов - '.$udta[16].'<br />';
echo '3000-3249 баллов - '.$udta[17].'<br />';
echo '3250-3499 баллов - '.$udta[18].'<br />';
echo '3500-4999 баллов - '.$udta[19].'<br />';
echo '5000-7499 баллов - '.$udta[20].'<br />';
echo '7500-9999 баллов - '.$udta[21].'<br />';
echo '10000 баллов и выше - '.$udta[22].'<br />';

echo '<br /><img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a>'; 
include_once "../themes/".$config['themes']."/foot.php";
?>