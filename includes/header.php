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
if (!defined('BASEDIR')) { header('Location:../index.php'); exit; }

if (isset($_SERVER['PHP_SELF'])) {$php_self = check(substr($_SERVER['PHP_SELF'],1));}
if (isset($_SERVER['REQUEST_URI'])) {$request_uri = check(urldecode(substr(strtok($_SERVER['REQUEST_URI'],'S'),1)));} else {$request_uri = 'index.php';}
if (isset($_SERVER['HTTP_REFERER'])) {$http_referer = check(urldecode(strtok($_SERVER['HTTP_REFERER'],'S')));} else {$http_referer = 'Не определено';}
if (empty($_SESSION['log'])) {$username = $config['guestsuser'];} else {$username = $_SESSION['log'];}

if (empty($_SESSION['user_brow'])) {
	$_SESSION['user_brow'] = get_user_agent();
}

$brow = $_SESSION['user_brow'];

############################################################################################
##                            Сжатие и буферизация данныx                                 ##
############################################################################################
if (!empty($config['gzip']) && extension_loaded('zlib') && ini_get('zlib.output_compression') != 'On' && ini_get('output_handler') != 'ob_gzhandler' && ini_get('output_handler') != 'zlib.output_compression') {
	if (isset($_SERVER['HTTP_ACCEPT_ENCODING'])) {
		$gzencode = $_SERVER['HTTP_ACCEPT_ENCODING'];
	} elseif (isset($_SERVER['HTTP_TE'])) {
		$gzencode = $_SERVER['HTTP_TE'];
	} else {
		$gzencode = false;
	}

	$support_gzip = (strpos($gzencode, 'gzip') !== false);
	$support_deflate = (strpos($gzencode, 'deflate') !== false);

	if ($support_gzip) {
		header("Content-Encoding: gzip");
		ob_start("compress_output_gzip");
	} elseif ($support_deflate) {
		header("Content-Encoding: deflate");
		ob_start("compress_output_deflate");
	}
}

############################################################################################
##                                 Счетчик запросов                                       ##
############################################################################################
$dosfiles = glob(DATADIR.'datados/*.dat');
foreach ($dosfiles as $filename) {
$file_array_filemtime = filemtime($filename);
if ($file_array_filemtime < (time() - 60)) {
unlink($filename);
}}
//-------------------------- Проверка на время -----------------------------//
if (file_exists(DATADIR.'datados/'.$ip_addr.'.dat')){
$file_dos_time = file(DATADIR.'datados/'.$ip_addr.'.dat');
$file_dos_str = explode('|', $file_dos_time[0]);
if ($file_dos_str[1] < (time() - 60)) {
unlink(DATADIR.'datados/'.$ip_addr.'.dat');
}}

//------------------------------ Запись логов -------------------------------//
$write = '|'.time().'|'.$brow.'|'.$http_referer.'|'.$request_uri.'|'.$username.'|';
write_files(DATADIR.'datados/'.$ip_addr.'.dat', $write."\r\n", 0, 0666);

//----------------------- Автоматическая блокировка ------------------------//
if ($config['doslimit']>0 && counter_string(DATADIR.'datados/'.$ip_addr.'.dat') > $config['doslimit']) {

unlink(DATADIR.'datados/'.$ip_addr.'.dat');

//-------------------------- Запись IP в базу --------------------------------//
$string = search_string(DATADIR.'ban.dat', $ip_addr, 1);
if (empty($string)) {

$write = no_br('|'.$request_uri.'|'.SITETIME.'|'.$http_referer.'|'.$username.'|'.$brow.'|'.$ip_addr.'|');
write_files(DATADIR.'datalog/ban.dat', $write."\r\n", 0, 0666);
write_files(DATADIR.'ban.dat', '|'.$ip_addr.'|'.SITETIME."||\r\n");

$countstr = counter_string(DATADIR.'datalog/ban.dat');
if ($countstr>=$config['maxlogdat']) {
delete_lines(DATADIR.'datalog/ban.dat', array(0,1));
}
}}

############################################################################################
##                                 Автоматический бан                                     ##
############################################################################################
$old_ips = file(DATADIR.'ban.dat');
foreach($old_ips as $old_ip_line){
$ip_arr = explode('|', $old_ip_line);

$ip_check_matches = 0;
$ipdr_check_matches = 0;
$db_ip_split = explode('.', $ip_arr[1]);
$this_ipdr_split = explode('.', $ip_addr);

for($i_i=0;$i_i<4;$i_i++){
if ($this_ipdr_split[$i_i] == $db_ip_split[$i_i] or $db_ip_split[$i_i] == '*') {
$ipdr_check_matches += 1;}}

if ($ip_addr!=$ip){
$this_ip_split = explode('.', $ip);

for($i_i=0;$i_i<4;$i_i++){
if ($this_ip_split[$i_i] == $db_ip_split[$i_i] or $db_ip_split[$i_i] == '*') {
$ip_check_matches += 1;}}
}

if ($ipdr_check_matches == 4 || $ip_check_matches == 4) {
if (!strstr($php_self, 'pages/banip.php')){header ('Location: '.$config['home'].'/pages/banip.php');  exit;}} //бан по IP
}

############################################################################################
##                               Авторизация по cookies                                   ##
############################################################################################
if ($config['cookies']==1){
if (empty($_SESSION['log']) && empty($_SESSION['par'])) {
if (isset($_COOKIE['cooklog']) && isset($_COOKIE['cookpar']) && preg_match('|^[a-z0-9_\-]+$|i',$_COOKIE['cooklog'])){
if ($config['keypass']!=""){

$unlog = xoft_decode($_COOKIE['cooklog'],$config['keypass']);
$unpar = xoft_decode($_COOKIE['cookpar'],$config['keypass']);

if (file_exists(DATADIR.'profil/'.$unlog.'.prof')){
$checkfiles = file_get_contents(DATADIR.'profil/'.$unlog.'.prof');
$checkdata = explode(':||:', $checkfiles);

if ($unlog==$checkdata[0] && md5(md5($unpar))==$checkdata[1] && !empty($checkdata[25])) {

$pr_ip = explode('.', $ip_addr);
$my_ip = $pr_ip[0].$pr_ip[1].$pr_ip[2];

$_SESSION['log'] = $unlog;
$_SESSION['par'] = $unpar;
$_SESSION['my_ip'] = $my_ip;

change_profil($unlog, array(11=>$checkdata[11]+1, 14=>$ip, 44=>SITETIME));

}}}}}}

//-------------------------------------------------------------//
if ($_SERVER['HTTP_HOST']) {$config['servername'] = $_SERVER['HTTP_HOST'];} else {$config['servername'] = $_SERVER['SERVER_NAME'];}
if (substr($config['servername'], 0, 4)=='www.'){$config['servername'] = preg_replace('#www\.#','',$config['servername'], 1);}
if (substr($config['servername'], 0, 4)=='wap.'){$config['servername'] = preg_replace('#wap\.#','',$config['servername'], 1);}

//---------------------- Установка сессионных переменных -----------------------//
if (empty($_SESSION['counton'])) {$_SESSION['counton'] = 0;}
if (empty($_SESSION['currs'])) {$_SESSION['currs'] = SITETIME;}
if (empty($_SESSION['token'])) {$_SESSION['token'] = generate_password(6);}
if (empty($_SESSION['protect'])) {$_SESSION['protect'] = mt_rand(1000,9999);}
$_SESSION['timeon'] = maketime(SITETIME - $_SESSION['currs']);
ob_start('ob_processing');

############################################################################################
##                                     Авторизация                                        ##
############################################################################################
if (isset($_SESSION['log']) && isset($_SESSION['par']) && preg_match('|^[a-z0-9\-]+$|i',$_SESSION['log'])){
if (file_exists(DATADIR.'profil/'.$_SESSION['log'].'.prof')){
$userprof = file_get_contents(DATADIR.'profil/'.$_SESSION['log'].'.prof');
$udata = explode(':||:', $userprof);

if ($udata[0]==$_SESSION['log'] && $udata[1]==md5(md5($_SESSION['par'])) && !empty($udata[25])){

$log  = $_SESSION['log'];
$config['themes'] = check($udata[20]);          # Скин/тема по умолчанию
$config['bookpost'] = (int)$udata[21];          # Вывод сообщений в гостевой
$config['postnews'] = (int)$udata[22];          # Новостей на страницу
$config['forumpost'] = (int)$udata[23];         # Вывод сообщение в форуме
$config['forumtem'] = (int)$udata[24];          # Вывод тем в форуме
$config['chatpost'] = (int)$udata[26];          # Вывод сообщений в чате
$config['boardspost'] = (int)$udata[28];        # Выод объявлений
$config['timeclocks'] =  check($udata[30]);     # Временной сдвиг
$config['showtime'] = (int)$udata[31];          # Вывод часов и дня недели
$config['privatpost'] = (int)$udata[32];        # Вывод писем в привате


if ($udata[37]==1){
if (!strstr($php_self, 'pages/ban.php') && !strstr($php_self, 'pages/pravila.php')){
header ('Location: '.$config['home'].'/pages/ban.php?log='.$log);  exit();}}

if ($config['regkeys']>0 && $udata[46]>0){
if (!strstr($php_self, 'pages/key.php') && !strstr($php_self,'input.php')){
header ('Location: '.$config['home'].'/pages/key.php?log='.$log);  exit();}}

if (SITETIME>$udata[53] && $udata[54]>0){
if (!strstr($php_self, 'games/kredit.php')){
header ('Location: '.$config['home'].'/games/kredit.php');  exit();}}

//---------------------- функция проверки ip и браузера -----------------------//
if ($udata[66]==1){
$pr_ip = explode('.', $ip_addr);
$new_ip = $pr_ip[0].$pr_ip[1].$pr_ip[2];

if ($new_ip!=$_SESSION['my_ip']){
session_unset();
setcookie(session_name(), '');
session_destroy();
header ('Location: '.$config['home'].'/'.$request_uri); exit();
}}

if (strstr($php_self, basename(ADMINDIR))){
//------------------------ Запись текущей страницы для админов -----------------------------//
$adm_log = no_br('|'.$brow.'|'.$ip.'|'.$log.'|'.$request_uri.'|'.$http_referer.'|'.SITETIME.'|');

write_files(DATADIR.'datalog/admin.dat', $adm_log."\r\n", 0, 0666);

$admlogcount = counter_string(DATADIR.'datalog/admin.dat');
if ($admlogcount>=300) {
delete_lines(DATADIR.'datalog/admin.dat', array(0,1));
}

} else {
//------------------------ Запись текущей страницы для юзера ------------------------------//
if (file_exists(DATADIR.'who.dat')){
$wholines = file(DATADIR.'who.dat');

foreach($wholines as $whokey=>$whovalue){
$whodats = explode("|",$whovalue);
if ($log == $whodats[0]) {
unset ($wholines[$whokey]);
}}

$wholines[] = no_br($log.'|'.$php_self.'|'.$_SESSION['counton'].'|'.SITETIME.'|');

write_files(DATADIR.'who.dat', implode($wholines)."\r\n", 1);

$whocount = counter_string(DATADIR.'who.dat');
if ($whocount>=$config['lastusers']) {
delete_lines(DATADIR.'who.dat', array(0,1));
}}}

//-------------------------- Дайджест ------------------------------------//
if (file_exists(DATADIR.'datalife/'.$log.'.dat')){
$lifefile = file_get_contents(DATADIR.'datalife/'.$log.'.dat');
$lifestr = explode('|', $lifefile);

$lifetime = SITETIME - $lifestr[0];

if ($lifetime<600 && $lifetime>2) {$usertime = $lifestr[1] + $lifetime;} else {$usertime=$lifestr[1];}

$tlife = no_br(SITETIME.'|'.$usertime.'|'.$log.'|'.$php_self.'|'.$ip.'|');

if ($usertime>0 && $tlife!=""){
write_files(DATADIR.'datalife/'.$log.'.dat', $tlife, 1, 0666);
}

} else {
$tlife = no_br(SITETIME.'|0|'.$log.'|'.$php_self.'|'.$ip.'|');
write_files(DATADIR.'datalife/'.$log.'.dat', $tlife, 1, 0666);
}
//--------------------------------------------------------------//
} else {$_SESSION['log']=''; $_SESSION['par']=''; $log='';}
} else {$_SESSION['log']=''; $_SESSION['par']=''; $log='';}
} else {$_SESSION['log']=''; $_SESSION['par']=''; $log='';}

//------------------------ Отключение кеширования -----------------------------//
if ($config['nocache']==0){
Header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
Header('Cache-Control: no-cache, must-revalidate');
Header('Pragma: no-cache');
Header('Last-Modified: '.gmdate("D, d M Y H:i:s").' GMT');
}

//------------------------ Автоопределение системы -----------------------------//
include_once BASEDIR.'includes/mobile_detect.php';
$browser_detect = new Mobile_Detect();

// ------------------------ Автоопределение системы -----------------------------//
if (!empty($config['webthemes']) && empty($_SESSION['my_themes'])) {
	if (empty($_SESSION['log']) || empty($_SESSION['par']) || empty($config['themes'])) {
		if (!$browser_detect->isMobile() && !$browser_detect->isTablet()) {
			$config['themes'] = $config['webthemes'];
		}
	}
}

if (isset($_SESSION['my_themes'])){$config['themes'] = $_SESSION['my_themes'];}
if (!file_exists(BASEDIR.'themes/'.$config['themes'].'/index.php')){$config['themes'] = 'default';}
if ($config['nickname']=='' && file_exists(BASEDIR.'INSTALL.php') && !strstr($php_self, 'INSTALL.php')){header ('Location: '.BASEDIR.'INSTALL.php'); exit;}
if ($config['closedsite']==1 && !strstr($php_self, 'pages/closed.php') && !strstr($php_self,'input.php') && $log!=$config['nickname']){header ('Location: '.$config['home'].'/pages/closed.php'); exit;}
$header_title = '';

############################################################################################
##                                      Кто-откуда                                        ##
############################################################################################
if ($http_referer!='Не определено'){

$checkref = check_string($http_referer);

if ($checkref!=$config['servername']){
if (preg_match('#^([a-z0-9_\-\.])+(\.([a-z0-9\/])+)+$#', $checkref)){

$refstring = search_string(DATADIR.'referer.dat', $checkref, 0);
if ($refstring) {

$textref = no_br($checkref.'|'.($refstring[1] + 1).'|'.SITETIME.'|'.$ip.'|');
replace_lines(DATADIR.'referer.dat', $refstring['line'], $textref);

} else {
$textref = no_br($checkref.'|1|'.SITETIME.'|'.$ip.'|');
write_files(DATADIR.'referer.dat', $textref."\r\n");
}

$refcount = counter_string(DATADIR.'referer.dat');
if ($refcount>=$config['referer']) {
delete_lines(DATADIR.'referer.dat',array(0,1));
}}}}

?>
