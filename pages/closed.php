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

if($config['closedsite']=="1"){

echo '<center><br /><br /><h2>Внимание! Сайт закрыт по техническим причинам</h2></center>';

echo 'Администрация сайта приносит вам свои извинения за возможные неудобства.<br />';
echo 'Работа сайта возможно возобновится в ближайшее время.<br />';

} else {
header("Location:../index.php"); exit;
}

echo'<br /><img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a>';
include_once "../themes/".$config['themes']."/foot.php";
?>
