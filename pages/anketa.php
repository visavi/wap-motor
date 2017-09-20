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

if (isset($_GET['uz']) && $_GET['uz']!=""){$uz=check($_GET['uz']);} else {$uz=check($log);}
if (isset($_GET['menu'])){$menu=(int)$_GET['menu'];} else {$menu="";}

echo '<div class="b"><img src="../images/img/partners.gif" alt="image" /> <b>Анкета '.nickname($uz).' </b> '.user_title($uz).user_visit($uz).'</div><br />';

if (preg_match('|^[a-z0-9\-]+$|i',$uz)){
if (file_exists(DATADIR."profil/$uz.prof")){
$text = file_get_contents(DATADIR."profil/$uz.prof");
$uzdata = explode(":||:",$text);

if ($uzdata[46]==1) {echo '<b><span style="color:#ff0000">Внимание, аккаунт требует подтверждение регистрации!</span></b><br />';}

if ($uzdata[37]==1 && $uzdata[38]>SITETIME) {echo '<b><span style="color:#ff0000">Внимание, юзер находится в бане!</span></b><br />';

echo 'До окончания бана осталось '.formattime($uzdata[38]-SITETIME).'<br />';
echo 'Причина: '.$uzdata[39].'<br />';}

echo 'Аватар: '.user_avatars($uz).'<br />';

if($uzdata[72]!=="" && file_exists(DATADIR."datagallery/$uzdata[72]")){
echo 'Фото: <a href="../gallery/index.php?action=showimg&amp;gid='.$uzdata[72].'">';
echo '<img src="../gallery/resize.php?name='.$uzdata[72].'" alt="image" /></a><br />';
}

echo 'Находится: '.user_visit($uz,1).'<br />';

if ($uzdata[40]==""){echo 'Cтатус: <span style="color:#ff0000"><b>'.user_ststuses($uzdata[36]).'</b></span><br />';
} else {echo 'Cтатус: <span style="color:#ff0000"><b>'.$uzdata[40].'</b></span><br />';}

echo 'Пол: ';
if($uzdata[15]=="N"){echo 'Не указан<br />';}
elseif($uzdata[15]=="M"){echo 'Мужской <br />';} else {echo 'Женский<br />';}

if ($uzdata[65]!="") {echo 'Логин: <b>'.$uzdata[0].'</b><br />';}
if ($uzdata[29]!="") {echo 'Имя: <b>'.$uzdata[29].'<br /></b>';}
if ($uzdata[2]!="") {echo 'Откуда: '.$uzdata[2].'<br />';}
if ($uzdata[3]!="") {echo 'О себе: '.$uzdata[3].' <br />';}
if ($uzdata[18]!=""){echo 'Дата рождения: '.$uzdata[18].'<br />';}
if ($uzdata[16]!="") {echo 'Рост: '.(int)$uzdata[16].' см.<br />';}
if ($uzdata[17]!="") {echo 'Вес: '.(int)$uzdata[17].' кг.<br />';}
if ($uzdata[19]!="") {echo '<img src="http://web.icq.com/whitepages/online?icq='.(int)$uzdata[19].'&amp;img=5" alt="image" /> ICQ: '.(int)$uzdata[19].' <br />';}

echo 'Всего посeщений: '.(int)$uzdata[11].'<br />';
echo 'Сообщений на форуме: '.(int)$uzdata[8].'<br />';
echo 'Сообщений в гостевой: '.(int)$uzdata[9].'<br />';
echo 'Сообщений в чате: '.(int)$uzdata[12].'<br />';
echo 'Комментариев: '.(int)$uzdata[33].'<br />';
echo 'Баллов: '.(int)$uzdata[36].' <br />';
echo 'Число нарушений: '.(int)$uzdata[64].' <br />';
echo 'Авторитет: '.(int)$uzdata[49].' (+'.(int)$uzdata[50].'/-'.(int)$uzdata[51].')<br />';

if (is_user()){
if ($log!=$uz){
echo '[ <a href="raiting.php?uz='.$uz.'&amp;action=plus&amp;uid='.$_SESSION['token'].'"><img src="../images/img/plus.gif" alt="image" /><span style="color:#0099cc"> Плюс</span></a> / ';
echo '<a href="raiting.php?uz='.$uz.'&amp;action=minus&amp;uid='.$_SESSION['token'].'"><span style="color:#ff0000">Минус</span> <img src="../images/img/minus.gif" alt="image" /></a> ]<br />';
}}

echo 'Всего денег: '.moneys(user_bankmany($uz)+$uzdata[41]).' <br />';
echo 'На руках: '.moneys($uzdata[41]).' <br />';
echo 'В банке: '.moneys(user_bankmany($uz)).' <br />';
if ($uzdata[54]>0){echo 'Задолженность по кредиту: '.moneys($uzdata[54]).' <br />';}

if ($uzdata[13]!="") {echo 'Браузер: '.$uzdata[13].' <br />';}

echo 'Рассылка новостей: ';
if ($uzdata[34]==1) {echo 'Подписан<br />';}else {echo 'Не подписан<br />';}
echo 'Используемый скин: '.$uzdata[20].'<br />';
if ($uzdata[6]!="") {echo 'Дата регистрации: '.date_fixed($uzdata[6],'j F Y').'<br />';}
echo 'Последняя авторизация: '.date_fixed($uzdata[44]).'<br />';

if (file_exists(DATADIR."datalife/$uz.dat")){
$lifefiles = file_get_contents(DATADIR."datalife/$uz.dat");
$lifestrs = explode("|",$lifefiles);
echo 'Провел на сайте: '.makestime($lifestrs[1]).'<br />';
}

//------------------- Игровой персонаж ------------------------//
if($uzdata[55]==1){

if ($menu==""){
echo '<img src="../images/img/person.gif" alt="image" /> <b><a href="anketa.php?uz='.$uz.'&amp;menu=1">Состояние персонажа</a></b><br />';
} else {
echo '<hr /><img src="../images/img/person.gif" alt="image" /> <b>Состояние персонажа</b><br /><br />';
echo '<b><a href="../games/health.php">Здоровье: '.(int)$uzdata[56].'%</a></b><br />';
echo '<img src="../gallery/grafic.php?rat='.(int)$uzdata[56].'&amp;imgs=1" alt="image" /><br />';
echo '<b><a href="../games/stamina.php">Выносливость: '.(int)$uzdata[57].'%</a></b><br />';
echo '<img src="../gallery/grafic.php?rat='.(int)$uzdata[57].'&amp;imgs=2&amp;limit='.(int)$uzdata[59].'" alt="image" /><br />';
echo 'Сила: <b>'.(int)$uzdata[58].'</b>%<br />';
echo '<img src="../gallery/grafic.php?rat='.(int)$uzdata[58].'&amp;imgs=3" alt="image" /><br />';

echo '<br /><b><a href="../games/magazin.php">Оружие</a></b><br />';
if ($uzdata[67]!=""){
$dat67 = explode("|",$uzdata[67]);
echo 'Легкое: <b>'.$dat67[4].'</b> (+'.$dat67[3].'%)<br />';
} else {echo 'Легкое: <b>Отсутствует</b><br />';}

if ($uzdata[68]!=""){
$dat68 = explode("|",$uzdata[68]);
echo 'Пистолет: <b>'.$dat68[4].'</b> (+'.$dat68[3].'%)<br />';
} else {echo 'Пистолет: <b>Отсутствует</b><br />';}

if ($uzdata[69]!=""){
$dat69 = explode("|",$uzdata[69]);
echo 'Тяжелое: <b>'.$dat69[4].'</b> (+'.$dat69[3].'%)<br />';
} else {echo 'Тяжелое: <b>Отсутствует</b><br />';}

if ($uzdata[70]!=""){
$dat70 = explode("|",$uzdata[70]);
echo 'Граната: <b>'.$dat70[4].'</b> (+'.$dat70[3].'%)<br />';
} else {echo 'Граната: <b>Отсутствует</b><br />';}

if ($uzdata[71]!=""){
$dat71 = explode("|",$uzdata[71]);
echo 'Амуниция: <b>'.$dat71[4].'</b><br />';
} else {echo 'Амуниция: <b>Отсутствует</b><br />';}


@$obves=$dat67[2]+$dat68[2]+$dat69[2]+$dat70[2]+$dat71[2];
@$oburon=$dat67[3]+$dat68[3]+$dat69[3]+$dat70[3];

echo '<br />Общий урон: <b>+'.$oburon.'%</b><br />';
echo 'Общий вес оружия: <b>'.round($obves/1000,1).'кг</b><br />';

}}

if ($uz!=$log){
echo '<br /><div class="b">';

echo '<img src="../images/img/chat.gif" alt="image" /> Добавить в ';
echo '<a href="kontakt.php?action=add&amp;uz='.$uz.'&amp;uid='.$_SESSION['token'].'">контакт</a> / ';
echo '<a href="ignor.php?action=add&amp;uz='.$uz.'&amp;uid='.$_SESSION['token'].'">игнор</a><br />';
echo '<img src="../images/img/mail.gif" alt="image" /> <a href="privat.php?action=submit&amp;uz='.$uz.'">Отправить сообщение</a><br />';

echo '<img src="../images/img/many.gif" alt="image" /> <a href="../games/perevod.php?uz='.$uz.'">Перечислить денег</a><br />';

if ($uzdata[5]!="" && $uzdata[5]!="http://") {echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="'.$uzdata[5].'">Перейти на сайт '.$uz.'</a><br />';
}

if (is_admin(array(101,102,103))){
echo '<img src="../images/img/error.gif" alt="image" /> <a href="'.ADMINDIR.'zaban.php?action=edit&amp;users='.$uz.'">Бан / Разбан</a><br />';
}

if (is_admin(array(101,102))){
echo '<img src="../images/img/panel.gif" alt="image" /> <a href="'.ADMINDIR.'users.php?action=edit&amp;users='.$uz.'">Редактировать</a><br />';
}

echo '</div>';

} else {

echo '<br /><div class="b">';
echo '<img src="../images/img/chel.gif" alt="image" /> <a href="profil.php">Мой профиль</a><br />';
echo '<img src="../images/img/account.gif" alt="image" /> <a href="account.php">Мои данные</a><br />';
echo '<img src="../images/img/panel.gif" alt="image" /> <a href="setting.php">Настройки</a><br />';
echo '</div>';
}


} else {echo '<img src="../images/img/error.gif" alt="image" /> Пользователь с данным логином  не зарегистрирован<br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> Произошла ошибка. Пользователь с данным логином не существует<br />';}

echo '<br /><img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a>';
include_once "../themes/".$config['themes']."/foot.php";
?>
