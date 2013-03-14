<?php
echo '</div><div align="center" class="c" id="down">';

echo '<a href="'.$config['home'].'/?'.SID.'">'.$config['copy'].'</a><br />';
require_once BASEDIR."includes/counters.php";

echo '[<a href="'.$config['home'].'/?'.SID.'">HOME</a> | <a href="'.$config['home'].'/download/?'.SID.'">DOWN</a> | <a href="'.$config['home'].'/forum/?'.SID.'">FORUM</a> | <a href="'.$config['home'].'/book/?'.SID.'">GUEST</a> | <a href="'.$config['home'].'/pages/index.php?action=menu&amp;'.SID.'">MAIN</a>]<br />';

require_once BASEDIR."includes/gzip_foot.php";
echo '<!--'.MOTOR_VERSION.' version-->';
echo '</div>';

echo '</td></tr></table>';
echo '</body></html>';
ob_end_flush();
exit;
?>
