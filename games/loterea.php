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

$config['randloterea'] = mt_rand(1,100);
$newtime = date("d",SITETIME);

if (isset($_GET['action'])) {$action = check($_GET['action']);} else {$action = "";}

echo '<img src="../images/img/partners.gif" alt="image" /> <b>Лотерея</b><br /><br />';

if (is_user()){

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if($action==""){

$ulot = read_string(DATADIR."loterea.dat", 0);

if ($newtime!=$ulot[1] || empty($ulot[2])){

$lots = array();
$flot = file(DATADIR."loterea.dat");
$count = count($flot);

for ($b=1; $b<$count; $b++) {
$dt = explode("|",$flot[$b]);
if ($dt[2]==$ulot[4]) {$lots[]=$dt[1];}
}

$wincount = count($lots);

//----------------------------- Награждение ------------------------------//
if ($wincount>0){

$allmoneys = round($ulot[2]/$wincount);

foreach ($lots as $uz){
if (file_exists(DATADIR."profil/$uz.prof")){

$uzdata = reading_profil($uz);
change_profil($uz, array(10=>$uzdata[10]+1, 41=>$uzdata[41]+$allmoneys));

$textpriv = no_br($config['nickname'].'|Поздравляем! Вы сорвали Джек-пот в лотерее и выиграли '.moneys($allmoneys).'|'.SITETIME.'|');
write_files(DATADIR.'privat/'.$uz.'.priv', "$textpriv\r\n");
}}

$winlot = implode(',',$lots);

} else {
$winlot = 'Джек-пот не выиграл никто!';
}

if ($wincount==0 && $ulot[2]>0){
$dpotsumm = $ulot[2];
} else {
$dpotsumm = (int)$config['jackpot'];
}

$text = no_br('|'.$newtime.'|'.$dpotsumm.'|'.$ulot[4].'|'.$config['randloterea'].'|'.$winlot.'|');

write_files(DATADIR."loterea.dat", "$text\r\n", 1);

}

$filelot = file(DATADIR."loterea.dat");
$ulot = explode("|",$filelot[0]);
$total = count($filelot)-1;

echo 'Участвуй в лотерее! С каждым разом джек-пот растет<br />';
echo 'Стань счастливым обладателем заветной суммы<br /><br />';

echo 'Джек-пот составляет <b><span style="color:#ff0000">'.moneys($ulot[2]).'</span></b><br />';


if ($ulot[3]!=""){
echo '<br />Выигрышное число прошлого тура: <b>'.(int)$ulot[3].'</b><br />';
echo 'Победители: '.$ulot[5].'<br />';
}

echo '<br />Введите число от 1 до 100 включительно';

echo '<br /><form action="loterea.php?action=bilet" method="post">';
echo '<input name="bilet" /><br />';
echo '<input type="submit" value="Купить билет" /></form>';

echo '<hr />В этом туре участвуют: '.(int)$total.'<br />';
echo 'Cтоимость билета '.moneys(50).'<br />';
echo 'В наличии: '.moneys($udata[41]).'<br />';

echo '<br /><img src="../images/img/chat.gif" alt="image" /> <a href="loterea.php?action=show">Участники</a><br />';
}

############################################################################################
##                                    Покупка билета                                      ##
############################################################################################
if ($action=="bilet"){

$bilet = (int)$_POST['bilet'];

if ($bilet>0 && $bilet<=100){
if ($udata[41]>=50){

$string = search_string(DATADIR."loterea.dat", $log, 1);
if (empty($string)){

$ulot = read_string(DATADIR."loterea.dat", 0);

$textlot = no_br('|'.$ulot[1].'|'.($ulot[2]+50).'|'.$ulot[3].'|'.$ulot[4].'|'.$ulot[5].'|');
replace_lines(DATADIR."loterea.dat", 0, $textlot);

$text = no_br('|'.$log.'|'.$bilet.'|');
write_files(DATADIR."loterea.dat", "$text\r\n");

change_profil($log, array(41=>$udata[41]-50));

echo '<b>Билет успешно приобретен!</b><br />';
echo 'Результат розыгрыша станет известным после полуночи!<br />';

} else {show_error('Вы уже купили билет! Нельзя покупать дважды!');}
} else {show_error('Вы не можете купить билет, т.к. на вашем счету недостаточно средств!');}
} else {show_error('Неверный ввод данных! Введите число от 1 до 100 включительно!');}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="loterea.php">Вернуться</a><br />';
echo '<img src="../images/img/chat.gif" alt="image" /> <a href="loterea.php?action=show">Участники</a><br />';
}

############################################################################################
##                                   Просмотр участников                                  ##
############################################################################################
if ($action=="show"){
echo 'Список участников купивших билеты<br /><br />';

$lotfiles = file(DATADIR."loterea.dat");
$total = count($lotfiles);

if ($total>1){

for ($i=1;$i<$total;$i++){
$user_dats = explode("|",$lotfiles[$i]);

echo $i.'. <img src="../images/img/chel.gif" alt="image" /> ';
echo '<b><a href="../pages/anketa.php?uz='.$user_dats[1].'">'.nickname($user_dats[1]).'</a></b> ';
echo '(Ставка: '.$user_dats[2].')<br />';
}

} else {show_error('Еще нет ни одного участника!');}

echo '<br />Всего участников: <b>'.(int)($total-1).'</b><br />';
echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="loterea.php">Вернуться</a><br />';
}

} else {show_login('Вы не авторизованы, чтобы учавствовать в лотерее, необходимо');}

echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>
