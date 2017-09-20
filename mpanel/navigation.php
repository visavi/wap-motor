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

if (is_admin(array(101,102))){

echo'<img src="../images/img/menu.gif" alt="image" /> <b>Управление навигацией</b><br /><br />';

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if ($action==""){

$files = file(DATADIR."navigation.dat");
$total = count($files);
if ($total>0) {

echo '<form action="navigation.php?action=del&amp;uid='.$_SESSION['token'].'" method="post">';

foreach($files as $key=>$val){
$data = explode("|", $val);

echo '<div class="b">';
echo '<img src="../images/img/edit.gif" alt="image" /> <b><a href="navigation.php?action=edit&amp;id='.$key.'">'.$data[1].'</a></b> ('.$data[0].')</div>';

echo '<div><input type="checkbox" name="del[]" value="'.$key.'" /> ';

if ($key != 0){echo '<a href="navigation.php?action=move&amp;id='.$key.'&amp;where=0&amp;uid='.$_SESSION['token'].'">Вверх</a> | ';} else {echo 'Вверх | ';}
if ($total > ($key+1)){echo '<a href="navigation.php?action=move&amp;id='.$key.'&amp;where=1&amp;uid='.$_SESSION['token'].'">Вниз</a>';} else {echo 'Вниз';}

echo '</div>';

}
echo '<br /><input type="submit" value="Удалить выбранное" /></form>';


echo '<br />Всего ссылок: <b>'.(int)$total.'</b><br />';

} else {echo '<b>Ссылок еще нет!</b><br />';}

echo '<br /><img src="../images/img/edit.gif" alt="image" /> <a href="navigation.php?action=add">Добавить</a>';
}

############################################################################################
##                               Подготовка к редактированию                              ##
############################################################################################
if($action=="edit") {

if (isset($_GET['id'])) {$id = (int)$_GET['id'];} else {$id = "";}

if ($id!==""){

$file = file(DATADIR."navigation.dat");

if (isset($file[$id])){
$data = explode("|",$file[$id]);

echo '<b><big>Редактирование ссылки</big></b><br /><br />';

echo '<form action="navigation.php?id='.$id.'&amp;action=addedit&amp;uid='.$_SESSION['token'].'" method="post">';
echo 'Ссылка: <br /><input type="text" name="navstr" value="'.$data[0].'" /><br />';
echo 'Название: <br /><input type="text" name="navname" value="'.$data[1].'" /><br />';
echo '<br /><input type="submit" value="Изменить" /></form><hr />';

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Данной ссылки не существует!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Не выбрана ссылка для редактирования!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="navigation.php">Вернуться</a>';
}


############################################################################################
##                                     Редактирование                                     ##
############################################################################################
if ($action=="addedit") {

$uid = check($_GET['uid']);
$navstr = check($_POST['navstr']);
$navname = check($_POST['navname']);
if (isset($_GET['id'])) {$id = (int)$_GET['id'];} else {$id = "";}

if ($uid==$_SESSION['token']){
if ($id!==""){
if ($navstr!="" && $navname!=""){

$text = no_br($navstr.'|'.$navname.'|');

replace_lines(DATADIR."navigation.dat", $id, $text);

header ("Location: navigation.php?isset=mp_editnavigation"); exit;

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Не указана ссылка или название!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Не выбрана ссылка для редактирования!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/reload.gif" alt="image" /> <a href="navigation.php?action=edit&amp;id='.$id.'">Вернуться</a><br />';
echo '<img src="../images/img/back.gif" alt="image" /> <a href="navigation.php">К списку</a>';
}

############################################################################################
##                                  Подготовка к добавлению                               ##
############################################################################################
if ($action=="add") {

echo '<b><big>Добавление ссылки</big></b><br /><br />';

echo '<form action="navigation.php?action=addstr&amp;uid='.$_SESSION['token'].'" method="post">';
echo 'Страница: <br /><input type="text" name="navstr" /><br />';
echo 'Название: <br /><input type="text" name="navname" /><br />';
echo '<br /><input type="submit" value="Добавить" /></form><hr />';

echo '<img src="../images/img/back.gif" alt="image" /> <a href="navigation.php">Вернуться</a>';
}

############################################################################################
##                                         Добавление                                     ##
############################################################################################
if ($action=="addstr") {

$uid = check($_GET['uid']);
$navstr = check($_POST['navstr']);
$navname = check($_POST['navname']);

if ($uid==$_SESSION['token']){
if ($navstr!="" && $navname!=""){

$text = no_br($navstr.'|'.$navname.'|');

write_files(DATADIR."navigation.dat", "$text\r\n");

header ("Location: navigation.php?isset=mp_addnavigation"); exit;

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Не указана ссылка или название!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/reload.gif" alt="image" /> <a href="navigation.php?action=add">Вернуться</a><br />';
echo '<img src="../images/img/back.gif" alt="image" /> <a href="navigation.php">К списку</a>';
}

############################################################################################
##                                       Сдвиг ссылок                                     ##
############################################################################################
if ($action=="move"){

$uid = check($_GET['uid']);
if (isset($_GET['id'])) {$id = (int)$_GET['id'];} else {$id = "";}
if (isset($_GET['where'])) {$where = (int)$_GET['where'];} else {$where = "";}

if ($uid==$_SESSION['token']){
if ($id!==""){
if ($where!==""){

move_lines(DATADIR."navigation.dat", $id, $where);

header ("Location: navigation.php?isset=mp_movenavigation"); exit;

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Не выбрано действие для сдвига!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Не выбрана строка для сдвига!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="navigation.php">Вернуться</a>';
}


############################################################################################
##                                 Удаление сообщений                                     ##
############################################################################################
if ($action=="del") {

$uid = check($_GET['uid']);
if (isset($_POST['del'])) {$del = intar($_POST['del']);} else {$del = "";}

if ($uid==$_SESSION['token']){
if ($del!==""){

delete_lines(DATADIR."navigation.dat", $del);

header ("Location: navigation.php?isset=mp_delnavigation"); exit;

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка удаления! Отсутствуют выбранные ссылки!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="navigation.php">Вернуться</a>';
}



//-------------------------------- КОНЦОВКА ------------------------------------//
echo '<br /><img src="../images/img/panel.gif" alt="image" /> <a href="index.php">В админку</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a><br />';

} else {header ("Location: ../index.php?isset=404"); exit;}

include_once ("../themes/".$config['themes']."/foot.php");
?>
