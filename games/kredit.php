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

if (isset($_GET['action'])) {$action = check($_GET['action']);} else {$action = "";}

echo '<img src="../images/img/partners.gif" alt="image" /> <b>Выдача кредитов</b><br /><br />';

if (is_user()){

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if ($action==""){

echo 'В наличии: '.moneys($udata[41]).'<br />';
echo 'В банке: '.moneys(user_bankmany($log)).'<br />';


//--------------------- Вычисление если долг ---------------------------//
if ($udata[53]!="" && $udata[54]>0){
echo '<br /><b><span style="color:#ff0000">Сумма долга составляет: '.moneys($udata[54]).'</span></b><br />';

if (SITETIME<$udata[53]){

echo 'До истечения срока кредита осталось <b>'.formattime($udata[53]-SITETIME).'</b><br />';

} else {

echo '<b><span style="color:#ff0000">Внимание! Время погашения кредита просрочено!</span></b><br />';
echo 'Начислен штраф в сумме 1%, у вас списано 10 баллов активности, и 1 балл авторитета<br />'; 

change_profil($log, array(36=>$udata[36]-10, 49=>$udata[49]-1, 51=>$udata[51]+1, 53=>SITETIME+86400, 54=>$udata[54]+round($udata[54]/100)));
}}

echo '<br /><b>Операция:</b>';

echo '<br /><form action="kredit.php?action=operacia&amp;'.SID.'" method="post"><input name="gold" /><br />';
echo '<select name="oper">';
echo '<option value="1">Взять кредит</option><option value="2">Погасить кредит</option>';
echo '</select><br /><br />';
echo '<input type="submit" value="Продолжить" /></form><hr />';

echo'Минимальная сумма кредита '.moneys($config['minkredit']).'<br />';
echo'Максимальная сумма кредита равна '.moneys($config['maxkredit']).'<br /><br />';

echo '<b>Условия кредита</b><br />Независимо от суммы кредита банк берет '.(int)$config['percentkredit'].'% за операцию, кредит выдается на 3 дня<br />';
echo 'Каждый просроченный день увеличивает сумму на 1% плюс у вас списывается 10 баллов активности и 1 балл авторитета<br />';
echo 'Кредит выдается пользователям у которых не менее 150 баллов в активе<br />';
}


############################################################################################
##                                     Операции                                           ##
############################################################################################
if ($action=="operacia"){

$gold = (int)$_POST['gold'];
$oper = (int)$_POST['oper'];

if ($oper==1 || $oper==2){
if ($gold>=$config['minkredit']){

//-------------------------- Выдача кредитов -----------------------------//
if ($oper=="1"){
echo '<b>Получение кредита</b><br />';

if ($gold<=$config['maxkredit']){
if ($udata[36]>=150){
if (empty($udata[53]) && empty($udata[54])){	
	
change_profil($log, array(41=>$udata[41]+$gold, 53=>SITETIME+259200, 54=>round((($gold*$config['percentkredit'])/100)+$gold)));

$udata = reading_profil($log);

echo 'Cредства успешно перечислены вам в карман!<br />';
echo 'Количество денег на руках: <b>'.moneys($udata[41]).'</b><br />';

} else {show_error('Ошибка, вы не сможете получить кредит, возможно за вами еще числится долг!');}
} else {show_error('Ошибка, ваш статус не позволяет вам получать кредит!');}
} else {show_error('Операции более чем с '.moneys($config['maxkredit']).' не проводятся!');}
}

//-------------------------- Погашение кредитов -----------------------------//
if ($oper=="2"){
echo '<b>Погашение кредита</b><br />';

if ($udata[54]>0){
if ($udata[54]==$gold){	
if ($gold<=$udata[41]){	

change_profil($log, array(41=>$udata[41]-$gold, 53=>0, 54=>0));

$udata = reading_profil($log);

echo 'Поздравляем! Кредит успешно погашен, благодорим за сотрудничество!<br />';
echo 'Остаток денег на руках: <b>'.moneys($udata[41]).'</b><br />';

} else {show_error('Ошибка! у вас нехватает денег для погашения кредита!');}
} else {show_error('Ошибка! Необходимо внести точную сумму вашей задолженности!');}
} else {show_error('Ошибка! У вас нет задолженности перед банком, погашать кредит не нужно!');}
}

} else {show_error('Операции менее чем с '.moneys($config['minkredit']).' не проводятся!');}
} else {show_error('Ошибка! Не выбрана операция!');}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="kredit.php?'.SID.'">Вернуться</a>';
}
	
} else {show_login('Вы не авторизованы, чтобы совершать операции, необходимо');}

echo '<br /><img src="../images/img/many.gif" alt="image" /> <a href="../games/bank.php?'.SID.'">Банк</a><br />';
echo '<img src="../images/img/games.gif" alt="image" /> <a href="../pages/index.php?action=arkada&amp;'.SID.'">Развлечения</a><br />'; 
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a>'; 

include_once ("../themes/".$config['themes']."/foot.php");
?>