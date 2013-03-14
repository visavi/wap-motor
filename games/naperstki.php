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

$rand = mt_rand(100, 999);
if (isset($_GET['action'])) {$action = check($_GET['action']);} else {$action = "";}

echo '<img src="../images/img/partners.gif" alt="image" /> <b>Наперстки</b><br /><br />';

if (is_user()){

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if ($action==""){

echo '<img src="../images/naperstki/1.gif" alt="image" />.<br /><br />';
echo '<b><a href="naperstki.php?action=choice&amp;'.SID.'">Играть</a></b><br /><br />';
echo 'У вас в наличии: '.moneys($udata[41]).'<br />';
echo '<br /><img src="../images/img/faq.gif" alt="image" /> <a href="naperstki.php?action=faq&amp;'.SID.'">Правила</a><br />';
}


############################################################################################
##                                     Выбор наперстка                                    ##
############################################################################################
if ($action=="choice"){

if (isset($_SESSION['naperstki'])){
$_SESSION['naperstki']="";
unset($_SESSION['naperstki']);
}

echo '<a href="naperstki.php?action=go&amp;thimble=1&amp;rand='.$rand.'&amp;'.SID.'"><img src="../images/naperstki/2.gif" alt="image" /></a> ';
echo '<a href="naperstki.php?action=go&amp;thimble=2&amp;rand='.$rand.'&amp;'.SID.'"><img src="../images/naperstki/2.gif" alt="image" /></a> ';
echo '<a href="naperstki.php?action=go&amp;thimble=3&amp;rand='.$rand.'&amp;'.SID.'"><img src="../images/naperstki/2.gif" alt="image" /></a>.<br /><br />';

echo 'Выберите наперсток в котором может находится шарик<br />';

echo 'У вас в наличии: '.moneys($udata[41]).'<br />';

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="naperstki.php?'.SID.'">Вернуться</a><br />'; 	
}

############################################################################################
##                                        Результат                                       ##
############################################################################################
if ($action=="go"){

$thimble = (int)$_GET['thimble'];
if (!isset($_SESSION['naperstki'])){$_SESSION['naperstki'] = 0;}

if ($udata[41]>=50){
if ($_SESSION['naperstki']<3){

$_SESSION['naperstki']++;

$rand_thimble = mt_rand(1, 3);

if ($rand_thimble==1){
echo '<img src="../images/naperstki/3.gif" alt="image" /> ';
} else {
echo '<img src="../images/naperstki/2.gif" alt="image" /> ';
}

if ($rand_thimble==2){
echo '<img src="../images/naperstki/3.gif" alt="image" /> ';
} else {
echo '<img src="../images/naperstki/2.gif" alt="image" /> ';
}

if ($rand_thimble==3){
echo '<img src="../images/naperstki/3.gif" alt="image" />.';
} else {
echo '<img src="../images/naperstki/2.gif" alt="image" />.';
}


//------------------------------ Выигрыш ----------------------------//
if ($thimble==$rand_thimble){

change_profil($log, array(41=>$udata[41]+100));

echo '<br /><b>Вы выиграли!</b><br />';

//------------------------------ Проигрыш ----------------------------//
} else {

change_profil($log, array(41=>$udata[41]-50));

echo '<br /><b>Вы проиграли!</b><br />';
}

} else {show_error('Необходимо выбрать один из наперстков');}

echo '<br /><b><a href="naperstki.php?action=choice&amp;rand='.$rand.'&amp;'.SID.'">К выбору</a></b><br /><br />';

$udata = reading_profil($log);
echo 'У вас в наличии: '.moneys($udata[41]).'<br />';

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="naperstki.php?'.SID.'">Вернуться</a><br />'; 	

} else {show_error('Вы не можете играть, т.к. на вашем счету недостаточно средств');}
}


############################################################################################
##                                     Описание игры                                      ##
############################################################################################
if($action=="faq"){
	
echo 'Для участия в игре нажмите "Играть"<br />';
echo 'За каждый проигрыш у вас будут списывать по '.moneys(50).'<br />';	
echo 'За каждый выигрыш вы получите '.moneys(100).'<br />';	
echo 'Шанс банкира на выигрыш немного больше, чем у вас<br />';	
echo 'Итак дерзайте!<br />';
	
echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="naperstki.php?'.SID.'">Вернуться</a><br />'; 	
}

} else {show_login('Вы не авторизованы, чтобы начать игру, необходимо');}

echo '<img src="../images/img/games.gif" alt="image" /> <a href="../pages/index.php?action=arkada&amp;'.SID.'">Развлечения</a><br />'; 
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a>'; 

include_once ("../themes/".$config['themes']."/foot.php");
?>