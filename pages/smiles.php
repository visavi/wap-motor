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
         
if (isset($_GET['start'])){$start = (int)$_GET['start'];} else {$start = 0;}
if (isset($_GET['action'])) {$action = check($_GET['action']);} else {$action = "";}

echo '<img src="../images/img/partners.gif" alt="image" /> <b>Список смайлов</b><br /><br />';

############################################################################################
##                                 Главная страница                                       ##
############################################################################################	
if ($action==""){

echo '<b>Общие смайлы</b> | <a href="smiles.php?action=admsmiles&amp;'.SID.'">Админские смайлы</a><br /><br />';

$arrsmiles = array();
$globsmiles = glob(BASEDIR."images/smiles/*.gif");
foreach ($globsmiles as $filename) {
$arrsmiles[] = basename($filename, '.gif');
}

sort($arrsmiles);
$total = count($arrsmiles); 

if ($total>0){

if ($start < 0 || $start > $total){$start = 0;}
if ($total < $start + $config['smilelist']){ $end = $total; }
else {$end = $start + $config['smilelist']; }
for ($i = $start; $i < $end; $i++){ 

echo '<img src="'.BASEDIR.'images/smiles/'.$arrsmiles[$i].'.gif" alt="image" /> — :'.$arrsmiles[$i].'<br />';
}

page_jumpnavigation('smiles.php?', $config['smilelist'], $start, $total);
page_strnavigation('smiles.php?', $config['smilelist'], $start, $total);

echo '<br /><br />Данные смайлы доступны всем авторизованным участникам сайта<br /><br />';

echo 'Всего cмайлов: <b>'.(int)$total.'</b><br />';

} else {echo '<img src="../images/img/reload.gif" alt="image" /> <b>В данной категории смайлов нет!</b><br />';}

}

############################################################################################
##                                  Админские смайлы                                      ##
############################################################################################	
if ($action=="admsmiles"){

echo '<a href="smiles.php?'.SID.'">Общие смайлы</a> | <b>Админские смайлы</b><br /><br />';

$arrsmiles = array();
$globsmiles = glob(BASEDIR."images/smiles2/*.gif");
foreach ($globsmiles as $filename) {
$arrsmiles[] = basename($filename, '.gif');
}

sort($arrsmiles);
$total = count($arrsmiles); 

if ($total>0){

if ($start < 0 || $start > $total){$start = 0;}
if ($total < $start + $config['smilelist']){ $end = $total; }
else {$end = $start + $config['smilelist']; }
for ($i = $start; $i < $end; $i++){ 

echo '<img src="'.BASEDIR.'images/smiles2/'.$arrsmiles[$i].'.gif" alt="image" /> — :'.$arrsmiles[$i].'<br />';
}

page_jumpnavigation('smiles.php?action=admsmiles&amp;', $config['smilelist'], $start, $total);
page_strnavigation('smiles.php?action=admsmiles&amp;', $config['smilelist'], $start, $total);

echo '<br /><br />Данные смайлы доступны только админам и модерам<br /><br />';

echo 'Всего cмайлов: <b>'.(int)$total.'</b><br />';

} else {echo '<img src="../images/img/reload.gif" alt="image" /> <b>В данной категории смайлов нет!</b><br />';}

}


echo '<br /><img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>