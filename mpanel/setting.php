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
	
if (isset($_GET['action'])){$action = check($_GET['action']);} else {$action = "";}

if (is_admin(array(101))){

echo'<img src="../images/img/partners.gif" alt="image" /> <b>Настройки системы</b><br /><br />';

############################################################################################
##                                 Главная страница                                       ##
############################################################################################	
if ($action==""){
if ($log==$config['nickname']){	
echo'<img src="../images/img/forums.gif" alt="image" /> <a href="setting.php?action=setone&amp;'.SID.'">Основные настройки</a><br />';}

echo'<img src="../images/img/forums.gif" alt="image" /> <a href="setting.php?action=settwo&amp;'.SID.'">Вывод информации</a><br />';	
echo'<img src="../images/img/forums.gif" alt="image" /> <a href="setting.php?action=setthree&amp;'.SID.'">Гостевая/Чат/Новости</a><br />';
echo'<img src="../images/img/forums.gif" alt="image" /> <a href="setting.php?action=setfour&amp;'.SID.'">Форум/Галерея/Объявления</a><br />';	
echo'<img src="../images/img/forums.gif" alt="image" /> <a href="setting.php?action=setfive&amp;'.SID.'">Загрузки/Голосования/Приват</a><br />';
echo'<img src="../images/img/forums.gif" alt="image" /> <a href="setting.php?action=setsix&amp;'.SID.'">Библиотека/Реклама</a><br />';
echo'<img src="../images/img/forums.gif" alt="image" /> <a href="setting.php?action=setseven&amp;'.SID.'">Постраничная навигация</a><br />';
echo'<img src="../images/img/forums.gif" alt="image" /> <a href="setting.php?action=setseven2&amp;'.SID.'">Постраничная навигация (прод.)</a><br />';
echo'<img src="../images/img/forums.gif" alt="image" /> <a href="setting.php?action=seteight&amp;'.SID.'">Прочее/Другое</a><br />';
echo'<img src="../images/img/forums.gif" alt="image" /> <a href="setting.php?action=setnine&amp;'.SID.'">Кэширование</a><br />';
echo'<img src="../images/img/forums.gif" alt="image" /> <a href="setting.php?action=setten&amp;'.SID.'">Защита/Безопасность</a><br />';
echo'<img src="../images/img/forums.gif" alt="image" /> <a href="setting.php?action=seteleven&amp;'.SID.'">Стоимость и цены</a><br />';
}

if ($log==$config['nickname']){	
############################################################################################
##                               Форма основных настроек                                  ##
############################################################################################
//1,2,3,8,9,10,11,12,13,14,15,16,29,50,52,57,61,62,69,113,118
if ($action=="setone"){	
echo '<b>Основные настройки</b><br /><hr />';	
	
echo '<form method="post" action="setting.php?action=editone&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">';

#----------------------------------------#
echo 'Wap-тема по умолчанию:<br />';
echo '<select name="set2">';
echo '<option value="'.$con_data[2].'">'.$con_data[2].'</option>';

$globthemes = glob(BASEDIR."themes/*", GLOB_ONLYDIR);
foreach ($globthemes as $wapthemes) {
if (basename($wapthemes)!=$con_data[2]){
echo '<option value="'.basename($wapthemes).'">'.basename($wapthemes).'</option>';
}}
echo '</select><br />';

#----------------------------------------#
echo 'Web-тема по умолчанию:<br />';
echo '<select name="set113">';

if (empty($con_data[113])){
echo '<option value="0">Выключить</option>';
} else {
echo '<option value="'.$con_data[113].'">'.$con_data[113].'</option>';
echo '<option value="0">Выключить</option>';
}

$globthemes = glob(BASEDIR."themes/*", GLOB_ONLYDIR);
foreach ($globthemes as $webthemes) {
if (basename($webthemes)!=$con_data[113]){
echo '<option value="'.basename($webthemes).'">'.basename($webthemes).'</option>';
}}

echo '</select><br />';

#----------------------------------------#

echo 'Логин администратора:<br /><input name="set8" maxlength="20" value="'.$con_data[8].'" /><br />';
echo 'E-mail администратора:<br /><input name="set9" maxlength="50" value="'.$con_data[9].'" /><br />';
echo 'Временной сдвиг:<br /><input name="set10" maxlength="3" value="'.$con_data[10].'" /><br />';
echo 'Заголовок всех страниц:<br /><input name="set11" maxlength="100" value="'.$con_data[11].'" /><br />';
echo 'Подпись вверху:<br /><input name="set12" maxlength="100" value="'.$con_data[12].'" /><br />';
echo 'Подпись внизу:<br /><input name="set13" maxlength="100" value="'.$con_data[13].'" /><br />';
echo 'Главная страница сайта:<br /><input name="set14" maxlength="50" value="'.$con_data[14].'" /><br />';
echo 'Адрес логотипа:<br /><input name="set15" maxlength="100" value="'.$con_data[15].'" /><br />';
echo 'Расширение страниц движка:<br /><input name="set16" maxlength="6" value="'.$con_data[16].'" /><br />';
echo 'Время антифлуда (сек):<br /><input name="set29" maxlength="3" value="'.$con_data[29].'" /><br />';
echo 'Лимит запросов с IP:<br /><input name="set57" maxlength="3" value="'.$con_data[57].'" /><br />';
echo 'Ключ для cookies:<br /><input name="set1" maxlength="25" value="'.$con_data[1].'" /><br />';


echo 'Время карантина:<br />';
echo '<select name="set3">';
$karantin = array(0=>'Выключить', 21600=>'6 часов', 43200=>'12 часов', 86400=>'24 часа', 129600=>'36 часов', 172800=>'48 часов');

echo '<option value="'.$con_data[3].'">'.$karantin[$con_data[3]].'</option>';

foreach($karantin as $k=>$v){
if ($k!=$con_data[3]){
echo '<option value="'.$k.'">'.$v.'</option>';
}}
echo '</select><br />';


echo 'Подтверждение регистрации:<br />';
echo '<select name="set62">';
$regist = array(0=>'Выключить', 1=>'Автоматически', 2=>'Вручную');

echo '<option value="'.$con_data[62].'">'.$regist[$con_data[62]].'</option>';

foreach($regist as $k=>$v){
if ($k!=$con_data[62]){
echo '<option value="'.$k.'">'.$v.'</option>';
}}
echo '</select><br />';


echo 'Разрешить вход по кукам: <br />Да';
if ($con_data[50]==1){
echo '<input name="set50" type="radio" value="1" checked="checked" />';} else {echo '<input name="set50" type="radio" value="1" />';} 	
echo ' &nbsp; &nbsp; ';
if ($con_data[50]==0){
echo '<input name="set50" type="radio" value="0" checked="checked" />';} else {echo '<input name="set50" type="radio" value="0" />';}
echo 'Нет<br />';

echo 'Разрешить кэширование: <br />Да';
if ($con_data[52]==1){
echo '<input name="set52" type="radio" value="1" checked="checked" />';} else {echo '<input name="set52" type="radio" value="1" />';} 	
echo ' &nbsp; &nbsp; ';
if ($con_data[52]==0){
echo '<input name="set52" type="radio" value="0" checked="checked" />';} else {echo '<input name="set52" type="radio" value="0" />';}
echo 'Нет<br />';

echo 'Регистрация открыта: <br />Да';
if ($con_data[61]==1){
echo '<input name="set61" type="radio" value="1" checked="checked" />';} else {echo '<input name="set61" type="radio" value="1" />';} 	
echo ' &nbsp; &nbsp; ';
if ($con_data[61]==0){
echo '<input name="set61" type="radio" value="0" checked="checked" />';} else {echo '<input name="set61" type="radio" value="0" />';}
echo 'Нет<br />';

echo 'Включить сжатие страниц GZIP: <br />Да';
if ($con_data[69]==1){
echo '<input name="set69" type="radio" value="1" checked="checked" />';} else {echo '<input name="set69" type="radio" value="1" />';} 	
echo ' &nbsp; &nbsp; ';
if ($con_data[69]==0){
echo '<input name="set69" type="radio" value="0" checked="checked" />';} else {echo '<input name="set69" type="radio" value="0" />';}
echo 'Нет<br />';

echo 'Закрыть сайт по техническим причинам: <br />Да';
if ($con_data[118]==1){
echo '<input name="set118" type="radio" value="1" checked="checked" />';} else {echo '<input name="set118" type="radio" value="1" />';} 	
echo ' &nbsp; &nbsp; ';
if ($con_data[118]==0){
echo '<input name="set118" type="radio" value="0" checked="checked" />';} else {echo '<input name="set118" type="radio" value="0" />';}
echo 'Нет<br />';

echo '<br /><input value="Изменить" type="submit" /></form><hr />';
echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="setting.php?'.SID.'">Вернуться</a>';
}

############################################################################################
##                                Изменение основных настроек                             ##
############################################################################################
if ($action=="editone"){

$uid = check($_GET['uid']);

if ($uid==$_SESSION['token']){
if ($_POST['set1']!="" && $_POST['set2']!="" && $_POST['set3']!="" && $_POST['set8']!="" && $_POST['set9']!="" && $_POST['set10']!="" && $_POST['set11']!="" && $_POST['set12']!="" && $_POST['set13']!="" && $_POST['set14']!="" && $_POST['set15']!="" && $_POST['set16']!="" && $_POST['set29']!="" && $_POST['set50']!="" && $_POST['set52']!="" && $_POST['set57']!="" && $_POST['set61']!="" && $_POST['set62']!="" && $_POST['set69']!="" && $_POST['set118']!=""){

change_setting(array(1=>check(no_br($_POST['set1'])), 2=>check(no_br($_POST['set2'])), 3=>check(no_br($_POST['set3'])), 8=>check(no_br($_POST['set8'])), 9=>check(no_br($_POST['set9'])), 10=>check(no_br($_POST['set10'])), 11=>check(no_br($_POST['set11'])), 12=>check(no_br($_POST['set12'])), 13=>check(no_br($_POST['set13'])), 14=>check(no_br($_POST['set14'])), 15=>check(no_br($_POST['set15'])), 16=>check(no_br($_POST['set16'])), 29=>(int)$_POST['set29'], 50=>(int)$_POST['set50'], 52=>(int)$_POST['set52'], 57=>(int)$_POST['set57'], 61=>(int)$_POST['set61'], 62=>(int)$_POST['set62'], 69=>(int)$_POST['set69'], 113=>check(no_br($_POST['set113'])), 118=>(int)$_POST['set118']));

header ("Location: setting.php?isset=mp_yesset&".SID); exit;

} else {echo '<b>Ошибка изменения настроек, все поля обязательны для заполнения!</b><br />';}
} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="setting.php?action=setone&amp;'.SID.'">Вернуться</a>';
}}

############################################################################################
##                                Форма вывода информации                                 ##
############################################################################################
//0,4,5,7,47,74,85,86,87,91
if ($action=="settwo"){	
echo '<b>Вывод информации</b><br /><hr />';	
	
echo '<form method="post" action="setting.php?action=edittwo&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">';

echo 'Показывать приветствие: <br />Да';
if ($con_data[0]==1){
echo '<input name="set0" type="radio" value="1" checked="checked" />';} else {echo '<input name="set0" type="radio" value="1" />';} 	
echo ' &nbsp; &nbsp; ';
if ($con_data[0]==0){
echo '<input name="set0" type="radio" value="0" checked="checked" />';} else {echo '<input name="set0" type="radio" value="0" />';}
echo 'Нет<br />';

echo 'Показывать часы: <br />Да';
if ($con_data[4]==1){
echo '<input name="set4" type="radio" value="1" checked="checked" />';} else {echo '<input name="set4" type="radio" value="1" />';} 	
echo ' &nbsp; &nbsp; ';
if ($con_data[4]==0){
echo '<input name="set4" type="radio" value="0" checked="checked" />';} else {echo '<input name="set4" type="radio" value="0" />';}
echo 'Нет<br />';


echo 'Показывать время генерации: <br />Да';
if ($con_data[5]==1){
echo '<input name="set5" type="radio" value="1" checked="checked" />';} else {echo '<input name="set5" type="radio" value="1" />';} 	
echo ' &nbsp; &nbsp; ';
if ($con_data[5]==0){
echo '<input name="set5" type="radio" value="0" checked="checked" />';} else {echo '<input name="set5" type="radio" value="0" />';}
echo 'Нет<br />';

echo 'Показывать онлайн: <br />Да';
if ($con_data[7]==1){
echo '<input name="set7" type="radio" value="1" checked="checked" />';} else {echo '<input name="set7" type="radio" value="1" />';} 	
echo ' &nbsp; &nbsp; ';
if ($con_data[7]==0){
echo '<input name="set7" type="radio" value="0" checked="checked" />';} else {echo '<input name="set7" type="radio" value="0" />';}
echo 'Нет<br />';

echo 'Показывать цитаты: <br />Да';
if ($con_data[47]==1){
echo '<input name="set47" type="radio" value="1" checked="checked" />';} else {echo '<input name="set47" type="radio" value="1" />';} 	
echo ' &nbsp; &nbsp; ';
if ($con_data[47]==0){
echo '<input name="set47" type="radio" value="0" checked="checked" />';} else {echo '<input name="set47" type="radio" value="0" />';}
echo 'Нет<br />';

echo 'Отображение счетчика:<br /><select name="set74">';

$incounters=array('Выключить', 'Хосты Хосты всего', 'Хиты Хиты всего', 'Хиты Хосты', 'Хиты всего Хосты всего', 'Графический');

echo '<option value="'.$con_data[74].'">'.$incounters[$con_data[74]].'</option>';

foreach($incounters as $k=>$v){
if ($k!=$con_data[74]){
echo '<option value="'.$k.'">'.$v.'</option>';
}}
echo '</select><br />';


echo 'Включить календарь: <br />Да';
if ($con_data[85]==1){
echo '<input name="set85" type="radio" value="1" checked="checked" />';} else {echo '<input name="set85" type="radio" value="1" />';} 	
echo ' &nbsp; &nbsp; ';
if ($con_data[85]==0){
echo '<input name="set85" type="radio" value="0" checked="checked" />';} else {echo '<input name="set85" type="radio" value="0" />';}
echo 'Нет<br />';

echo 'Бегущая строка с юзерами: <br />Да';
if ($con_data[86]==1){
echo '<input name="set86" type="radio" value="1" checked="checked" />';} else {echo '<input name="set86" type="radio" value="1" />';} 	
echo ' &nbsp; &nbsp; ';
if ($con_data[86]==0){
echo '<input name="set86" type="radio" value="0" checked="checked" />';} else {echo '<input name="set86" type="radio" value="0" />';}
echo 'Нет<br />';


echo 'Выпадающий список скинов/тем:<br /><select name="set87">';

$incounters=array('Выключить', 'Обычный список', 'Список без кнопки');

echo '<option value="'.$con_data[87].'">'.$incounters[$con_data[87]].'</option>';

foreach($incounters as $k=>$v){
if ($k!=$con_data[87]){
echo '<option value="'.$k.'">'.$v.'</option>';
}}
echo '</select><br />';

echo 'Выпадающий список навигации:<br /><select name="set91">';

$innavigation=array('Выключить', 'Обычный список', 'Список без кнопки');

echo '<option value="'.$con_data[91].'">'.$innavigation[$con_data[91]].'</option>';

foreach($innavigation as $k=>$v){
if ($k!=$con_data[91]){
echo '<option value="'.$k.'">'.$v.'</option>';
}}
echo '</select><br />';


echo '<br /><input value="Изменить" type="submit" /></form><hr />';
echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="setting.php?'.SID.'">Вернуться</a>';		
}

############################################################################################
##                              Изменение вывода информации                               ##
############################################################################################
if($action=="edittwo"){

$uid = check($_GET['uid']);

if ($uid==$_SESSION['token']){
if($_POST['set0']!="" && $_POST['set4']!="" && $_POST['set5']!="" && $_POST['set7']!="" && $_POST['set47']!=""  && $_POST['set74']!="" && $_POST['set85']!="" && $_POST['set86']!="" && $_POST['set87']!="" && $_POST['set91']!=""){

change_setting(array(0=>(int)$_POST['set0'], 4=>(int)$_POST['set4'], 5=>(int)$_POST['set5'], 7=>(int)$_POST['set7'], 47=>(int)$_POST['set47'], 74=>(int)$_POST['set74'], 85=>(int)$_POST['set85'], 86=>(int)$_POST['set86'], 87=>(int)$_POST['set87'], 91=>(int)$_POST['set91']));

header ("Location: setting.php?isset=mp_yesset&".SID); exit;

} else {echo '<b>Ошибка изменения настроек, все поля обязательны для заполнения!</b><br />';}
} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}


echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="setting.php?action=settwo&amp;'.SID.'">Вернуться</a>';
}


############################################################################################
##                        Форма изменения гостевой, новостей и чата                       ##
############################################################################################
//17,18,19,20,21,22,23,25,56,63,64,65,130
if ($action=="setthree"){	
echo '<b>Настройки гостевой, новостей и чата</b><br /><hr />';	
	
echo '<form method="post" action="setting.php?action=editthree&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">';

echo 'Новостей на страницу:<br /><input name="set17" maxlength="2" value="'.$con_data[17].'" /><br />';
echo 'Вывод новостей на главную:<br /><input name="set18" maxlength="2" value="'.$con_data[18].'" /><br />';
echo 'Сообщений в гостевой на стр.:<br /><input name="set19" maxlength="2" value="'.$con_data[19].'" /><br />';

echo 'Разрешать гостям писать в гостевой: <br />Да';
if ($con_data[20]==1){
echo '<input name="set20" type="radio" value="1" checked="checked" />';} else {echo '<input name="set20" type="radio" value="1" />';} 	
echo ' &nbsp; &nbsp; ';
if ($con_data[20]==0){
echo '<input name="set20" type="radio" value="0" checked="checked" />';} else {echo '<input name="set20" type="radio" value="0" />';}
echo 'Нет<br />';


echo 'Включить шутника в чате: <br />Да';
if ($con_data[63]==1){
echo '<input name="set63" type="radio" value="1" checked="checked" />';} else {echo '<input name="set63" type="radio" value="1" />';} 	
echo ' &nbsp; &nbsp; ';
if ($con_data[63]==0){
echo '<input name="set63" type="radio" value="0" checked="checked" />';} else {echo '<input name="set63" type="radio" value="0" />';}
echo 'Нет<br />';

echo 'Включить бота в чате: <br />Да';
if ($con_data[64]==1){
echo '<input name="set64" type="radio" value="1" checked="checked" />';} else {echo '<input name="set64" type="radio" value="1" />';} 	
echo ' &nbsp; &nbsp; ';
if ($con_data[64]==0){
echo '<input name="set64" type="radio" value="0" checked="checked" />';} else {echo '<input name="set64" type="radio" value="0" />';}
echo 'Нет<br />';

echo 'Включить умника в чате: <br />Да';
if ($con_data[65]==1){
echo '<input name="set65" type="radio" value="1" checked="checked" />';} else {echo '<input name="set65" type="radio" value="1" />';} 	
echo ' &nbsp; &nbsp; ';
if ($con_data[65]==0){
echo '<input name="set65" type="radio" value="0" checked="checked" />';} else {echo '<input name="set65" type="radio" value="0" />';}
echo 'Нет<br />';


echo 'Неавторизованный пользователь:<br /><input name="set21" maxlength="20" value="'.$con_data[21].'" /><br />';
echo 'Кол-во постов в  чате сохраняется:<br /><input name="set22" maxlength="4" value="'.$con_data[22].'" /><br />';
echo 'Cообщений в чате на стр.:<br /><input name="set23" maxlength="2" value="'.$con_data[23].'" /><br />';
echo 'Кол-во комментариев в новостях сохраняется:<br /><input name="set130" maxlength="4" value="'.$con_data[130].'" /><br />';
echo 'Кол-во  постов в гостевой сохраняется:<br /><input name="set25" maxlength="4" value="'.$con_data[25].'" /><br />';
echo 'Кол-во писем рассылки в пакете:<br /><input name="set56" maxlength="3" value="'.$con_data[56].'" /><br />';

echo '<br /><input value="Изменить" type="submit" /></form><hr />';
echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="setting.php?'.SID.'">Вернуться</a>';
}

############################################################################################
##                          Изменение в гостевой, новостей и чата                         ##
############################################################################################
if ($action=="editthree"){

$uid = check($_GET['uid']);

if ($uid==$_SESSION['token']){
if ($_POST['set17']!="" && $_POST['set18']!="" && $_POST['set19']!="" && $_POST['set20']!="" && $_POST['set21']!="" && $_POST['set22']!="" && $_POST['set23']!="" && $_POST['set25']!="" && $_POST['set56']!="" && $_POST['set63']!="" && $_POST['set64']!="" && $_POST['set65']!="" && $_POST['set130']!=""){

change_setting(array(17=>(int)$_POST['set17'], 18=>(int)$_POST['set18'], 19=>(int)$_POST['set19'], 20=>(int)$_POST['set20'], 21=>check(no_br($_POST['set21'])), 22=>(int)$_POST['set22'], 23=>(int)$_POST['set23'], 25=>(int)$_POST['set25'], 56=>(int)$_POST['set56'], 63=>(int)$_POST['set63'], 64=>(int)$_POST['set64'], 65=>(int)$_POST['set65'], 130=>(int)$_POST['set130']));

header ("Location: setting.php?isset=mp_yesset&".SID); exit;

} else {echo '<b>Ошибка изменения настроек, все поля обязательны для заполнения!</b><br />';}
} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="setting.php?action=settwo&amp;'.SID.'">Вернуться</a>';
}

############################################################################################
##                     Форма изменения форума, галереи и объявлений                       ##
############################################################################################
//26,27,28,34,35,36,37,38,39,109,110,111
if ($action=="setfour"){	
echo '<b>Настройки форума, галереи и объявлений</b><br /><hr />';	
	
echo '<form method="post" action="setting.php?action=editfour&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">';
echo 'Сообщений в форуме на стр.:<br /><input name="set26" maxlength="2" value="'.$con_data[26].'" /><br />';
echo 'Тем в форуме на стр.:<br /><input name="set27" maxlength="2" value="'.$con_data[27].'" /><br />';
echo 'Кол-во тем в форуме сохраняется:<br /><input name="set28" maxlength="4" value="'.$con_data[28].'" /><br />';
echo 'Объявлений на стр.:<br /><input name="set35" maxlength="2" value="'.$con_data[35].'" /><br />';
echo 'Кол-во дней показа объявлений:<br /><input name="set36" maxlength="3" value="'.$con_data[36].'" /><br />';
echo 'Kол-во фото на стр.:<br /><input name="set37" maxlength="2" value="'.$con_data[37].'" /><br />';
echo 'Максимальный вес фото (kb):<br /><input name="set38" maxlength="6" value="'.round($con_data[38]/1024).'" /><br />';
echo 'Максимальный размер фото (px):<br /><input name="set39" maxlength="3" value="'.$con_data[39].'" /><br />';
echo 'Размер скриншотов (px):<br /><input name="set109" maxlength="3" value="'.$con_data[109].'" /><br />';
echo 'Комментариев на страницу в галерее:<br /><input name="set110" maxlength="3" value="'.$con_data[110].'" /><br />';
echo 'Комментариев сохраняется в галерее:<br /><input name="set111" maxlength="3" value="'.$con_data[111].'" /><br />';

echo 'Наложение копирайта на изображения: <br />Да';
if ($con_data[34]==1){
echo '<input name="set34" type="radio" value="1" checked="checked" />';} else {echo '<input name="set34" type="radio" value="1" />';} 	
echo ' &nbsp; &nbsp; ';
if ($con_data[34]==0){
echo '<input name="set34" type="radio" value="0" checked="checked" />';} else {echo '<input name="set34" type="radio" value="0" />';}
echo 'Нет<br />';


echo '<br /><input value="Изменить" type="submit" /></form><hr />';
echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="setting.php?'.SID.'">Вернуться</a>';
}

############################################################################################
##                     Изменение в форуме, галерее и объявлениях                          ##
############################################################################################
if ($action=="editfour"){

$uid = check($_GET['uid']);

if ($uid==$_SESSION['token']){
if ($_POST['set26']!="" && $_POST['set27']!="" && $_POST['set28']!="" && $_POST['set34']!="" && $_POST['set35']!="" && $_POST['set36']!="" && $_POST['set37']!="" && $_POST['set38']!="" && $_POST['set39']!="" && $_POST['set109']!="" && $_POST['set110']!="" && $_POST['set111']!=""){

change_setting(array(26=>(int)$_POST['set26'], 27=>(int)$_POST['set27'], 28=>(int)$_POST['set28'], 34=>(int)$_POST['set34'], 35=>(int)$_POST['set35'], 36=>(int)$_POST['set36'], 37=>(int)$_POST['set37'], 38=>round($_POST['set38'] * 1024), 39=>(int)$_POST['set39'], 109=>(int)$_POST['set109'], 110=>(int)$_POST['set110'], 111=>(int)$_POST['set111']));

header ("Location: setting.php?isset=mp_yesset&".SID); exit;

} else {echo '<b>Ошибка изменения настроек, все поля обязательны для заполнения!</b><br />';}
} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="setting.php?action=setfour&amp;'.SID.'">Вернуться</a>';
}


############################################################################################
##                  Форма изменения загрузок, голосований и привата                       ##
############################################################################################
//30,33,40,41,42,46,66,98
if ($action=="setfive"){	
echo '<b>Настройки загрузок, голосований и привата</b><br /><hr />';	
	
echo '<form method="post" action="setting.php?action=editfive&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">';	

echo 'Размер ящика для привата (kb):<br /><input name="set30" maxlength="2" value="'.$con_data[30].'" /><br />';
echo 'Писем в привате на стр.:<br /><input name="set33" maxlength="2" value="'.$con_data[33].'" /><br />';		
echo 'Комментарий в загрузках на стр.:<br /><input name="set40" maxlength="2" value="'.$con_data[40].'" /><br />';	
echo 'Кол-во комментарий сохраняется:<br /><input name="set41" maxlength="3" value="'.$con_data[41].'" /><br />';
echo 'Файлов в загрузках на стр.:<br /><input name="set42" maxlength="2" value="'.$con_data[42].'" /><br />';
echo 'Кол-во голосований на стр.:<br /><input name="set46" maxlength="2" value="'.$con_data[46].'" /><br />';
echo 'Файлов в просмотре архивов на стр.:<br /><input name="set66" maxlength="2" value="'.$con_data[66].'" /><br />';

echo 'Уведомлять об изменении авторитета:<br />Да';
if ($con_data[98]==1){
echo '<input name="set98" type="radio" value="1" checked="checked" />';} else {echo '<input name="set98" type="radio" value="1" />';} 	
echo ' &nbsp; &nbsp; ';
if ($con_data[98]==0){
echo '<input name="set98" type="radio" value="0" checked="checked" />';} else {echo '<input name="set98" type="radio" value="0" />';}
echo 'Нет<br />';


echo '<br /><input value="Изменить" type="submit" /></form><hr />';
echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="setting.php?'.SID.'">Вернуться</a>';
}

############################################################################################
##                   Изменение в загрузках, голосованиях и привате                        ##
############################################################################################
if ($action=="editfive"){

$uid = check($_GET['uid']);

if ($uid==$_SESSION['token']){
if ($_POST['set30']!="" && $_POST['set33']!="" && $_POST['set40']!="" && $_POST['set41']!="" && $_POST['set42']!="" && $_POST['set46']!="" && $_POST['set66']!="" && $_POST['set98']!=""){

change_setting(array(30=>(int)$_POST['set30'], 33=>(int)$_POST['set33'], 40=>(int)$_POST['set40'], 41=>(int)$_POST['set41'], 42=>(int)$_POST['set42'], 46=>(int)$_POST['set46'], 66=>(int)$_POST['set66'], 98=>(int)$_POST['set98']));

header ("Location: setting.php?isset=mp_yesset&".SID); exit;

} else {echo '<b>Ошибка изменения настроек, все поля обязательны для заполнения!</b><br />';}
} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="setting.php?action=setfive&amp;'.SID.'">Вернуться</a>';
}

############################################################################################
##                        Форма изменения библиотеки/рекламы                              ##
############################################################################################
//67,68,72,73,101,102
if ($action=="setsix"){	
echo '<b>Настройки библиотеки</b><br /><hr />';	
	
echo '<form method="post" action="setting.php?action=editsix&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">';	

echo 'Статей в библиотеке на стр.:<br /><input name="set67" maxlength="2" value="'.$con_data[67].'" /><br />';	
echo 'Строк в статье на стр.:<br /><input name="set68" maxlength="3" value="'.$con_data[68].'" /><br />';

echo 'Включить рекламу вверху: <br />Да';
if ($con_data[72]==1){
echo '<input name="set72" type="radio" value="1" checked="checked" />';} else {echo '<input name="set72" type="radio" value="1" />';} 	
echo ' &nbsp; &nbsp; ';
if ($con_data[72]==0){
echo '<input name="set72" type="radio" value="0" checked="checked" />';} else {echo '<input name="set72" type="radio" value="0" />';}
echo 'Нет<br />';

echo 'Включить рекламу внизу: <br />Да';
if ($con_data[73]==1){
echo '<input name="set73" type="radio" value="1" checked="checked" />';} else {echo '<input name="set73" type="radio" value="1" />';} 	
echo ' &nbsp; &nbsp; ';
if ($con_data[73]==0){
echo '<input name="set73" type="radio" value="0" checked="checked" />';} else {echo '<input name="set73" type="radio" value="0" />';}
echo 'Нет<br />';

echo 'Разрешить добавлять статьи: <br />Да';
if ($con_data[101]==1){
echo '<input name="set101" type="radio" value="1" checked="checked" />';} else {echo '<input name="set101" type="radio" value="1" />';} 	
echo ' &nbsp; &nbsp; ';
if ($con_data[101]==0){
echo '<input name="set101" type="radio" value="0" checked="checked" />';} else {echo '<input name="set101" type="radio" value="0" />';}
echo 'Нет<br />';

echo 'Макс. символов в новой статье:<br /><input name="set102" maxlength="6" value="'.$con_data[102].'" /><br />';

echo '<br /><input value="Изменить" type="submit" /></form><hr />';
echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="setting.php?'.SID.'">Вернуться</a>';
}



//---------------------- Изменение библиотеки/рекламы ------------------------------//
if ($action=="editsix"){

$uid = check($_GET['uid']);
if ($uid==$_SESSION['token']){
if ($_POST['set67']!="" && $_POST['set68']!="" && $_POST['set72']!="" && $_POST['set73']!=""  && $_POST['set101']!=""  && $_POST['set102']!=""){

change_setting(array(67=>(int)$_POST['set67'], 68=>(int)$_POST['set68'], 72=>(int)$_POST['set72'], 73=>(int)$_POST['set73'], 101=>(int)$_POST['set101'], 102=>(int)$_POST['set102']));

header ("Location: setting.php?isset=mp_yesset&".SID); exit;

} else {echo '<b>Ошибка изменения настроек, все поля обязательны для заполнения!</b><br />';}
} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="setting.php?action=setsix&amp;'.SID.'">Вернуться</a>';
}

############################################################################################
##                           Форма изменения постраничной навигации                       ##
############################################################################################
//31,44,45,49,51,53,54,55,60,70,92,93,94,96,99,100,105,106
if ($action=="setseven"){	
echo '<b>Настройки постраничной навигации</b><br /><hr />';	
	
echo '<form method="post" action="setting.php?action=editseven&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">';	

echo 'Пользователей в юзерлисте:<br /><input name="set31" maxlength="2" value="'.$con_data[31].'" /><br />';	
echo 'Пользователей в кто-где:<br /><input name="set44" maxlength="2" value="'.$con_data[44].'" /><br />';
echo 'Сохраняется истории в кто-где:<br /><input name="set45" maxlength="3" value="'.$con_data[45].'" /><br />';
echo 'Пользователей в статистике вкладов:<br /><input name="set49" maxlength="2" value="'.$con_data[49].'" /><br />';
echo 'Сайтов в кто-откуда<br /><input name="set60" maxlength="3" value="'.$con_data[60].'" /><br />';
echo 'Сохраняется истории в кто-откуда:<br /><input name="set51" maxlength="3" value="'.$con_data[51].'" /><br />';
echo 'Ссылок пирамиды на главной:<br /><input name="set53" maxlength="2" value="'.$con_data[53].'" /><br />';
echo 'Пользователей в онлайне:<br /><input name="set54" maxlength="2" value="'.$con_data[54].'" /><br />';
echo 'Смайлов на стр.:<br /><input name="set55" maxlength="2" value="'.$con_data[55].'" /><br />';
echo 'Юзеров в рейтинге авторитетов на стр.:<br /><input name="set70" maxlength="2" value="'.$con_data[70].'" /><br />';
echo 'Юзеров в контакт-листе:<br /><input name="set92" maxlength="2" value="'.$con_data[92].'" /><br />';
echo 'Юзеров в игнор-листе:<br /><input name="set93" maxlength="2" value="'.$con_data[93].'" /><br />';
echo 'Юзеров в рейтинге долгожителей:<br /><input name="set94" maxlength="2" value="'.$con_data[94].'" /><br />';
echo 'Юзеров в списке забаненных:<br /><input name="set96" maxlength="2" value="'.$con_data[96].'" /><br />';
echo 'Подписчиков на страницу:<br /><input name="set99" maxlength="2" value="'.$con_data[99].'" /><br />';
echo 'Заголовков на страницу:<br /><input name="set100" maxlength="2" value="'.$con_data[100].'" /><br />';
echo 'Новостей движка в обновлениях:<br /><input name="set105" maxlength="2" value="'.$con_data[105].'" /><br />';
echo 'Кол-во юзеров в топе форума:<br /><input name="set106" maxlength="2" value="'.$con_data[106].'" /><br />';


echo '<br /><input value="Изменить" type="submit" /></form><hr />';
echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="setting.php?'.SID.'">Вернуться</a>';
}


############################################################################################
##                               Изменение постраничной навигации                         ##
############################################################################################
if ($action=="editseven"){

$uid = check($_GET['uid']);

if ($uid==$_SESSION['token']){
if ($_POST['set31']!="" && $_POST['set44']!="" && $_POST['set45']!="" && $_POST['set49']!="" && $_POST['set51']!="" && $_POST['set53']!="" && $_POST['set54']!="" && $_POST['set55']!="" && $_POST['set60']!="" && $_POST['set70']!="" && $_POST['set92']!="" && $_POST['set93']!="" && $_POST['set94']!="" && $_POST['set96']!="" && $_POST['set99']!="" && $_POST['set100']!="" && $_POST['set105']!="" && $_POST['set106']!=""){


change_setting(array(31=>(int)$_POST['set31'], 44=>(int)$_POST['set44'], 45=>(int)$_POST['set45'], 49=>(int)$_POST['set49'], 51=>(int)$_POST['set51'], 53=>(int)$_POST['set53'], 54=>(int)$_POST['set54'], 55=>(int)$_POST['set55'], 60=>(int)$_POST['set60'], 70=>(int)$_POST['set70'], 92=>(int)$_POST['set92'], 93=>(int)$_POST['set93'], 94=>(int)$_POST['set94'], 96=>(int)$_POST['set96'], 99=>(int)$_POST['set99'], 100=>(int)$_POST['set100'], 105=>(int)$_POST['set105'], 106=>(int)$_POST['set106']));

header ("Location: setting.php?isset=mp_yesset&".SID); exit;

} else {echo '<b>Ошибка изменения настроек, все поля обязательны для заполнения!</b><br />';}
} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="setting.php?action=setseven&amp;'.SID.'">Вернуться</a>';
}



############################################################################################
##                      Форма изменения постраничной навигации (прод.)                    ##
############################################################################################
//116,117,127,129
if ($action=="setseven2"){	
echo '<b>Постраничная навигация (прод.)</b><br /><hr />';	
	
echo '<form method="post" action="setting.php?action=editseven2&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">';	

echo 'Аватаров на страницу:<br /><input name="set116" maxlength="2" value="'.$con_data[116].'" /><br />';	
echo 'Файлов в редакторе админки:<br /><input name="set117" maxlength="2" value="'.$con_data[117].'" /><br />';	
echo 'Просмотр логов на страницу:<br /><input name="set127" maxlength="2" value="'.$con_data[127].'" /><br />';
echo 'Данных на страницу в черном списке:<br /><input name="set129" maxlength="2" value="'.$con_data[129].'" /><br />';

echo '<br /><input value="Изменить" type="submit" /></form><hr />';
echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="setting.php?'.SID.'">Вернуться</a>';
}

############################################################################################
##                          Изменение постраничной навигации (прод.)                      ##
############################################################################################
if ($action=="editseven2"){

$uid = check($_GET['uid']);

if ($uid==$_SESSION['token']){
if ($_POST['set116']!="" && $_POST['set117']!="" && $_POST['set127']!="" && $_POST['set129']!=""){

change_setting(array(116=>(int)$_POST['set116'], 117=>(int)$_POST['set117'], 127=>(int)$_POST['set127'], 129=>(int)$_POST['set129']));

header ("Location: setting.php?isset=mp_yesset&".SID); exit;

} else {echo '<b>Ошибка изменения настроек, все поля обязательны для заполнения!</b><br />';}
} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="setting.php?action=setseven2&amp;'.SID.'">Вернуться</a>';
}


############################################################################################
##                            Форма основных прочих настроек                              ##
############################################################################################
//58,82,83,89,90,97
if ($action=="seteight"){	
echo '<b>Прочее/Другое</b><br /><hr />';	
	
echo '<form method="post" action="setting.php?action=editeight&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">';	

echo 'Сохраняется информации в лог-файле:<br /><input name="set58" maxlength="3" value="'.$con_data[58].'" /><br />';	
echo 'Ключевые слова (keywords):<br /><input name="set82" maxlength="250" value="'.$con_data[82].'" /><br />';	
echo 'Краткое описание (description):<br /><input name="set83" maxlength="250" value="'.$con_data[83].'" /><br />';
echo 'Не сканируемые расширения (через запятую):<br /><input name="set88" maxlength="250" value="'.$con_data[88].'" /><br />';

echo 'Разрешить русские ники: <br />Да';
if ($con_data[89]==1){
echo '<input name="set89" type="radio" value="1" checked="checked" />';} else {echo '<input name="set89" type="radio" value="1" />';} 	
echo ' &nbsp; &nbsp; ';
if ($con_data[89]==0){
echo '<input name="set89" type="radio" value="0" checked="checked" />';} else {echo '<input name="set89" type="radio" value="0" />';}
echo 'Нет<br />';

echo 'Разрешить объяснительные из бана: <br />Да';
if ($con_data[90]==1){
echo '<input name="set90" type="radio" value="1" checked="checked" />';} else {echo '<input name="set90" type="radio" value="1" />';} 	
echo ' &nbsp; &nbsp; ';
if ($con_data[90]==0){
echo '<input name="set90" type="radio" value="0" checked="checked" />';} else {echo '<input name="set90" type="radio" value="0" />';}
echo 'Нет<br />';
echo 'Максимальное время бана (суток):<br /><input name="set97" maxlength="3" value="'.round($con_data[97]/1440).'" /><br />';

echo '<br /><input value="Изменить" type="submit" /></form><hr />';
echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="setting.php?'.SID.'">Вернуться</a>';
}


############################################################################################
##                                 Форма прочих настроек                                  ##
############################################################################################
if($action=="editeight"){

$uid = check($_GET['uid']);

if ($uid==$_SESSION['token']){
if ($_POST['set58']!="" && $_POST['set82']!="" && $_POST['set83']!="" && $_POST['set88']!="" && $_POST['set89']!="" && $_POST['set90']!=""){

change_setting(array(58=>(int)$_POST['set58'], 82=>check(no_br($_POST['set82'])), 83=>check(no_br($_POST['set83'])), 88=>check(no_br($_POST['set88'])), 89=>(int)$_POST['set89'], 90=>(int)$_POST['set90'], 97=>round($_POST['set97'] * 1440)));

header ("Location: setting.php?isset=mp_yesset&".SID); exit;

} else {echo '<b>Ошибка изменения настроек, все поля обязательны для заполнения!</b><br />';}
} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="setting.php?action=seteight&amp;'.SID.'">Вернуться</a>';
}

############################################################################################
##                               Форма изменения кэширования                              ##
############################################################################################
//76,77,78,79,80,84,95,107,108,112,126,128,131
if ($action=="setnine"){	
echo '<b>Настройки кэширования</b><br /><hr />';	
	
echo '<form method="post" action="setting.php?action=editnine&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">';	

echo 'кэш в юзерлисте: <br /><input name="set76" maxlength="2" value="'.$con_data[76].'" /><br />';	
echo 'Рейтинг авторитетов: <br /><input name="set77" maxlength="2" value="'.$con_data[77].'" /><br />';
echo 'Рейтинг толстосумов: <br /><input name="set78" maxlength="2" value="'.$con_data[78].'" /><br />';
echo 'Загруз-центр: <br /><input name="set79" maxlength="2" value="'.$con_data[79].'" /><br />';
echo 'Библиотека: <br /><input name="set80" maxlength="2" value="'.$con_data[80].'" /><br />';
echo 'Поиск пользователей: <br /><input name="set84" maxlength="2" value="'.$con_data[84].'" /><br />';
echo 'Рейтинг долгожителей: <br /><input name="set95" maxlength="2" value="'.$con_data[95].'" /><br />';
echo 'Топ юзеров в форуме: <br /><input name="set107" maxlength="2" value="'.$con_data[107].'" /><br />';
echo 'Топ тем в форуме: <br /><input name="set108" maxlength="2" value="'.$con_data[108].'" /><br />';
echo 'Листинг администрации: <br /><input name="set112" maxlength="2" value="'.$con_data[112].'" /><br />';
echo 'кэширование при регистрации: <br /><input name="set126" maxlength="2" value="'.$con_data[126].'" /><br />';
echo 'Популярныe скины: <br /><input name="set128" maxlength="2" value="'.$con_data[128].'" /><br />';
echo 'Рейтинг вкладчиков: <br /><input name="set131" maxlength="2" value="'.$con_data[131].'" /><br />';

echo '<br /><input value="Изменить" type="submit" /></form><hr />';

echo '* Все настройки измеряются в часах<br />';
echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="setting.php?'.SID.'">Вернуться</a>';
}

############################################################################################
##                                  Изменение кэширования                                 ##
############################################################################################
if ($action=="editnine"){

$uid = check($_GET['uid']);

if ($uid==$_SESSION['token']){
if ($_POST['set76']!="" && $_POST['set77']!="" && $_POST['set78']!="" && $_POST['set79']!="" && $_POST['set80']!="" && $_POST['set84']!="" && $_POST['set95']!="" && $_POST['set107']!="" && $_POST['set108']!="" && $_POST['set112']!="" && $_POST['set126']!="" && $_POST['set128']!="" && $_POST['set131']!=""){

change_setting(array(76=>(int)$_POST['set76'], 77=>(int)$_POST['set77'], 78=>(int)$_POST['set78'], 79=>(int)$_POST['set79'], 80=>(int)$_POST['set80'], 84=>(int)$_POST['set84'], 95=>(int)$_POST['set95'], 107=>(int)$_POST['set107'], 108=>(int)$_POST['set108'], 112=>(int)$_POST['set112'], 126=>(int)$_POST['set126'], 128=>(int)$_POST['set128'], 131=>(int)$_POST['set131']));

header ("Location: setting.php?isset=mp_yesset&".SID); exit;

} else {echo '<b>Ошибка изменения настроек, все поля обязательны для заполнения!</b><br />';}
} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="setting.php?action=setnine&amp;'.SID.'">Вернуться</a>';
}

############################################################################################
##                               Форма изменения безопасности                             ##
############################################################################################
//103,104,59
if ($action=="setten"){	
echo '<b>Настройки безопасности</b><br /><hr />';	
	
echo '<form method="post" action="setting.php?action=editten&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">';	

echo 'Замена смайлов в сообщениях:<br /><input name="set59" maxlength="2" value="'.$con_data[59].'" /><br />';

echo 'Включить защитную картинку: <br />Да';
if ($con_data[103]==1){
echo '<input name="set103" type="radio" value="1" checked="checked" />';} else {echo '<input name="set103" type="radio" value="1" />';} 	
echo ' &nbsp; &nbsp; ';
if ($con_data[103]==0){
echo '<input name="set103" type="radio" value="0" checked="checked" />';} else {echo '<input name="set103" type="radio" value="0" />';}
echo 'Нет<br />';

echo 'Деформация защитной картинки: <br />Да';
if ($con_data[104]==1){
echo '<input name="set104" type="radio" value="1" checked="checked" />';} else {echo '<input name="set104" type="radio" value="1" />';} 	
echo ' &nbsp; &nbsp; ';
if ($con_data[104]==0){
echo '<input name="set104" type="radio" value="0" checked="checked" />';} else {echo '<input name="set104" type="radio" value="0" />';}
echo 'Нет<br />';


echo '<br /><input value="Изменить" type="submit" /></form><hr />';

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="setting.php?'.SID.'">Вернуться</a>';
}

############################################################################################
##                               Изменение безопасности                                   ##
############################################################################################
if($action=="editten"){

$uid = check($_GET['uid']);

if ($uid==$_SESSION['token']){
if ($_POST['set59']!="" && $_POST['set103']!="" && $_POST['set104']!=""){

change_setting(array(59=>(int)$_POST['set59'], 103=>(int)$_POST['set103'], 104=>(int)$_POST['set104']));

header ("Location: setting.php?isset=mp_yesset&".SID); exit;

} else {echo '<b>Ошибка изменения настроек, все поля обязательны для заполнения!</b><br />';}
} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="setting.php?action=setten&amp;'.SID.'">Вернуться</a>';
}


############################################################################################
##                            Форма изменения стоимости и цен                             ##
############################################################################################
//114,115,119,120,121,122,123,124,125,132,133,134,135
if ($action=="seteleven"){	
echo '<b>Стоимость и цены</b><br /><hr />';	
	
echo '<form method="post" action="setting.php?action=editeleven&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">';	

echo 'Цена на покупку аватара: <br /><input name="set114" maxlength="9" value="'.$con_data[114].'" /><br />';
echo 'Цена на загрузку аватара: <br /><input name="set115" maxlength="9" value="'.$con_data[115].'" /><br />';
echo 'Кол. баллов для загрузки аватара: <br /><input name="set132" maxlength="4" value="'.$con_data[132].'" /><br />';
echo 'Размер загружаемого аватара (px): <br /><input name="set133" maxlength="3" value="'.$con_data[133].'" /><br />';
echo 'Вес загружаемого аватара (byte): <br /><input name="set134" maxlength="5" value="'.$con_data[134].'" /><br />';
echo 'Джек-пот в лотерее: <br /><input name="set119" maxlength="9" value="'.$con_data[119].'" /><br />';
echo 'Макс. ставка в игре 21-очко: <br /><input name="set120" maxlength="9" value="'.$con_data[120].'" /><br />';
echo 'Мин. сумма кредита: <br /><input name="set121" maxlength="9" value="'.$con_data[121].'" /><br />';
echo 'Макс. сумма кредита: <br /><input name="set122" maxlength="9" value="'.$con_data[122].'" /><br />';
echo 'Проценты банка за кредит: <br /><input name="set123" maxlength="9" value="'.$con_data[123].'" /><br />';
echo 'Максимальная сумма в банке: <br /><input name="set135" maxlength="10" value="'.$con_data[135].'" /><br />';
echo 'Выигрыш в игре Угадай число: <br /><input name="set124" maxlength="9" value="'.$con_data[124].'" /><br />';
echo 'Попыток в игре Угадай число: <br /><input name="set125" maxlength="9" value="'.$con_data[125].'" /><br />';

echo '<br /><input value="Изменить" type="submit" /></form><hr />';

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="setting.php?'.SID.'">Вернуться</a>';
}

############################################################################################
##                               Изменение стоимости и цен                                ##
############################################################################################
if ($action=="editeleven"){

$uid = check($_GET['uid']);

if ($uid==$_SESSION['token']){
if ($_POST['set114']!="" && $_POST['set115']!="" && $_POST['set119']!="" && $_POST['set120']!="" && $_POST['set121']!="" && $_POST['set122']!="" && $_POST['set123']!="" && $_POST['set124']!="" && $_POST['set125']!="" && $_POST['set132']!="" && $_POST['set133']!="" && $_POST['set134']!="" && $_POST['set135']!=""){

change_setting(array(114=>(int)$_POST['set114'], 115=>(int)$_POST['set115'], 119=>(int)$_POST['set119'], 120=>(int)$_POST['set120'], 121=>(int)$_POST['set121'], 122=>(int)$_POST['set122'], 123=>(int)$_POST['set123'], 124=>(int)$_POST['set124'], 125=>(int)$_POST['set125'], 132=>(int)$_POST['set132'], 133=>(int)$_POST['set133'], 134=>(int)$_POST['set134'], 135=>(int)$_POST['set135']));

header ("Location: setting.php?isset=mp_yesset&".SID); exit;

} else {echo '<b>Ошибка изменения настроек, все поля обязательны для заполнения!</b><br />';}
} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="setting.php?action=seteleven&amp;'.SID.'">Вернуться</a>';
}

echo'<br /><img src="../images/img/panel.gif" alt="image" /> <a href="index.php?'.SID.'">В админку</a><br />';
echo'<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a><br />';

} else {header ("Location: ../index.php?isset=404&".SID); exit;}

include_once ("../themes/".$config['themes']."/foot.php");
?>