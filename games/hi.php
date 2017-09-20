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

echo '<img src="../images/img/partners.gif" alt="image" /> <b>Угадай число</b><br /><br />';

if (is_user()){

$lownumber = 1;         // Минимальное случайное число
$highnumber = 100;      // Максимальое случайное число

if(isset($_GET['newgame'])){
$_SESSION['hill'] = mt_rand($lownumber, $highnumber);
$_SESSION['hi_count'] = 0;
}

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if($action==""){

echo '<b>Введите число от '.(int)$lownumber.' до '.(int)$highnumber.'</b><br /><br />';
echo '<b>Попыток: 0</b><br />';

echo '<div class="form" id="form"><form action="hi.php?action=hi" method="post">';
echo 'Ведите число:<br />';
echo '<input type="text" name="guess" /><br />';
echo '<input type="submit" value="Угадать" />';
echo '</form></div>';

echo'У вас в наличии: '.moneys($udata[41]).'<br />';
echo'<br /><img src="../images/img/faq.gif" alt="image" /> <a href="hi.php?action=faq">Правила</a>';
}

############################################################################################
##                                          Игра                                          ##
############################################################################################
if ($action=="hi"){

$guess = (int)$_POST['guess'];

if ($udata[41]>=5){
if ($guess>=$lownumber && $guess<=$highnumber){

if (empty($_SESSION['hill'])){
$_SESSION['hill'] = mt_rand($lownumber, $highnumber);
$_SESSION['hi_count'] = 0;
}

$_SESSION['hi_count']++;

if ($guess!=$_SESSION['hill']){
if ($_SESSION['hi_count']<$config['hipopytka']){

echo'<b>Введите число от '.(int)$lownumber.' до '.(int)$highnumber.'</b><br /><br />';

echo '<b>Попыток: '.(int)$_SESSION['hi_count'].'</b><br />';


if ($guess>$_SESSION['hill']){echo (int)$guess.' — это большое число<br />Введите меньше<br /><br />';}
if ($guess<$_SESSION['hill']){echo (int)$guess.' — это маленькое число<br />Введите больше<br /><br />';}

echo '<div class="form" id="form"><form action="hi.php?action=hi" method="post">';
echo 'Ведите число:<br />';
echo '<input type="text" name="guess" /><br />';
echo '<input type="submit" value="Угадать" />';
echo '</form></div>';

change_profil($log, array(41=>$udata[41]-5));

$count_pop = $config['hipopytka'] - $_SESSION['hi_count'];

echo 'Осталось попыток: <b>'.(int)$count_pop.'</b><br />';
echo 'У вас в наличии: '.moneys($udata[41]).'<br />';
/////////////////////////

} else {echo 'Вы проигали потому что, не отгадали число за '.(int)$config['hipopytka'].' попыток<br />';

$_SESSION['hill']="";
$_SESSION['hi_count']="";

unset($_SESSION['hill']);
unset($_SESSION['hi_count']);
}

} else {

change_profil($log, array(41=>$udata[41]+$config['hisumma']));

echo '<b>Поздравляем!!! Вы угадали число '.(int)$guess.'</b><br />';
echo 'Ваш выигрыш составил '.moneys($config['hisumma']).'<br />';

$_SESSION['hill']="";
$_SESSION['hi_count']="";

unset($_SESSION['hill']);
unset($_SESSION['hi_count']);

}
} else {show_error('Ошибка! Необходимо ввести число в пределах разрешенного диапазона!');}
} else {show_error('Вы не можете играть, т.к. на вашем счету недостаточно средств!');}

echo '<br /><img src="../images/img/reload.gif" alt="image" /> <a href="hi.php?newgame">Начать заново</a>';
}

############################################################################################
##                                    Правила игры                                        ##
############################################################################################
if ($action=="faq"){

echo 'Для участия в игре напишите число и нажмите "Угадать", за каждую попытку у вас будут списывать по '.moneys(5).'<br />';
echo 'После каждой попытки вам дают подсказку большое это число или маленькое<br />';
echo 'Если вы не уложились за '.(int)$config['hipopytka'].' попыток, то игра будет начата заново<br />';
echo 'При выигрыше вы получаете на счет '.moneys($config['hisumma']).'<br />';
echo 'Итак дерзайте!<br /><br />';

echo '<img src="../images/img/back.gif" alt="image" /> <a href="hi.php">Вернуться</a>';
}

} else {show_login('Вы не авторизованы, чтобы начать игру, необходимо');}

echo '<br /><img src="../images/img/games.gif" alt="image" /> <a href="../pages/index.php?action=arkada">Развлечения</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>
