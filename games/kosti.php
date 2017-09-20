<?php
#-----------------------------------------------------#
#          ********* WAP-MOTORS *********             #
#             Made by   :  VANTUZ                     #
#               E-mail  :  visavi.net@mail.ru         #
#                 Site  :  http://pizdec.ru           #
#             WAP-Site  :  http://visavi.net          #
#                  ICQ  :  36-44-66                   #
#  Вы не имеете право вносить изменения в код скрипта #
#        для его дальнейшего распространения          #
#-----------------------------------------------------#
require_once "../includes/start.php";
require_once "../includes/functions.php";
require_once "../includes/header.php";
include_once "../themes/".$config['themes']."/index.php";

$rand = mt_rand(100, 999);
if (isset($_GET['action'])) {$action = check($_GET['action']);} else {$action = "";}

echo '<img src="../images/img/partners.gif" alt="image" /> <b>Кости</b><br /><br />';

if (is_user()){

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if ($action==""){

echo '<img src="../images/kosti/6.gif" alt="image" />  и <img src="../images/kosti/6.gif" alt="image" />.<br /><br />';

echo '<b><a href="kosti.php?action=go&amp;rand='.$rand.'">Играть</a></b><br /><br />';

echo 'У вас в наличии: '.moneys($udata[41]).'<br />';

echo '<br /><img src="../images/img/faq.gif" alt="image" /> <a href="kosti.php?action=faq">Правила</a>';
}

############################################################################################
##                                       Результат                                        ##
############################################################################################
if ($action=="go"){

if ($udata[41]>=5){

sleep(1); //задержка 1 сек

$num1 = mt_rand(2, 6);
$num2 = mt_rand(1, 6);
$num3 = mt_rand(1, 6);
$num4 = mt_rand(1, 5);


echo 'У банкира  выпало:<br />';
echo '<img src="../images/kosti/'.$num1.'.gif" alt="image" />  и <img src="../images/kosti/'.$num2.'.gif" alt="image" />.<br /><br />';

echo 'У вас выпало:<br />';
echo '<img src="../images/kosti/'.$num3.'.gif" alt="image" />  и <img src="../images/kosti/'.$num4.'.gif" alt="image" />.<br /><br />';


$num_bank = $num1 + $num2;
$num_user = $num3 + $num4;

//------------------------------ Выигрыш банкира ----------------------------//

if ($num_bank>$num_user){

change_profil($log, array(41=>$udata[41]-5));

echo '<b>Банкир выиграл!</b>';
}

//------------------------------ Выигрыш пользователя ----------------------------//

if ($num_bank<$num_user){

change_profil($log, array(41=>$udata[41]+10));

echo '<b>Вы выиграли!</b>';
}


if ($num_bank==$num_user){echo '<b>Ничья!</b>';}

echo '<br /><br />';
echo '<b><a href="kosti.php?action=go&amp;rand='.$rand.'">Играть</a></b><br /><br />';

$udata = reading_profil($log);

echo 'У вас в наличии: '.moneys($udata[41]).'<br />';

} else {show_error('Вы не можете играть т.к. на вашем счету недостаточно средств');}

echo '<br /><img src="../images/img/faq.gif" alt="image" /> <a href="kosti.php?action=faq">Правила</a>';
}


############################################################################################
##                                    Правила игры                                        ##
############################################################################################
if ($action=="faq"){

echo 'Для участия в игре нажмите "Играть"<br />';
echo 'За каждый проигрыш у вас будут списывать по '.moneys(5).'<br />';
echo 'За каждый выигрыш вы получите '.moneys(10).'<br />';
echo 'Шанс банкира на выигрыш немного больше, чем у вас<br />';
echo 'Итак дерзайте!<br />';

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="kosti.php">Вернуться</a>';
}

} else {show_login('Вы не авторизованы, чтобы начать игру, необходимо');}

echo '<br /><img src="../images/img/games.gif" alt="image" /> <a href="../pages/index.php?action=arkada">Развлечения</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>
