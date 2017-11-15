<?php

/*---------------------------------------------
  MAIAN SURVEY v1.1
  Written by David Ian Bennett
  E-Mail: N/A
  Website: www.maiansurvey.com
----------------------------------------------*/

if (!defined('INC')) {
  exit;
} 

$footer = $msg_script3.': <a href="'.($SETTINGS->cfg_afflink ? $SETTINGS->cfg_afflink : 'http://www.maiansurvey.com').'" title="'.$msg_script.' '.$msg_script2.'">'.$msg_script.' '.$msg_script2.'</a> &copy; '.(date("Y")=='2008' ? '2008' : '2008-'.date("Y")).' '.$msg_script6;

$tpl = new Savant3();
$tpl->assign('FOOTER', $footer);
$tpl->display('templates/'.(defined('RESULTS_DATA') ? 'results_footer' : 'footer').'.tpl.php');

?>
