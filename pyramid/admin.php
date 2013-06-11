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
require_once ("conf.php");


if (isset($_GET['action'])) {$action = check($_GET['action']);} else {$action = "";}

show_title('menu.gif', 'Настройки пирамиды');

if (is_admin(array(101,102,103,105))){


if ($action == ""){

echo '<form method="post" action="admin.php?action=settings&amp;'.SID.'">';

echo 'Показывать IP адрес?<br />';
if ($look_ip=="On"){
echo '<input name="swip" type="radio" value="On" checked="checked" /> Да ';
}else{
echo '<input name="swip" type="radio" value="On" /> Да ';}

if ($look_ip=="Off"){
echo '<input name="swip" type="radio" value="Off" checked="checked" /> Нет ';
}else{
echo '<input name="swip" type="radio" value="Off" /> Нет ';}

echo '<br /><br />Маленький шрифт<br />';
if ($small_msg=="On"){
echo '<input name="small" type="radio" value="On" checked="checked" /> Да ';
} else {
echo '<input name="small" type="radio" value="On" /> Да ';}
if ($small_msg=="Off"){
echo '<input name="small" type="radio" value="Off" checked="checked" /> Нет ';
} else {
echo '<input name="small" type="radio" value="Off" /> Нет ';}


echo '<br /><br />Сообщений на главную<br />';
echo '<input name="mess" type="text" value="'.$msg_list.'" /><br />';

echo 'Всего сообщений<br />';
echo '<input name="all" type="text" value="'.$all_msg.'" /><br />';

echo 'Сообщений в истории<br />';
echo '<input name="history" type="text" value="'.$msg_his.'" /><br />';

echo'<br /><input value="Изменить" type="submit" /></form><hr />';


echo '<form method="post" action="admin.php?action=userset&amp;'.SID.'">';
echo '<br /><b>Цвет ваших сообщений</b><br />';

if (file_exists("color/$log.dat")){
$wss = file_get_contents("color/$log.dat");
} else {$wss = '';}

echo '<input name="color" type="radio" value="blue"';if($wss=="blue"){echo' checked="checked" />';}else{echo' />';}
echo '<font color="blue"> Синий</font><br />';

echo '<input name="color" type="radio" value="red"';if($wss=="red"){echo' checked="checked" />';}else{echo' />';}
echo '<font color="red"> Красный</font><br />';

echo '<input name="color" type="radio" value="green"';if($wss=="green"){echo' checked="checked" />';}else{echo' />';}
echo '<font color="green"> Зеленый</font><br />';


echo '<input name="color" type="radio" value="yellow"';if($wss=="yellow"){echo' checked="checked" />';}else{echo' />';}
echo '<font color="yellow"> Желтый</font><br />';

echo '<br /><input value="Изменить" type="submit" /></form><hr />';
}

#####################################
if ($action=="settings"){

$swip = check($_POST['swip']);
$small = check($_POST['small']);
$mess = intval($_POST['mess']);
$all = intval($_POST['all']);
$history = intval($_POST['history']);

if (!empty($swip) && !empty($small) && !empty($mess) && !empty($all) && !empty($history)){

$text = no_br($swip.'|'.$small.'|'.$mess.'|'.$all.'|'.$history.'|');

write_files("config.dat", "$text\r\n", 1, 0666);

header ("Location: admin.php?isset=editsetting&".SID); exit;

} else {show_error('Ошибка! Вы не заполнили все поля!');}
}


#####################################
if ($action=="userset"){

$color = check($_POST['color']);

if (!empty($color)){

write_files("color/$log.dat", $color, 1, 0666);

header ("Location: admin.php?isset=editsetting&".SID); exit;

} else {show_error('Ошибка! Вы не выбрали цвет для ваших сообщений!');}
}

} else {show_error('Ошибка! Данная страница доступна только администрации!');}

echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a>'; 

include_once ("../themes/".$config['themes']."/foot.php");
?>