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

echo '<img src="../images/img/partners.gif" alt="image" /> <b>Выносливость</b><br /><br />';

if (is_user()){

if ($udata[55]==1){
if (empty($udata[59])) {$udata[59] = 50;}

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if ($action==""){
echo 'В наличии: '.moneys($udata[41]).'<br />';
echo 'Уровень выносливости: <b>'.(int)$udata[57].'</b>%<br />';
echo 'Максимальный уровень выносливости: <b>'.(int)$udata[59].'</b>%<br />';
echo '<img src="../gallery/grafic.php?rat='.(int)$udata[57].'&amp;imgs=2&amp;limit='.(int)$udata[59].'" alt="image" /><br /><br />';

echo 'Вы можете увеличить уровень выносливости разными способами<br /><br />';

echo '<img src="../images/img/plus.gif" alt="image" /> <b><a href="stamina.php?action=operacia&amp;pred=0&amp;'.SID.'">Тренироваться</a></b> (Бесплатно)<br />';
echo '(Увеличивает вашу выносливость всего на 3%)<br /><br />';

echo '<img src="../images/img/plus.gif" alt="image" /> <b><a href="stamina.php?action=operacia&amp;pred=1&amp;'.SID.'">Выпить водки</a></b> (Цена: '.moneys(300).')<br />';
echo '(Увеличивает вашу выносливость уже на 10%, но стоит денег)<br /><br />';

echo '<img src="../images/img/plus.gif" alt="image" /> <b><a href="stamina.php?action=operacia&amp;pred=2&amp;'.SID.'">Применить аптечку</a></b> (Цена: '.moneys(1000).')<br />';
echo '(Увеличивает вашу выносливость на 20%, весьма эффективный способ)<br /><br />';

echo '<img src="../images/img/plus.gif" alt="image" /> <b><a href="stamina.php?action=operacia&amp;pred=3&amp;'.SID.'">Использовать допинг</a></b> (Цена: '.moneys(3000).')<br />';
echo '(Увеличивает вашу выносливость на 30%, быстрый способ)<br /><br />';

echo '<img src="../images/img/plus.gif" alt="image" /> <b><a href="stamina.php?action=operacia&amp;pred=4&amp;'.SID.'">Использовать энергетик</a></b> (Цена: '.moneys(10000).')<br />';
echo '(Увеличивает вашу выносливость на 50%, самый быстрый способ)<br /><br />';

echo 'Выберите любой способ и при достаточном количестве денег вы сможете увеличить свою выносливость<br />';
echo 'Увеличивать свою выносливость можно не чаще чем раз в 3 часа<br />';
}

############################################################################################
##                                    Улучшение состояния                                 ##
############################################################################################
if ($action=="operacia"){

$pred = (int)$_GET['pred'];
if (empty($udata[59])) {$udata[59] = 50;}

if ($udata[62]<SITETIME){	

//--------------------------------------------------------------------//
if ($pred==0){
if ($udata[59]>=($udata[57]+3)){

change_profil($log, array(57=>$udata[57]+3, 62=>SITETIME+3600*3));

echo '<b>Вы успешно улучшили состояние своей выносливости!</b><br />';

} else {show_error('У вас достаточный уровень выносливости, вам незачем его пополнять!');}
}

//--------------------------------------------------------------------//
if ($pred==1){
if ($udata[41]>=300){
if ($udata[59]>=($udata[57]+10)){

change_profil($log, array(41=>$udata[41]-300, 57=>$udata[57]+10, 62=>SITETIME+3600*3));

echo '<b>Вы успешно улучшили состояние своей выносливости!</b><br />';

} else {show_error('У вас достаточный уровень выносливости, вам незачем его пополнять!');}
} else {show_error('На вашем счету недостаточно денег для подобной покупки!');}
}

//--------------------------------------------------------------------//
if ($pred==2){
if ($udata[41]>=1000){
if ($udata[59]>=($udata[57]+20)){

change_profil($log, array(41=>$udata[41]-1000, 57=>$udata[57]+20, 62=>SITETIME+3600*3));

echo '<b>Вы успешно улучшили состояние своей выносливости!</b><br />';

} else {show_error('У вас достаточный уровень выносливости, вам незачем его пополнять!');}
} else {show_error('На вашем счету недостаточно денег для подобной покупки!');}
}

//--------------------------------------------------------------------//
if ($pred==3){
if ($udata[41]>=3000){
if ($udata[59]>=($udata[57]+30)){

change_profil($log, array(41=>$udata[41]-3000, 57=>$udata[57]+30, 62=>SITETIME+3600*3));

echo '<b>Вы успешно улучшили состояние своей выносливости!</b><br />';

} else {show_error('У вас достаточный уровень выносливости, вам незачем его пополнять!');}
} else {show_error('На вашем счету недостаточно денег для подобной покупки!');}
}

//--------------------------------------------------------------------//
if ($pred==4){
if ($udata[41]>=10000){
if ($udata[59]>=($udata[57]+50)){	

change_profil($log, array(41=>$udata[41]-10000, 57=>$udata[57]+50, 62=>SITETIME+3600*3));

echo '<b>Вы успешно улучшили состояние своей выносливости!</b><br />';

} else {show_error('У вас достаточный уровень выносливости, вам незачем его пополнять!');}
} else {show_error('На вашем счету недостаточно денег для подобной покупки!');}
}

$udata = reading_profil($log);

echo 'Уровень вашей выносливости: <b>'.(int)$udata[57].'</b>%<br />';
echo 'Максимальный уровень выносливости: <b>'.(int)$udata[59].'</b>%<br />';
echo'<img src="../gallery/grafic.php?rat='.(int)$udata[57].'&amp;imgs=2&amp;limit='.(int)$udata[59].'" alt="image" /><br />';

} else {show_error('Увеличивать уровень своей выносливости можно не чаще чем раз в 3 часа');}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="stamina.php?'.SID.'">Вернуться</a>';
}
	
} else {echo 'Ошибка! Ваш персонаж игры не включен! Для того чтобы его включить, измените свои настройки<br />';
echo 'Персонаж позволит вам участвовать в разных играх, боях, покупать оружие, прокачивать своего бойца, зарабатывать деньги и многое другое<br />';
echo'<br /><img src="../images/img/panel.gif" alt="image" /> <a href="../pages/setting.php?'.SID.'">Настройки</a>';
}	
	
} else {show_login('Вы не авторизованы, чтобы совершать операции, необходимо');}

echo '<br /><img src="../images/img/games.gif" alt="image" /> <a href="../pages/index.php?action=arkada&amp;'.SID.'">Развлечения</a><br />'; 
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a>'; 

include_once ("../themes/".$config['themes']."/foot.php");
?>