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
require_once ('../includes/start.php');
require_once ('../includes/functions.php');
require_once ('../includes/header.php');
include_once ('../themes/'.$config['themes'].'/index.php');
require_once ("conf.php");

$msg = check($_POST['msg']);
$icq = intval(str_replace('-', '', $_POST['icq']));

show_title('menu.gif', 'Добавление сообщения');

if (is_user()){
if (utf_strlen($msg)>=5 && utf_strlen($msg)<300){

if (is_admin(array(101,102,103,105))){
if (file_exists("color/$log.dat")){
$selt = file_get_contents("color/$log.dat");
if (!empty($selt)){
$msg =str_replace ("$msg","[$selt] $msg [/$selt]",$msg);
}}}

antiflood("Location: index.php?isset=antiflood");

$msg = no_br($msg,'<br />');
$msg = antimat($msg);
$msg = smiles($msg);

$text = no_br($log.'|'.$msg.'|'.$icq.'|'.SITETIME.'|'.$ip.'|'.$brow.'|');

write_files("msg.dat", "$text\r\n", 0, 0666);

$countstr = counter_string("msg.dat");
if ($countstr>=$all_msg) {
delete_lines(DATADIR."msg.dat",array(0,1));
}

header ("Location: ../index.php?isset=addon"); exit;

} else {show_error('Ошибка! Слишком длинное или короткое сообщение!');}

} else {show_login('Вы не авторизованы, чтобы добавить сообщение, необходимо');}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="index.php">Вернуться</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>
