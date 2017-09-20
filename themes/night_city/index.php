<?php
#-----------------------------------------------------#
#     ******* night_city  for Wap-Motor 19.0 ******   #
#             Made by   :  dekameron                  #
#               E-mail  :  dekameron.if@gmail.com     #
#                 Site  :  http://mobilni.h2m.ru      #
#                  ICQ  :  490900396                  #
#                 Банка :  WM397061295941             #
#                          R392966157285              #
#                          Z413162534324              #
#-----------------------------------------------------#
header("Content-type:text/html; charset=utf-8");
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru"><head>';
echo '<title>%TITLE%</title>';
echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
echo '<link rel="shortcut icon" href="/themes/night_city/site/favicon.ico" />';
echo '<link rel="stylesheet" href="/themes/night_city/night_city.css" type="text/css" />';
echo '<link rel="alternate" type="application/rss+xml" title="RSS News" href="/news/rss.php" />';
echo '<meta name="keywords" content="%KEYWORDS%" />';
echo '<meta name="description" content="%DESCRIPTION%" />';
echo '<meta name="generator" content="Wap-Motor '.MOTOR_VERSION.'" />';
echo '</head><body>';
echo '<!--Themes by dekameron-->';

function amendment($myhtml) {
$myhtml = str_replace('images/img/act1.gif','themes/night_city/img/act.png',$myhtml);
$myhtml = str_replace('images/img/act2.gif','themes/night_city/img/act.png',$myhtml);
$myhtml = str_replace('images/img/act3.gif','themes/night_city/img/act.png',$myhtml);
$myhtml = str_replace('images/img/act.gif','themes/night_city/img/act.png',$myhtml);
$myhtml = str_replace('images/img/homepage.gif','themes/night_city/img/act.png',$myhtml);
$myhtml = str_replace('images/img/act_home.gif','themes/night_city/img/act.png',$myhtml);
$myhtml = str_replace('images/img/back.gif','themes/night_city/img/act.png',$myhtml);
$myhtml = str_replace('images/img/reload.gif','themes/night_city/img/act.png',$myhtml);
$myhtml = str_replace('images/img/exit.gif','themes/night_city/img/act.png',$myhtml);
$myhtml = str_replace('images/img/chel.gif','themes/night_city/img/chel.png',$myhtml);
$myhtml = str_replace('images/img/rss.gif','themes/night_city/img/act.png',$myhtml);
$myhtml = str_replace('images/img/panel.gif','themes/night_city/img/act.png',$myhtml);
$myhtml = str_replace('images/img/mail.gif','themes/night_city/img/act.png',$myhtml);
$myhtml = str_replace('images/img/mail2.gif','themes/night_city/img/act.png',$myhtml);
$myhtml = str_replace('images/img/error.gif','themes/night_city/img/act.png',$myhtml);
$myhtml = str_replace('images/img/zip.gif','themes/night_city/img/file.png',$myhtml);
$myhtml = str_replace('images/img/download.gif','themes/night_city/img/downl.png',$myhtml);
$myhtml = str_replace('images/img/stat.gif','themes/night_city/img/act.png',$myhtml);
$myhtml = str_replace('images/img/many.gif','themes/night_city/img/act.png',$myhtml);
$myhtml = str_replace('images/img/person.gif','themes/night_city/img/act.png',$myhtml);
$myhtml = str_replace('images/img/partners.gif','themes/night_city/img/partn.png',$myhtml);
$myhtml = str_replace('images/img/profiles.gif','themes/night_city/img/partn.png',$myhtml);
$myhtml = str_replace('images/img/down.gif','themes/night_city/img/partn.png',$myhtml);
$myhtml = str_replace('images/img/menu.gif','themes/night_city/img/partn.png',$myhtml);
$myhtml = str_replace('images/img/mails.gif','themes/night_city/img/partn.png',$myhtml);
$myhtml = str_replace('images/img/search.gif','themes/night_city/img/act.png',$myhtml);
$myhtml = str_replace('images/img/motors.gif','themes/night_city/img/partn.png',$myhtml);
$myhtml = str_replace('images/img/online.gif','themes/night_city/img/act.png',$myhtml);
$myhtml = str_replace('images/img/faq.gif','themes/night_city/img/act.png',$myhtml);
$myhtml = str_replace('images/img/forums.gif','themes/night_city/img/file.png',$myhtml);
$myhtml = str_replace('images/img/files.gif','themes/night_city/img/files.png',$myhtml);
$myhtml = str_replace('images/img/dir.gif','themes/night_city/img/dir.png',$myhtml);
$myhtml = str_replace('images/img/opendir.gif','themes/night_city/img/dir.png',$myhtml);
$myhtml = str_replace('images/img/top20_dir.gif','themes/night_city/img/dir.png',$myhtml);
$myhtml = str_replace('images/img/new_dir.gif','themes/night_city/img/dir.png',$myhtml);
$myhtml = str_replace('images/img/new.gif','themes/night_city/img/act.png',$myhtml);
$myhtml = str_replace('images/img/new1.gif','themes/night_city/img/act.png',$myhtml);
$myhtml = str_replace('images/img/new2.gif','themes/night_city/img/act.png',$myhtml);
$myhtml = str_replace('images/img/new3.gif','themes/night_city/img/act.png',$myhtml);
$myhtml = str_replace('images/img/rating0.gif','themes/night_city/img/rating0.png',$myhtml);
$myhtml = str_replace('images/img/rating1.gif','themes/night_city/img/rating1.png',$myhtml);
$myhtml = str_replace('images/img/rating2.gif','themes/night_city/img/rating2.png',$myhtml);
$myhtml = str_replace('images/img/rating3.gif','themes/night_city/img/rating3.png',$myhtml);
$myhtml = str_replace('images/img/rating4.gif','themes/night_city/img/rating4.png',$myhtml);
$myhtml = str_replace('images/img/rating5.gif','themes/night_city/img/rating5.png',$myhtml);
$myhtml = str_replace('images/img/rating6.gif','themes/night_city/img/rating6.png',$myhtml);
$myhtml = str_replace('images/img/rating7.gif','themes/night_city/img/rating7.png',$myhtml);
$myhtml = str_replace('images/img/rating8.gif','themes/night_city/img/rating8.png',$myhtml);
$myhtml = str_replace('images/img/rating9.gif','themes/night_city/img/rating9.png',$myhtml);
$myhtml = str_replace('images/img/rating10.gif','themes/night_city/img/rating10.png',$myhtml);
$myhtml = str_replace('images/img/anonim.gif','themes/night_city/img/anonim.png',$myhtml);
$myhtml = str_replace('images/img/security.gif','themes/night_city/img/security.png',$myhtml);
$myhtml = str_replace('images/img/women.gif','themes/night_city/img/women.png',$myhtml);
return $myhtml; }
ob_start('amendment');

echo '<table cellpadding="0" cellspacing="0"><tr><td>';
echo '<div class="a" id="up"><br /><a href="/index.php"><img src="/themes/night_city/site/logo.png" alt="'.$config['title'].'" /></a><br /><br />'.$config['logos'].'<br /><br /></div>';

if($config['rekhead']==1){include_once DATADIR."datamain/reklama_head.dat";}
include_once (BASEDIR."includes/isset.php");
echo'</td></tr><tr><td class="main">';
echo '<div>';
?>
