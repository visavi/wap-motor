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

echo '<img src="../images/img/act.gif" alt="image" /> <a href="adminchat.php">Админ-чат</a> ('.stats(4).')<br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="book.php">Управление гостевой</a> ('.stats(0).')<br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="chat.php">Управление мини-чатом</a> ('.stats(8).')<br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="forum.php">Управление форумом</a> ('.stats_forum().')<br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="gallery.php">Управление галереей</a> ('.stats_gallery().')<br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="board.php">Управление объявлениями</a> ('.stats_board().')<br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="reklama.php">Управление рекламой</a><br />';

if (is_admin(array(101,102,103))){
echo '--------------------------<br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="zaban.php">Бан / Разбан</a><br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="banlist.php">Список забаненых</a> ('.stats_banned().')<br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="adminlist.php">Список старших</a> ('.stats_admins().')<br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="reglist.php">Список ожидающих</a> ('.stats_reglist().')<br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="antimat.php">Управление антиматом</a> ('.stats_antimat().')<br />';
}

if (is_admin(array(101,102))){
echo '--------------------------<br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="headlines.php">Управление заголовками</a> ('.stats_headlines().')<br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="news.php">Управление новостями</a> ('.stats_allnews().')<br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="votes.php">Управление голосованием</a><br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="users.php">Управление юзерами</a> ('.stats_users().')<br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="status.php">Управление статусами</a><br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="ban.php">IP-бан панель</a> ('.stats_ipbanned().')<br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="welcome.php">Управление приветствием</a><br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="logfiles.php">Ошибки / Автобаны</a><br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="logadmin.php">Логи посещений</a><br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="phpinfo.php">PHP-информация</a> ('.phpversion().')<br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="blacklist.php">Черный список</a> ('.stats_blacklogin().'/'.stats_blackmail().')<br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="navigation.php">Управление навигацией</a> ('.stats_navigation().')<br />';
}

if (is_admin(array(101))){
echo '--------------------------<br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="setting.php">Настройки системы</a><br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="backup.php">Backup-панель</a><br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="delusers.php">Чистка юзеров</a><br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="subscribe.php">Управление подписчиками</a><br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="systems.php">Проверить систему</a><br />';
echo '<img src="../images/img/act.gif" alt="image" /> <a href="checker.php">Сканировать систему</a> ('.stats_checker().')<br />';

if ($log==$config['nickname']){
echo '<img src="../images/img/act.gif" alt="image" /> <a href="files.php">Редактирование файлов</a><br />';
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
echo 'Удалите этот файл прямо <u><a href="index.php?action=delinstall">сейчас</a></u></div>';
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
echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="index.php">Вернуться</a>';
}

echo '<br /><img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a><br />';

} else {header ("Location: ../index.php?isset=404"); exit;}

include_once ("../themes/".$config['themes']."/foot.php");
?>
