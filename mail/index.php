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

show_title('partners.gif', 'Письмо Администратору');

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if($action==""){

echo '<form method="post" action="index.php?action=go">';

if (!is_user()){
echo 'Ваше имя:<br /><input name="name" maxlength="20" /><br />';
echo 'Ваш E-mail:<br /><input name="umail" maxlength="50" /><br />';

} else {

echo '<input name="name" type="hidden" value="'.$log.'" />';
echo '<input name="umail" type="hidden" value="'.$udata[4].'" />';
}


echo 'Сообщение:<br /><textarea cols="25" rows="5" name="body"></textarea><br />';

echo 'Проверочный код: ';
if ($config['protectimg']==1){
echo '<br /><img src="../gallery/protect.php" alt="" /><br />';
} else {
echo '<b>'.$_SESSION['protect'].'</b><br />';
}

echo '<input name="provkod" maxlength="6" /><br /><br />';
echo '<input value="Отправить" name="go" type="submit" /></form><hr />';

echo 'Обновите страницу если вы не видите проверочный код!<br />';
}

//------------------------------ Отправка сообшения --------------------------//
if ($action=="go"){

$name = check($_POST['name']);
$body = check($_POST['body']);
$umail = check($_POST['umail']);
$provkod = (int)$_POST['provkod'];

if ($_SESSION['protect']==$provkod){
if (utf_strlen(trim($name))>=3 && utf_strlen($name)<50){
if (utf_strlen(trim($body))>=5 && utf_strlen($body)<5000){
if (preg_match('#^([a-z0-9_\-\.])+\@([a-z0-9_\-\.])+(\.([a-z0-9])+)+$#',$umail)){

$_SESSION['protect'] = "";
unset($_SESSION['protect']);

$body=utf_substr($body,0,5000);

addmail($config['emails'], "Письмо с сайта ".$config['title'], "Ip: $ip \nБраузер: $brow \nОтправлено: ".date('j.m.y / H:i',SITETIME)."\n\nСообщение: \n".$body, $umail, $name);

header ("Location: ../index.php?isset=mail"); exit;

} else {show_error('Вы ввели неверный адрес e-mail, необходим формат name@site.domen!');}
} else {show_error('Слишком длинное или короткое сообшение, необходимо от 5 до 5000 символов!');}
} else {show_error('Слишком длинное или короткое имя, необходимо от 3 до 50 символов!');}
} else {show_error('Проверочное число не совпало с данными на картинке!');}


echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="index.php">Вернуться</a>';
}

echo '<br /><img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a><br />';

include_once "../themes/".$config['themes']."/foot.php";
?>
