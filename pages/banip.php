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

echo '<center><br /><br /><h2>Вас забанили по IP!<br />Вход на сайт запрещен!</h2></center>'; 

echo '<b>Возможные причины:</b><br />';
echo '1. Вы нарушили какие-либо правила сайта<br />';
echo '2. Превышена допустимая частота запросов с одного IP<br />';
echo '3. Вы всунулись туда, куда не положено<br />';
echo '4. Возможно у вас просто одинаковые IP с нарушителем<br /><br />';
echo '<b>Что теперь делать?</b><br />';
echo 'Сменить браузер, войти с другого IP или с прокси-сервера и<br />';
echo 'Попросить администрацию разбанить ваш IP<br /><br />';
echo 'Если нет такой возможности остается только ждать, список забаненых IP очищают раз в 3-4 дня<br />';

echo'<br /><img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a>';
include_once "../themes/".$config['themes']."/foot.php";
?>