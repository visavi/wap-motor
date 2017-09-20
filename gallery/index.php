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

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if ($action=="") {

show_title('partners.gif', 'Галерея сайта');

echo '<a href="#down"><img src="../images/img/downs.gif" alt="image" /></a> ';
echo '<a href="index.php?action=addfoto">Добавить фото</a>';

if (is_admin(array(101,102,103,105))){
echo ' / <a href="'.ADMINDIR.'gallery.php?start='.$start.'">Управление</a>';}
echo '<br />';

if (file_exists(DATADIR."datagallery/fotobase.dat")) {
$lines = file(DATADIR."datagallery/fotobase.dat");
$lines = array_reverse($lines);
$total = count($lines);

if ($total>0){

if ($start < 0 || $start >= $total){$start = 0;}
if ($total < $start + $config['fotolist']){ $end = $total; }
else {$end = $start + $config['fotolist']; }
for ($i = $start; $i < $end; $i++){

$dt = explode("|", $lines[$i]);

$totalkomm = counter_string(DATADIR."datagallery/$dt[6].dat");
$filesize = formatsize(filesize(DATADIR.'datagallery/'.$dt[6]));

echo '<div class="b"><img src="../images/img/gallery.gif" alt="image" /> ';
echo '<b><a href="index.php?action=showimg&amp;gid='.$dt[6].'&amp;start='.$start.'">'.$dt[1].'</a></b> ('.$filesize.')</div><div>';

echo '<a href="index.php?action=showimg&amp;gid='.$dt[6].'&amp;start='.$start.'"><img src="resize.php?name='.$dt[6].'" alt="image" /></a>';

echo '<br />'.$dt[0].'<br />';

echo 'Добавлено: <a href="../pages/anketa.php?uz='.$dt[2].'">'.nickname($dt[2]).'</a> ('.date_fixed($dt[4]).')<br />';
echo '<a href="index.php?action=komm&amp;gid='.$dt[6].'">Комментарии</a> ('.(int)$totalkomm.')';
echo '</div>';
}
page_jumpnavigation('index.php?', $config['fotolist'], $start, $total);
page_strnavigation('index.php?', $config['fotolist'], $start, $total);

echo '<br /><br />Всего фотографий: <b>'.(int)$total.'</b><br />';

} else {show_error('Фотографий нет, будь первым!');}
} else {show_error('Фотографий нет, будь первым!');}

}

############################################################################################
##                             Просмотр полной фотографии                                 ##
############################################################################################
if ($action=="showimg"){
$gid = check($_GET['gid']);

show_title('partners.gif', 'Просмотр фотографий');

if (preg_match('|^[a-z0-9_\.\-]+$|i', $gid)){
if (file_exists(DATADIR."datagallery/fotobase.dat")){

$string = search_string(DATADIR."datagallery/fotobase.dat", $gid, 6);
if ($string) {

$totalkomm = counter_string(DATADIR."datagallery/$string[6].dat");
$filesize = formatsize(filesize(DATADIR.'datagallery/'.$string[6]));

echo '<div class="b"><img src="../images/img/gallery.gif" alt="image" /> ';
echo '<b>'.$string[1].'</b> ('.$filesize.')</div><div>';

echo '<a href="fullsize.php?name='.$string[6].'"><img src="fullsize.php?name='.$string[6].'" alt="image" /></a>';

echo '<br />'.$string[0].'<br />';
echo 'Добавил: <a href="../pages/anketa.php?uz='.$string[2].'">'.nickname($string[2]).'</a> ('.date_fixed($string[4]).')<br />';


echo '<a href="index.php?action=komm&amp;gid='.$string[6].'">Комментарии</a> ('.(int)$totalkomm.')';
echo '</div>';

} else {show_error('Ошибка! Такой фотографии нет в базе');}
} else {show_error('Ошибка! Фотографий еще нет');}
} else {show_error('Ошибка! Недопустимое название изображения!');}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="index.php?start='.$start.'">Вернуться</a>';
}

############################################################################################
##                                  Форма загрузки фото                                   ##
############################################################################################
if ($action=="addfoto"){

show_title('partners.gif', 'Добавление фотографии');

if (is_user()){

echo '<form action="index.php?action=add" method="post" name="form" enctype="multipart/form-data">';
echo 'Название: <br /><input type="text" name="name" /><br />';
echo 'Прикрепить фото:<br /><input type="file" name="file" /><br />';
echo 'Подпись к фото: <br /><textarea cols="25" rows="3" name="msg"></textarea><br />';
echo 'Отображать в анкете: <input name="ashow" type="checkbox" value="1" /><br /><br />';
echo '<input type="submit" value="Добавить" /></form><hr />';
echo 'Разрешается добавлять фотки с расширением jpg или gif<br />';
echo 'Весом не более '.formatsize($config['filesize']).' и размером от 50 до '.(int)$config['filefoto'].' px<br />';

} else {show_login('Вы не авторизованы, чтобы добавить фотографию, необходимо');}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="index.php?start='.$start.'">Вернуться</a>';
}

############################################################################################
##                                   Загрузка фото                                        ##
############################################################################################
if ($action=="add"){

show_title('partners.gif', 'Результат добавления');

$name = check($_POST['name']);
$msg = check($_POST['msg']);
if (isset($_POST['ashow'])) {$ashow = 1;} else {$ashow = 0;}

if (is_user()){
if (utf_strlen(trim($name))>=5 && utf_strlen($name)<50) {
if (utf_strlen(trim($msg))>=5 && utf_strlen($msg)<1000) {

$newfotosize = check($_FILES['file']['size']);
$newfotoname = check($_FILES['file']['name']);
$newfotorazmer = GetImageSize($_FILES['file']['tmp_name']);
$width = $newfotorazmer[0];
$height = $newfotorazmer[1];

$ext = strtolower(substr($newfotoname, strrpos($newfotoname, '.') + 1));

if ($ext=='jpg' || $ext=='gif'){
if ($width<=$config['filefoto'] && $height<=$config['filefoto'] && $height>=50 && $width>=50) {
if ($newfotosize<=$config['filesize'] && $newfotosize>0) {

antiflood("Location: index.php?action=addfoto&isset=antiflood");
karantin($udata[6], "Location: index.php?action=addfoto&isset=karantin");

$msg = no_br($msg,'<br />');
$msg = antimat($msg);

$unifile = unifile(DATADIR."datagallery/fotobase.dat", 5);

if (copy($_FILES['file']['tmp_name'], DATADIR.'datagallery/'.$unifile.'.'.$ext)){

if ($config['copyfoto']==1) {copyright_image(DATADIR.'datagallery/'.$unifile.'.'.$ext);}

@chmod(DATADIR.'/datagallery/'.$unifile.'.'.$ext, 0666);

$text = no_br($msg.'|'.$name.'|'.$log.'||'.SITETIME.'|'.$unifile.'|'.$unifile.'.'.$ext.'|');

write_files(DATADIR."datagallery/fotobase.dat", "$text\r\n", 0, 0666);

if ($ashow==1){change_profil($log, array(72=>$unifile.'.'.$ext));}

header ("Location: index.php?isset=addfoto"); exit;

} else {show_error('Ошибка! Не удалось загрузить фотографию!');}
} else {show_error('Ошибка! Вес изображения должен быть не более '.formatsize($config['filesize']));}
} else {show_error('Ошибка! Размер изображение должен быть от 50 до '.(int)$config['filefoto'].'px');}
} else {show_error('Ошибка! Недопустимое расширение (Только jpg или gif)!');}
} else {show_error('Слишком длинное или короткое описание (Необходимо от 5 до 1000 символов)');}
} else {show_error('Слишком длинное или короткое название (Необходимо от 5 до 50 символов)');}
} else {show_login('Вы не авторизованы, чтобы добавить фотографию, необходимо');}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="index.php?action=addfoto">Вернуться</a>';
}


############################################################################################
##                                 Добавление комментариев                                ##
############################################################################################
if ($action=="komm"){

$gid = check($_GET['gid']);

show_title('partners.gif', 'Комментарии');

if (preg_match('|^[a-z0-9_\.\-]+$|i', $gid)){
if (is_user()){

echo '<form action="index.php?action=addkomm&amp;gid='.$gid.'" method="post">';
echo '<b>Сообщение:</b><br />';
echo '<textarea cols="25" rows="3" name="msg"></textarea><br />';
echo '<input type="submit" value="Написать" /></form><hr />';

} else {show_login('Вы не авторизованы, чтобы добавить сообщение, необходимо');}

if (file_exists(DATADIR."datagallery/$gid.dat")){
$file = file(DATADIR."datagallery/$gid.dat");
$file = array_reverse($file);
$total = count($file);

if ($total>0){

$is_admin = is_admin(array(101,102,103,105));

if ($is_admin){
echo '<form action="index.php?action=del&amp;gid='.$gid.'&amp;start='.$start.'&amp;uid='.$_SESSION['token'].'" method="post">';
}

if ($start < 0 || $start >= $total){$start = 0;}
if ($total < $start + $config['postgallery']){ $end = $total; }
else {$end = $start + $config['postgallery'];}
for ($i = $start; $i < $end; $i++){

$data = explode("|",$file[$i]);
$num=$total-$i-1;

$data[0]=bb_code($data[0]);

echo '<div class="b"> ';

if ($is_admin){
echo '<input type="checkbox" name="del[]" value="'.$num.'" /> ';
}

echo user_avatars($data[3]);

echo '<b><a href="../pages/anketa.php?uz='.$data[3].'"> '.nickname($data[3]).' </a></b> '.user_title($data[3]).user_online($data[3]);

echo '<small> ('.date_fixed($data[2]).')</small></div>';

echo '<div>'.$data[0].'</div>';
}

if ($is_admin){
echo '<br /><input type="submit" value="Удалить выбранное" /></form>';
}

page_jumpnavigation('index.php?action=komm&amp;gid='.$gid.'&amp;', $config['postgallery'], $start, $total);
page_strnavigation('index.php?action=komm&amp;gid='.$gid.'&amp;', $config['postgallery'], $start, $total);

} else {show_error('Комментариев еще нет, будь первым!');}
} else {show_error('Комментариев еще нет, будь первым!');}
} else {show_error('Ошибка! Недопустимое название изображения!');}

echo '<br /><br /><img src="../images/img/back.gif" alt="image" /> <a href="index.php">Вернуться</a>';
}

############################################################################################
##                                   Запись комментариев                                  ##
############################################################################################
if ($action=="addkomm"){

$gid = check($_GET['gid']);
$msg = check($_POST['msg']);

show_title('partners.gif', 'Добавление комментария');

if (is_user()){
if (preg_match('|^[a-z0-9_\.\-]+$|i', $gid)){
if (utf_strlen(trim($msg))>5 && utf_strlen($msg)<1000){

if (file_exists(DATADIR."datagallery/$gid")){

antiflood("Location: index.php?action=komm&gid=$gid&isset=antiflood");
karantin($udata[6], "Location: index.php?action=komm&gid=$gid&isset=karantin");
statistics(7);

$msg = no_br($msg,'<br />');
$msg = antimat($msg);
$msg = smiles($msg);

$text = no_br($msg.'||'.SITETIME.'|'.$log.'|');

write_files(DATADIR."datagallery/$gid.dat", "$text\r\n", 0, 0666);

//---------------------------------------------------------//
$countstr = counter_string(DATADIR."datagallery/$gid.dat");
if ($countstr>=$config['maxpostgallery']) {
delete_lines(DATADIR."datagallery/$gid.dat",array(0,1));
}

change_profil($log, array(14=>$ip, 33=>$udata[33]+1, 36=>$udata[36]+1, 41=>$udata[41]+1));

header("location: index.php?action=komm&gid=$gid&isset=addkomm"); exit;

} else {show_error('Ошибка, такой фотографии не существует!');}
} else {show_error('Вы не написали комментарий или он слишком короткий');}
} else {show_error('Ошибка! Недопустимое название изображения!');}
} else {show_login('Вы не авторизованы, чтобы добавить сообщение, необходимо');}

echo '<br /><br /><img src="../images/img/back.gif" alt="image" /> <a href="index.php?action=komm&amp;gid='.$gid.'">Вернуться</a><br />';
echo '<img src="../images/img/reload.gif" alt="image" /> <a href="index.php">В галерею</a>';
}


############################################################################################
##                                 Удаление комментариев                                  ##
############################################################################################
if ($action=="del"){

show_title('partners.gif', 'Удаление комментариев');

if (is_admin(array(101,102,103,105))){

$uid = check($_GET['uid']);
if (isset($_GET['gid'])) {$gid = check($_GET['gid']);} else {$gid = "";}
if (isset($_POST['del'])) {$del = intar($_POST['del']);} else {$del = "";}

if ($uid==$_SESSION['token']){
if ($del!==""){
if (preg_match('|^[a-z0-9_\.\-]+$|i', $gid)){
if (file_exists(DATADIR."datagallery/$gid.dat")){

delete_lines(DATADIR."datagallery/$gid.dat", $del);

header("location: index.php?action=komm&gid=$gid&start=$start&isset=delkomm"); exit;

} else {show_error('Ошибка! Отстутствует файл с сообщениями!');}
} else {show_error('Ошибка! Не выбран файл с сообщениями!');}
} else {show_error('Ошибка! Отстутствуют выбранные сообщения для удаления!');}
} else {show_error('Ошибка! Неверный идентификатор сессии, повторите действие!');}
} else {show_error('Ошибка! Удалять сообщения могут только модераторы!');}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="index.php?action=komm&amp;gid='.$gid.'&amp;start='.$start.'">Вернуться</a>';
}

echo '<br /><img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>
