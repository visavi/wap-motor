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

if (is_admin(array(101))){

echo '<img src="../images/img/partners.gif" alt="image" /> <b>Очистка базы юзеров</b><br /><br />';

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if ($action==""){

$count = count(glob(DATADIR."profil/*.prof"));

echo 'Удалить пользователей которые не посещали сайт более:';

echo '<form action="delusers.php?action=poddel" method="post">';
echo '<br /><select name="deldate">';
echo '<option value="360">1 года</option>';
echo '<option value="270">9 месяцев</option>';
echo '<option value="180">6 месяцев</option>';
echo '<option value="150">5 месяцев</option>';
echo '<option value="120">4 месяцев</option>';
echo '<option value="90">3 месяцев</option>';
echo '<option value="60">2 месяцев</option>';
echo '<option value="30">1 месяца</option>';
echo '</select> <input value="Анализ" type="submit" /></form><hr />';

echo 'Всего пользователей: '.$count.'<br />';
}

############################################################################################
##                                Подтверждение удаления                                  ##
############################################################################################
if($action=="poddel"){

$deldate = (int)$_POST['deldate'];

if ($deldate>=30){

$array_users = array();
$globusers = glob(DATADIR."profil/*.prof");
foreach ($globusers as $filename) {
$filemtime = filemtime($filename) + $deldate * 24 * 3600;

if (SITETIME>$filemtime){
$array_users[] = basename($filename, '.prof');
}}

$total = count($array_users);

if ($total>0){
echo 'Вы подтверждаете, что хотите полностью удалить пользователей  не посещавших сайт более <b>'.$deldate.'</b> дней?<br /><br />';
echo '<img src="../images/img/error.gif" alt="image" /> <b><a href="delusers.php?action=del&amp;deldate='.$deldate.'&amp;uid='.$_SESSION['token'].'">Удалить пользователей</a></b><br /><br />';

echo '<b>Список:</b> ';

foreach ($array_users as $key=>$value){
if($key==0){
echo '<a href="../pages/anketa.php?uz='.$value.'">'.nickname($value).'</a>';
} else {
echo ', <a href="../pages/anketa.php?uz='.$value.'">'.nickname($value).'</a>';
}}


echo '<br /><br />Будет удалено пользователей: <b>'.(int)$total.'</b><br />';

} else {echo '<b>Нет пользователей для удаления!</b><br />';}
} else {echo '<b>Ошибка! Не указано время для удаления</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="delusers.php">Вернуться</a>';
}

############################################################################################
##                                Удаление пользователей                                  ##
############################################################################################
if($action=="del"){

$uid = check($_GET['uid']);
$deldate = (int)$_GET['deldate'];

if ($uid==$_SESSION['token']){
if ($deldate>=30){

$array_users = array();
$globusers = glob(DATADIR."profil/*.prof");
foreach ($globusers as $filename) {
$filemtime = filemtime($filename) + $deldate * 24 * 3600;

if (SITETIME>$filemtime){
$array_users[] = basename($filename, '.prof');
}}

$total = count($array_users);

if ($total>0){

foreach ($array_users as $value){
delete_users($value);
}

echo 'Все пользователи не посещавшие сайт более <b>'.$deldate.'</b> дней, успешно удалены!<br />';
echo 'Было удалено пользователей: <b>'.(int)$total.'</b><br />';

} else {echo '<b>Нет пользователей для удаления!</b><br />';}
} else {echo '<b>Ошибка! Не указано время для удаления</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="delusers.php">Вернуться</a>';
}

echo '<br /><img src="../images/img/panel.gif" alt="image" /> <a href="index.php">В админку</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a><br />';

} else {header ("Location: ../index.php?isset=404"); exit;}

include_once ("../themes/".$config['themes']."/foot.php");
?>
