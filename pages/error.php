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
require_once "../includes/start.php";
require_once "../includes/functions.php";
require_once "../includes/header.php";

if (isset($_GET['error'])){
if ($_GET['error']==403 || $_GET['error']==404){

$error = (int)$_GET['error'];
$write = '|'.$request_uri.'|'.SITETIME.'|'.$http_referer.'|'.$username.'|'.$brow.'|'.$ip.'|';

if ($error==403){
write_files(DATADIR."datalog/error403.dat", "$write\r\n", 0, 0666);

$countstr = counter_string(DATADIR."datalog/error403.dat");
if ($countstr>=$config['maxlogdat']) {
delete_lines(DATADIR."datalog/error403.dat",array(0,1));
}}

if ($error==404){
write_files(DATADIR."datalog/error404.dat", "$write\r\n", 0, 0666);

$countstr = counter_string(DATADIR."datalog/error404.dat");
if ($countstr>=$config['maxlogdat']) {
delete_lines(DATADIR."datalog/error404.dat",array(0,1));
}}

header ("Location: ".$config['home']."/index.php?isset=".$error.""); exit;
}}

header ("Location: ".$config['home']."/index.php?isset=404"); exit;

?>
