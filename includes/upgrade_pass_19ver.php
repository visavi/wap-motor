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
if (!defined('BASEDIR')) { header("Location:../index.php"); exit; }

/* этот файл служит для автоматического изменения пароля на двойной md5() файл подключается в input.php */

$inform = file_get_contents(DATADIR."profil/$login.prof"); 
$info = explode(":||:",$inform);

if ($login!=$info[0] || md5(md5($pass))!=$info[1]) {

if ($login==$info[0] && md5($pass)==$info[1]) {

//------------------------------ Запись в профиль ----------------------------//
$ufile = file_get_contents(DATADIR."profil/$login.prof"); 
$udata = explode(":||:",$ufile);

$udata[1] = md5(md5($pass));

$utext="";
for ($u=0; $u<$config['userprofkey']; $u++){
$utext.=$udata[$u].':||:';}

if($udata[0]!="" && $udata[1]!="" && $udata[4]!="" && $utext!=""){
$fp=fopen(DATADIR."profil/$login.prof","a+");    
flock($fp,LOCK_EX);           
ftruncate($fp,0);                                                                
fputs($fp,$utext);
fflush($fp);
flock($fp,LOCK_UN);
fclose($fp); 
unset($utext); 
}


}}
?>