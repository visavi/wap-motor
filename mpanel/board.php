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

echo '<img src="../images/img/partners.gif" alt="image" /> <b>Доска объявлений</b><br /><br />';

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if ($action=="") {

$is_admin = is_admin(array(101,102));

if (file_exists(DATADIR."databoard/database.dat")) {
$lines = file(DATADIR."databoard/database.dat");
$total = count($lines);

if ($total>0) {

if ($is_admin) {echo '<form action="board.php?action=delrub&amp;uid='.$_SESSION['token'].'" method="post">';}

foreach($lines as $key=>$boardval){
$data = explode("|", $boardval);

$totalboard = counter_string(DATADIR."databoard/$data[2].dat");

echo '<div class="b"><img src="../images/img/forums.gif" alt="image" /> ';
echo '<b><a href="board.php?action=board&amp;id='.$data[2].'">'.$data[0].'</a></b> ('.(int)$totalboard.')';

if ($is_admin){
echo '<br /><input type="checkbox" name="del[]" value="'.$key.'" /> ';

if ($key != 0){echo '<a href="board.php?action=move&amp;id='.$key.'&amp;where=0&amp;uid='.$_SESSION['token'].'">Вверх</a> | ';} else {echo 'Вверх | ';}
if ($total > ($key+1)){echo '<a href="board.php?action=move&amp;id='.$key.'&amp;where=1&amp;uid='.$_SESSION['token'].'">Вниз</a>';} else {echo 'Вниз';}
echo ' | <a href="board.php?action=edit&amp;id='.$key.'">Редактировать</a>';
}

echo '</div>';

echo '<div>'.$data[1].'</div>';
}

if ($is_admin) {echo '<br /><input type="submit" value="Удалить выбранное" /></form>';}

echo '<br />Всего рубрик: <b>'.(int)$total.'</b><br />';

} else {echo '<img src="../images/img/reload.gif" alt="image" /> <b>Доска объявлений пуста, рубрики еще не созданы!</b><br />';}
} else {echo '<img src="../images/img/reload.gif" alt="image" /> <b>Доска объявлений пуста, рубрики еще не созданы!</b><br />';}

if ($is_admin) {echo '<br /><img src="../images/img/edit.gif" alt="image" /> <a href="board.php?action=add">Добавить</a>';}
}

############################################################################################
##                                   Просмотр рубрики                                     ##
############################################################################################
if ($action=="board")  {

$id = (int)$_GET['id'];
if ($id!=""){

$string = search_string(DATADIR."databoard/database.dat", $id, 2);
if ($string) {

echo '<a href="#down"><img src="../images/img/downs.gif" alt="image" /></a> ';
echo '<a href="board.php">Объявления</a> | ';
echo '<a href="../board/add.php?id='.$id.'">Добавить | </a>';
echo '<a href="../board/index.php?action=board&amp;id='.$id.'">Обзор</a><br /><br />';

echo '<b><img src="../images/img/themes.gif" alt="image" /> '.$string[0].'</b> ('.$string[1].')<hr />';

if (file_exists(DATADIR."databoard/$id.dat")){
$lines = file(DATADIR."databoard/$id.dat");
$lines = array_reverse($lines);
$total = count($lines);

if ($total>0) {

echo '<form action="board.php?action=deltop&amp;id='.$id.'&amp;start='.$start.'&amp;uid='.$_SESSION['token'].'" method="post">';

if ($start < 0 || $start > $total){$start = 0;}
if ($total < $start + $config['boardspost']){ $end = $total; }
else {$end = $start + $config['boardspost']; }
for ($i = $start; $i < $end; $i++){

$data = explode("|",$lines[$i]);

$num = $total - $i - 1;

if (utf_strlen($data[2])>100) {
$data[2] = utf_substr($data[2],0,100); $data[2].="...";
}

echo '<div class="b">';

echo '<input type="checkbox" name="del[]" value="'.$num.'" /> ';

echo '<img src="../images/img/forums.gif" alt="image" /> '.($i+1).'. ';
echo '<b>'.$data[0].'</b> (<small>'.date_fixed($data[3]).'</small>)</div>';
echo '<div>Текст объявления: '.$data[2].'<br />';
echo 'Автор объявления: <a href="../pages/anketa.php?uz='.$data[1].'">'.nickname($data[1]).'</a>';
echo '</div>';

}
echo '<br /><input type="submit" value="Удалить выбранное" /></form>';

page_jumpnavigation('board.php?action=board&amp;id='.$id.'&amp;', $config['boardspost'], $start, $total);
page_strnavigation('board.php?action=board&amp;id='.$id.'&amp;', $config['boardspost'], $start, $total);

echo '<br /><br />Всего объявлений: <b>'.(int)$total.'</b><br />';

} else {echo '<img src="../images/img/reload.gif" alt="image" /> <b>Объявлений еще нет!</b><br />';}
} else {echo '<img src="../images/img/reload.gif" alt="image" /> <b>Объявлений еще нет!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Данной рубрики не существует!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Не выбрана рубрика для просмотра!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="board.php">Вернуться</a>';
}

############################################################################################
##                                  Подготовка к добавлению                               ##
############################################################################################
if ($action=="add") {

if (is_admin(array(101,102))){

echo '<b><big>Добавление рубрики</big></b><br /><br />';

echo '<form action="board.php?action=addrub&amp;uid='.$_SESSION['token'].'" method="post">';
echo 'Название: <br /><input type="text" name="zag" /><br />';
echo 'Описание: <br /><input type="text" name="msg" /><br />';
echo '<br /><input type="submit" value="Добавить" /></form><hr />';

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Добавлять рубрики могут только администраторы!</b><br />';}

echo '<img src="../images/img/back.gif" alt="image" /> <a href="board.php">Вернуться</a>';
}

############################################################################################
##                                         Добавление                                     ##
############################################################################################
if ($action=="addrub") {

$uid = check($_GET['uid']);
$zag = check($_POST['zag']);
$msg = check($_POST['msg']);

if (is_admin(array(101,102))){
if ($uid==$_SESSION['token']){
if (utf_strlen(trim($zag))>=3 && utf_strlen($zag)<50){
if (utf_strlen(trim($msg))>=5 && utf_strlen($msg)<50){

$unifile = unifile(DATADIR."databoard/database.dat", 2);

$text = no_br($zag.'|'.$msg.'|'.$unifile.'|');

write_files(DATADIR."databoard/database.dat", "$text\r\n", 0, 0666);

header ("Location: board.php?isset=mp_addboard"); exit;

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Слишком длинное или короткое описание рубрики!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Слишком длинное или короткое название рубрики!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Добавлять рубрики могут только администраторы!</b><br />';}

echo '<br /><img src="../images/img/reload.gif" alt="image" /> <a href="board.php?action=add">Вернуться</a><br />';
echo '<img src="../images/img/back.gif" alt="image" /> <a href="board.php">К объявлениям</a>';
}


############################################################################################
##                                    Редактирование                                      ##
############################################################################################
if ($action=="edit") {

if (isset($_GET['id'])) {$id = (int)$_GET['id'];} else {$id = "";}

if (is_admin(array(101,102))){
if ($id!==""){

$file = file(DATADIR."databoard/database.dat");
if (isset($file[$id])){
$data = explode("|", $file[$id]);

echo '<b><big>Редактирование рубрики</big></b><br /><br />';

echo '<form action="board.php?id='.$id.'&amp;action=addedit&amp;uid='.$_SESSION['token'].'" method="post">';

echo 'Название: <br /><input type="text" name="zag" value="'.$data[0].'" /><br />';
echo 'Описание: <br /><input type="text" name="msg" value="'.$data[1].'" /><br /><br />';

echo '<input type="submit" value="Изменить" /></form><hr />';

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Данной рубрики не существует!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Не выбрана рубрика для редактирования!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Редактировать рубрики могут только администраторы!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="board.php">Вернуться</a>';
}


############################################################################################
##                                 Изменение рубрики                                      ##
############################################################################################
if ($action=="addedit") {

$uid = check($_GET['uid']);
$zag = check($_POST['zag']);
$msg = check($_POST['msg']);
if (isset($_GET['id'])) {$id = (int)$_GET['id'];} else {$id = "";}

if (is_admin(array(101,102))){
if ($uid==$_SESSION['token']){
if ($id!==""){
if (utf_strlen(trim($zag))>=3 && utf_strlen($zag)<50){
if (utf_strlen(trim($msg))>=5 && utf_strlen($msg)<50){

$file = file(DATADIR."databoard/database.dat");
if (isset($file[$id])){
$data = explode("|", $file[$id]);

$text = no_br($zag.'|'.$msg.'|'.$data[2].'|');

replace_lines(DATADIR."databoard/database.dat", $id, $text);

header ("Location: board.php?isset=mp_editboard"); exit;

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Рубрики для редактирования не существует!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Слишком длинное или короткое описание рубрики!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Слишком длинное или короткое название рубрики!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Не выбрана рубрика для редактирования!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Редактировать рубрики могут только администраторы!</b><br />';}

echo '<br /><img src="../images/img/reload.gif" alt="image" /> <a href="board.php?action=add">Вернуться</a><br />';
echo '<img src="../images/img/back.gif" alt="image" /> <a href="board.php">К объявлениям</a>';
}

############################################################################################
##                                       Сдвиг рубрик                                     ##
############################################################################################
if ($action=="move"){

$uid = check($_GET['uid']);
if (isset($_GET['id'])) {$id = (int)$_GET['id'];} else {$id = "";}
if (isset($_GET['where'])) {$where = (int)$_GET['where'];} else {$where = "";}

if (is_admin(array(101,102))){
if ($uid==$_SESSION['token']){
if ($id!==""){
if ($where!==""){

move_lines(DATADIR."databoard/database.dat", $id, $where);

header ("Location: board.php?isset=mp_moveboard"); exit;

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Не выбрано действие для сдвига!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Не выбрана строка для сдвига!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Двигать рубрики могут только администраторы!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="board.php">Вернуться</a>';
}


############################################################################################
##                                 Удаление рубрики                                       ##
############################################################################################
if ($action=="delrub") {

$uid = check($_GET['uid']);
if (isset($_POST['del'])) {$del = intar($_POST['del']);} else {$del = "";}

if (is_admin(array(101,102))){
if ($uid==$_SESSION['token']){
if ($del!==""){

$file = file(DATADIR."databoard/database.dat");

foreach($del as $val){
$data = explode("|", $file[$val]);

if(file_exists(DATADIR."databoard/$data[2].dat")){
unlink (DATADIR."databoard/$data[2].dat");
}}

delete_lines(DATADIR."databoard/database.dat", $del);

header ("Location: board.php?isset=mp_delboard"); exit;

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка удаления! Отсутствуют выбранные рубрики!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Удалять рубрики могут только администраторы!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="board.php">Вернуться</a>';
}


############################################################################################
##                                 Удаление объявлений                                    ##
############################################################################################
if ($action=="deltop") {

$id = check($_GET['id']);
$uid = check($_GET['uid']);
if (isset($_POST['del'])) {$del = intar($_POST['del']);} else {$del = "";}

if ($uid==$_SESSION['token']){
if ($id!=""){
if ($del!==""){

delete_lines(DATADIR."databoard/$id.dat", $del);

header ("Location: board.php?action=board&id=$id&start=$start&isset=mp_deltopboard"); exit;

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Отсутствуют выбранные объявления!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Не выбрана рубрика для удаления!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="board.php?action=board&amp;id='.$id.'&amp;start='.$start.'">Вернуться</a>';
}

//----------------------- Концовка -------------------------//
echo '<br /><img src="../images/img/panel.gif" alt="image" /> <a href="index.php">В админку</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a><br />';

} else {header ("Location: ../index.php?isset=404"); exit;}

include_once ("../themes/".$config['themes']."/foot.php");
?>
