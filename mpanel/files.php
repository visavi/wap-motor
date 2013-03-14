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
if (isset($_GET['file'])) {$file = check($_GET['file']);} else {$file = "";}

if (is_admin(array(101)) && $log==$config['nickname']){

show_title('menu.gif', 'Редактирование страниц');

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if ($action==""){

$arrfiles = array();
$globfiles = glob(DATADIR."datamain/*.dat");
foreach ($globfiles as $filename) {
$arrfiles[] = basename($filename);
}

$total = count($arrfiles);  

if ($total>0) {

if ($start < 0 || $start > $total){$start = 0;}
if ($total < $start + $config['editfiles']){ $end = $total; }
else {$end = $start + $config['editfiles']; }
for ($i = $start; $i < $end; $i++){	
	
$filename = str_replace('.dat','',$arrfiles[$i]);
$size = formatsize(filesize(DATADIR."datamain/$arrfiles[$i]")); 
$strok = count(file(DATADIR."datamain/$arrfiles[$i]")); 

if ($arrfiles[$i]=='index.dat'){

echo '<div class="b"><img src="../images/img/edit.gif" alt="image" /> ';
echo '<b><a href="../index.php?'.SID.'"><span style="color:#ff0000">'.$arrfiles[$i].'</span></a></b> ('.$size.')<br />';
echo '<a href="files.php?action=edit&amp;file='.$arrfiles[$i].'&amp;'.SID.'">Редактировать</a> | ';
echo '<a href="files.php?action=obzor&amp;file='.$arrfiles[$i].'&amp;'.SID.'">Просмотр</a></div>'; 
echo '<div>Кол. строк: '.$strok.'<br />';
echo 'Изменен: '.date_fixed(filemtime(DATADIR."datamain/$arrfiles[$i]")).'</div>';
} else {

echo '<div class="b"><img src="../images/img/edit.gif" alt="image" /> ';
echo '<b><a href="../pages/index.php?action='.$filename.'&amp;'.SID.'">'.$arrfiles[$i].'</a></b> ('.$size.')<br />';
echo '<a href="files.php?action=edit&amp;file='.$arrfiles[$i].'&amp;'.SID.'">Редактировать</a> | ';
echo '<a href="files.php?action=obzor&amp;file='.$arrfiles[$i].'&amp;'.SID.'">Просмотр</a> | ';
echo '<a href="files.php?action=poddel&amp;file='.$arrfiles[$i].'&amp;'.SID.'">Удалить</a></div>';
echo '<div>Кол. строк: '.$strok.'<br />';
echo 'Изменен: '.date_fixed(filemtime(DATADIR."datamain/$arrfiles[$i]")).'</div>';
}}

page_jumpnavigation('files.php?', $config['editfiles'], $start, $total);
page_strnavigation('files.php?', $config['editfiles'], $start, $total);

echo '<br /><br />Всего файлов: <b>'.(int)$total.'</b><br />';

} else {show_error('Файлов еще нет!');}

echo'<br /><img src="../images/img/files.gif" alt="image" /> <a href="files.php?action=new&amp;'.SID.'">Создать</a><br />';
echo'<img src="../images/img/faq.gif" alt="image" /> <a href="files.php?action=faq&amp;'.SID.'">Помощь</a>';
}


############################################################################################
##                                      Обзор файла                                       ##
############################################################################################
if ($action=="obzor"){

if (preg_match('|^[a-z0-9_\.\-]+$|i', $file)){
if (file_exists(DATADIR."datamain/$file")){

echo '<b>Просмотр файла '.$file.'</b><br />';

$opis = file_get_contents(DATADIR."datamain/$file");
$count = count($opis);

echo 'Строчек: '.(int)$count.'<br /><br />';

echo highlight_code(check($opis)).'<br />';

echo '<br /><img src="../images/img/edit.gif" alt="image" /> <a href="files.php?action=edit&amp;file='.$file.'&amp;'.SID.'">Редактировать</a><br />';
echo '<img src="../images/img/error.gif" alt="image" /> <a href="files.php?action=poddel&amp;file='.$file.'&amp;'.SID.'">Удалить</a>';

} else {show_error('Ошибка! Данного файла не существует!');}
} else {show_error('Ошибка! Недопустимое название страницы!');}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="files.php?'.SID.'">Вернуться</a>';
}

############################################################################################
##                             Подготовка к редактированию                                ##
############################################################################################
if ($action=="edit"){

if (preg_match('|^[a-z0-9_\.\-]+$|i', $file)){
if (file_exists(DATADIR."datamain/$file")){
if (is_writeable(DATADIR."datamain/$file")){

$datamainfile = file_get_contents(DATADIR."datamain/$file");
$filename = str_replace(".dat","",$file);
$datamainfile = str_replace('&amp;','&',$datamainfile);

echo '<div class="form" id="form">';
echo '<b>Редактирование файла '.$file.'</b><br />';

echo '<form action="files.php?action=editfile&amp;file='.$file.'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" name="form" method="post">';

echo '<textarea cols="90" rows="20" name="msg">'.check($datamainfile).'</textarea><br />';

quickpaste('msg');
quicktags();

echo '<br /><input type="submit" value="Редактировать" /></form></div>';

} else {show_error('Ошибка! Файл недоступен для записи!');}
} else {show_error('Ошибка! Данного файла не существует!');}
} else {show_error('Ошибка! Недопустимое название страницы!');}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="files.php?'.SID.'">Вернуться</a><br />';
echo '<img src="../images/img/online.gif" alt="image" /> <a href="../pages/index.php?action='.$filename.'&amp;'.SID.'">Просмотр</a>';
}

############################################################################################
##                                  Редактирование файла                                  ##
############################################################################################
if ($action=="editfile"){

$uid = check($_GET['uid']);
$msg = $_POST['msg'];

if ($uid==$_SESSION['token']){
if ($msg!=""){
if (preg_match('|^[a-z0-9_\.\-]+$|i', $file)){
if (file_exists(DATADIR."datamain/$file")){

$msg = str_replace('&','&amp;',$msg);

write_files(DATADIR."datamain/$file", $msg, 1);

header ("Location: files.php?action=edit&file=$file&isset=mp_editfiles&".SID); exit;

} else {show_error('Ошибка! Данного файла не существует!');}
} else {show_error('Ошибка! Недопустимое название страницы!');}
} else {show_error('Ошибка! Вы не ввели текст для редактирования!');}
} else {show_error('Ошибка! Неверный идентификатор сессии, повторите действие!');}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="files.php?action=edit&amp;file='.$file.'&amp;'.SID.'">Вернуться</a>';
}

############################################################################################
##                                       Помощь                                           ##
############################################################################################
if ($action=="faq"){

echo '<b>Сокрашенные коды Wap-Motor</b><br /><br />';	

echo '<img src="../images/editor/a.gif" alt="image" /> - Тег служит для создания гипертекста (ссылок). Гипертекст позволяет осуществлять мгновенный переход от одного фрагмента текста к другому.<br />';
echo '<img src="../images/editor/img.gif" alt="image" /> - Тег служит для внедрения графики на страницы. alt - Выводит текст к картинке. Полезно, если браузер не отображает графику на странице.<br />';
echo '<img src="../images/editor/br.gif" alt="image" /> - Тег служит для перевода текста на следующую строку<br />';
echo '<img src="../images/editor/hr.gif" alt="image" /> - Тег добавляет в HTML документ горизонтальную линию. Перед и после линии помещается пустая строка<br />';
echo '<img src="../images/editor/b.gif" alt="image" /> - Тег создает жирный текст<br />';
echo '<img src="../images/editor/big.gif" alt="image" /> - Тег выводит более крупный текст<br />';
echo '<img src="../images/editor/small.gif" alt="image" /> - Тег выводит более мелкий текст<br />';
echo '<img src="../images/editor/i.gif" alt="image" /> - Тег создает наклонный текст<br />';
echo '<img src="../images/editor/u.gif" alt="image" /> - Тег указывает, что текст должен быть подчеркнут<br />';
echo '<img src="../images/editor/right.gif" alt="image" /> - Тег создает новый блок. Текст выровнен по правому краю<br />';
echo '<img src="../images/editor/center.gif" alt="image" /> - Тег создает новый блок. Текст выровнен по центру<br />';
echo '<img src="../images/editor/left.gif" alt="image" /> - Тег создает новый блок. Текст выровнен по левому краю<br />';

echo '<img src="../images/editor/red.gif" alt="image" /> - Тег изменяет цвет текста на красный<br />';
echo '<img src="../images/editor/green.gif" alt="image" /> - Тег изменяет цвет текста на зеленый<br />';
echo '<img src="../images/editor/blue.gif" alt="image" /> - Тег изменяет цвет текста на синий<br />';
echo '<img src="../images/editor/yellow.gif" alt="image" /> - Тег изменяет цвет текста на желтый<br />';

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="files.php?'.SID.'">Вернуться</a>';
}

############################################################################################
##                             Подготовка к созданию файла                                ##
############################################################################################
if($action=="new"){

echo '<b>Создание нового файла</b><br /><br />';

if (is_writeable(DATADIR."datamain")){

echo '<div class="form"><form action="files.php?action=addnew&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" method="post">';
echo 'Название файла:<br />';
echo '<input type="text" name="newfile" maxlength="20" /><br /><br />';
echo '<input value="Создать файл" type="submit" /></form></div>';
echo '<br />Разрешены латинские символы и цифры, а также знаки дефис и нижнее подчеркивание<br />';

} else {show_error('Директория недоступна для создания файлов!');}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="files.php?'.SID.'">Вернуться</a>';
}

############################################################################################
##                                      Создание файла                                    ##
############################################################################################
if ($action=="addnew"){

$uid = check($_GET['uid']);
$newfile = check($_POST['newfile']);

if ($uid==$_SESSION['token']){
if (preg_match('|^[a-z0-9_\-]+$|i', $newfile)){
if (!file_exists(DATADIR.'datamain/'.$newfile.'.dat')){	

write_files(DATADIR.'datamain/'.$newfile.'.dat', '', 1, 0666);

header ('Location: files.php?action=edit&file='.$newfile.'.dat&isset=mp_newfiles&'.SID);

} else {show_error('Ошибка! Файл с данным названием уже существует!');}
} else {show_error('Ошибка! Недопустимое название файла!');}
} else {show_error('Ошибка! Неверный идентификатор сессии, повторите действие!');}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="files.php?action=new&amp;'.SID.'">Вернуться</a>';
}

############################################################################################
##                                  Подготовка к удалению                                 ##
############################################################################################
if ($action=="poddel"){

if (preg_match('|^[a-z0-9_\.\-]+$|i', $file)){
if (file_exists(DATADIR."datamain/$file")){

echo 'Вы подтверждаете что хотите удалить файл <b>'.$file.'</b><br />';
echo '<img src="../images/img/error.gif" alt="image" /> <b><a href="files.php?action=del&amp;file='.$file.'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">Удалить</a></b><br />';

} else {show_error('Ошибка! Данного файла не существует!');}
} else {show_error('Ошибка! Недопустимое название страницы!');}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="files.php?'.SID.'">Вернуться</a>';
}

############################################################################################
##                                     Удаление файла                                     ##
############################################################################################
if($action=="del"){

$uid = check($_GET['uid']);

if ($uid==$_SESSION['token']){
if (preg_match('|^[a-z0-9_\.\-]+$|i', $file)){
if (file_exists(DATADIR."datamain/$file")){
if ($file!='index.dat'){

if (unlink (DATADIR."datamain/$file")){

header ("Location: files.php?isset=mp_delfiles&".SID); exit;

} else {show_error('Ошибка! Не удалось удалить файл!');}
} else {show_error('Ошибка! Запрещено удалять главный файл!');}
} else {show_error('Ошибка! Данного файла не существует!');}
} else {show_error('Ошибка! Недопустимое название страницы!');}
} else {show_error('Ошибка! Неверный идентификатор сессии, повторите действие!');}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="files.php?'.SID.'">Вернуться</a>';
}

echo'<br /><img src="../images/img/panel.gif" alt="image" /> <a href="index.php?'.SID.'">В админку</a><br />';
echo'<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a><br />';

} else {header ("Location: ../index.php?isset=404&".SID); exit;}

include_once ("../themes/".$config['themes']."/foot.php");
?>