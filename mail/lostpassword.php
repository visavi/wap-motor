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

show_title('partners.gif', 'Восстановление пароля');

if (!is_user()){

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if ($action==""){

if (isset($_COOKIE['cookname'])) {$cookname = check($_COOKIE['cookname']);} else {$cookname = "";}

echo 'Введите свой логин и код для проверки<br />';
echo 'Инструкция по восстановлению будет выслана на электронный адрес указанный в профиле<br />';
echo 'Восстанавливать пароль можно не чаще чем раз в 12 часов<br /><br />';

echo '<form method="post" action="lostpassword.php?action=send&amp;'.SID.'">';
echo 'Логин:<br />';
echo '<input name="uz" type="text" maxlength="20" value="'.$cookname.'" /><br />';
echo 'Проверочный код: ';
if ($config['protectimg']==1){
echo '<img src="'.BASEDIR.'gallery/protect.php?'.SID.'" alt="" /><br />';
} else {
echo '<b>'.$_SESSION['protect'].'</b><br />';
}
echo '<input name="provkod" maxlength="6" /><br /><br />';
echo '<input value="Получить пароль" type="submit" /></form><hr />';

}

############################################################################################
##                            Подтверждение восстановления                                ##
############################################################################################
if($action=="send"){

$uz = check($_POST['uz']);
$provkod = (int)$_POST['provkod'];

if ($uz!=""){
if (preg_match('|^[a-z0-9\-]+$|i',$uz)){
if ($_SESSION['protect']==$provkod){
if (file_exists(DATADIR."profil/$uz.prof")){

$uzdata = reading_profil($uz);
if (xoft_decode($uzdata[35],$config['keypass'])<SITETIME){

$_SESSION['protect'] = "";
unset($_SESSION['protect']);

$restore_key = xoft_encode((SITETIME + 43200),$config['keypass']);

change_profil($uz, array(35=>$restore_key));

//---------------- Инструкция по восстановлению пароля на E-mail --------------------------//
if ($uzdata[4]!=""){
addmail($uzdata[4], "Подтверждение восстановления пароля на сайте ".$config['title'], "Здравствуйте, ".$uzdata[0]." \nВами была произведена операция по восстановлению пароля на сайте ".$config['home']." \n\nДанные отправителя: \nIp: $ip \nБраузер: $brow \nОтправлено: ".date('j.m.y / H:i',SITETIME)."\n\nДля того чтобы восстановить пароль, вам необходимо перейти по ссылке: \n\n".$config['home']."/mail/lostpassword.php?action=restore&uz=".$uzdata[0]."&key=".$restore_key." \n\nЕсли это письмо попало к вам по ошибке или вы не собираетесь восстанавливать пароль, то просто проигнорируйте его");
}

echo 'Письмо с инструкцией по востановлению пароля успешно выслано на E-mail указанный в профиле<br />';
echo 'Внимательно прочтите письмо и выполните все необходимые действия для восстановления пароля<br />';
echo 'Восстанавливать пароль можно не чаще чем раз в 12 часов<br />';

} else {show_error('Ошибка, с момента последнего восстановления пароля прошло менее 12 часов!');}
} else {show_error('Ошибка, пользователя с данным логином не зарегестрирован!');}
} else {show_error('Проверочное число не совпало с данными на картинке!');}
} else {show_error('Недопустимые символы в названии логина!');}
} else {show_error('Ошибка, вы не ввели логин для восстановления!');}

echo'<br /><img src="../images/img/back.gif" alt="image" /> <a href="lostpassword.php?'.SID.'">Вернуться</a>';
}

############################################################################################
##                                Восстановление пароля                                   ##
############################################################################################
if($action=="restore"){

$uz = check($_GET['uz']);
$key = check($_GET['key']);

if ($uz!=""){
if ($key!=""){
if (preg_match('|^[a-z0-9\-]+$|i',$uz)){
if (file_exists(DATADIR."profil/$uz.prof")){

$uzdata = reading_profil($uz);

if ($key==$uzdata[35]){

$newpass = generate_password();
$mdnewpas = md5(md5($newpass));

change_profil($uz, array(1=>$mdnewpas, 35=>''));

//--------------------------- Восстановлению пароля на E-mail --------------------------//
if($uzdata[4]!=""){
addmail($uzdata[4], "Восстановление пароля на сайте ".$config['title'], "Здравствуйте, ".$uzdata[0]." \nВаши новые данные для входа на на сайт ".$config['home']." \nЛогин: ".$uzdata[0]." \nПароль: ".$newpass." \n\nЗапомните и постарайтесь больше не забывать данные, а лучше сделайте сразу закладку на наш сайт \n".$config['home']."/input.php?login=".$uzdata[0]."&pass=".$newpass."&cookietrue=1 \nПароль вы сможете поменять в своем профиле \nВсего наилучшего!");
}

header ("Location: ../index.php?isset=lostpass&".SID); exit;

} else {show_error('Ошибка, секретный код в ссылке не совпадает с данными в профиле!');}
} else {show_error('Ошибка, пользователя с данным логином не зарегестрирован!');}
} else {show_error('Недопустимые символы в названии логина!');}
} else {show_error('Ошибка, отсутствует секретный код в ссылке для восстановления пароля!');}
} else {show_error('Ошибка, отсутствует логин в ссылке для восстановления пароля!');}
}

} else {show_error('Ошибка! Вы авторизованы, восстановление пароля невозможно!');}

echo '<br /><img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a><br />';

include_once ("../themes/".$config['themes']."/foot.php");
?>