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

sleep(1); 
if (isset($_POST['login'])) {$login = check($_POST['login']);} else {$login = check($_GET['login']);}
if (isset($_POST['pass'])) {$pass = check($_POST['pass']);} else {$pass = check($_GET['pass']);}
if (isset($_POST['cookietrue'])) {$cookietrue = (int)$_POST['cookietrue'];} else {$cookietrue = (int)$_GET['cookietrue'];}
if (isset($_GET['action'])) {$action = check($_GET['action']);} else {$action = "";}

############################################################################################
##                                       Авторизация                                      ##
############################################################################################
if ($action==""){
if (preg_match('|^[a-z0-9\-]+$|i',$login) && preg_match('|^[a-z0-9\-]+$|i',$pass)){
if (file_exists(DATADIR."profil/$login.prof")){

/* АПГРЕЙД из 18 в 19 версию */
include_once ("includes/upgrade_pass_19ver.php");
/* АПГРЕЙД из 18 в 19 версию */

$inform = file_get_contents(DATADIR."profil/$login.prof"); 
$info = explode(":||:",$inform);

if ($login==$info[0] && md5(md5($pass))==$info[1]) {

if ($cookietrue==1){
	
$apar = xoft_encode($pass,$config['keypass']);
$alog = xoft_encode($login,$config['keypass']);

setcookie("cookpar", $apar, time()+3600*24*365);
setcookie("cooklog", $alog, time()+3600*24*365);
}
setcookie("cookname", $login, time()+3600*24*365);

$pr_ip = explode(".",$ip_addr);
$my_ip = $pr_ip[0].$pr_ip[1].$pr_ip[2];

$_SESSION['log'] = $login;
$_SESSION['par'] = $pass;
$_SESSION['my_ip'] = $my_ip;

change_profil($login, array(11=>$info[11]+1, 14=>$ip, 25=>1, 44=>SITETIME));

header ("Location: index.php?".SID); exit; 
}}}
header ("Location: pages/login.php?isset=inputoff"); exit; 
}

############################################################################################
##                                           Выход                                        ##
############################################################################################
if ($action=="exit"){

if (is_user()) {
change_profil($log, array(25=>0));
}

unset($_SESSION['log']);
unset($_SESSION['par']);	
setcookie('cookpar', '');
setcookie('cooklog', '');
session_unset();
setcookie(session_name(), '');
session_destroy();
header ("Location: index.php?isset=exit"); exit;
}

?>