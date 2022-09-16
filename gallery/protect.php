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
require_once "../includes/captcha/CaptchaBuilder.php";
require_once "../includes/captcha/PhraseBuilder.php";
require_once "../includes/captcha/GifEncoder.php";

header('Content-Type: image/gif');

$phrase = new \Visavi\Captcha\PhraseBuilder();
$phrase = $phrase->getPhrase(5, '1234567890');

$captcha = new \Visavi\Captcha\CaptchaBuilder($phrase);
$_SESSION['protect'] = $captcha->getPhrase();

echo $captcha->render();
