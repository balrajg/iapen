<?php

/*---------------------------------------------
  MAIAN SURVEY v1.1
  Written by David Ian Bennett
  E-Mail: N/A
  Website: www.maiansurvey.com
----------------------------------------------*/

// Error reporting..
error_reporting(1);

// Start session..
session_start();

// Set paths..
define ('PATH', dirname(__FILE__).'/');
define ('INC',1);

// Load get vars..
$code   = isset($_GET['survey']) ? $_GET['survey'] : (isset($_SESSION['survey_code_id']) ? $_SESSION['survey_code_id'] : '');
$page   = isset($_GET['page']) ? (int)$_GET['page'] : '1';
$count  = 0;

include(PATH.'inc/connect.php');
include(PATH.'lang/english.php');
include(PATH.'inc/functions.php');
include(PATH.'inc/defined.php');
include(PATH.'classes/class_mail.inc.php');
include(PATH.'classes/survey.php');
include(PATH.'classes/html_rendering.php');
include(PATH.'inc/lib/Savant3.php');

// Collation..
@mysql_query("SET CHARACTER SET 'utf8'");
@mysql_query("SET NAMES 'utf8'");

// Set timezone..
date_default_timezone_set((TIMEZONE ? TIMEZONE : date_default_timezone_get()));

// Initiate settings class..
$MAIL      = new mailClass();
$SETTINGS  = loadSettings();
$SURVEY    = new webSurvey();
$HTML      = new htmlObject();

// Check var if reloading from admin..
if (isset($_GET['survey']) && strlen($_GET['survey'])>33) {
  $split = explode("-",$_GET['survey']);
  if (md5($SETTINGS->cfg_login)==$split[0]) {
    $code = substr($_GET['survey'],33,strlen($_GET['survey']));
    $_SESSION['admin_status'] = time();
  }
}

// Load class vars..
$SURVEY->prefix   = DB_PREFIX;
$HTML->prefix     = DB_PREFIX;
$SURVEY->survey   = $code;
$MAIL->smtp       = $SETTINGS->smtp;
$MAIL->smtp_host  = $SETTINGS->smtp_host;
$MAIL->smtp_user  = $SETTINGS->smtp_user;
$MAIL->smtp_pass  = $SETTINGS->smtp_pass;
$MAIL->smtp_port  = $SETTINGS->smtp_port;
$MAIL->html       = SET_HTML;
$MAIL->addTag('{SCRIPT_PATH}', $SETTINGS->cfg_wurl);
$MAIL->addTag('{WEBSITE_NAME}', $SETTINGS->cfg_wname);
$MAIL->addTag('{WEBSITE_URL}', $SETTINGS->cfg_wurl);

// Display captcha..
if (isset($_GET['captcha'])) {
  include (PATH.'inc/captcha/securimage.php');
  $C = new securimage();
  $C->show();
  exit;
}

// Check survey..
// If invalid code, show error..
if (!isset($_GET['error']) && !isset($_SESSION['admin_status'])) {
  if (!$SURVEY->checkSurveyExists() || $code=='' || !ctype_alnum($code)) {
    header("Location: index.php?code=".$code."&error=".($code=='' ? 'no_code' : 'invalid'));
    exit;
  }
}

// Check survey expiry date...
if (!isset($_GET['error']) && !isset($_SESSION['admin_status'])) {
  if ($SURVEY->checkSurveyExpiryDate()) {
    header("Location: index.php?code=".$code."&error=expired");
    exit;
  }
}

// Load templates..
if (isset($_GET['error'])) {
  switch ($_GET['error']) {
    case 'invalid':      $errMsg = $msg_error2; break;
    case 'expired':      $errMsg = $msg_error;  break;
    case 'no_questions': $errMsg = $msg_error3; break;
    case 'no_votes':     $errMsg = $msg_error4; break;
    case 'no_code':      $errMsg = $msg_error5; break;
    case 'no_view':      $errMsg = $msg_error6; break;
  }
  include(PATH.'inc/header.php');
  $tpl = new Savant3();
  $tpl->assign('ERROR_MESSAGE',str_replace("{code}",$_GET['code'],$errMsg));
  $tpl->display('templates/error.tpl.php');
  include(PATH.'inc/footer.php');

// Show help tip..
} elseif (isset($_GET['help'])) {
  $QUE = $SURVEY->getQuestion($_GET['help']);
  echo nl2br(cleanDataEnt($QUE->que_help_text));

// Process user e-mail option
} elseif (isset($_GET['email']) || isset($_POST['process_email'])) {

  // Load survey vars into array..
  $webSurvey = $SURVEY->loadSurvey();

  // Process e-mail address..
  if (isset($_POST['process_email'])) {
    // IE requires the image var is set by using the underscore..
    if (isset($_POST['yes_x']) || isset($_POST['yes'])) {
      if (isset($_POST['process_email'])) {
        if (trim($_POST['name'])=='') {
          $errMsg = $public_email3;
        }
        if (!preg_match("/^[_.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z.-]+.)+[a-zA-Z]{2,6}$/i", $_POST['email'])) {
          $errMsg = (isset($errMsg) ? $errMsg.'<br />' : '').$public_email2;
        }
      }
      // Log user data if no errors..
      if (!isset($errMsg)) {
        $SURVEY->logUserData($webSurvey->sur_id);
      }
    }
    // Now send email..
    if ($webSurvey->sur_notification_email) {
      $MAIL->addTag('{SURVEY_NAME}', $webSurvey->sur_title);
      $MAIL->addTag('{URL}', $SETTINGS->cfg_wurl.'admin/');
      $MAIL->addTag('{NAME}', $_POST['name']);
      $MAIL->addTag('{EMAIL}', $_POST['email']);
      $MAIL->addTag('{SURVEY_URL}', $SETTINGS->cfg_wurl.'results.php?survey='.$_SESSION['survey_code_id']);
      // If comma is present, its multiple addresses, so explode into array..
      $addresses = (strpos($webSurvey->sur_notification_email,',')===FALSE ? $webSurvey->sur_notification_email : explode(",",$webSurvey->sur_notification_email));
      $MAIL->sendMail($addresses,
                      $SETTINGS->cfg_wname,
                      $SETTINGS->cfg_wemail,
                      $msg_script17,
                      $MAIL->template(PATH.'templates/email/notification.txt')
                      );
    }
    // Redirect to thanks page..
    header("Location: index.php?thanks=1");
    exit;
  }

  include(PATH.'inc/header.php');

  $tpl = new Savant3();
  $tpl->assign('HEADING',$public_email);
  $tpl->assign('MESSAGE',showSurveyEmailMessage());
  $tpl->assign('ERROR',(isset($errMsg) ? str_replace('{error}',$errMsg,file_get_contents(PATH.'templates/html/error.tpl')) : ''));
  $tpl->assign('NAME',$public_email4);
  $tpl->assign('EMAIL',$public_email5);
  $tpl->assign('N_VALUE',(isset($_POST['name']) ? cleanDataEnt($_POST['name']) : ''));
  $tpl->assign('E_VALUE',(isset($_POST['email']) ? cleanDataEnt($_POST['email']) : ''));
  $tpl->display('templates/email_box.tpl.php');

  $tpl2 = new Savant3();
  $tpl2->assign('NO_THANKS',$msg_script15);
  $tpl2->assign('THANKS',$msg_script16);
  $tpl2->display('templates/buttons_email.tpl.php');

  include(PATH.'inc/footer.php');

// Show thanks page..
} elseif (isset($_GET['thanks']) ) {
  // Set cookie..
  $SURVEY->setSurveyCookie();

  // Load survey vars into array..
  $webSurvey = $SURVEY->loadSurvey();

  include(PATH.'inc/header.php');
  $tpl = new Savant3();
  $tpl->assign('MSG', nl2br(cleanDataEnt($webSurvey->sur_complete_message)));
  $tpl->assign('THANKS',$public_thanks);
  $tpl->assign('RESULTS',($webSurvey->sur_view_summary ? str_replace("{code}",$_SESSION['survey_code_id'],$public_thanks2) : ''));
  $tpl->display('templates/thanks.tpl.php');
  include(PATH.'inc/footer.php');

  // Clear session vars..
  $SURVEY->clearSessionVars();
  $sessionID = '';

// Parse and load survey..
} else {

  // Load survey vars into array..
  $webSurvey           = $SURVEY->loadSurvey();
  // Load survey questions into array...
  $webSurveyQuestions  = $SURVEY->loadSurveyQuestions($webSurvey->sur_id);
  // Initialise session var..
  $sessionID           = session_id();

  // Does this survey have questions..
  if (!isset($_GET['error'])) {
    if (empty($webSurveyQuestions)) {
      header("Location: index.php?code=".$code."&error=no_questions");
      exit;
    }
  }

  // Has visitor participated before..
  if (!isset($_GET['error']) && !isset($_SESSION['admin_status'])) {
    if (!$webSurvey->sur_allow_multiple_votes && $SURVEY->checkSurveyCookie()) {
      header("Location: index.php?code=".$code."&error=no_votes");
      exit;
    }
  }

  // Reload page if survey var isn`t set..
  if (!isset($_SESSION['survey_code_id']) || (isset($_SESSION['survey_code_id']) && $_SESSION['survey_code_id']!=$code)) {
    $_SESSION['survey_code_id'] = $code;
    header("Location: index.php");
    exit;
  }

  // Are we showing survey on multiple pages..
  if (!$webSurvey->sur_display_type) {
    // Determine which question we are on..
    // Also determine first and last question for survey..
    $firstQuestionID  = $webSurveyQuestions[0];
    $lastQuestionID   = $webSurveyQuestions[(count($webSurveyQuestions)-1)];
    $currentQuestion  = (isset($_SESSION['question_slot']) ? $webSurveyQuestions[$_SESSION['question_slot']] : $webSurveyQuestions[0]);
    // Get question data..
    $QUE              = $SURVEY->getQuestion($currentQuestion);

    // If page var is present, re-load..
    // This moves the array pointer back one slot and reveals previous question..
    if (isset($_GET['page'])) {
      $_SESSION['question_slot'] = $_GET['page'];
      // Update session vars..
      header("Location: index.php");
      exit;
    }

    // Process survey questions...
    if (isset($_POST['question'])) {
      // Lets clean the post array...this removes harmful tags and data..
      $_POST = multiDimensionalArrayMap('cleanEvilTags',$_POST);
      // Start processing with clear post array..
      if (!$SURVEY->errorCheckField($QUE->que_id,$public_survey2,$public_survey3)) {
        // Was previous question the last question...
        if ($_POST['question']==$lastQuestionID) {
          $SURVEY->loadQuestionSessionVars($sessionID,$webSurvey->sur_id);
          // Add to database..
          $SURVEY->addSurveyResponsesToDatabase($sessionID,$webSurvey->sur_id);
          // Log keywords..
          if ($webSurvey->en_keys) {
            $SURVEY->logKeywords($webSurvey->sur_id);
          }
          // Is notification to be sent..
          if ($webSurvey->sur_notification_email && !$webSurvey->sur_email_request) {
            $MAIL->addTag('{SURVEY_NAME}', $webSurvey->sur_title);
            $MAIL->addTag('{URL}', $SETTINGS->cfg_wurl.'admin/');
            $MAIL->addTag('{NAME}', 'N/A');
            $MAIL->addTag('{EMAIL}', 'N/A');
            $MAIL->addTag('{SURVEY_URL}', $SETTINGS->cfg_wurl.'results.php?survey='.$_SESSION['survey_code_id']);
            // If comma is present, its multiple addresses, so explode into array..
            $addresses = (strpos($webSurvey->sur_notification_email,',')===FALSE ? $webSurvey->sur_notification_email : explode(",",$webSurvey->sur_notification_email));
            $MAIL->sendMail($addresses,
                            $SETTINGS->cfg_wname,
                            $SETTINGS->cfg_wemail,
                            $msg_script17,
                            $MAIL->template(PATH.'templates/email/notification.txt')
                            );
          }
          // Are we requesting visitors e-mail address? If so, load form for e-mail..
          if ($webSurvey->sur_email_request) {
            header("Location: index.php?email=1");
            exit;
          } else {
            // Are we directing visitor to specific page or thanks page..
            if ($webSurvey->sur_complete_url) {
              // Double check url is present..if not, default to thanks..
              if ($webSurvey->sur_complete_url && $webSurvey->sur_complete_url!='http://') {
                // Clear session vars..set cookie..
                $SURVEY->clearSessionVars();
                $SURVEY->setSurveyCookie();
                $sessionID = '';
                header("Location: ".$webSurvey->sur_complete_url."");
              } else {
                header("Location: index.php?thanks=1");
              }
              exit;
            } else {
              header("Location: index.php?thanks=1");
              exit;
            }
          }
        } else {
          $_SESSION['question_slot'] = (isset($_SESSION['question_slot']) ? ($_SESSION['question_slot']+1) : '1');
          // Update session vars..
          $SURVEY->loadQuestionSessionVars($sessionID,$webSurvey->sur_id);
          header("Location: index.php");
          exit;
        }
      } else {
        $errMsg = $SURVEY->errorCheckField($QUE->que_id,$public_survey2,$public_survey3);
      }
    }

    include(PATH.'inc/header.php');

    $tpl = new Savant3();
    $tpl->assign('TITLE',showSurveyTitle());
    $tpl->assign('QUESTION',cleanDataEnt($QUE->que_text));
    $tpl->assign('ERROR',(isset($errMsg) ? $errMsg : ''));
    $tpl->assign('HELP',showHelpTip($QUE->que_id));
    $tpl->assign('ANSWER',$HTML->renderHTML($QUE->que_id,$public_survey));
    $tpl->assign('QUESTION_ID',(isset($QUE) ? $QUE->que_id : ''));
    $tpl->display('templates/survey_multiple_pages.tpl.php');

    $tpl2 = new Savant3();
    $tpl2->assign('PREVIOUS',(isset($_SESSION['question_slot']) && $_SESSION['question_slot']>0 ? loadPreviousButton(($_SESSION['question_slot']-1)) : ''));
    $tpl2->assign('CONTINUE',($QUE->que_id==$lastQuestionID ? $public_buttons4 : $public_buttons2));
    $tpl2->assign('GIF',($QUE->que_id==$lastQuestionID ? 'finish' : 'continue'));
    $tpl2->assign('TEXT',showSurveyFooterInformation());
    $tpl2->display('templates/multiple_pages_buttons.tpl.php');

    include(PATH.'inc/footer.php');
  } else {

    // This is the processing for single page..
    $sData   = '';
    $helpID  = 0;

    // Loop through questions..
    foreach ($webSurveyQuestions AS $id) {
      // Get question..
      $QUE      = $SURVEY->getQuestion($id);
      $errMsg   = '';
      // Check for errors is form is processed..
      if (isset($_POST['process_single'])) {
        // Lets clean the post array...this removes harmful tags and data..
        $_POST = multiDimensionalArrayMap('cleanEvilTags',$_POST);
        // Start processing with clear post array..
        if ($SURVEY->errorCheckField($QUE->que_id,$public_survey2,$public_survey3)) {
          $errMsg = $SURVEY->errorCheckField($QUE->que_id,$public_survey2,$public_survey3);
          $count++;
        }
      }
      $find     = array('{question}','{help}','{error_message}','{answer}');
      $replace  = array(cleanDataEnt($QUE->que_text),showHelpTip($QUE->que_id,++$helpID),$errMsg,$HTML->renderHTML($QUE->que_id,$public_survey));
      $sData    .= str_replace($find,$replace,file_get_contents(PATH.'templates/html/single_question.tpl'));
    }

    // Are we loading single page captcha?
    if ($webSurvey->sur_captcha) {
      // Check for errors is form is processed..
      if (isset($_POST['process_single'])) {
        // Lets clean the post array...this removes harmful tags and data..
        $_POST = multiDimensionalArrayMap('cleanEvilTags',$_POST);
        // Start processing with clear post array..
        include(PATH.'inc/captcha/securimage.php');
        $C      = new Securimage();
        $valid  = $C->check($_POST['code']);
        if($valid == false) {
          $errCMsg = $msg_publicindex2;
          $count++;
        }
      }
      $find     = array('{text}','{error_message}');
      $replace  = array($msg_publicindex,(isset($errCMsg) ? '<div class="error">'.$errCMsg.'</div>' : ''));
      $sData   .= str_replace($find,$replace,file_get_contents(PATH.'templates/html/captcha.tpl'));
    }

    // Continue with processing if no errors..
    if (isset($_POST['process_single']) && $count==0) {
      // Add to session vars...
      foreach ($webSurveyQuestions AS $id) {
        $SURVEY->loadQuestionSessionVars($sessionID,$webSurvey->sur_id,$id);
      }
      // Add to database..
      $SURVEY->addSurveyResponsesToDatabase($sessionID,$webSurvey->sur_id);
      // Log keywords..
      if ($webSurvey->en_keys) {
        $SURVEY->logKeywords($webSurvey->sur_id);
      }
      // Is notification to be sent..
      if ($webSurvey->sur_notification_email) {
        $MAIL->addTag('{SURVEY_NAME}', $webSurvey->sur_title);
        $MAIL->addTag('{URL}', $SETTINGS->cfg_wurl.'admin/');
        $MAIL->addTag('{SURVEY_URL}', $SETTINGS->cfg_wurl.'results.php?survey='.$_SESSION['survey_code_id']);
        // If comma is present, its multiple addresses, so explode into array..
        $addresses = (strpos($webSurvey->sur_notification_email,',')===FALSE ? $webSurvey->sur_notification_email : explode(",",$webSurvey->sur_notification_email));
        $MAIL->sendMail($addresses,
                        $SETTINGS->cfg_wname,
                        $SETTINGS->cfg_wemail,
                        $msg_script17,
                        $MAIL->template(PATH.'templates/email/notification.txt')
                        );
      }
      // Are we requesting visitors e-mail address? If so, load form for e-mail..
      if ($webSurvey->sur_email_request) {
        header("Location: index.php?email=1");
        exit;
      } else {
        // Are we directing visitor to specific page or thanks page..
        if ($webSurvey->sur_complete_url) {
          // Double check url is present..if not, default to thanks..
          if ($webSurvey->sur_complete_url && $webSurvey->sur_complete_url!='http://') {
            // Clear session vars..set cookie..
            $SURVEY->clearSessionVars();
            $SURVEY->setSurveyCookie();
            $sessionID = '';
            header("Location: ".$webSurvey->sur_complete_url."");
          } else {
            header("Location: index.php?thanks=1");
          }
          exit;
        } else {
          header("Location: index.php?thanks=1");
          exit;
        }
      }
    }

    include(PATH.'inc/header.php');

    $tpl = new Savant3();
    $tpl->assign('TITLE',showSurveyTitle());
    $tpl->assign('SURVEY_DATA',$sData);
    $tpl->display('templates/survey_single_page.tpl.php');

    $tpl2 = new Savant3();
    $tpl2->assign('CONTINUE',$public_buttons4);
    $tpl2->display('templates/single_page_buttons.tpl.php');

    include(PATH.'inc/footer.php');
  }
}

?>
