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

$tpl = new Savant3();
$tpl->assign('CHARSET', $msg_charset);
$tpl->assign('TITLE', (defined('RESULTS_DATA') ? $public_header2 : $public_header).(showSurveyTitle() ? ': '.showSurveyTitle(true) : ''));
$tpl->assign('LOAD_COLOR_SCHEME', (isset($webSurvey) ? $SURVEY->loadColorScheme($webSurvey->sur_color_scheme) : $HTML->loadDefaultColorScheme()));
$tpl->display('templates/'.(defined('RESULTS_DATA') ? 'results_header' : 'header').'.tpl.php');

?>
