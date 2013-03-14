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
require_once ("includes/start.php");
require_once ("includes/functions.php");
require_once ("includes/header.php");
include_once ("themes/".$config['themes']."/index.php");

if (isset($_GET['action'])) {$action = check($_GET['action']);} else {$action = "";}

if(!file_exists(DATADIR.'profil/'.$config['nickname'].'.prof')){

############################################################################################
##                                         Шаг первый                                     ##
############################################################################################
if ($action=="") {

show_title('partners.gif', 'ШАГ ПЕРВЫЙ - ПРИНЯТИЕ СОГЛАШЕНИЯ');

echo '<big><b>Пользовательское соглашение</b></big><br />';

$agreement = 'Пользовательское соглашение на использование скриптов, распространяемых cайтом VISAVI.NET. 

Действие данного пользовательского соглашения распространяется на все скрипты или иные разработки сайта VISAVI.NET.
Все скрипты относящиеся к бесплатным версиям могут распространяться только на условиях данного пользовательского соглашения.

Настоящее пользовательское соглашение адресовано Вам и заключается с Вами.

Данное пользовательское соглашение распространяется только на изготовление копий, распространение и модификацию
исключительно бесплатных версий скриптов Скрипта. Иные виды
действий над скриптом выходят за рамки данного пользовательского соглашения

1. Разрешается делать копии и распространять точные копии исходных кодов
скрипта в том виде, в каком Вы их получили, на любом носителе
при условии, что каждую копию Вы снабжаете упоминаниями об авторском праве
и отказом от гарантий; сохраняете без изменений все, относящееся к данному
пользовательскому соглашению и отсутствию каких-либо гарантий, и передаете всем
сторонним получателям Скрипта копию данного пользовательского
соглашения вместе со скрипт. 

2. В свою копию Скрипта и в любую его часть Вы можете
вносить изменения, создавая, таким образом, разработку на основе
Скрипта, и делать копии и распространять эти модификации
или разработки на условиях, перечисленных выше, в разделе 1, в том случае,
если будут соблюдены также следующие условия:

2.1 вы обязаны в точности указать, какие файлы были изменены, что именно
было изменено, и проставить дату внесения изменений.

2.2 любые распространяемые или публикуемые вами разработки, которые
включают в себя целиком Скрипт или какие-либо его части,
сделанные на основе Скрипта или каких-либо его частей,
Вы должны в обязательном порядке согласовывать с нами на условиях данного
пользовательского соглашения. 

3. Вы не обязаны принимать условия данного пользовательского соглашения,
поскольку вы не подписывали его. Однако ничто иное не дает вам позволения
изменять или распространять Скрипт или созданные на его
основе разработки. В этом случае подобные действия запрещены действующим
законодательством, если вы не приняли условия данного соглашения.';

echo '<form action="INSTALL.php?action=check&amp;'.SID.'" method="post">';
echo '<textarea cols="100" rows="20" name="msg">'.$agreement.'</textarea><br /><br />';
echo '<a href="help/LICENSE.html">Полный текст пользовательского соглашения</a><br /><br />';
echo '<input name="agree" type="checkbox" value="1" /> <b>Я ПРИНИМАЮ УСЛОВИЯ СОГЛАШЕНИЯ И ГОТОВ ПРИСТУПИТЬ К УСТАНОВКЕ</b><br /><br />';
echo '<input type="submit" value="Продолжить" /></form><hr />';

}

############################################################################################
##                                         Шаг второй                                     ##
############################################################################################
if ($action=="check"){

if (isset($_POST['agree'])) {$agree = check($_POST['agree']);} else {$agree = 0;}

if ($agree==1){

show_title('partners.gif', 'ШАГ ВТОРОЙ - ПРОВЕРКА СИСТЕМЫ');

if (file_exists(DATADIR.'profil') && file_exists(DATADIR.'config.dat')){
if (is_writeable(DATADIR.'profil') && is_writeable(DATADIR.'config.dat')){

if (substr(dirname($php_self),1)!=""){
echo '<img src="images/img/custom.gif" alt="image" /> <span style="color:#ff0000"><b>Внимание!</b><br />Вы пытаетесь установить движок в директорию <b>'.substr(dirname($php_self),1).'</b>, она не является корневой директорией, в этом случае корректная работа движка не гарантируется.<br />Правильным выходом из этой ситуации будет создание поддомена <b>'.substr(dirname($php_self),1).'.'.$config['servername'].'</b> и установка движка в него</span><br /><br />';
}

$dires = array();
$files = array();

$dir = opendir (DATADIR); 
while ($file = readdir ($dir)) {

if ($file!='.' && $file!='..' && $file!='license.key' && $file!='.htaccess'){

if (is_dir(DATADIR.$file)){
$dires[] = $file;
} else {
$files[] = $file;
}}}
closedir ($dir); 

echo'<b>Готовность файлов</b><br /><br />';

if (file(DATADIR.".htaccess")){
echo 'Файл .htaccess задействован<br />';

if (is_writeable(DATADIR.".htaccess")){
echo '<b><span style="color:#ff0000">Внимание! На файл .htaccess не рекомедуется ставить права разрешающие запись</span></b><br />';
echo 'Установите обычные права (CHMOD) не позволяющие менять содержимое файла (обычно 644)<br /><br />';
}

} else {
echo '<b><span style="color:#ff0000">Внимание!!! Файл .htaccess отсутствует, в данном случае безопасность не гарантируется</span></b><br />';
echo 'Если ваш сервер не поддерживает htaccess, рекомендуем сменить сервер, т.к. из-за отсутствия этого файла становятся доступные для злоумышленников системные, конфигурационные файлы, профили и письма пользователей<br /><br />';
}

foreach ($files as $value){
echo 'Файл '.DATADIR.$value.' - '; 

if (is_writeable(DATADIR.$value)){ 
echo '<span style="color:#00ff00">Готов</span>'; 
} else { 
echo '<span style="color:#ff0000">Не готов</span>'; 
}

echo ' ('.permissions(DATADIR.$value).')<br />';
} 


echo'<br /><hr /><b>Готовность директорий</b><br /><br />';

foreach ($dires as $value){
echo 'Директория '.DATADIR.$value.' - '; 

if (is_writeable(DATADIR.$value)) {
echo '<span style="color:#00ff00">Готова</span>';
} else {
echo '<span style="color:#ff0000">Не готова</span>'; 
}

echo ' ('.permissions(DATADIR.$value).')<br />';
} 


echo '<br />Самые важные файлы готовы к работе<br />';
echo 'Вы можете приступить к установке портала<br /><br />'; 

echo '<img src="images/img/reload.gif" alt="image" /> <b><a href="INSTALL.php?action=upd&amp;'.SID.'">ПРИСТУПИТЬ К УСТАНОВКЕ</a></b><br /><br />';
echo 'Если какой-то пункт выделен красным, необходимо зайти по фтп и выставить CHMOD разрешающую запись<br />';

} else {
echo '<b><span style="color:#ff0000">Ошибка! Самые важные файлы НЕ готовы к работе</span></b><br />';
echo 'Обратите внимание на директорию '.DATADIR.'profil и файл '.DATADIR.'config.dat<br />';
echo 'Вы НЕ можете приступить к установке портала<br />Вам необходимо выставить правильные атрибуты CHMOD, подробнее читайте в help/README.html<br />';
}

} else {
echo '<b><span style="color:#ff0000">Ошибка! Отсутствуют необходимые для работы файлы</span></b><br />';
echo 'Обратите внимание на директорию '.DATADIR.'profil и файл '.DATADIR.'config.dat<br />';
echo 'Проверьте все ли файлы вы извлекли из архива с движком<br />';
}

} else {
echo '<img src="images/img/partners.gif" alt="image" /> <b>ОТКАЗ ПРИНЯТИЯ УСЛОВИЙ СОГЛАШЕНИЯ</b><br /><br />';
echo 'Вы не можете продолжить установку движка так как отказываетесь принимать условия соглашения<br />';
echo 'Любое использование нашего движка означает ваше согласие с нашим соглашением<br />';
}

echo '<br /><img src="'.BASEDIR.'images/img/back.gif" alt="image" /> <a href="INSTALL.php?'.SID.'">Вернуться</a>';
}


############################################################################################
##                                         Шаг третий                                     ##
############################################################################################
if ($action=="upd"){

show_title('partners.gif', 'ШАГ ТРЕТИЙ - ИНСТАЛЛЯЦИЯ');

echo 'Прежде чем перейти к администрированию вашего сайта, необходимо пройти процесс инсталляции.<br />';
echo 'Эта процедура сама создаст аккаунт администратора и пропишет ваши данные.<br />';
echo 'Перед тем как нажимать кнопку Пуск, убедитесь, что на всех файлах и папках в директории '.DATADIR.' стоят права доступа, разрешающие в нее запись 777 для папок и 666 для файлов, иначе процесс не сможет быть завершен удачно.<br />';
echo 'После окончания инсталляции необходимо удалить файл INSTALL.php навсегда, пароль и остальные данные вы сможете поменять в своем профиле<br /><br /><hr />';
echo 'Внимание, только знаки латинского алфавита, цифры и знак тире<br />';	

echo '<form method="post" action="INSTALL.php?action=install&amp;'.SID.'">';
echo 'Логин (max20) *<br />';
echo '<input name="name" maxlength="20" /><br />';
echo 'Пароль(max20) *<br />';
echo '<input name="password" type="password" maxlength="20" /><br />';
echo 'Повторите пароль *<br />';
echo '<input name="password2" type="password" maxlength="20" /><br />';
echo 'Ваш e-mail *<br />';
echo '<input name="oemails" maxlength="100" /><br />';
echo 'Адрес сайта *<br />';
echo '<input name="osite" value="http://'.$config['servername'].'" maxlength="100" /><br /><br />';
echo '<input value="Пуск" type="submit" /></form><hr />';

echo 'Все поля обязательны для заполнения<br />E-mail будет нужен для восстановления пароля, пишите только свои данные<br />Не нажимайте кнопку дважды, подождите до тех пор, пока процесс не завершится<br />';
echo 'В поле ввода адреса сайта необходимо ввести адрес в который у вас распакован движок, если это поддомен или папка, то необходимо указать ее, к примеру http://wap.visavi.net<br />';
echo 'Пароль необходимо выбирать посложнее, лучше всего состоящий из цифр, маленьких и больших латинских символов одновременно, длинее 5 символов<br />';

echo '<br /><img src="'.BASEDIR.'images/img/back.gif" alt="image" /> <a href="INSTALL.php?action=check&amp;'.SID.'">Вернуться</a>';
}

############################################################################################
##                                        Шаг четвертый                                   ##
############################################################################################
if ($action=="install"){

show_title('partners.gif', 'ШАГ ЧЕТВЕРТЫЙ - РЕЗУЛЬТАТ УСТАНОВКИ');

$name = check($_POST['name']);
$password = check($_POST['password']);
$password2 = check($_POST['password2']);
$oemails = strtolower(check($_POST['oemails']));
$osite = strtolower(check($_POST['osite']));


if (strlen($name)<=20 && strlen($password)<=20){
if (strlen($name)>=3 && strlen($password)>=3){
if (preg_match('|^[a-z0-9\-]+$|i',$name)){
if (preg_match('|^[a-z0-9\-]+$|i',$password)){
if ($password==$password2){ 
if (preg_match('#^([a-z0-9_\-\.])+\@([a-z0-9_\-\.])+(\.([a-z0-9])+)+$#',$oemails)){
if (preg_match('#^http://([a-z0-9_\-\.])+(\.([a-z0-9\/])+)+$#',$osite)){


$text = $name.':||:'.md5(md5($password)).':||::||:Администратор  сайта:||:'.$oemails.':||::||:'.SITETIME.':||:101:||:0:||:0:||:1:||:0:||:0:||:'.$brow.':||:'.$ip.':||:N:||::||::||::||::||:'.$config['themes'].':||:'.$config['bookpost'].':||:'.$config['postnews'].':||:'.$config['forumpost'].':||:'.$config['forumtem'].':||::||:'.$config['chatpost'].':||::||:'.$config['boardspost'].':||::||:'.$config['timeclocks'].':||:'.$config['showtime'].':||:'.$config['privatpost'].':||:0:||::||::||:500:||:0:||:0:||::||:Администратор  сайта:||:100000:||:1:||:images/avators/noavatar.gif:||:'.SITETIME.':||:1:||::||::||:0:||:0:||:0:||:0:||::||::||:0:||:0:||:0:||:0:||:0:||:50:||::||::||::||::||:0:||::||:0:||::||::||::||::||::||::||:0:||:0:||::||::||::||:';

write_files(DATADIR."profil/$name.prof", $text, 0, 0666);

$textpriv = 'Vantuz|Привет, '.$name.'! Спасибо за установку нашего портала WAP-MOTOR ver. '.MOTOR_VERSION.', новые версии, апгрейды, плагины, а также множество других дополнений вы найдете на нашем сайте http://VISAVI.NET. Не забудьте удалить файл INSTALL.php сделать это можно прямо из админ-панели|'.SITETIME.'|';      

write_files(DATADIR."privat/$name.priv", "$textpriv\r\n", 0, 0666);

write_files(DATADIR."datatmp/reguser.dat", strtolower($name).'|'.$oemails."||\r\n", 0, 0666);

$textnews = 'Супер новость!|Ура! Мы установили новый движок для сайта WAP-MOTOR PORTAL ver. '.MOTOR_VERSION.'! Скачать этот движок вы можете с официального сайта http://visavi.net||'.SITETIME.'|'.$name.'|1|';

write_files(DATADIR."news.dat", "$textnews\r\n", 0, 0666);


$ufile = file_get_contents(DATADIR."config.dat"); 
$data = explode("|",$ufile);

$data[1] = generate_password();
$data[8] = $name;
$data[9] = $oemails;
$data[14] = $osite;
$data[15] = "$osite/images/img/wap-motor.gif";

$utext = "";
for ($u=0; $u<$config['configkeys']; $u++){
$utext.=$data[$u].'|';}

if($data[8]!="" && $data[9]!="" && $utext!=""){
$fp=fopen(DATADIR."config.dat","a+");    
flock($fp,LOCK_EX);           
ftruncate($fp,0);                                                                
fputs($fp,$utext);
fflush($fp);
flock($fp,LOCK_UN);
fclose($fp);  
unset($utext); 
}

echo 'ПОЗДРАВЛЯЕМ, ваш пароль и логин созданы,теперь вы можете войти под своим аккаунтом на сайт, если все прошло удачно на главной страничке вы должны увидеть ссылку АДМИНКА, она будет показываться только вам, также НЕОБХОДИМО удалить файл INSTALL.php<br /><br /><br />УДАЛИТЕ INSTALL.php НЕ СТОИТ ДЕРЖАТЬ ЕГО НА САЙТЕ<br /><br />';

echo'<img src="images/img/reload.gif" alt="image" /> <b><a href="input.php?login='.$name.'&amp;pass='.$password.'&amp;cookietrue=1&amp;'.SID.'">Войти на сайт</a></b>';

} else {show_error('Неправильный адрес сайта, необходим формата http://my_site.domen');}
} else {show_error('Неправильный адрес e-mail, необходим формат name@site.domen');}
} else {show_error('Ошибка! Веденные пароли отличаются друг от друга!');}
} else {show_error('Недопустимые символы в пароле. Разрешены только знаки латинского алфавита и цифры!');}
} else {show_error('Недопустимые символы в логине. Разрешены только знаки латинского алфавита и цифры!');}
} else {show_error('Ошибка! Слишком короткий логин или пароль (От 3 до 20 символов)');}
} else {show_error('Ошибка! Слишком длинный логин или пароль (От 3 до 20 символов)');}

echo '<br /><img src="'.BASEDIR.'images/img/back.gif" alt="image" /> <a href="INSTALL.php?action=upd&amp;'.SID.'">Вернуться</a>';
} 

############################################################################################
##                                  Удаление автоинсталятора                              ##
############################################################################################
if ($action=="installer"){

if (file_exists("INSTALLER.php")) {unlink("INSTALLER.php");}
if (file_exists("last_version.txt")) {unlink("last_version.txt");}

$globfiles = glob("motor*.zip");
foreach ($globfiles as $filename) {
unlink(basename($filename));
}

header ("Location: INSTALL.php"); exit;
}


} else {
echo '<br /><img src="images/img/antihacking.gif" alt="image" /> <b><span style="color:#ff0000">Ошибка инсталляции!</span></b><br />';
echo 'Вы не сможете установить портал. Профиль администратора уже создан<br />';
echo 'Если вы хотите сбросить пароль, то вам необходимо вручную удалить файл '.DATADIR.'profil/логин_админа.prof<br />';}

echo '<br /><img src="'.BASEDIR.'images/img/homepage.gif" alt="image" /> <a href="'.BASEDIR.'index.php?'.SID.'">На главную</a><br />';

include_once ("themes/".$config['themes']."/foot.php");
?>
