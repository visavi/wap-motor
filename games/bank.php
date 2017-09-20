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

echo '<img src="../images/img/partners.gif" alt="image" /> <b>Банк</b><br /><br />';

if (is_user()){

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if ($action==""){

$string = search_string(DATADIR."bank.dat", $log, 1);
if ($string) {

echo 'В наличии: '.moneys($udata[41]).'<br />';
echo 'В банке: '.moneys($string[2]).'<br /><br />';

if ($string[2]>$config['maxsumbank']){echo '<b><span style="color:#ff0000">Внимание у вас слишком большой вклад</span></b><br />';}

if ($string[2]>0 && $string[2]<$config['maxsumbank']){
if ($string[3]>=SITETIME){

echo 'До получения процентов осталось '.formattime($string[3]-SITETIME).'<br />';

} else {

$stavka=12;
if ($string[2]>=100000){$stavka=6;}
if ($string[2]>=250000){$stavka=3;}
if ($string[2]>=500000){$stavka=2;}
if ($string[2]>=1000000){$stavka=1;}

$percent = round((($string[2]*$stavka)/100));

$text = no_br('|'.$log.'|'.($percent + $string[2]).'|'.(SITETIME + 43200).'|');

replace_lines(DATADIR."bank.dat", $string['line'], $text);

echo '<b>Продление счета успешно завершено, получено c процентов: '.moneys($percent).'</b><br />';
}}

} else {
echo 'Вы новый клиент нашего банка. Мы рады, что вы доверяеете нам свои деньги<br />';
echo 'Сейчас ваш счет не открыт, достаточно вложить '.moneys(10).', чтобы получать проценты с вклада<br />';
}


echo '<br /><b>Операция:</b><br />';

echo '<form action="bank.php?action=operacia" method="post">';
echo '<input name="gold" /><br />';
echo '<select name="oper">';
echo '<option value="2">Положить на счет</option><option value="1">Снять со счета</option>';
echo '</select><br /><br />';
echo '<input type="submit" value="Продолжить" /></form><hr />';

echo 'Минимальная сумма вклада или остатка счета: '.moneys(10).'<br />';
echo 'Максимальная сумма вклада: '.moneys($config['maxsumbank']).'<br /><br />';
echo 'Процентная ставка зависит от суммы вклада<br />';
echo 'Вклад до 100тыс. - ставка 12%<br />';
echo 'Вклад более 100тыс. - ставка 6%<br />';
echo 'Вклад более 250тыс. - ставка 3%<br />';
echo 'Вклад более 500тыс. - ставка 2%<br />';
echo 'Вклад более 1млн. - ставка 1%<br /><br />';

echo 'Всего вкладчиков: <b>'.counter_string(DATADIR."bank.dat").'</b><br />';
}


############################################################################################
##                                        Операции                                        ##
############################################################################################
if ($action=="operacia"){

$gold = (int)$_POST['gold'];
$oper = (int)$_POST['oper'];

//----------------------- Снятие со счета ----------------------------//
if ($oper==1){

echo '<b>Снятие со счета</b><br />';

if ($gold>=10){

$string = search_string(DATADIR."bank.dat", $log, 1);
if ($string) {

if ($gold<=($string[2]-10)){

change_profil($log, array(41=>$udata[41]+$gold));

$text = no_br('|'.$log.'|'.($string[2] - $gold).'|'.(SITETIME + 43200).'|');

replace_lines(DATADIR."bank.dat", $string['line'], $text);

echo 'Сумма в размере <b>'.moneys($gold).'</b> успешно списана с вашего счета<br />';

} else {show_error('Ошибка! Вы не можете снять деньги, минимальный остаток не менее '.moneys(10).'!');}
} else {show_error('Ошибка! Вы не можете снять деньги, у вас не открыт счет!');}
} else {show_error('Ошибка! Операции менее чем с '.moneys(10).' не проводятся!');}

}

//-------------------------- Пополение счета --------------------------------//
if ($oper==2){

echo '<b>Пополнение счета</b><br />';

if ($gold>=10){
if ($gold<=$udata[41]){

change_profil($log, array(41=>$udata[41]-$gold));

$string = search_string(DATADIR."bank.dat", $log, 1);
if ($string) {

$text = no_br('|'.$log.'|'.($string[2] + $gold).'|'.(SITETIME + 43200).'|');
replace_lines(DATADIR."bank.dat", $string['line'], $text);

} else {
$text = no_br('|'.$log.'|'.$gold.'|'.(SITETIME + 43200).'|');
write_files(DATADIR."bank.dat", "$text\r\n");
}


echo 'Сумма в размере <b>'.moneys($gold).'</b> успешно зачислена на ваш счет<br />';
echo 'Получить проценты с вклада вы сможете не ранее чем через 12 часов<br />';


} else {show_error('Недостаточное количество денег, у вас нет данной суммы на руках');}
} else {show_error('Операции менее чем с '.moneys(10).' не проводятся');}
}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="bank.php">Вернуться</a>';
}

} else {show_login('Вы не авторизованы, чтобы совершать операции, необходимо');}

echo '<br /><img src="../images/img/stat.gif" alt="image" /> <a href="../games/livebank.php">Статистика вкладов</a><br />';
echo '<img src="../images/img/many.gif" alt="image" /> <a href="../games/kredit.php">Выдача кредитов</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>
