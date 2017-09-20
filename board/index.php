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
include_once (BASEDIR."themes/".$config['themes']."/index.php");

if (isset($_GET['start'])) {$start = (int)$_GET['start'];} else {$start = 0;}
if (isset($_GET['action'])) {$action = check($_GET['action']);} else {$action = "";}

show_title('partners.gif', 'Доска объявлений');

############################################################################################
##                                 Вывод перечня категорий                                ##
############################################################################################
if ($action=="") {

if (file_exists(DATADIR."databoard/database.dat")) {
$lines = file(DATADIR."databoard/database.dat");
$total = count($lines);

if ($total>0) {

foreach($lines as $boardval){
$data = explode("|", $boardval);

$totalboard = counter_string(DATADIR."databoard/$data[2].dat");

echo '<div class="b"><img src="../images/img/forums.gif" alt="image" /> ';
echo '<b><a href="index.php?action=board&amp;id='.$data[2].'">'.$data[0].'</a></b> ('.(int)$totalboard.')</div>';

echo '<div>'.$data[1].'<br />';

if($totalboard>0){
$fileboard = file(DATADIR."databoard/$data[2].dat");
$lostlist = explode("|",end($fileboard));

if (utf_strlen($lostlist[0])>35) {$lostlist[0]=utf_substr($lostlist[0],0,30); $lostlist[0].="...";}

echo 'Тема: <a href="index.php?action=view&amp;id='.$lostlist[6].'&amp;bid='.$lostlist[5].'">'.$lostlist[0].'</a><br />';

echo 'Объявление: <a href="../pages/anketa.php?uz='.$lostlist[1].'"> '.nickname($lostlist[1]).'</a> <small>('.date_fixed($lostlist[3]).')</small>';

} else {echo 'Рубрика пуста, объявлений нет!';}

echo '</div>';
}

echo '<br />Всего рубрик: <b>'.(int)$total.'</b><br />';

} else {show_error('Доска объявлений пуста, рубрики еще не созданы!');}
} else {show_error('Доска объявлений пуста, рубрики еще не созданы!');}
}

############################################################################################
##                         Вывод объявлений в текущей категории                           ##
############################################################################################
if ($action=="board"){

$id = (int)$_GET['id'];

$string = search_string(DATADIR."databoard/database.dat", $id, 2);
if ($string) {

echo '<a href="#down"><img src="../images/img/downs.gif" alt="image" /></a> ';
echo '<a href="index.php">Объявления</a> | ';
echo '<a href="add.php?id='.$id.'">Добавить</a>';

if (is_admin(array(101,102,103,105))){
echo ' | <a href="'.ADMINDIR.'board.php?action=board&amp;id='.$id.'">Управление</a>';
}

echo '<br /><br /><b><img src="../images/img/themes.gif" alt="image" /> '.$string[0].'</b> ('.$string[1].')<hr />';

if (file_exists(DATADIR."databoard/$id.dat")){
$files = file(DATADIR."databoard/$id.dat");
//---------------Функция автоудаления--------------------//
$newlines = array();
foreach($files as $bkey=>$bvalue){
$bdata = explode("|", $bvalue);
if($bdata[4]<SITETIME){
$newlines[] = (int)$bkey;
}}

if(count($newlines)>0){
delete_lines(DATADIR."databoard/$id.dat", $newlines);
}
//------------------------------------------------------//
$files = array_reverse($files);
$total = count($files);

if ($total>0) {

if ($start < 0 || $start >= $total){$start = 0;}
if ($total < $start + $config['boardspost']){ $end = $total; }
else {$end = $start + $config['boardspost']; }
for ($i = $start; $i < $end; $i++){

$data = explode("|",$files[$i]);

if (utf_strlen($data[2])>100) {
$data[2] = utf_substr($data[2],0,100); $data[2].="...";
}

echo '<div class="b">';
echo '<img src="../images/img/forums.gif" alt="image" /> '.($i+1).'. ';
echo '<b><a href="index.php?action=view&amp;id='.$id.'&amp;bid='.$data[5].'&amp;start='.$start.'">'.$data[0].'</a></b> ';
echo '<small>('.date_fixed($data[3]).')</small></div>';
echo 'Текст объявления: '.$data[2].'<br />';
echo 'Автор объявления: <a href="../pages/anketa.php?uz='.$data[1].'">'.nickname($data[1]).'</a><br />';

}

page_jumpnavigation('index.php?action=board&amp;id='.$id.'&amp;', $config['boardspost'], $start, $total);
page_strnavigation('index.php?action=board&amp;id='.$id.'&amp;', $config['boardspost'], $start, $total);

echo '<br />Всего объявлений: <b>'.(int)$total.'</b><br />';

} else {show_error('Объявлений еще нет, будь первым!');}
} else {show_error('Объявлений еще нет, будь первым!');}
} else {show_error('Ошибка! Данной рубрики не существует!');}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="index.php">Вернуться</a>';
}

############################################################################################
##                         Просмотр объявления в текущей категории                        ##
############################################################################################
if($action=="view"){

$id = (int)$_GET['id'];
$bid = (int)$_GET['bid'];

if (file_exists(DATADIR."databoard/$id.dat")){
$string = search_string(DATADIR."databoard/database.dat", $id, 2);
if ($string) {

$bstr = search_string(DATADIR."databoard/$id.dat", $bid, 5);
if ($bstr) {

echo '<a href="#down"><img src="../images/img/downs.gif" alt="image" /></a> ';
echo '<a href="index.php">Объявления</a> | ';
echo '<a href="add.php?id='.$id.'">Добавить</a><br /><br />';

echo '<b><img src="../images/img/themes.gif" alt="image" /> '.$string[0].'</b> ('.$string[1].')<hr />';

echo '<b><img src="../images/img/board.gif" alt="image" /> '.$bstr[0].'</b><br /><br />';

echo 'Текст объявления: '.$bstr[2].'<br /><br />';
echo 'Автор объявления: <a href="../pages/anketa.php?uz='.$bstr[1].'">'.nickname($bstr[1]).'</a><br />';
echo 'Информация для контакта: <a href="../pages/privat.php?action=submit&amp;uz='.$bstr[1].'">Приват</a><br />';
echo 'Дата размещения:  '.date_fixed($bstr[3]).'<br />';
echo '<small>Дата удаления: <b>'.date_fixed($bstr[4]).'</b></small>';

} else {show_error('Ошибка! Данного объявления не существует!');}
} else {show_error('Ошибка! Данной рубрики не существует!');}
} else {show_error('Ошибка! Данной рубрики не существует!');}

echo '<br /><br /><img src="../images/img/back.gif" alt="image" /> <a href="index.php?action=board&amp;id='.$id.'&amp;start='.$start.'">Вернуться</a><br />';
echo '<img src="../images/img/board.gif" alt="image" /> <a href="index.php">Объявления</a>';
}

echo '<br /><img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>
