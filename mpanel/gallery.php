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

if (isset($_GET['start'])) {$start = (int)$_GET['start'];} else {$start = 0;}
if (isset($_GET['action'])) {$action = check($_GET['action']);} else {$action = "";}

if (is_admin(array(101,102,103,105))){

echo'<img src="../images/img/menu.gif" alt="image" /> <b>Управление галереей</b><br /><br />';

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if ($action==""){

echo '<a href="#down"><img src="../images/img/downs.gif" alt="image" /></a> ';
echo '<a href="gallery.php?start='.$start.'&amp;rand='.mt_rand(100,999).'">Обновить</a> / ';
echo '<a href="../gallery/index.php?action=addfoto">Добавить фото</a> / ';
echo '<a href="../gallery/index.php?start='.$start.'">Обзор</a><hr />';

if (file_exists(DATADIR."datagallery/fotobase.dat")) {
$lines = file(DATADIR."datagallery/fotobase.dat");
$lines = array_reverse($lines);
$total = count($lines);

if ($total>0){

echo '<form action="gallery.php?action=del&amp;start='.$start.'&amp;uid='.$_SESSION['token'].'" method="post">';

if ($start < 0 || $start > $total){$start = 0;}
if ($total < $start + $config['fotolist']){ $end = $total; }
else {$end = $start + $config['fotolist']; }
for ($i = $start; $i < $end; $i++){

$dt = explode("|", $lines[$i]);

$num = $total - $i - 1;

$totalkomm = counter_string(DATADIR."datagallery/$dt[6].dat");
$filesize = formatsize(filesize(DATADIR.'datagallery/'.$dt[6]));

echo '<div class="b"><img src="../images/img/gallery.gif" alt="image" /> ';
echo '<b><a href="../gallery/fullsize.php?name='.$dt[6].'">'.$dt[1].'</a></b> ('.$filesize.')<br />';

echo '<input type="checkbox" name="del[]" value="'.$num.'" /> ';

echo '<a href="gallery.php?action=edit&amp;start='.$start.'&amp;id='.$num.'">Редактировать</a>';

echo '</div><div>';

echo '<a href="../gallery/fullsize.php?name='.$dt[6].'"><img src="../gallery/resize.php?name='.$dt[6].'" alt="image" /></a>';

echo '<br />'.$dt[0].'<br />';

echo 'Добавлено: <a href="../pages/anketa.php?uz='.$dt[2].'">'.nickname($dt[2]).'</a> ('.date_fixed($dt[4]).')<br />';
echo '<a href="../gallery/index.php?action=komm&amp;gid='.$dt[6].'">Комментарии</a> ('.(int)$totalkomm.')';
echo '</div>';
}

echo '<br /><input type="submit" value="Удалить выбранное" /></form>';

page_jumpnavigation('gallery.php?', $config['fotolist'], $start, $total);
page_strnavigation('gallery.php?', $config['fotolist'], $start, $total);

echo'<br /><br />Всего фотографий: <b>'.(int)$total.'</b><br />';

} else {echo '<b>Галерея пустая, фотографий еще нет!</b><br />';}
} else {echo '<b>Галерея пустая, фотографий еще нет!</b><br />';}

}

############################################################################################
##                                    Редактирование                                      ##
############################################################################################
if ($action=="edit") {

if (isset($_GET['id'])) {$id = (int)$_GET['id'];} else {$id = "";}

if ($id!==""){
$file = file(DATADIR."datagallery/fotobase.dat");
if (isset($file[$id])){
$data = explode("|", $file[$id]);

$data[0] = str_replace("<br />","\r\n",$data[0]);

echo '<b><big>Редактирование изображения</big></b><br /><br />';

echo '<form action="gallery.php?id='.$id.'&amp;action=addedit&amp;start='.$start.'&amp;uid='.$_SESSION['token'].'" method="post">';

echo '<img src="../images/img/edit.gif" alt="image" /> <b>'.nickname($data[2]).'</b> <small>('.date_fixed($data[4]).')</small><br /><br />';

echo 'Название:<br /><input type="text" value="'.$data[1].'" name="name" /><br />';
echo 'Описание:<br />';
echo '<textarea cols="50" rows="3" name="msg">'.$data[0].'</textarea><br /><br />';
echo '<input type="submit" value="Изменить" /></form><hr />';

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Такого изображения не существует!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Не выбрано изображение для редактирования!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="gallery.php?start='.$start.'">Вернуться</a>';
}


############################################################################################
##                                 Изменение сообщения                                    ##
############################################################################################
if ($action=="addedit") {

$uid = check($_GET['uid']);
$msg = check($_POST['msg']);
$name = check($_POST['name']);
if (isset($_GET['id'])) {$id = (int)$_GET['id'];} else {$id = "";}

if ($uid==$_SESSION['token']){
if ($id!==""){

if (utf_strlen(trim($name))>=5 && utf_strlen($name)<50) {
if (utf_strlen(trim($msg))>=5 && utf_strlen($msg)<1000){

$file = file(DATADIR."datagallery/fotobase.dat");
if (isset($file[$id])){
$data = explode("|", $file[$id]);

$msg = no_br($msg,' <br /> ');

$text = no_br($msg.'|'.$name.'|'.$data[2].'||'.$data[4].'|'.$data[5].'|'.$data[6].'|');

replace_lines(DATADIR."datagallery/fotobase.dat", $id, $text);

header ("Location: gallery.php?start=$start&isset=editfoto"); exit;

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Такого изображения не существует!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Слишком длинное или короткое описание!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Слишком длинное или короткое название!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Не выбрано изображение для редактирования!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="gallery.php?action=edit&amp;id='.$id.'&amp;start='.$start.'">Вернуться</a>';
}

############################################################################################
##                                 Удаление изображений                                   ##
############################################################################################
if ($action=="del") {

$uid = check($_GET['uid']);
if (isset($_POST['del'])) {$del = intar($_POST['del']);} else {$del = "";}

if ($uid==$_SESSION['token']){
if ($del!==""){

$file = file(DATADIR."datagallery/fotobase.dat");

foreach($del as $val){
$data = explode("|", $file[$val]);

if(file_exists(DATADIR."datagallery/$data[6]")){
unlink (DATADIR."datagallery/$data[6]");
}

if(file_exists(DATADIR."datagallery/$data[6].dat")){
unlink (DATADIR."datagallery/$data[6].dat");
}}

delete_lines(DATADIR."datagallery/fotobase.dat", $del);

header ("Location: gallery.php?start=$start&isset=delfoto");  exit;

} else {echo '<b>Ошибка удаления! Отсутствуют выбранные изображения!</b><br />';}
} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="gallery.php?start='.$start.'">Вернуться</a>';
}

echo'<br /><img src="../images/img/panel.gif" alt="image" /> <a href="index.php">В админку</a><br />';
echo'<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a><br />';

} else {header ("Location: ../index.php?isset=404"); exit;}

include_once ("../themes/".$config['themes']."/foot.php");
?>
