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

echo '<img src="../images/img/partners.gif" alt="image" /> <b>Управление статусами</b><br /><br />';

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if($action==""){

if (file_exists(DATADIR."status.dat")){
$text = file_get_contents(DATADIR."status.dat");
$data = explode("|",$text);

echo '<form method="post" action="status.php?action=edit&amp;uid='.$_SESSION['token'].'">';
echo '0 - 4 балла:<br /><input name="st0" value="'.$data[0].'" /><br />';
echo '5 - 9 баллов:<br /><input name="st1" value="'.$data[1].'" /><br />';
echo '10 - 19 баллов:<br /><input name="st2" value="'.$data[2].'" /><br />';
echo '20 - 49 баллов:<br /><input name="st3" value="'.$data[3].'" /><br />';
echo '50 - 99 баллов:<br /><input name="st4" value="'.$data[4].'" /><br />';
echo '100 - 249 баллов:<br /><input name="st5" value="'.$data[5].'" /><br />';
echo '250 - 499 баллов:<br /><input name="st6" value="'.$data[6].'" /><br />';
echo '500 - 749 баллов:<br /><input name="st7" value="'.$data[7].'" /><br />';
echo '750 - 999 баллов:<br /><input name="st8" value="'.$data[8].'" /><br />';
echo '1000 - 1249 баллов:<br /><input name="st9" value="'.$data[9].'" /><br />';
echo '1250 - 1499 баллов:<br /><input name="st10" value="'.$data[10].'" /><br />';
echo '1500 - 1749 баллов:<br /><input name="st11" value="'.$data[11].'" /><br />';
echo '1750 - 1999 баллов:<br /><input name="st12" value="'.$data[12].'" /><br />';
echo '2000 - 2249 баллов:<br /><input name="st13" value="'.$data[13].'" /><br />';
echo '2250 - 2499 баллов:<br /><input name="st14" value="'.$data[14].'" /><br />';
echo '2500 - 2749 баллов:<br /><input name="st15" value="'.$data[15].'" /><br />';
echo '2750 - 2999 баллов:<br /><input name="st16" value="'.$data[16].'" /><br />';
echo '3000 - 3249 баллов:<br /><input name="st17" value="'.$data[17].'" /><br />';
echo '3250 - 3499 баллов:<br /><input name="st18" value="'.$data[18].'" /><br />';
echo '3500 - 4999 баллов:<br /><input name="st19" value="'.$data[19].'" /><br />';
echo '5000 - 7499 баллов:<br /><input name="st20" value="'.$data[20].'" /><br />';
echo '7500 - 9999 баллов:<br /><input name="st21" value="'.$data[21].'" /><br />';
echo '10000 баллов и выше:<br /><input name="st22" value="'.$data[22].'" /><br />';

echo '<br /><input value="Сохранить" type="submit" /></form><hr />';

} else {echo '<b>Ошибка! Отсутствует файл со статусами!</b><br />';}
}

############################################################################################
##                                Редактирование статусов                                 ##
############################################################################################
if($action=="edit") {

$uid = check($_GET['uid']);
$st0 = check($_POST['st0']);
$st1 = check($_POST['st1']);
$st2 = check($_POST['st2']);
$st3 = check($_POST['st3']);
$st4 = check($_POST['st4']);
$st5 = check($_POST['st5']);
$st6 = check($_POST['st6']);
$st7 = check($_POST['st7']);
$st8 = check($_POST['st8']);
$st9 = check($_POST['st9']);
$st10 = check($_POST['st10']);
$st11 = check($_POST['st11']);
$st12 = check($_POST['st12']);
$st13 = check($_POST['st13']);
$st14 = check($_POST['st14']);
$st15 = check($_POST['st15']);
$st16 = check($_POST['st16']);
$st17 = check($_POST['st17']);
$st18 = check($_POST['st18']);
$st19 = check($_POST['st19']);
$st20 = check($_POST['st20']);
$st21 = check($_POST['st21']);
$st22 = check($_POST['st22']);

if ($uid==$_SESSION['token']){
if ($st0!="" && $st1!="" && $st2!="" && $st3!="" && $st4!="" && $st5!="" && $st6!="" && $st7!="" && $st8!="" && $st9!="" && $st10!="" && $st11!="" && $st12!="" && $st13!="" && $st14!="" && $st15!="" && $st16!="" && $st17!="" && $st18!="" && $st19!="" && $st20!="" && $st21!="" && $st22!=""){

$text=no_br($st0.'|'.$st1.'|'.$st2.'|'.$st3.'|'.$st4.'|'.$st5.'|'.$st6.'|'.$st7.'|'.$st8.'|'.$st9.'|'.$st10.'|'.$st11.'|'.$st12.'|'.$st13.'|'.$st14.'|'.$st15.'|'.$st16.'|'.$st17.'|'.$st18.'|'.$st19.'|'.$st20.'|'.$st21.'|'.$st22.'|');

write_files(DATADIR."status.dat", $text, 1);

header ("Location: status.php?isset=mp_editstatus"); exit;

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Не заполнены все поля для статусов!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="status.php">Вернуться</a>';
}



//-------------------------------- КОНЦОВКА ------------------------------------//
echo '<br /><img src="../images/img/panel.gif" alt="image" /> <a href="index.php">В админку</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a><br />';

} else {header ("Location: ../index.php?isset=404"); exit;}

include_once ("../themes/".$config['themes']."/foot.php");
?>
