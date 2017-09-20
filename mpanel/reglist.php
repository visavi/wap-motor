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

$config['reglist'] = 10;

if (isset($_GET['start'])) {$start = (int)$_GET['start'];} else {$start = 0;}
if (isset($_GET['action'])) {$action = check($_GET['action']);} else {$action = "";}

if (is_admin(array(101,102,103))){

##########################################################################
##                         Главная страница                             ##
##########################################################################

echo '<img src="../images/img/partners.gif" alt="image" /> <b>Ожидающие регистрации</b><br /><br />';

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if ($action==""){

if ($config['regkeys']==0) {echo '<img src="../images/img/warning.gif" alt="image" /> <b><span style="color:#ff0000">Подтверждение регистрации отключено!</span></b><br />';}
if ($config['regkeys']==1) {echo '<img src="../images/img/warning.gif" alt="image" /> <b><span style="color:#ff0000">Включено автоматическое подтверждение регистраций!</span></b><br />';}
if ($config['regkeys']==2) {echo '<img src="../images/img/warning.gif" alt="image" /> <b><span style="color:#ff0000">Включена модерация регистраций!</span></b><br />';}

if (file_exists(DATADIR."datatmp/reglist.dat")){
$file = file(DATADIR."datatmp/reglist.dat");
$total = count($file);

//------------------- Удаление не подтвердивших регистрацию ---------------//
if ($config['regkeys']==1) {
if ($total>0) {

$del = array();
$array_users = array();

foreach($file as $keys=>$arrvalue){
$dt = explode("|",$arrvalue);

if (SITETIME>($dt[2]+86400)){
$del[] = $keys;
$array_users[] = $dt[0];
}}

$count_delusers = count($array_users);

if($count_delusers>0){
echo '<br />Было удалено аккаунтов: <b>'.(int)$count_delusers.'</b><br />';

delete_lines(DATADIR."datatmp/reglist.dat", $del);

echo 'Список: ';
foreach($array_users as $delkey=>$delvalue){

if ($delkey==0) {echo $delvalue;} else {echo ', '.$delvalue;}
if (file_exists(DATADIR."profil/$delvalue.prof")){
delete_users($delvalue);
}}
echo '<br /><br />';
}}}
//-------------------------------------------------------------------------//

$file = file(DATADIR."datatmp/reglist.dat");
$file = array_reverse($file);
$total = count($file);

if ($total>0){

echo '<form action="reglist.php?action=choice&amp;start='.$start.'&amp;uid='.$_SESSION['token'].'" method="post">';

if ($start < 0 || $start > $total){$start = 0;}
if ($total < $start + $config['reglist']){ $end = $total; }
else {$end = $start + $config['reglist'];}
for ($i = $start; $i < $end; $i++){

$data = explode("|",$file[$i]);

$num = $total - $i - 1;

echo '<div class="b">';
echo '<input type="checkbox" name="id[]" value="'.$num.'" /> ';
echo '<img src="../images/img/chel.gif" alt="image" /> <b><a href="../pages/anketa.php?uz='.$data[0].'"> '.nickname($data[0]).' </a></b>';
echo '(E-mail: '.$data[1].')</div>';

echo '<div>Зарегистрирован: '.date_fixed($data[2]).'</div>';

}

echo '<br /><select name="choice">';
echo '<option value="1">Разрешить</option>';
echo '<option value="2">Запретить</option>';
echo '</select>';

echo '<input type="submit" value="Выполнить" /></form>';

page_jumpnavigation('reglist.php?', $config['reglist'], $start, $total);
page_strnavigation('reglist.php?', $config['reglist'], $start, $total);


echo '<br /><br />Всего ожидающих: <b>'.(int)$total.'</b><br />';

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Нет пользователей требующих подтверждения регистрации!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Нет пользователей требующих подтверждения регистрации!</b><br />';}
}

############################################################################################
##                                        Действие                                        ##
############################################################################################
if ($action=="choice") {

$uid = check($_GET['uid']);
$choice = (int)$_POST['choice'];
if (isset($_POST['id'])) {$id = intar($_POST['id']);} else {$id = "";}

if ($uid==$_SESSION['token']){
if (!empty($choice)){
if ($id!==""){

//-------------------------------- Разрешение регистрации -------------------------------------//
if ($choice==1){

$file = file(DATADIR."datatmp/reglist.dat");

foreach($id as $val){
if (isset($file[$val])){
$data = explode("|", $file[$val]);

if (file_exists(DATADIR."profil/$data[0].prof")){
change_profil($data[0], array(46=>0, 47=>''));
}}}

delete_lines(DATADIR."datatmp/reglist.dat", $id);

header ("Location: reglist.php?start=$start&isset=mp_addregusers"); exit();
}

//----------------------------------- Запрет регистрации -------------------------------------//
if ($choice==2){

$file = file(DATADIR."datatmp/reglist.dat");

foreach($id as $val){
if (isset($file[$val])){
$data = explode("|", $file[$val]);

if (file_exists(DATADIR."profil/$data[0].prof")){
delete_users($data[0]);
}}}

delete_lines(DATADIR."datatmp/reglist.dat", $id);

header ("Location: reglist.php?start=$start&isset=mp_delregusers"); exit();
}

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Отсутствуют выбранные пользователи!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Не выбрано действие!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="reglist.php?start='.$start.'">Вернуться</a>';
}

echo '<br /><img src="../images/img/panel.gif" alt="image" /> <a href="index.php">В админку</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a><br />';

} else {header ("Location: ../index.php?isset=404"); exit();}

include_once ("../themes/".$config['themes']."/foot.php");
?>
