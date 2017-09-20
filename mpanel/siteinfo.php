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

if (isset($_GET['action'])) {$action = check($_GET['action']);} else {$action = "";}
if (isset($_GET['start'])) {$start = (int)$_GET['start'];} else {$start = 0;}

if (is_admin(array(101,102,103,105))){

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if($action==""){

echo '<img src="../images/img/menu.gif" alt="image" /> <b>Информация о портале</b><br /><br />';

echo 'Используемая версия: '.MOTOR_VERSION.'<br /><br />';

$filsize = 0;
$filtime = 0;

if (file_exists(DATADIR."datatmp/information.dat")){
$filtime = filemtime(DATADIR."datatmp/information.dat") + 10800;
$filsize = filesize(DATADIR."datatmp/information.dat");
}

if (time() > $filtime || $filsize == 0){

if (copy("http://wap-motor.com/motor/information.txt", DATADIR."datatmp/information.dat")) {
chmod(DATADIR."datatmp/information.dat", 0666);

} else {

echo '<b>Ошибка! Не удалось загрузить информацию о последних изменениях и новых версиях</b><br />';
echo 'Вы можете просмотреть все <b><a href="http://visavi.net/wap-motor/index.php?action=news">новости изменений</a></b> о движке WAP-MOTOR на нашем сайте Visavi.net<br /><br />';
}
}

if (file_exists(DATADIR."datatmp/information.dat")){

echo file_get_contents(DATADIR."datatmp/information.dat");

} else {echo '<b>Информационный файл отсутствует!</b><br />';}

echo '<br /><img src="../images/img/zip.gif" alt="image" /> <a href="siteinfo.php?action=upgrades">Апгрейды</a><br />';
echo '<img src="../images/img/reload.gif" alt="image" /> <a href="siteinfo.php?action=changes">Изменения</a><br />';
}

############################################################################################
##                                   Просмотр апгрейдов                                   ##
############################################################################################
if($action=="upgrades"){

echo '<img src="../images/img/menu.gif" alt="image" /> <b>Список апгрейдов</b><br /><br />';

$filsize = 0;
$filtime = 0;

if (file_exists(DATADIR."datatmp/upgrades.dat")){
$filtime = filemtime(DATADIR."datatmp/upgrades.dat") + 10800;
$filsize = filesize(DATADIR."datatmp/upgrades.dat");
}

if (time() > $filtime || $filsize == 0){

if (copy("http://wap-motor.com/motor/upgrades.txt", DATADIR."datatmp/upgrades.dat")) {
chmod(DATADIR."datatmp/upgrades.dat", 0666);

} else {
echo '<b>Ошибка! Не удалось загрузить информацию о апгрейдах</b><br />';
echo 'Вы можете просмотреть все <b><a href="http://visavi.net/wap-motor/index.php?action=upgrades">апгрейды</a></b> на нашем сайте Visavi.net<br /><br />';
}
}

if (file_exists(DATADIR."datatmp/upgrades.dat")){

echo file_get_contents(DATADIR."datatmp/upgrades.dat");

} else {echo '<b>Информационный файл отсутствует!</b><br />';}

echo '<br /><br /><img src="../images/img/reload.gif" alt="image" /> <a href="siteinfo.php">Вернуться</a><br />';
}


############################################################################################
##                                    Список изменений                                    ##
############################################################################################
if ($action=="changes"){
echo '<img src="../images/img/menu.gif" alt="image" /> <b>Готовящиеся изменения</b><br /><br />';

$filsize = 0;
$filtime = 0;

if (file_exists(DATADIR."datatmp/changes.dat")){
$filtime = filemtime(DATADIR."datatmp/changes.dat") + 86400;
$filsize = filesize(DATADIR."datatmp/changes.dat");
}

if (time() > $filtime || $filsize == 0){

if (copy("http://wap-motor.com/motor/changes.txt", DATADIR."datatmp/changes.dat")) {
chmod(DATADIR."datatmp/changes.dat", 0666);

} else {
echo '<b>Ошибка! Не удалось загрузить информацию об истории изменений</b><br />';
echo 'Вы можете просмотреть всю <b><a href="http://visavi.net/wap-motor/index.php?action=changes">Историю изменений</a></b> о движке WAP-MOTOR на нашем сайте Visavi.net<br />';
}
}

if(file_exists(DATADIR."datatmp/changes.dat")){

$file = file_get_contents(DATADIR."datatmp/changes.dat");

$file = explode("|",$file);
$file = array_reverse($file);
$total = count($file);

if($total>0){

if ($start < 0 || $start > $total){$start = 0;}
if ($total < $start + $config['siteinfo']){ $end = $total; }
else {$end = $start + $config['siteinfo']; }
for ($i = $start; $i < $end; $i++){

$file[$i] = no_br($file[$i],'<br />');
$file[$i] = preg_replace('|<b>(.*?)</b><br />(.*?)<br />$|', '<div class="b"><img src="../images/img/news.gif" alt="image" /> <b>\\1</b></div><div>\\2</div>', $file[$i]);

echo $file[$i];
}

page_jumpnavigation('siteinfo.php?action=changes&amp;', $config['siteinfo'], $start, $total);
page_strnavigation('siteinfo.php?action=changes&amp;', $config['siteinfo'], $start, $total);

} else {echo '<img src="../images/img/reload.gif" alt="image" /> <b>Измений пока нет!</b><br /><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Информационный файл отсутствует!</b><br />';}

echo '<br /><br /><img src="../images/img/reload.gif" alt="image" /> <a href="siteinfo.php">Вернуться</a><br />';
}

echo '<img src="../images/img/panel.gif" alt="image" /> <a href="index.php">В админку</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a><br />';

} else {header ("Location: ../index.php?isset=404"); exit;}

include_once ("../themes/".$config['themes']."/foot.php");
?>
