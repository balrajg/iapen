<?php

/*---------------------------------------------
  MAIAN SURVEY v1.1
  Written by David Ian Bennett
  E-Mail: N/A
  Website: www.maiansurvey.com
----------------------------------------------*/

// Error reporting..
error_reporting(0);

// Set paths..
define ('PATH', dirname(__FILE__).'/');
define ('INC',1);
define ('RESULTS_DATA',1);

// Load get vars..
$code   = isset($_GET['survey']) ? $_GET['survey'] : '';
$count  = 0;
$sData  = '';

include(PATH.'inc/connect.php');
include(PATH.'lang/english.php');
include(PATH.'inc/functions.php');
include(PATH.'inc/defined.php');
include(PATH.'classes/survey.php');
include(PATH.'classes/results.php');
include(PATH.'inc/lib/Savant3.php');

// Collation..
@mysql_query("SET CHARACTER SET 'utf8'");
@mysql_query("SET NAMES 'utf8'");

// Set timezone..
date_default_timezone_set((TIMEZONE ? TIMEZONE : date_default_timezone_get()));

// Initiate settings class..
$SETTINGS         = loadSettings();

// Check var if reloading from admin..
if (strlen($_GET['survey'])>33) {
  $split = explode("-",$_GET['survey']);
  if (md5($SETTINGS->cfg_login)==$split[0]) {
    $code = substr($_GET['survey'],33,strlen($_GET['survey']));
    $_SESSION['admin_status'] = time();
  }
}

$SURVEY           = new webSurvey();
$RESULTS          = new webSurveyResults();
$SURVEY->prefix   = DB_PREFIX;
$RESULTS->prefix  = DB_PREFIX;
$SURVEY->survey   = $code;
$RESULTS->survey  = $code;

// Load survey vars into array..
$webSurvey        = $SURVEY->loadSurvey();

// Check survey..
// If invalid code, show error..
if (!$SURVEY->checkSurveyExists() || $code=='' && (!isset($_SESSION['admin_status']))) {
  header("Location: index.php?code=".$code."&error=".($code=='' ? 'no_code' : 'invalid'));
  exit;
}

// Check survey expiry date...
if ($SURVEY->checkSurveyExpiryDate() && (!isset($_SESSION['admin_status']))) {
  header("Location: index.php?code=".$code."&error=expired");
  exit;
}

// Can visitor view this survey?
if (!$webSurvey->sur_view_summary && (!isset($_SESSION['admin_status']))) {
  header("Location: index.php?code=".$code."&error=no_view");
  exit;
}

// Are we loading pop up screen?
if (isset($_GET['other'])) {
  $QUE    = $SURVEY->getQuestion($_GET['other']);
  $qdata  = '';
  // Load unique answers for this question..
  $query = mysql_query("SELECT DISTINCT(ans_text) FROM ".DB_PREFIX."answers 
                        WHERE ans_que_id  = '".(int)$_GET['other']."'
                        AND ans_var_id    = '0'       
                        ORDER BY ans_id
                        ") or die(db_MSG(__FILE__,__LINE__));
  while ($ANS = mysql_fetch_object($query)) {
    if ($ANS->ans_text) {
      // Get count of other answers for this question...
      $tCount      = mysql_num_rows($query);
      // How many times does this answer occur..
      $qCount      = mysqlTableCount('answers',' WHERE ans_text = \''.safeImport($ANS->ans_text).'\'');
      // Calculate percentage..
      $percentage  = number_format($qCount/$tCount*100,1).'%';
      $qdata      .= str_replace(array('{answer}','{percentage}'),
                                 array(nl2br(cleanDataEnt($ANS->ans_text)),$percentage.' ('.$qCount.')'),
                                 file_get_contents(PATH.'templates/html/result_type_other_answer.tpl')
                     );
    }
  }
  // Any data??
  if ($qdata=='') {
    $qdata .= str_replace(array('{answer}','{percentage}'),array($public_results10,''),file_get_contents(PATH.'templates/html/result_type_other_answer.tpl'));
  }
  // Load question..
  $load  = str_replace(array('{question}','{answer}','{back}'),
                       array(cleanDataEnt($QUE->que_text).' ('.$public_results4.')',$qdata,$msg_script20),
                       file_get_contents(PATH.'templates/html/result_type_other_question.tpl')
           ); 
  // If we are still here, we can view the survey results..
  include(PATH.'inc/header.php');
  $tpl = new Savant3();
  $tpl->assign('PRINT',showPrintBar());
  $tpl->assign('TITLE',showSurveyTitle(false));
  $tpl->assign('SURVEY_RESULTS',$load);
  $tpl->display('templates/other_results.tpl.php'); 
  include(PATH.'inc/footer.php');
} else {
  // Load survey questions into array...
  $webSurveyQuestions  = $SURVEY->loadSurveyQuestions($webSurvey->sur_id);

  // Loop through questions..
  foreach ($webSurveyQuestions AS $id) {
    // Get question..
    $QUE      = $SURVEY->getQuestion($id);
    $find     = array('{question}','{question_data}');
    $replace  = array(cleanDataEnt($QUE->que_text),$RESULTS->showQuestionSurveyResults($QUE->que_answer_type,$QUE->que_id,$public_results4,$public_results5,$public_results6,$public_results7,$public_results8));
    $sData    .= str_replace($find,$replace,file_get_contents(PATH.'templates/html/single_question_result.tpl'));
  }

  // If we are still here, we can view the survey results..
  include(PATH.'inc/header.php');
  $tpl = new Savant3();
  $tpl->assign('PRINT',showPrintBar());
  $tpl->assign('TITLE',showSurveyTitle(false));
  $tpl->assign('SURVEY_RESULTS',$sData);
  $tpl->display('templates/results.tpl.php'); 
  include(PATH.'inc/footer.php');
}

?>
