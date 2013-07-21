<?php
header('Content-type:text/html; charset=utf-8');
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru"><head>';
echo '<title>%TITLE%</title>';
echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
echo '<link rel="shortcut icon" href="'.$config['home'].'/favicon.ico" />';
echo '<link rel="stylesheet" href="'.$config['home'].'/themes/themez/style.css" type="text/css" />';
echo '<link rel="alternate" type="application/rss+xml" title="RSS News" href="'.$config['home'].'/news/rss.php" />';
echo '<meta name="keywords" content="%KEYWORDS%" />';
echo '<meta name="description" content="%DESCRIPTION%" />';
echo '<meta name="generator" content="Wap-Motor '.MOTOR_VERSION.'" />';
echo '</head><body>';
echo '<!--Themes by Silent-->';


echo '<table cellpadding="0" cellspacing="0"><tr><td>';
echo '<div class="a" id="up"><img src="'.$config['logotip'].'" alt="image" /><br />'.$config['logos'].' </div>';

if ($config['rekhead']==1){include_once DATADIR."datamain/reklama_head.dat";}
include_once (BASEDIR."includes/isset.php");
echo '</td></tr><tr><td class="main">';
echo '<div>';
?>
