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
require_once ("../includes/start.php");
require_once ("../includes/functions.php");
require_once ("../includes/header.php");
include_once ("../themes/".$config['themes']."/index.php");

if (isset($_GET['action'])) {$action = check($_GET['action']);} else {$action = "";}

show_title('partners.gif', 'Бандит');

if (is_user()){

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if ($action==""){

echo 'Любишь азарт? А выигрывая, чувствуешь адреналин? Играй и получай призы<br /><br />';

echo '.<img src="../images/bandit/1.gif" alt="image" /> <img src="../images/bandit/2.gif" alt="image" /> <img src="../images/bandit/3.gif" alt="image" />.<br />';
echo '.<img src="../images/bandit/7.gif" alt="image" /> <img src="../images/bandit/7.gif" alt="image" /> <img src="../images/bandit/7.gif" alt="image" />.<br />';
echo '.<img src="../images/bandit/4.gif" alt="image" /> <img src="../images/bandit/5.gif" alt="image" /> <img src="../images/bandit/6.gif" alt="image" />.<br />';

echo '<br /><b><a href="bandit.php?action=go">Играть</a></b><br />';

echo 'В наличии '.moneys($udata[41]).'<br /><br />';

echo '<img src="../images/img/faq.gif" alt="image" /> <a href="bandit.php?action=faq">Правила игры</a><br />';
}


############################################################################################
##                                           Игра                                         ##
############################################################################################
if ($action=="go"){
if ($udata[41]>=5){

sleep(1);

$num1 = mt_rand(1, 8);
$num2 = mt_rand(1, 8);
$num3 = mt_rand(1, 8);
$num4 = mt_rand(1, 8);

$num_arr = array(1,1,2,2,3,3,4,4,5,5,6,6,7,8,8);
$num5 = $num_arr[array_rand($num_arr)];

$num6 = mt_rand(1, 8);
$num7 = mt_rand(1, 8);
$num8 = mt_rand(1, 8);
$num9 = mt_rand(1, 8);

$rand = mt_rand(100, 999);

echo '.<img src="../images/bandit/'.$num1.'.gif" alt="image" /> <img src="../images/bandit/'.$num2.'.gif" alt="image" /> <img src="../images/bandit/'.$num3.'.gif" alt="image" />.<br />';
echo '.<img src="../images/bandit/'.$num4.'.gif" alt="image" /> <img src="../images/bandit/'.$num5.'.gif" alt="image" /> <img src="../images/bandit/'.$num6.'.gif" alt="image" />.<br />';
echo '.<img src="../images/bandit/'.$num7.'.gif" alt="image" /> <img src="../images/bandit/'.$num8.'.gif" alt="image" /> <img src="../images/bandit/'.$num9.'.gif" alt="image" />.<br /><br />';

//------------------------------- линии -----------------------------------//
$sum = 0;

if ($num1 == 1 && $num2 == $num1 && $num3 == $num1) {echo 'Вишенки - вехний ряд<br />'; $sum+="5";}
if ($num4 == 1 && $num5 == $num4 && $num6 == $num4) {echo 'Вишенки - средний ряд<br />'; $sum+="10";}
if ($num7 == 1 && $num8 == $num7 && $num9 == $num7) {echo 'Вишенки - нижний ряд<br />';  $sum+="5";}

if ($num1 == 2 && $num2 == $num1 && $num3 == $num1) {echo 'Апельсины - вехний ряд<br />'; $sum+="10";}
if ($num4 == 2 && $num5 == $num4 && $num6 == $num4) {echo 'Апельсины - средний ряд<br />'; $sum+="15";}
if ($num7 == 2 && $num8 == $num7 && $num9 == $num7) {echo 'Апельсины - нижний ряд<br />'; $sum+="10";}

if ($num1 == 3 && $num2 == $num1 && $num3 == $num1) {echo 'Виноград - вехний ряд<br />'; $sum+="15";}
if ($num4 == 3 && $num5 == $num4 && $num6 == $num4) {echo 'Виноград - средний ряд<br />'; $sum+="25";}
if ($num7 == 3 && $num8 == $num7 && $num9 == $num7) {echo 'Виноград - нижний ряд<br />'; $sum+="15";}

if ($num1 == 4 && $num2 == $num1 && $num3 == $num1) {echo 'Бананы - вехний ряд<br />'; $sum+="25";}
if ($num4 == 4 && $num5 == $num4 && $num6 == $num4) {echo 'Бананы - средний ряд<br />'; $sum+="35";}
if ($num7 == 4 && $num8 == $num7 && $num9 == $num7) {echo 'Бананы - нижний ряд<br />'; $sum+="25";}

if ($num1 == 5 && $num2 == $num1 && $num3 == $num1) {echo 'Яблоки - вехний ряд<br />'; $sum+="30";}
if ($num4 == 5 && $num5 == $num4 && $num6 == $num4) {echo 'Яблоки - средний ряд<br />'; $sum+="50";}
if ($num7 == 5 && $num8 == $num7 && $num9 == $num7) {echo 'Яблоки - нижний ряд<br />'; $sum+="30";}

if ($num1 == 6 && $num2 == $num1 && $num3 == $num1) {echo 'BAR - вехний ряд<br />'; $sum+="50";}
if ($num4 == 6 && $num5 == $num4 && $num6 == $num4) {echo 'BAR - средний ряд<br />'; $sum+="70";}
if ($num7 == 6 && $num8 == $num7 && $num9 == $num7) {echo 'BAR - нижний ряд<br />'; $sum+="55";}

if ($num1 == 7 && $num2 == $num1 && $num3 == $num1) {echo '777 - вехний ряд<br />'; $sum+="177";}
if ($num4 == 7 && $num5 == $num4 && $num6 == $num4) {echo '777 - средний ряд<br />'; $sum+="777";}
if ($num7 == 7 && $num8 == $num7 && $num9 == $num7) {echo '777 - нижний ряд<br />'; $sum+="177";}

if ($num1 == 8 && $num2 == $num1 && $num3 == $num1) {echo '$$$ - вехний ряд<br />'; $sum+="60";}
if ($num4 == 8 && $num5 == $num4 && $num6 == $num4) {echo '$$$ - средний ряд<br />'; $sum+="100";}
if ($num7 == 8 && $num8 == $num7 && $num9 == $num7) {echo '$$$ - нижний ряд<br />'; $sum+="60";}

//--------------------------------------- столбцы --------------------------------------//

if ($num1 == 1 && $num4 == $num1 && $num7 == $num1) {echo 'Вишенки - левый столбец<br />';  $sum+="5";}
if ($num2 == 1 && $num5 == $num2 && $num8 == $num2) {echo 'Вишенки - средний столбец<br />';  $sum+="10";}
if ($num3 == 1 && $num6 == $num3 && $num9 == $num3) {echo 'Вишенки - правый столбец<br />';  $sum+="5";}

if ($num1 == 2 && $num4 == $num1 && $num7 == $num1) {echo 'Апельсины - левый столбец<br />'; $sum+="10";}
if ($num2 == 2 && $num5 == $num2 && $num8 == $num2) {echo 'Апельсины - средний столбец<br />'; $sum+="15";}
if ($num3 == 2 && $num6 == $num3 && $num9 == $num3) {echo 'Апельсины - правый столбец<br />'; $sum+="10";}

if ($num1 == 3 && $num4 == $num1 && $num7 == $num1) {echo 'Виноград - левый столбец<br />'; $sum+="15";}
if ($num2 == 3 && $num5 == $num2 && $num8 == $num2) {echo 'Виноград - средний столбец<br />'; $sum+="25";}
if ($num3 == 3 && $num6 == $num3 && $num9 == $num3) {echo 'Виноград - правый столбец<br />'; $sum+="15";}

if ($num1 == 4 && $num4 == $num1 && $num7 == $num1) {echo 'Бананы - левый столбец<br />'; $sum+="25";}
if ($num2 == 4 && $num5 == $num2 && $num8 == $num2) {echo 'Бананы - средний столбец<br />'; $sum+="40";}
if ($num3 == 4 && $num6 == $num3 && $num9 == $num3) {echo 'Бананы - правый столбец<br />'; $sum+="25";}

if ($num1 == 5 && $num4 == $num1 && $num7 == $num1) {echo 'Яблоки - левый столбец<br />'; $sum+="40";}
if ($num2 == 5 && $num5 == $num2 && $num8 == $num2) {echo 'Яблоки - средний столбец<br />'; $sum+="75";}
if ($num3 == 5 && $num6 == $num3 && $num9 == $num3) {echo 'Яблоки - правый столбец<br />'; $sum+="40";}

if ($num1 == 6 && $num4 == $num1 && $num7 == $num1) {echo 'BAR - левый столбец<br />'; $sum+="75";}
if ($num2 == 6 && $num5 == $num2 && $num8 == $num2) {echo 'BAR - средний столбец<br />'; $sum+="100";}
if ($num3 == 6 && $num6 == $num3 && $num9 == $num3) {echo 'BAR - правый столбец<br />'; $sum+="75";}

if ($num1 == 7 && $num4 == $num1 && $num7 == $num1) {echo '777 - левый столбец<br />'; $sum+="100";}
if ($num2 == 7 && $num5 == $num2 && $num8 == $num2) {echo '777 - средний столбец<br />'; $sum+="177";}
if ($num3 == 7 && $num6 == $num3 && $num9 == $num3) {echo '777 - правый столбец<br />'; $sum+="100";}

if ($num1 == 8 && $num4 == $num1 && $num7 == $num1) {echo '$$$ - левый столбец<br />'; $sum+="60";}
if ($num2 == 8 && $num5 == $num2 && $num8 == $num2) {echo '$$$ - средний столбец<br />'; $sum+="100";}
if ($num3 == 8 && $num6 == $num3 && $num9 == $num3) {echo '$$$ - правый столбец<br />'; $sum+="60";}

//------------------------------ диагональ -----------------------------------//

if ($num1 == 1 && $num5 == $num1 && $num9 == $num1) {echo 'Вишенки - по диагонали<br />';  $sum+="5";}
if ($num3 == 1 && $num5 == $num3 && $num7 == $num3) {echo 'Вишенки - по диагонали<br />';  $sum+="5";}

if ($num1 == 2 && $num5 == $num1 && $num9 == $num1) {echo 'Апельсины - по диагонали<br />';  $sum+="10";}
if ($num3 == 2 && $num5 == $num3 && $num7 == $num3) {echo 'Апельсины - по диагонали<br />';  $sum+="10";}

if ($num1 == 3 && $num5 == $num1 && $num9 == $num1) {echo 'Виноград - по диагонали<br />';  $sum+="15";}
if ($num3 == 3 && $num5 == $num3 && $num7 == $num3) {echo 'Виноград - по диагонали<br />';  $sum+="15";}

if ($num1 == 4 && $num5 == $num1 && $num9 == $num1) {echo 'Бананы - по диагонали<br />';  $sum+="25";}
if ($num3 == 4 && $num5 == $num3 && $num7 == $num3) {echo 'Бананы - по диагонали<br />';  $sum+="25";}

if ($num1 == 5 && $num5 == $num1 && $num9 == $num1) {echo 'Яблоки - по диагонали<br />';  $sum+="50";}
if ($num3 == 5 && $num5 == $num3 && $num7 == $num3) {echo 'Яблоки - по диагонали<br />';  $sum+="50";}

if ($num1 == 6 && $num5 == $num1 && $num9 == $num1) {echo 'BAR - по диагонали<br />';  $sum+="100";}
if ($num3 == 6 && $num5 == $num3 && $num7 == $num3) {echo 'BAR - по диагонали<br />';  $sum+="100";}

if ($num1 == 7 && $num5 == $num1 && $num9 == $num1) {echo '777 - по диагонали<br />';  $sum+="250";}
if ($num3 == 7 && $num5 == $num3 && $num7 == $num3) {echo '777 - по диагонали<br />';  $sum+="250";}

if ($num1 == 8 && $num5 == $num1 && $num9 == $num1) {echo '$$$ - по диагонали<br />';  $sum+="150";}
if ($num3 == 8 && $num5 == $num3 && $num7 == $num3) {echo '$$$ - по диагонали<br />';  $sum+="150";}

change_profil($log, array(41=>$udata[41]-5));

if ($sum>0){
echo 'Ваш выигрыш составил: <b>'.(int)$sum.'</b><br /><br />';

change_profil($log, array(41=>$udata[41]+$sum));
}

echo '<b><a href="bandit.php?action=go&amp;rand='.$rand.'">Играть</a></b><br />';

} else {show_error('Вы не можете играть т.к. на вашем счету недостаточно средств');}

$udata = reading_profil($log);

echo 'В наличии '.moneys($udata[41]).'<br /><br />';

echo '<img src="../images/img/faq.gif" alt="image" /> <a href="bandit.php?action=faq">Правила игры</a><br />';
}


//---------------------------- Правила -----------------------------------//
if ($action=="faq"){

echo 'Правила предельно просты. Нажимайте на кнопку Играть и выигрывайте деньги.<br />';
echo 'За каждое нажатие у вас со счета списывают '.moneys(5).'<br />';
echo 'Если у вам повезет и вы выиграете деньги, то то они сразу же будут перечислены вам на счет<br /><br />';
echo 'Комбинации картинок считаются по вертикали, горизонтали и даже по диагонали<br /><br />';
echo 'Список выигрышных комбинаций:<br />';

echo '<img src="../images/bandit/1.gif" alt="image" /> * 3 вишенки = '.moneys(10).' средний ряд/столбец  (5 - нижний или верхний ряд/столбец)<br />';
echo '<img src="../images/bandit/2.gif" alt="image" /> * 3 апельсина = '.moneys(15).' средний ряд/столбец  (10 - нижний или верхний ряд/столбец)<br />';
echo '<img src="../images/bandit/3.gif" alt="image" /> * 3 винограда = '.moneys(25).' средний ряд/столбец  (15 - нижний или верхний ряд/столбец)<br />';
echo '<img src="../images/bandit/4.gif" alt="image" /> * 3 Банана = '.moneys(35).' средний ряд/столбец  (25 - нижний или верхний ряд/столбец)<br />';
echo '<img src="../images/bandit/5.gif" alt="image" /> * 3 Яблока = '.moneys(50).' средний ряд/столбец  (30 - нижний или верхний ряд/столбец)<br />';
echo '<img src="../images/bandit/6.gif" alt="image" /> * 3 BAR = '.moneys(100).' по диагонали<br />';
echo '<img src="../images/bandit/6.gif" alt="image" /> * 3 BAR = '.moneys(70).' средний ряд/столбец  (50 - нижний или верхний ряд/столбец)<br />';
echo '<img src="../images/bandit/8.gif" alt="image" /> * 3 $$$ = '.moneys(100).' средний ряд/столбец  (60 - нижний или верхний ряд/столбец)<br />';
echo '<img src="../images/bandit/8.gif" alt="image" /> * 3 $$$ = '.moneys(150).' по диагонали<br />';
echo '<img src="../images/bandit/7.gif" alt="image" /> * 3 777 = '.moneys(177).' средний столбец  (100 - правый или левый столбец)<br />';
echo '<img src="../images/bandit/7.gif" alt="image" /> * 3 777 = '.moneys(250).' по диагонали<br />';
echo '<img src="../images/bandit/7.gif" alt="image" /> * 3 777 = '.moneys(777).' средний ряд  (177 - нижний или верхний ряд)<br />';


echo '<br /><img src="../images/img/games.gif" alt="image" /> <a href="bandit.php">В игру</a><br />';
}

} else {show_login('Вы не авторизованы, чтобы начать игру, необходимо');}

echo '<img src="../images/img/games.gif" alt="image" /> <a href="../pages/index.php?action=arkada">Развлечения</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>
