<?php
#####################################
##     *** WAP MOTOR ****          ##
##      Автор : VERTUOZ            ##
##     E-mail : info@05dag.ru    ##
##       Site : http://05dag.ru  ##
##        ICQ : 369902212          ##
#####################################
$text = file(BASEDIR."pyramid/config.dat"); 
if ($text){
$data = explode("|",$text[0]);}
$look_ip = $data[0]; #  Показывать IP
$small_msg = $data[1]; #  маленький шрифт
$msg_list = $data[2]; #  Сообщений в пирамиде
$all_msg = $data[3]; #  Всего сообщений
$msg_his = $data[4]; #  Сообщений в истории
?>