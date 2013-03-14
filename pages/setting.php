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

echo '<img src="../images/img/profiles.gif" alt="image" /> <b>Мои настройки</b><br /><br />';

if (is_user()){

############################################################################################
##                                 Главная страница                                       ##
############################################################################################	
if ($action==""){

echo '<form method="post" action="setting.php?action=edit&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">';

echo 'Wap-тема по умолчанию:<br />';
echo '<select name="skins">';
echo '<option value="'.$config['themes'].'">'.$config['themes'].'</option>';

$globthemes = glob(BASEDIR."themes/*", GLOB_ONLYDIR);
foreach ($globthemes as $themes) {
if (basename($themes)!=$config['themes']){
echo '<option value="'.basename($themes).'">'.basename($themes).'</option>';
}}

echo '</select><br />';

echo 'Сообщений в гостевой на стр.:<br /><input name="bookpostus" value="'.$udata[21].'" /><br />';
echo 'Новостей на стр.:<br /><input name="news" value="'.$udata[22].'" /><br />';
echo 'Сообщений в форуме:<br /><input name="forumpost" value="'.$udata[23].'" /><br />';
echo 'Тем в форуме:<br /><input name="forumtem" value="'.$udata[24].'" /><br />';
echo 'Cообщений в чате :<br /><input name="chatpost" value="'.$udata[26].'" /><br />';
echo 'Кол-во объявлений на стр.:<br /><input name="board" value="'.$udata[28].'" /><br />';
echo 'Писем в привате на стр.:<br /><input name="prrivs" value="'.$udata[32].'" /><br />';
echo 'Временной сдвиг (+1 -1):<br /><input name="sdvig" value="'.$udata[30].'" /><br />';

echo 'Показывать Часы:<br />';
echo 'Да';

if ($udata[31]==1){
echo '<input name="times" type="radio" value="1" checked="checked" />';
} else {
echo '<input name="times" type="radio" value="1" />';}
echo ' &nbsp; &nbsp; ';

if ($udata[31]==0){
echo '<input name="times" type="radio" value="0" checked="checked" />';
} else {
echo '<input name="times" type="radio" value="0" />';}  
echo 'Нет<br />';	
	
echo 'Включить персонажа игры:<br />';
echo 'Да';
if ($udata[55]==1){
echo '<input name="editperson" type="radio" value="1" checked="checked" />';
} else {
echo '<input name="editperson" type="radio" value="1" />';}
echo ' &nbsp; &nbsp; ';	
	
	
if ($udata[55]==0){
echo '<input name="editperson" type="radio" value="0" checked="checked" />';
} else {
echo '<input name="editperson" type="radio" value="0" />';}  
echo 'Нет<br />';		
	
echo 'Привязка к IP:<br />';
echo 'Да';
if ($udata[66]==1){
echo '<input name="ipcontrol" type="radio" value="1" checked="checked" />';
} else {
echo '<input name="ipcontrol" type="radio" value="1" />';}
echo ' &nbsp; &nbsp; ';	
	
	
if ($udata[66]==0){
echo '<input name="ipcontrol" type="radio" value="0" checked="checked" />';
} else {
echo '<input name="ipcontrol" type="radio" value="0" />';}  
echo 'Нет<br /><br />';	

echo '<input value="Изменить" type="submit" /></form><hr />';

echo '* Значение всех полей (max.50)<br />';

}

############################################################################################
##                                       Изменение                                        ##
############################################################################################	
if ($action=="edit"){

$uid = check($_GET['uid']);
$skins = check($_POST['skins']);
$bookpostus = (int)$_POST['bookpostus'];
$news = (int)$_POST['news'];
$forumpost = (int)$_POST['forumpost'];
$forumtem = (int)$_POST['forumtem'];
$chatpost = (int)$_POST['chatpost'];
$board = (int)$_POST['board'];
$prrivs = (int)$_POST['prrivs'];
$sdvig = check($_POST['sdvig']);
$times = (int)$_POST['times'];
$graffic = (int)$_POST['graffic'];
$editavator = (int)$_POST['editavator'];
$editperson = (int)$_POST['editperson'];
$ipcontrol = (int)$_POST['ipcontrol'];

if ($uid==$_SESSION['token']){
if (preg_match('|^[a-z0-9_\-]+$|i',$skins)){
if (file_exists(BASEDIR."themes/$skins/index.php")){
if ($bookpostus>=3 && $bookpostus<=50){
if ($news>=3 && $news<=50){
if ($forumpost>=3 && $forumpost<=50){
if ($forumtem>=3 && $forumtem<=50){
if ($chatpost>=3 && $chatpost<=50){
if ($board>=3 && $board<=50){
if ($prrivs>=3 && $prrivs<=50){
if (preg_match('|^[\-\+]{0,1}[0-9]{1,2}$|',$sdvig)){

if (isset($_SESSION['my_themes']) && $_SESSION['my_themes']!=""){
$_SESSION['my_themes']="";
unset($_SESSION['my_themes']);
}

change_profil($log, array(14=>$ip, 20=>$skins, 21=>$bookpostus, 22=>$news, 23=>$forumpost, 24=>$forumtem, 26=>$chatpost, 28=>$board, 30=>$sdvig, 31=>$times, 32=>$prrivs, 42=>$graffic, 45=>$editavator, 55=>$editperson, 66=>$ipcontrol));

header ("Location: setting.php?isset=editsetting&".SID); exit;

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Временной сдвиг. (Допустимый диапазон -24 — +24 часов)</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Приватные сообщения (Допустимое значение от 3 до 50)</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Объявления (Допустимое значение от 3 до 50)</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Сообщения в чате (Допустимое значение от 3 до 50)</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Темы в форуме (Допустимое значение от 3 до 50)</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Сообщения в форуме (Допустимое значение от 3 до 50)</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Новости (Допустимое значение от 3 до 50)</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Сообщения в гостевой (Допустимое значение от 3 до 50)</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Данный скин не установлен на сайте</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Недопустимое название скина</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="setting.php?'.SID.'">Вернуться</a>';
}

} else {show_login('Вы не авторизованы, чтобы изменять настройки, необходимо');}

echo '<br /><img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>