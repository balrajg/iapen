<?php

/*---------------------------------------------
  MAIAN SURVEY v1.1
  Written by David Ian Bennett
  E-Mail: N/A
  Website: www.maiansurvey.com
----------------------------------------------*/

// Error reporting..
error_reporting(0);

// Start session..
session_start();

// Define vars..
define('INC', 1);

// Set paths..
define ('PATH', dirname(__FILE__).'/');
define ('REL_PATH', '../');

// Load include files..
include(REL_PATH.'inc/connect.php');
include(REL_PATH.'lang/english.php');
include(REL_PATH.'inc/functions.php');
include(PATH.'inc/functions.php');
include(PATH.'inc/constants.php');
include(PATH.'classes/PaginateIt.php');
include(PATH.'classes/settings.php');
include(PATH.'classes/class_mail.inc.php');

// Collation..
@mysql_query("SET CHARACTER SET 'utf8'");
@mysql_query("SET NAMES 'utf8'");

// Set timezone..
date_default_timezone_set((TIMEZONE ? TIMEZONE : date_default_timezone_get()));

// Initiate settings class..
$MAIL         = new mailClass();
$STS          = new programSettings();
$STS->prefix  = DB_PREFIX;

// Initiate vars..
$cmd           = (isset($_GET['cmd']) ? $_GET['cmd'] : 'home');
$page          = (isset($_GET['page']) ? (int)$_GET['page'] : '1');
$count         = 0;
$limit         = DATA_PER_PAGE;
$limitvalue    = $page * $limit - ($limit);
$title         = $msg_script.' '.$msg_script2.' - '.$msg_header;
$SETTINGS      = $STS->loadSettings();

// Default mail vars..
$MAIL->smtp       = $SETTINGS->smtp;
$MAIL->smtp_host  = $SETTINGS->smtp_host;
$MAIL->smtp_user  = $SETTINGS->smtp_user;
$MAIL->smtp_pass  = $SETTINGS->smtp_pass;
$MAIL->smtp_port  = $SETTINGS->smtp_port;
$MAIL->html       = SET_HTML;
$MAIL->addTag('{WEBSITE_NAME}', $SETTINGS->cfg_wname);
$MAIL->addTag('{WEBSITE_URL}', $SETTINGS->cfg_wurl);

// If password blank, update and reload..
if ($SETTINGS->cfg_password=='') {
  $_POST['user'] = 'admin';
  $STS->updatePassword('admin');
  header("Location: index.php");
  exit;
}

// Load templates..
switch ($cmd) {
  // Home..
  case 'home':
  
  isSessionActive();
  
  $title = $title.' - '.$msg_header2;
  
  include(PATH.'templates/header.php');
  include(PATH.'templates/home.php');
  include(PATH.'templates/footer.php');
  break;
  
  // Settings..
  case 'settings':
  
  isSessionActive();
  
  $title = $title.' - '.$msg_header8;
  
  if (isset($_POST['process'])) {
    $_POST = array_map('trim',$_POST);
    if ($_POST['cfg_wname']=='') {
      $N_ERROR = $msg_settings6; $count++;
    }
    if (!preg_match("/^[_.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z.-]+.)+[a-zA-Z]{2,6}$/i", $_POST['cfg_wemail'])) {
      $E_ERROR = $msg_settings7; $count++;
    }
    if ($_POST['cfg_wurl']=='') {
      $U_ERROR = $msg_settings8; $count++;
    }
    if ($count==0) {
      $STS->updateSettings();
      header("Location: index.php?cmd=settings");
      exit;
    }
  }
  
  include(PATH.'templates/header.php');
  include(PATH.'templates/settings.php');
  include(PATH.'templates/footer.php');
  break;
  
  // Surveys..
  case 'surveys':
  case 'create-survey':
  case 'edit-survey':
  case 'copy-survey':
  case 'clear-results':
  
  isSessionActive();
  
  include(PATH.'classes/surveys.php');
  $SVY          = new surveys();
  $SVY->prefix  = DB_PREFIX;
  
  switch ($cmd) {
    case 'surveys':
    $title = $title.' - '.$msg_header4;
    break;
    case 'create-survey':
    $title = $title.' - '.$msg_survey2;
    break;
    case 'edit-survey':
    $title = $title.' - '.$msg_survey23;
    break;
    case 'copy-survey':
    $title = $title.' - '.$msg_survey40;
    break;
    case 'clear-results':
    $title = $title.' - '.$msg_survey55;
    break;
  }
  
  // Add survey..
  if (isset($_POST['process'])) {
    $_POST = array_map('trim',$_POST);
    if ($SVY->checkTitle($_POST['sur_title']) || $_POST['sur_title']=='') {
      $T_ERROR = ($_POST['sur_title']=='' ? $msg_survey26 : $msg_survey25);
    } else {
      $SVY->addSurvey();
      $CREATED = true;
    }
  }
  
  // Edit survey..
  if (isset($_GET['edit']) || isset($_POST['edit'])) {
    $EDIT = $SVY->getSurvey(isset($_GET['edit']) ? $_GET['edit'] : $_POST['edit']);
    if (isset($_POST['edit'])) {
      $_POST = array_map('trim',$_POST);
      if ($SVY->checkTitle($_POST['sur_title'],$EDIT->sur_id) || $_POST['sur_title']=='') {
        $T_ERROR = ($_POST['sur_title']=='' ? $msg_survey26 : $msg_survey25);
      } else {
        $SVY->updateSurvey();
        $UPDATED = true;
      }
    }
  }
  
  // Copy survey..
  if (isset($_GET['copy']) || isset($_POST['copy'])) {
    $COPY = $SVY->getSurvey(isset($_GET['copy']) ? $_GET['copy'] : $_POST['copy']);
    if (isset($_POST['copy'])) {
      $_POST = array_map('trim',$_POST);
      if ($SVY->checkTitle($_POST['sur_title']) || $_POST['sur_title']=='') {
        $T_ERROR = ($_POST['sur_title']=='' ? $msg_survey26 : $msg_survey25);
      } else {
        $SVY->addSurvey();
        $COPIED = true;
      }
    }
  }
  
  // Preview survey..
  if (isset($_GET['preview'])) {
    header("Location: ".REL_PATH."index.php?survey=".$_GET['preview']);
    exit;
  }
  
  // Delete survey..
  if (isset($_GET['delete'])) {
    $SVY->deleteSurvey($_GET['delete']);
    header("Location: index.php?cmd=surveys");
    exit;
  }
  
  // Clear results..
  if ($cmd=='clear-results') {
    $SVY->clearResults($_GET['survey']);
    include(PATH.'templates/header.php');
    include(PATH.'templates/'.$cmd.'.php');
    include(PATH.'templates/footer.php');
    exit;
  }
  
  // Load options..
  if (isset($_GET['options'])) {
    $_SESSION['loadOptions'] = $_GET['options'];
    header("Location: index.php?cmd=surveys&reload=1");
    exit;
  } else {
    if (isset($_SESSION['loadOptions']) && !isset($_GET['reload']) && !isset($COPY)) {
      unset($_SESSION['loadOptions']);
      header("Location: index.php?cmd=surveys");
      exit;
    }
  }
  
  include(PATH.'templates/header.php');
  include(PATH.'templates/'.$cmd.'.php');
  include(PATH.'templates/footer.php');
  break;
  
  // Colour Schemes..
  case 'colours':
  case 'create-colour-scheme':
  case 'edit-colour-scheme':
  
  isSessionActive();
  
  include(PATH.'classes/colors.php');
  $CLR          = new colorSchemer();
  $CLR->prefix  = DB_PREFIX;
  
  switch ($cmd) {
    case 'colours':
    $title = $title.' - '.$msg_header5;
    break;
    case 'create-colour-scheme':
    $title = $title.' - '.$msg_colours2;
    break;
    case 'edit-colour-scheme':
    $title = $title.' - '.$msg_colours18;
    break;
  }
  
  // Add scheme..
  if (isset($_POST['process'])) {
    $_POST = array_map('trim',$_POST);
    if ($CLR->checkTitle($_POST['csc_title']) || $_POST['csc_title']=='') {
      $T_ERROR = ($_POST['csc_title']=='' ? $msg_colours20 : $msg_colours17);
    } else {
      $CLR->addScheme();
      header("Location: index.php?cmd=colours");
      exit;
    }
  }
  
  // Edit scheme..
  if (isset($_GET['edit']) || isset($_POST['edit'])) {
    $EDIT = $CLR->getScheme(isset($_GET['edit']) ? $_GET['edit'] : $_POST['edit']);
    if (isset($_POST['edit'])) {
      $_POST = array_map('trim',$_POST);
      if ($CLR->checkTitle($_POST['csc_title'],$EDIT->csc_id) || $_POST['csc_title']=='') {
        $T_ERROR = ($_POST['csc_title']=='' ? $msg_colours20 : $msg_colours17);
      } else {
        $CLR->updateScheme();
        header("Location: index.php?cmd=edit-colour-scheme&edit=".$EDIT->csc_id);
        exit;
      }
    }
  }
  
  // Preview scheme..
  if (isset($_GET['preview'])) {
    $PREVIEW = $CLR->getScheme($_GET['preview']);
    include(PATH.'templates/popup/preview-colour-scheme.php');
    exit;
  }
  
  // Delete scheme..
  if (isset($_GET['delete'])) {
    $CLR->deleteScheme($_GET['delete']);
    header("Location: index.php?cmd=colours");
    exit;
  }
  
  include(PATH.'templates/header.php');
  include(PATH.'templates/'.$cmd.'.php');
  include(PATH.'templates/footer.php');
  break;
  
  // Questions..
  case 'questions':
  case 'add-question':
  case 'edit-question':
  
  isSessionActive();
  
  include(PATH.'classes/questions.php');
  $QTN          = new questions();
  $QTN->prefix  = DB_PREFIX;
  
  switch ($cmd) {
    case 'questions':
    $title = $title.' - '.$msg_question;
    break;
    case 'add-question':
    $title = $title.' - '.$msg_question3;
    if (!isset($_GET['help'])) {
      $SUR = rowData('surveys',' WHERE sur_id = \''.(int)(isset($_POST['survey']) ? $_POST['survey'] : $_GET['survey']).'\'');
    }
    break;
    case 'edit-question':
    $title = $title.' - '.$msg_question23;
    break;
  }
  
  // View help file..
  if (isset($_GET['help'])) {
    include(PATH.'templates/popup/answer-type.php');
    exit;
  }
  
  // Update order..
  if (isset($_POST['order'])) {
    $QTN->updateOrderByOptions();
    header("Location: index.php?cmd=questions&survey=".$_POST['survey']);
    exit;
  }
  
  // Add question..
  if (isset($_POST['process'])) {
    $_POST = array_map('trim',$_POST);
    if ($_POST['que_text']=='') {
      $Q_ERROR = $msg_question25;
    } else {
      $QTN->addQuestion();
      $CREATED = true;
    }
  }
  
  // Edit question..
  if (isset($_GET['edit']) || isset($_POST['edit'])) {
    $EDIT     = $QTN->getQuestion(isset($_GET['edit']) ? $_GET['edit'] : $_POST['edit']);
    $VARIANTS = $QTN->getVariants($EDIT->que_id);
    $SUR      = rowData('surveys',' WHERE sur_id = \''.$EDIT->que_sur_id.'\'');
    if (isset($_POST['edit'])) {
      $_POST = array_map('trim',$_POST);
      if ($_POST['que_text']=='') {
        $Q_ERROR = $msg_question25;
      } else {
        $QTN->updateQuestion();
        $UPDATED = true;
      }
    }
  }
  
  // Delete questions..
  if (isset($_GET['delete'])) {
    $QTN->deleteQuestion($_GET['delete']);
    header("Location: index.php?cmd=questions&survey=".$_GET['survey']);
    exit;
  }
  
  include(PATH.'templates/header.php');
  include(PATH.'templates/'.$cmd.'.php');
  include(PATH.'templates/footer.php');
  break;
  
  // Export contacts..
  case 'contacts':
  
  isSessionActive();
  
  $title = $title.' - '.$msg_survey51;
  
  // Clear results..
  if (isset($_GET['clear'])) {
    include(PATH.'classes/surveys.php');
    $SVY          = new surveys();
    $SVY->prefix  = DB_PREFIX;
    $SVY->clearContacts($_GET['survey']);
    include(PATH.'templates/header.php');
    include(PATH.'templates/clear-contacts.php');
    include(PATH.'templates/footer.php');
    exit;
  }
  
  if (isset($_POST['process'])) {
    // If survey array is empty, set default..
    if (!isset($_POST['survey'])) {
      $_POST['survey']   = array();
      $_POST['survey'][] = 'all';
    }
    // Make sure we have a seperator..
    $sep  = ($_POST['seperator'] ? $_POST['seperator'] : ',');
    // Define id numbers. All overwrites id selections..
    $ids  = (in_array('all',$_POST['survey']) ? 'all' : implode(",",$_POST['survey']));
    // Download...
    $STS->importFileCSV($msg_contacts6,$msg_contacts7,$sep,$ids,$msg_javascript11);
    exit;
  }
  
  include(PATH.'templates/header.php');
  include(PATH.'templates/contacts.php');
  include(PATH.'templates/footer.php');
  break;
  
  // Keyword analysis..
  case 'keywords':
  
  isSessionActive();
  
  include(PATH.'classes/keywords.php');
  $KEY          = new keywords();
  $KEY->prefix  = DB_PREFIX;
  
  // Clear keywords..
  if (isset($_GET['clear'])) {
    $KEY->clearKeywords();
    $title = $title.' - '.$msg_survey52;
    include(PATH.'templates/header.php');
    include(PATH.'templates/clear-keywords.php');
    include(PATH.'templates/footer.php');
    exit;
  }
  // Print keywords..
  if (isset($_GET['print'])) {
    include(PATH.'classes/surveys.php');
    $SVY          = new surveys();
    $SVY->prefix  = DB_PREFIX;
    include(PATH.'templates/popup/print.php');
    exit;
  }
  // View search for keyword..
  if (isset($_GET['search'])) {
    include(PATH.'classes/surveys.php');
    $SVY          = new surveys();
    $SVY->prefix  = DB_PREFIX;
    include(PATH.'templates/popup/search.php');
    exit;
  }
  // Hide/show filter options..
  if (isset($_GET['hide']) || isset($_GET['show'])) {
    if (isset($_GET['hide'])) {
      $_SESSION['hide_filter'] = time();
    } else {
      unset($_SESSION['hide_filter']);
    }
    header("Location: index.php?cmd=keywords&survey=".$_GET['survey'].(isset($_GET['question']) ? '&question='.cleanData($_GET['question']) : '').(isset($_GET['from']) ? '&from='.$_GET['from'] : '').(isset($_GET['to']) ? '&to='.$_GET['to'] : ''));
    exit;
  }
  
  $title = $title.' - '.$msg_survey52;
  
  include(PATH.'templates/header.php');
  include(PATH.'templates/keywords.php');
  include(PATH.'templates/footer.php');
  break;
  
  // Change Password..
  case 'pass':
  
  isSessionActive();
  
  $title = $title.' - '.$msg_header6;
  
  if (isset($_POST['process'])) {
    $_POST = array_map('trim',$_POST);
    if ($_POST['old']=='') {
      $O_ERROR = $msg_pass5; $count++;
      $old     = true;
    }
    if (!isset($old) && md5($_POST['old'].SECRET_KEY)!=$SETTINGS->cfg_password) {
      $O_ERROR = $msg_pass10; $count++;
    }
    if ($_POST['new1']=='') {
      $N_ERROR = $msg_pass6; $count++;
      $new     = true;
    }
    if (!isset($new) && $_POST['new1']!=$_POST['new2']) {
      $N2_ERROR = $msg_pass7; $count++;
    }
    if ($count==0) {
      $STS->updatePassword($_POST['new1']);
      $CHANGED = true;
    }
  }
  
  include(PATH.'templates/header.php');
  include(PATH.'templates/pass.php');
  include(PATH.'templates/footer.php');
  break;
  
  // New Pass..
  case 'newpass':
  
  isSessionActive(true);
  
  $title = $title.' - '.$msg_login7;
  
  // Get new password..
  if (isset($_POST['process'])) {
    $username  = $SETTINGS->cfg_login;
    $_POST     = array_map('trim',$_POST);
    if ($_POST['user']!=$username) {
      $U_ERROR = $msg_login12; $count++;
    }
    if ($_POST['email']!=$SETTINGS->cfg_wemail) {
      $E_ERROR = $msg_login15; $count++;
    }
    if ($count==0) {
      $newpass = substr(md5(uniqid(rand(),1)), 2, 7);
      $STS->updatePassword($newpass);
      $MAIL->addTag('{PASS}',$newpass);
      $MAIL->addTag('{NAME}',$username);
      $MAIL->addTag('{URL}',$SETTINGS->cfg_wurl.'admin/index.php?cmd=login');
      $MAIL->sendMail($username,
                      $SETTINGS->cfg_wemail,
                      $SETTINGS->cfg_wname,
                      $SETTINGS->cfg_wemail,
                      $msg_login16,
                      $MAIL->template(REL_PATH.'templates/email/new_pass.txt')
                      );
      $SENT = true;
    }
  }
  
  include(PATH.'templates/header.php');
  include(PATH.'templates/newpass.php');
  include(PATH.'templates/footer.php');
  break;
  
  // Login..
  case 'login':
  
  isSessionActive(true);
  
  $title = $title.' - '.$msg_header2;
  
  // Login..
  if (isset($_POST['process'])) {
    $username  = $SETTINGS->cfg_login;
    $password  = $SETTINGS->cfg_password;
    $_POST     = array_map('trim',$_POST);
    if ($_POST['user']!=$username) {
      $U_ERROR = $msg_login12; $count++;
    }
    if (md5($_POST['pass'].SECRET_KEY)!=$password) {
      $P_ERROR = $msg_login13; $count++;
    }
    if ($count==0) {
      $_SESSION['wpp_session'] = md5($_POST['user']).time();
      if (isset($_POST['cookie'])) {
        setcookie(COOKIE_NAME,md5(SECRET_KEY),time()+60*60*24*30);
      }
      header("Location: index.php");
      exit;
    }
  }
  
  include(PATH.'templates/header.php');
  include(PATH.'templates/login.php');
  include(PATH.'templates/footer.php');
  break;
  
  // Logout..
  case 'logout':
  
  session_unset();
  session_destroy();
  unset($_SESSION);
  
  if (isset($_COOKIE[COOKIE_NAME])) {
    @setcookie(COOKIE_NAME,'');
    unset($_COOKIE);
  }
  
  header("Location: index.php?cmd=login");
  break;
}

?>
