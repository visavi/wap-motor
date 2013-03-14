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

if (is_admin(array(101))){

echo '<img src="../images/img/menu.gif" alt="image" /> <b>Проверка системы</b><br /><br />';

$dires = array();
$files = array();

$dir = opendir (DATADIR); 
while ($file = readdir ($dir)) {

if ($file!='.' && $file!='..' && $file!='license.key' && $file!='.htaccess'){

if (is_dir(DATADIR.$file)){
$dires[] = $file;
} else {
$files[] = $file;
}}}
closedir ($dir); 


############################################################################################
##                                          Файлы                                         ##
############################################################################################
echo'<b>Готовность файлов</b><br /><br />';

if (file(DATADIR.".htaccess")){
echo 'Файл .htaccess задействован<br />';

if (is_writeable(DATADIR.".htaccess")){
echo '<b><span style="color:#ff0000">Внимание! На файл .htaccess не рекомедуется ставить права разрешающие запись</span></b><br />';
echo 'Установите обычные права (CHMOD) не позволяющие менять содержимое файла (обычно 644)<br />';
}

} else {
echo '<b><span style="color:#ff0000">Внимание!!! Файл .htaccess отсутствует, в данном случае безопасность не гарантируется</span></b><br />';
echo 'Если ваш сервер не поддерживает htaccess, рекомендуем сменить сервер, т.к. из-за отсутствия этого файла становятся доступные для злоумышленников системные, конфигурационные файлы, профили и письма пользователей<br />';
}

echo '<br /><table width="99%" border="0" cellspacing="0" cellpadding="2">';
echo '<tr bgcolor="ffff00"><td width="40%">Файл</td><td width="20%">Доступ</td><td width="20%">Chmod</td><td width="20%">Размер</td></tr>';

foreach ($files as $key=>$value){

if($key&1){$bgcolor="#e0e0e0"; }else{$bgcolor="#ffffff";}

echo '<tr bgcolor="'.$bgcolor.'"><td width="40%">'.$value.'</td><td width="20%">'; 

if (is_writeable(DATADIR.$value)){ 
echo '<span style="color:#00ff00">Готов</span>'; 
} else { 
echo '<span style="color:#ff0000">Не готов</span>'; 
}

echo '</td><td width="20%">'.permissions(DATADIR.$value).'</td><td width="20%">'.formatsize(filesize(DATADIR.$value)).'</td></tr>';
} 

echo '</table>';

############################################################################################
##                                         Директории                                     ##
############################################################################################	
echo'<br /><b>Готовность директорий</b><br /><br />';

echo '<table width="99%" border="0" cellspacing="0" cellpadding="2">';
echo '<tr bgcolor="ffff00"><td width="40%">Директория</td><td width="20%">Доступ</td><td width="20%">Chmod</td><td width="20%">Размер</td></tr>';

foreach ($dires as $key=>$value){

if($key&1){$bgcolor="#e0e0e0"; }else{$bgcolor="#ffffff";}

echo '<tr bgcolor="'.$bgcolor.'"><td width="40%">'.$value.'</td><td width="20%">'; 

if (is_writeable(DATADIR.$value)) {
echo '<span style="color:#00ff00">Готова</span>';
} else {
echo '<span style="color:#ff0000">Не готова</span>'; 
}

echo '</td><td width="20%">'.permissions(DATADIR.$value).'</td><td width="20%">'.formatsize(read_dir(DATADIR.$value)).'</td></tr>';
} 

echo '</table>';

echo '<br />Если какой-то пункт выделен красным необходимо зайти по фтп и выставить CHMOD разрещающую запись<br />';

echo'<br /><img src="../images/img/panel.gif" alt="image" /> <a href="index.php?'.SID.'">В админку</a><br />';
echo'<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a><br />';

} else {header ("Location: ../index.php?isset=404&".SID); exit;}

include_once ("../themes/".$config['themes']."/foot.php");
?>