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

$msg = check($_POST['msg']);

show_title('partners.gif', 'Добавление сообщения');

if (is_user()){
if (utf_strlen(trim($msg))>3 && utf_strlen($msg)<1000){

antiflood("Location: index.php?isset=antiflood&".SID);
karantin($udata[6], "Location: index.php?isset=karantin&".SID);
statistics(8);

$msg = no_br($msg,'<br />');
$msg = antimat($msg);
$msg = smiles($msg);

$file = file(DATADIR."chat.dat");
$data = explode("|",end($file));

$text = no_br($msg.'|'.$log.'||'.SITETIME.'|'.$brow.'|'.$ip.'|0|'.$data[7].'|'.$data[8].'|');

write_files(DATADIR."chat.dat", "$text\r\n");

$countstr = counter_string(DATADIR."chat.dat");
if ($countstr>=$config['maxpostchat']) {
delete_lines(DATADIR."chat.dat",array(0,1,2,3,4));
}

change_profil($log, array(14=>$ip, 12=>$udata[12]+1, 36=>$udata[36]+1, 41=>$udata[41]+1));

//--------------------------------------------------------------------------//
if ($config['botnik']==1){ 

include_once BASEDIR."includes/chat_bot.php";

if ($mssg!=""){
$text = no_br($mssg.'|'.$namebots.'||'.SITETIME.'|MOT-V3|L-O-V-E|0|'.$data[7].'|'.$data[8].'|');

write_files(DATADIR."chat.dat", "$text\r\n");
}}

//--------------------------------------------------------------------------//
if ($config['magnik']==1){

if (stristr($msg, $data[8])) { 

$text = no_br('Молодец '.nickname($log).'! Правильный ответ [b]'.$data[8].'[/b]! Следующий вопрос через 1 минуту|Вундер-киндер||'.SITETIME.'|Opera|127.0.0.3|0|'.(SITETIME + 60).'||');

write_files(DATADIR."chat.dat", "$text\r\n");
}}

header ("Location: index.php?isset=addon&".SID); exit;

} else {show_error('Ошибка, слишком длинное или короткое сообщение!');}
} else {show_login('Вы не авторизованы, чтобы добавить сообщение, необходимо');}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="index.php?'.SID.'">Вернуться</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a>'; 

include_once "../themes/".$config['themes']."/foot.php";
?>

