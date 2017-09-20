<?php
#-----------------------------------------------------#
#          ********* WAP-MOTORS *********             #
#             Made by   :  VANTUZ                     #
#               E-mail  :  visavi.net@mail.ru         #
#                 Site  :  http://pizdec.ru           #
#             WAP-Site  :  http://visavi.net          #
#                  ICQ  :  36-44-66                   #
#  Вы не имеете право вносить изменения в код скрипта #
#-----------------------------------------------------#
header("Content-type:text/html; charset=utf-8");
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru"><head>';
echo '<title>%TITLE%</title>';
echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
echo '<link rel="shortcut icon" href="/favicon.ico" />';
echo '<link rel="stylesheet" href="/themes/toonel/style.css" type="text/css" />';
echo '<link rel="alternate" type="application/rss+xml" title="RSS News" href="/news/rss.php" />';
echo '<meta name="keywords" content="%KEYWORDS%" />';
echo '<meta name="description" content="%DESCRIPTION%" />';
echo '<meta name="generator" content="Wap-Motor '.MOTOR_VERSION.'" />';
echo '</head><body>';
echo '<!--Design by Vantuz (http://pizdec.ru)-->';

echo '<table border="0" align="center" cellpadding="0" cellspacing="0" class="submenu" id="up"><tr>
<td class="t1"><a href="/index.php"><img src="/themes/toonel/logo.gif" alt="'.$config['title'].'" /></a></td>


    <td class="t2"></td>
    <td class="t3">';

if (is_user()){

    echo '<a title="Управление настройками" class="menu" href="/pages/?action=menu">Мое меню</a> | ';

} else {

     echo '<a title="Страница авторизации" class="menu" href="/pages/login.php">Вход</a> | ';

    }
    echo'<a title="Центр общения" class="menu" href="/forum/">Форум</a> |
    <a title="Гостевая комната" class="menu" href="/book/">Гостевая</a> |
    <a title="Наши новости" class="menu" href="/news/">Новости</a>';




echo'</td><td class="t4"></td>
</tr></table>';

echo '<table border="0" align="center" cellpadding="0" cellspacing="0" class="tab2">
<tr><td align="left" valign="top" class="leftop">';

echo '</td>
      <td class="bortop"></td>
      <td align="right" valign="top" class="righttop"></td>
      </tr><tr>
      <td class="left_mid">&nbsp;</td>
      <td valign="top" class="lr">';


if ($config['rekhead']==1){include_once DATADIR."datamain/reklama_head.dat";}
include_once (BASEDIR."includes/isset.php");
echo '<div>';
?>
