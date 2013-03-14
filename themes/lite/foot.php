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
echo '</div><div id="down">';
echo '<a href="'.$config['home'].'/?'.SID.'">'.$config['copy'].'</a><br />';
require_once BASEDIR."includes/counters.php";
echo '</div><div style="text-align:center">';
require_once BASEDIR."includes/gzip_foot.php";
echo '<!--'.MOTOR_VERSION.' version-->';
echo '</div></div></body></html>';
ob_end_flush();
exit;
?>
