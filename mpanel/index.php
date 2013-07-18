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

if(isset($_GET['action'])) {$action = check($_GET['action']);} else {$action = "";}

if (is_admin(array(101,102,103,105))){

echo '<img src="../images/img/menu.gif" alt="image" /> <b>Панель управления</b> ('.MOTOR_VERSION.')<br /><br />';

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if($action==""){

if (stats_version()>MOTOR_VERSION) {
echo '<img src="../images/img/custom.gif" alt="image" />  <b><a href="http://visavi.net/wap-motor/member.php"><span style="color:#ff0000">Доступна новая версия '.stats_version().'</span></a></b><br /><br />';
}

echo '<img src="../images/img/act.gif" alt="image" /> <a href="adminchat.php?'.SID.'">Админ-чат</a> ('.stats(4).')<br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="book.php?'.SID.'">Управление гостевой</a> ('.stats(0).')<br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="chat.php?'.SID.'">Управление мини-чатом</a> ('.stats(8).')<br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="forum.php?'.SID.'">Управление форумом</a> ('.stats_forum().')<br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="gallery.php?'.SID.'">Управление галереей</a> ('.stats_gallery().')<br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="board.php?'.SID.'">Управление объявлениями</a> ('.stats_board().')<br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="reklama.php?'.SID.'">Управление рекламой</a><br />';

if (is_admin(array(101,102,103))){
echo '--------------------------<br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="zaban.php?'.SID.'">Бан / Разбан</a><br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="banlist.php?'.SID.'">Список забаненых</a> ('.stats_banned().')<br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="adminlist.php?'.SID.'">Список старших</a> ('.stats_admins().')<br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="reglist.php?'.SID.'">Список ожидающих</a> ('.stats_reglist().')<br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="antimat.php?'.SID.'">Управление антиматом</a> ('.stats_antimat().')<br />';
}

if (is_admin(array(101,102))){
echo '--------------------------<br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="headlines.php?'.SID.'">Управление заголовками</a> ('.stats_headlines().')<br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="news.php?'.SID.'">Управление новостями</a> ('.stats_allnews().')<br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="votes.php?'.SID.'">Управление голосованием</a><br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="users.php?'.SID.'">Управление юзерами</a> ('.stats_users().')<br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="status.php?'.SID.'">Управление статусами</a><br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="ban.php?'.SID.'">IP-бан панель</a> ('.stats_ipbanned().')<br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="welcome.php?'.SID.'">Управление приветствием</a><br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="logfiles.php?'.SID.'">Ошибки / Автобаны</a><br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="logadmin.php?'.SID.'">Логи посещений</a><br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="phpinfo.php?'.SID.'">PHP-информация</a> ('.phpversion().')<br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="blacklist.php?'.SID.'">Черный список</a> ('.stats_blacklogin().'/'.stats_blackmail().')<br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="navigation.php?'.SID.'">Управление навигацией</a> ('.stats_navigation().')<br />';
}

if (is_admin(array(101))){
echo '--------------------------<br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="setting.php?'.SID.'">Настройки системы</a><br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="backup.php?'.SID.'">Backup-панель</a><br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="delusers.php?'.SID.'">Чистка юзеров</a><br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="subscribe.php?'.SID.'">Управление подписчиками</a><br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="systems.php?'.SID.'">Проверить систему</a><br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="checker.php?'.SID.'">Сканировать систему</a> ('.stats_checker().')<br />';

if ($log==$config['nickname']){
echo '<img src="../images/img/act.gif" alt="image" /> <a href="files.php?'.SID.'">Редактирование файлов</a><br />';
}}


//----------------------------------------------------------------------//
if (file_exists(DATADIR.'profil/'.$config['nickname'].'.prof')){

$adminprofil = reading_profil($config['nickname']);

if ($adminprofil[7]!=101){
echo '<br /><div class="b"><b><span style="color:#ff0000">Внимание!!! Профиль суперадмина не имеет достаточных прав</span></b><br />Логин который вписан в config.dat имеет уровень доступа <b>'.(int)$adminprofil[7].' - '.user_status($adminprofil[7]).'</b></div>';
}
} else {
echo '<br /><div class="b"><b><span style="color:#ff0000">Внимание!!! Отсутствует профиль суперадмина</span></b><br />Логин который вписан в config.dat <b>'.check($config['nickname']).'</b> не задействован на сайте</div>';
}

if (file_exists(BASEDIR."INSTALL.php") && $config['nickname']!=""){
echo '<br /><div class="b"><b><span style="color:#ff0000">Внимание!!! Необходимо удалить файл INSTALL.php</span></b><br />';
echo 'Удалите этот файл прямо <u><a href="index.php?action=delinstall&amp;'.SID.'">сейчас</a></u></div>';
}
}

############################################################################################
##                                     Удаление INSTALL                                   ##
############################################################################################
if($action=="delinstall"){

if (file_exists(BASEDIR."INSTALL.php")){

if (unlink (BASEDIR."INSTALL.php")){
echo '<b>Файл инсталляции успешно удален!</b><br />';
} else {
echo '<b>Ошибка, недостаточно прав для удаления, удалите файл вручную!</b><br />';
}
} else {
echo '<b>Ошибка, файл инсталляции отсутствует!</b><br />';
}
echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="index.php?'.SID.'">Вернуться</a>';
}

echo '<br /><img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a><br />';

} else {header ("Location: ../index.php?isset=404&".SID); exit;}

include_once ("../themes/".$config['themes']."/foot.php");
?>
