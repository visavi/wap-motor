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
if (!defined("BASEDIR")) { header("Location:../index.php"); exit; }

if ($config['navigation']>0){include_once (BASEDIR."includes/navigation.php");}

if ($config['rekfoot']==1){include_once (DATADIR."datamain/reklama_foot.dat");}

if (!empty($support_gzip) || !empty($support_deflate)) {
	$contents = ob_get_contents();
	$gzip_file = strlen($contents);

	if ($support_gzip) {
		$gzip_file_out = strlen(compress_output_gzip($contents));
	} else {
		if ($support_deflate) {
			$gzip_file_out = strlen(compress_output_deflate($contents));
		} else {
			$gzip_file_out = strlen($contents);
		}
	}

	$compression = round(100 - (100 / ($gzip_file / $gzip_file_out)), 1);
	if ($compression > 0 && $compression < 100){
		echo 'Cжатие: '.$compression.'%<br />';
	}

} else {
	$gzip_file = ob_get_length();
	$gzip_file_out = $gzip_file;
}

//---------------------- Установка сессионных переменных -----------------------//
if (isset($_SESSION['note'])) {
	unset($_SESSION['note']);
}

if(empty($_SESSION['traffic'])){$_SESSION['traffic'] = 0;}
if(empty($_SESSION['traffic2'])){$_SESSION['traffic2'] = 0;}
if(empty($_SESSION['counton'])){$_SESSION['counton'] = 0;}

$_SESSION['traffic'] = $_SESSION['traffic'] + $gzip_file_out;
$_SESSION['traffic2'] = $_SESSION['traffic2'] + $gzip_file;
$_SESSION['counton']++;

if ($config['generics']==1) {
echo round(microtime(1)-$starttime, 4).' сек.<br />';
}
?>
