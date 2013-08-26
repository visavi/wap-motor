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
echo '</div>

</td><td class="right_mid">&nbsp;</td></tr>
  <tr>
    <td align="left" valign="top" class="lefbot"></td>
    <td class="borbottom"></td>
    <td align="right" valign="top" class="rightbot"></td>
  </tr>
</table>';


echo '<table width="620" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="120" valign="top" class="fottopleft"></td>
    <td class="ftop"></td>
    <td width="120" valign="top" class="fottopright"></td>
  </tr>
  <tr>
    <td colspan="3" class="ftexttd">';


echo '<div style="text-align:center">';
require_once BASEDIR."includes/counters.php";
echo '</div>';

echo '</td>
  </tr>
  <tr>


    <td valign="top" class="footer_left"></td>


    <td align="center" valign="top" class="fbottom">';

    	echo '<div style="text-align:center"><a href="/index.php?'.SID.'">'.$config['copy'].'</a></div>';

    	echo '</td>
    <td valign="top" class="footer_right"></td>
  </tr>
</table>';


echo '<div style="text-align:center" id="down">';

require_once BASEDIR."includes/gzip_foot.php";

echo '</div>';

echo '<!--'.MOTOR_VERSION.' version-->';
echo '</body></html>';
ob_end_flush();
exit;
?>
