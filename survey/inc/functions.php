<?php

/*---------------------------------------------
  MAIAN SURVEY v1.1
  Written by David Ian Bennett
  E-Mail: N/A
  Website: www.maiansurvey.com
----------------------------------------------*/

// Catch MySQL errors..
function db_MSG($file,$line) {
  echo '<p style="color:red;border:2px solid red;padding:10px;font-size:12px;line-height:20px;background:#f2f2f2">';
  echo '<b style="color:black">MYSQL DATABASE ERROR:</b><br />';
  echo '<b>Code</b>: '.mysql_errno().'<br />';
  echo '<b>Error</b>: '.mysql_error().'<br />';
  echo '<b>File</b>: '.$file.'<br />';
  echo '<b>Line</b>: '.$line.'<br />';
  echo '</p>';
  exit;
}

// Show help tip..
function showHelpTip($id,$count='') {
  global $QUE,$msg_script14;
  $string = '';
  if ($QUE->que_help_text) {
    $string = ' <a href="index.php?help='.$id.'&amp;width='.TOOLTIP_WIDTH.'" class="jTip" id="two'.($count ? $count : '').'" rel="'.$msg_script14.'"><img style="vertical-align:bottom" src="templates/images/help.png" alt="" title="" /></a>';
  }
  return $string;
}

// Show footer data..total questions..progress bar..
function showSurveyFooterInformation() {
  global $SURVEY,$public_buttons3,$webSurvey;
  
  // Calculate percentage for progress bar..
  $cells  = ceil(100/$SURVEY->getSurveyQuestionCount($webSurvey->sur_id));
  
  // Question count..
  $count = (isset($_SESSION['question_slot']) && $_SESSION['question_slot']>0 ? ($_SESSION['question_slot']+1) : '1');
  $width  = ($count==1 ? '1%' : $cells*($count-1).'%');
  
  // Progress bar..
  $pBar = str_replace(array('{width}','{start}'),array($width,($width=='1%' ? 'Hidden' : '')),file_get_contents(PATH.'templates/html/progress_bar.tpl'));
  
  return str_replace("{count}",$SURVEY->getSurveyQuestionCount($webSurvey->sur_id),$public_buttons3).' 
         ('.$count.'/'.$SURVEY->getSurveyQuestionCount($webSurvey->sur_id).')'.$pBar;
}

// Render survey title..
function showSurveyTitle($title=false) {
  global $webSurvey,$public_results;
  
  $string = '';
  if (isset($webSurvey) && $webSurvey->sur_title_should_display) {
    $string = str_replace('{title}',cleanData($webSurvey->sur_title),file_get_contents(PATH.'templates/html/title.tpl'));
  }
  return ($title ? cleanData($webSurvey->sur_title) : $string);
}

// Render print bar..
function showPrintBar() {
  global $public_results2,$public_results3,$SURVEY,$webSurvey,$public_results;
  return str_replace(array('{print}','{people}','{results}'),array($public_results3,str_replace("{count}",$SURVEY->getParticipantCount($webSurvey->sur_id),$public_results2),$public_results),file_get_contents(PATH.'templates/html/print_bar.tpl'));
}

// Render survey title..
function showSurveyEmailMessage() {
  global $webSurvey;
  $string = '';
  if (isset($webSurvey) && $webSurvey->sur_email_request_message) {
    $string = str_replace('{title}',cleanData(nl2br($webSurvey->sur_email_request_message)),file_get_contents(PATH.'templates/html/email_text.tpl'));
  }
  return $string;
}

// Recursive way of handling multi dimensional arrays to mimic array map..
// We don`t use the clear option in ISS..in case you were wondering..
function multiDimensionalArrayMap($func,$arr) {
  $newArr = array();
  if (!empty($arr)) {
    foreach($arr AS $key => $value) {
      $newArr[$key] = (is_array($value) ? multiDimensionalArrayMap($func,$value) : $func($value));
    }
  }
  return $newArr;
}

// Removes potential harmful tags
function cleanEvilTags($data) {
  $data = preg_replace("/javascript/i", "j&#097;v&#097;script",$data);
  $data = preg_replace("/alert/i", "&#097;lert",$data);
  $data = preg_replace("/about:/i", "&#097;bout:",$data);
  $data = preg_replace("/onmouseover/i", "&#111;nmouseover",$data);
  $data = preg_replace("/onclick/i", "&#111;nclick",$data);
  $data = preg_replace("/onload/i", "&#111;nload",$data);
  $data = preg_replace("/onsubmit/i", "&#111;nsubmit",$data);
  $data = preg_replace("/<body/i", "&lt;body",$data);
  $data = preg_replace("/<html/i", "&lt;html",$data);
  $data = preg_replace("/document\./i", "&#100;ocument.",$data);
  return trim(strip_tags($data));
}

// Load previous button if not first page..
function loadPreviousButton($page) {
  global $public_buttons;
  return str_replace(array('{previous}','{page}'),array($public_buttons,$page),file_get_contents(PATH.'templates/html/previous.tpl'));
}

// Load settings..
function loadSettings() {
  global $database;
  $query = mysql_query("SELECT * FROM ".DB_PREFIX."config LIMIT 1") or die(db_MSG(__FILE__,__LINE__));
  return mysql_fetch_object($query);
}

// Table count..
function mysqlTableCount($table,$query='',$row='count(*) AS r_count',$num=false) {
  global $database;
  $count = mysql_query("SELECT ".$row." FROM ".DB_PREFIX.$table.$query."") or die(db_MSG(__FILE__,__LINE__));
  if ($num) {
    return mysql_num_rows($count);
  } else {
    $COUNT = mysql_fetch_object($count);
    return $COUNT->r_count;
  }
}

// Strip html
function cleanDataEnt($data) {
  $data = htmlspecialchars($data);
  $data = str_replace('&amp;#','&#',$data);
  $data = str_replace('&amp;amp;','&amp;',$data);
  return cleanData($data);
}

// Clean data..
function cleanData($data) {
  if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
    $sybase  = strtolower(@ini_get('magic_quotes_sybase'));
    if (empty($sybase) || $sybase=='off') {
      // Fixes issue of new line chars not parsing between single quotes..
      $data = str_replace('\n','\\\n',$data);
      return stripslashes($data);
    }
  }
  return $data;
}

// Define new line character..
function defineNewline() {
  if (defined('PHP_EOL')) {
    return PHP_EOL;
  }
  $unewline = "\r\n";
  if (strstr(strtolower($_SERVER["HTTP_USER_AGENT"]), 'win')) {
    $unewline = "\r\n";
  } else if (strstr(strtolower($_SERVER["HTTP_USER_AGENT"]), 'mac')) {
    $unewline = "\r";
  } else {
    $unewline = "\n";
  }
  return $unewline;
}

// Remove double apostrophes via magic quotes setting..
function removeDoubleApostrophes($data) {
  return str_replace("''","'",$data);
}

//---------------------------------------------------
// Gets visitor IP address..
//---------------------------------------------------

function getRealIPAddr() {
  $ip = array();
  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip[] = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'],',')!==FALSE) {
      $split = explode(',',$_SERVER['HTTP_X_FORWARDED_FOR']);
      foreach ($split AS $value) {
        $ip[] = $value;
      }
    } else {
      $ip[] = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
  } else {
    $ip[] = $_SERVER['REMOTE_ADDR'];
  }
  return (!empty($ip) ? implode(',',$ip) : '');
}

function safeImport($data) {
  if (is_array($data)) {
    if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
      $sybase  = strtolower(@ini_get('magic_quotes_sybase'));
      if (empty($sybase) || $sybase=='off') {
        $data  = multiDimensionalArrayMap('stripslashes',$data);
      } else {
        $data  = multiDimensionalArrayMap('removeDoubleApostrophes',$data);
      }
    }
    $data = multiDimensionalArrayMap('mysql_real_escape_string',$data);
  } else {
    if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
      $sybase  = strtolower(@ini_get('magic_quotes_sybase'));
      if (empty($sybase) || $sybase=='off') {
        $data  = stripslashes($data);
      } else {
        $data  = removeDoubleApostrophes($data);
      }
    }
    $data = mysql_real_escape_string($data);
  }
  return $data;
}

// Get browser type..
function get_browser_type() {
  $agent = 'IE';
  if (isset($_SERVER['HTTP_USER_AGENT'])) {
    if (strpos(strtoupper($_SERVER['HTTP_USER_AGENT']),'OPERA')!==FALSE) {
      $agent = 'OPERA';
    } elseif (strpos(strtoupper($_SERVER['HTTP_USER_AGENT']),'MSIE')!==FALSE) {
      $agent = 'IE';
    } elseif (strpos(strtoupper($_SERVER['HTTP_USER_AGENT']),'OMNIWEB')!==FALSE) {
      $agent = 'OMNIWEB';
    } elseif (strpos(strtoupper($_SERVER['HTTP_USER_AGENT']),'MOZILLA')!==FALSE) {
      $agent = 'MOZILLA';
    } elseif (strpos(strtoupper($_SERVER['HTTP_USER_AGENT']),'KONQUEROR')!==FALSE) {
      $agent = 'KONQUEROR';
    } else {
      $agent = 'OTHER';
    }
  }
  return $agent;
}

// Get mime type..
function get_mime_type() {
  $agent = get_browser_type();
  $mime_type = ($agent == 'IE' || $agent == 'OPERA')
  ? 'application/octetstream'
  : 'application/octet-stream';
  return $mime_type;
}

// Sanitize data..
// Clean date vars..
$_GET = array_map('htmlspecialchars',$_GET);
if (isset($_GET['from']) && $_GET['from'] && strtotime($_GET['from'])==0) {
  $_GET['from'] = '0000-00-00';
}
if (isset($_GET['to']) && $_GET['to'] && strtotime($_GET['to'])==0) {
  $_GET['to'] = '0000-00-00';
}

?>