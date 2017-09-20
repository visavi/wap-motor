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

include_once"../includes/pclzip.php";

if (isset($_GET['start'])) {$start = (int)$_GET['start'];} else {$start = 0;}
if (isset($_GET['action'])) {$action = check($_GET['action']);} else {$action = "";}

if (is_admin(array(101))){

echo '<img src="../images/img/partners.gif" alt="image" /> <b>Backup сайта</b><br /><br />';

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if ($action==""){

echo 'Вы можете сейчас сделать бэкап скачав все данные в запакованном архиве zip<br />';
echo 'И потом в случае сбоя сервера, все данные можно легко восстановить<br /><br />';

$array_backup = array();
$array_timebackup = array();
$array_sizebackup = array();

$globfiles = glob(DATADIR."databackup/*.zip");

if ($globfiles){
foreach ($globfiles as $filename) {
$array_backup[] = basename($filename);
$array_timebackup[] = filemtime($filename);
$array_sizebackup[] = filesize($filename);
}

$totalarc = count($array_backup);
if($totalarc>0){

arsort($array_timebackup);

foreach($array_timebackup as $key=>$value){
echo '<div class="b">';
echo '<img src="../images/img/zip.gif" alt="image" /> <b><a href="backup.php?action=view&amp;filearc='.$array_backup[$key].'">'.$array_backup[$key].'</a></b> ('.formatsize($array_sizebackup[$key]).')</div>';
echo '<div><a href="backup.php?action=prounzip&amp;filearc='.$array_backup[$key].'">Восстановить</a> | ';
echo '<a href="backup.php?action=del&amp;filearc='.$array_backup[$key].'&amp;uid='.$_SESSION['token'].'">Удалить</a></div>';
}

echo '<br />Всего архивов: <b>'.(int)$totalarc.'</b><br />';

} else {echo '<img src="../images/img/reload.gif" alt="image" /> <b>Бэкапов еще нет!</b><br />';}
} else {echo '<img src="../images/img/reload.gif" alt="image" /> <b>Бэкапов еще нет!</b><br />';}

echo '<br /><img src="../images/img/backup.gif" alt="image" /> <a href="backup.php?action=backup">Создать</a>';
}

############################################################################################
##                                  Выбор файлов для архивации                            ##
############################################################################################
if ($action == "backup"){

if(is_writeable(DATADIR."databackup")){

echo 'Выберите директории для архивации<br /><br />';

$backdir_array = array();

$globdirs = glob(DATADIR."*", GLOB_ONLYDIR);

foreach ($globdirs as $dirs) {
if ($dirs!=DATADIR.'databackup' && $dirs!=DATADIR.'datatmp' && $dirs!=DATADIR.'datados'){
$backdir_array[] = $dirs;
}}

sort($backdir_array);

echo '<form method="post" action="backup.php?action=newbackup">';

echo '<input name="files" value="1" type="checkbox" checked="checked" /> <img src="../images/img/adddir.gif" alt="image" /> <b>Главные файлы</b><br />';

foreach($backdir_array as $value){
echo '<input name="dirarc[]" value="'.$value.'" type="checkbox" checked="checked" /> ';
echo '<img src="../images/img/dir.gif" alt="image" /> <b>'.basename($value).'</b> ('.formatsize(read_dir(DATADIR.$value)).')<br />';
}

echo '<br /><input type="submit" value="Сделать бекап" /></form><hr />';

} else {echo '<b>Ошибка! Запрещена запись в папку databackup</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="backup.php">Вернуться</a>';
}

############################################################################################
##                                    Создание бэкапа                                     ##
############################################################################################
if ($action == "newbackup"){

if (isset($_POST['files'])) {$files = 1;} else {$files = 0;}
if (isset($_POST['dirarc'])) {$dirarc = check($_POST['dirarc']);} else {$dirarc = "";}
$datetime = date('d-M-Y_H-i-s', SITETIME);

if ($dirarc!="" || $files!=""){

$nam_backup = 'backup_'.$datetime.'.zip';

if ($files==1){
$globfiles = glob(DATADIR."*.dat");
foreach ($globfiles as $filename) {
$dirarc[] = $filename;
}}

$newarc = implode(',',$dirarc);

$archive = new PclZip(DATADIR.'databackup/'.$nam_backup);

if($archive->add($newarc,PCLZIP_OPT_REMOVE_PATH, DATADIR)){
chmod (DATADIR."databackup/$nam_backup", 0666);

header ("Location: backup.php?isset=mp_yesbackup");  exit;

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Не удалось создать архив с данными!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Не выбраны директории или файлы для аривации!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="backup.php?action=backup">Вернуться</a>';

}

############################################################################################
##                                    Удаление архивов                                    ##
############################################################################################
if ($action == "del"){

$uid = check($_GET['uid']);
$filearc = check($_GET['filearc']);

if ($uid==$_SESSION['token']){
if ($filearc!=""){
if (preg_match('|^[a-z0-9_\.\-]+$|i', $filearc)){
if (file_exists(DATADIR."databackup/$filearc")){

unlink (DATADIR."databackup/$filearc");

header ("Location: backup.php?isset=mp_delbackup"); exit;

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Данного архива не существует!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Недопустимое название архива!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Вы не выбрали архив для удаления!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="backup.php">Вернуться</a>';
}


############################################################################################
##                             Подтверждение востановления архива                         ##
############################################################################################
if ($action == "prounzip"){

$filearc = check($_GET['filearc']);

if ($filearc!=""){

echo 'Вы подтверждаете, что хотите восстановить бэкап сайта '.$filearc.'?<br />';
echo '<img src="../images/img/reload.gif" alt="image" /> ';
echo '<b><a href="backup.php?action=unzip&amp;filearc='.$filearc.'&amp;uid='.$_SESSION['token'].'">Да, подтверждаю!</a></b><br />';

echo '<br />Восстановление архива не заменяет существующие файлы, а восстанавливает те, которые были случайно удалены<br />';

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Вы не выбрали архив для восстановления!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="backup.php">Вернуться</a>';
}

############################################################################################
##                                     Востановления архива                               ##
############################################################################################
if ($action == "unzip"){

$uid = check($_GET['uid']);
$filearc = check($_GET['filearc']);

if ($uid==$_SESSION['token']){
if ($filearc!=""){
if (preg_match('|^[a-z0-9_\.\-]+$|i', $filearc)){
if (file_exists(DATADIR."databackup/$filearc")){

$archive = new PclZip(DATADIR.'databackup/'.$filearc);

if($archive->extract(PCLZIP_OPT_PATH, DATADIR, PCLZIP_OPT_SET_CHMOD, 0777)){

header ("Location: backup.php?isset=mp_restorebackup"); exit;

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Не удалось восстановить архив!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Данного архива не существует!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Недопустимое название архива!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Вы не выбрали архив для восстановления!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="backup.php">Вернуться</a>';
}

############################################################################################
##                                       Просмотр архива                                  ##
############################################################################################
if ($action == "view"){

$filearc = check($_GET['filearc']);

if ($filearc!=""){
if (preg_match('|^[a-z0-9_\.\-]+$|i', $filearc)){
if (file_exists(DATADIR."databackup/$filearc")){


$archive = new PclZip(DATADIR.'databackup/'.$filearc);
if (($list = $archive->listContent()) != 0){

sort($list);
$total = count($list);

if ($total>0){

foreach($list as $value){
$zfilename[] = $value['filename'];
$zfilesize[] = $value['size'];
$zfolder[] = $value['folder'];
}

echo '<img src="../images/img/zip.gif" alt="image" /> <b>'.$filearc.'</b><br /><br />';

if ($start < 0 || $start > $total){$start = 0;}
if ($total < $start + $config['ziplist']){ $end = $total;}
else {$end = $start + $config['ziplist']; }
for ($i = $start; $i < $end; $i++){

if($zfolder[$i]==1){
$zfilename[$i] = substr($zfilename[$i],0,-1);

echo '<img src="../images/img/dir.gif" alt="image" /> <b>Директория '.$zfilename[$i].'</b><br />';
} else {
echo '<img src="../images/img/files.gif" alt="image" /> '.$zfilename[$i].' ('.formatsize($zfilesize[$i]).')<br />';
}
}

page_jumpnavigation('backup.php?action=view&amp;filearc='.$filearc.'&amp;', $config['ziplist'], $start, $total);
page_strnavigation('backup.php?action=view&amp;filearc='.$filearc.'&amp;', $config['ziplist'], $start, $total);

echo '<br /><br />Всего файлов: <b>'.$total.'</b><br />';

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! В данном архиве нет файлов!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Невозможно открыть архив!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Данного архива не существует!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Недопустимое название архива!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Вы не выбрали архив для просмотра!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="backup.php">Вернуться</a>';
}


echo '<br /><img src="../images/img/panel.gif" alt="image" /> <a href="index.php">В админку</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a><br />';

} else {header ("Location: ../index.php?isset=404"); exit;}

include_once"../themes/".$config['themes']."/foot.php";
?>
