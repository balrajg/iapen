<?php

/*---------------------------------------------
  MAIAN SURVEY v1.1
  Written by David Ian Bennett
  E-Mail: N/A
  Website: www.maiansurvey.com
----------------------------------------------*/

class webSurvey {

var $prefix;
var $survey;

function checkSurveyExists() {
  $query = mysql_query("SELECT * FROM ".$this->prefix."surveys 
                        WHERE uniCode   = '".$this->survey."'
                        AND sur_status  = '1'
                        LIMIT 1
                        ") or die(db_MSG(__FILE__,__LINE__));
  return (mysql_num_rows($query)>0 ? true : false);
}

function checkSurveyExpiryDate() {
  $query = mysql_query("SELECT * FROM ".$this->prefix."surveys 
                        WHERE uniCode   = '".$this->survey."'
                        AND sur_status  = '1'
                        LIMIT 1
                        ") or die(db_MSG(__FILE__,__LINE__));
  $row = mysql_fetch_object($query);
  
  return (date("Y-m-d") >= $row->sur_date_expire && $row->sur_date_expire!='0000-00-00' ? true : false);
}

function loadVariant($id) {
  $query = mysql_query("SELECT * FROM ".$this->prefix."variants 
                        WHERE var_id = '".(int)$id."' LIMIT 1
                        ") or die(db_MSG(__FILE__,__LINE__));
  return mysql_fetch_object($query);
}

function loadResultsVariant($var,$que) {
  $query = mysql_query("SELECT * FROM ".$this->prefix."variants 
                        WHERE var_opt_id  = '".(int)$var."'
                        AND var_que_id    = '".(int)$que."' 
                        LIMIT 1
                        ") or die(db_MSG(__FILE__,__LINE__));
  return mysql_fetch_object($query);
}

function loadSurvey() {
  $query = mysql_query("SELECT * FROM ".$this->prefix."surveys 
                        WHERE uniCode = '".$this->survey."' LIMIT 1
                        ") or die(db_MSG(__FILE__,__LINE__));
  return mysql_fetch_object($query);
}

function getParticipantCount($id) {
  $id    = (int)$id;
  $query = mysql_query("SELECT DISTINCT(ans_session_id) FROM ".$this->prefix."answers 
                        WHERE ans_sur_id = '$id'
                        ") or die(db_MSG(__FILE__,__LINE__));
  return mysql_num_rows($query);
}

function loadColorScheme($id) {
  $id    = (int)$id;
  $query = mysql_query("SELECT * FROM ".$this->prefix."colorschemes 
                        WHERE csc_id = '$id' LIMIT 1
                        ") or die(db_MSG(__FILE__,__LINE__));
  return mysql_fetch_array($query);
}

function loadSurveyQuestions($id) {
  $q     = array();
  $id    = (int)$id;
  $query = mysql_query("SELECT que_id FROM ".$this->prefix."questions 
                        WHERE que_sur_id = '$id'
                        ORDER BY orderBy
                        ") or die(db_MSG(__FILE__,__LINE__));
  while ($row = mysql_fetch_object($query)) {
    $q[] = $row->que_id;
  }
  return $q;
}

function getSurveyQuestionCount($id) {
  $id     = (int)$id;
  $query = mysql_query("SELECT count(*) AS q_count FROM ".$this->prefix."questions 
                        WHERE que_sur_id = '$id' LIMIT 1
                        ") or die(db_MSG(__FILE__,__LINE__));
  $row = mysql_fetch_object($query);
  return $row->q_count;
}

function getQuestion ($id) {
  $id     = (int)$id;
  $query = mysql_query("SELECT * FROM ".$this->prefix."questions 
                        WHERE que_id = '$id' LIMIT 1
                        ") or die(db_MSG(__FILE__,__LINE__));
  return mysql_fetch_object($query);
}

function getVariantCount($id) {
  $id     = (int)$id;
  $query = mysql_query("SELECT * FROM ".$this->prefix."variants 
                        WHERE var_que_id = '$id'
                        ") or die(db_MSG(__FILE__,__LINE__));
  return mysql_num_rows($query);
}

function getDistinctAnswers($id,$ans) {
  $id     = (int)$id;
  $ans    = (int)$ans;
  $query = mysql_query("SELECT count(*) AS a_count FROM ".$this->prefix."answers 
                        WHERE ans_que_id  = '$id'
                        AND ans_var_id    = '$ans'
                        ") or die(db_MSG(__FILE__,__LINE__));
  $row = mysql_fetch_object($query);
  return $row->a_count;
}

function loadQuestionSessionVars($session,$survey,$id=0) {
  // If id var is greater than 0, question post var isn`t present so lets create it..
  if ($id>0) {
    $_POST['question'] = $id;
  }
  // Get question..
  $QUESTION = $this->getQuestion($_POST['question']);
  // Initialise vars if they aren`t set. This will be for the first question only during a multiple question survey..
  if (!isset($_SESSION['session_survey'])) {
    $_SESSION['session_survey']      = $session; // Session id..this is constant..
    $_SESSION['session_survey_id']   = $survey;  // Survey id..this is also constant..
    $_SESSION['session_build_type']  = array();  // Build type..array build..
    $_SESSION['session_que_id']      = array();  // Survey question id..array build..
  }
  if (!in_array($_POST['question'],$_SESSION['session_que_id'])) {
    $_SESSION['session_que_id'][]           = $_POST['question'];
  }
  $_SESSION['session_build_type'][$_POST['question']]  = $QUESTION->que_answer_type;
  // Process and write to session arrays..
  switch ($QUESTION->que_answer_type) {
    // Processing for radio buttons with other option. Radio buttons can only have one option selected..
    // If the text field is also present, this replaces the radio button selection if text is entered...
    case '3':
    if (isset($_POST['field_other_'.$_POST['question']]) && $_POST['field_other_'.$_POST['question']]) {
      unset($_SESSION['field_'.$_POST['question']]);
      $_SESSION['field_'.$_POST['question']]  = '';
      $_SESSION['field_'.$_POST['question']]  = $_POST['field_other_'.$_POST['question']];
    } else {
      $_SESSION['field_'.$_POST['question']]  = (isset($_POST['field_'.$_POST['question']]) ? $_POST['field_'.$_POST['question']] : '');
    }
    break;
    // Processing for checkboxes with other option. Checkboxes can have multiple selections
    // If the text field is also present, this is included with the checked box data..
    case '6':
    $_SESSION['field_'.$_POST['question']]  = array();  // Survey question answer..array build..clear each time question is updated..
    if (isset($_POST['field_'.$_POST['question']])) {
      for ($i=0; $i<count($_POST['field_'.$_POST['question']]); $i++) {
        $_SESSION['field_'.$_POST['question']][$i] = $_POST['field_'.$_POST['question']][$i];
      }
    }
    if (isset($_POST['field_other_'.$_POST['question']]) && $_POST['field_other_'.$_POST['question']]) { 
      $_SESSION['field_'.$_POST['question']][] = $_POST['field_other_'.$_POST['question']];
    }
    break;
    // Other option processing..
    default:
    if (isset($_POST['field_'.$_POST['question']]) && is_array($_POST['field_'.$_POST['question']])) {
      $_SESSION['field_'.$_POST['question']]  = array();  // Survey question answer..array build..clear each time question is updated..
      for ($i=0; $i<count($_POST['field_'.$_POST['question']]); $i++) {
        $_SESSION['field_'.$_POST['question']][$i] = $_POST['field_'.$_POST['question']][$i];
      }
    } else {
      if (isset($_POST['field_'.$_POST['question']]) || isset($_POST['field_other_'.$_POST['question']])) {
        $_SESSION['field_'.$_POST['question']]  = '';  // Survey question answer..array build..clear each time question is updated..
        $_SESSION['field_'.$_POST['question']]  = (isset($_POST['field_other_'.$_POST['question']]) ? $_POST['field_other_'.$_POST['question']] : $_POST['field_'.$_POST['question']]);
      }
    }
    break;
  }
}

function loadOrderOfImportanceArray($id) {
  $id    = (int)$id;
  $query = mysql_query("SELECT count(*) AS v_count FROM ".$this->prefix."variants WHERE var_que_id = '$id'") or die(db_MSG(__FILE__,__LINE__));
  $row   = mysql_fetch_object($query);
  return range(1,$row->v_count);
}

function errorCheckField($id,$lang,$lang2) {
  $QUESTION  = $this->getQuestion($id);
  $count     = 0;
  $data      = '';
  // Are we checking order of importance option..
  // Different checking for this to make sure each option different..
  if ($QUESTION->que_answer_type==7 && $QUESTION->que_required) {
    $array = (isset($_POST['field_'.$id]) ? $_POST['field_'.$id] : '');
    if (!empty($array)) {
      // Flip post array...woosh...
      $array = array_flip($array);
      // Get array of values...
      $oFImp = $this->loadOrderOfImportanceArray($id);
      // See if values exist...well, keys now actually...
      for ($i=0; $i<count($oFImp); $i++) {
        if (!array_key_exists($oFImp[$i],$array)) {
          $data = str_replace('{error}',$lang2,file_get_contents(PATH.'templates/html/error.tpl'));
        }
      }
    }
  } else {
    // Check array fields..this would apply to select and checkboxes..
    if (isset($_POST['field_'.$id]) && is_array($_POST['field_'.$id]) && empty($_POST['field_'.$id]) && $QUESTION->que_required) {
      $count++;
    }
    // Check none array fields..boxes and radio buttons..
    if (isset($_POST['field_'.$id]) && !is_array($_POST['field_'.$id]) && $_POST['field_'.$id]=='' && $QUESTION->que_required) {
      $count++;
    }
    // Check field id is set..
    if (!isset($_POST['field_'.$id]) && $QUESTION->que_required) {
      $count++;
    }
    // If field id isn`t set, but other field is, reset count..
    if ($count>0 && isset($_POST['field_other_'.$id]) && $_POST['field_other_'.$id]!='') {
      $count = 0;
    }
    // If error, show error..
    if ($count>0) {
      $data = str_replace('{error}',$lang,file_get_contents(PATH.'templates/html/error.tpl'));
    }
  }
  return $data;
}

function setSurveyCookie() {
  if (!isset($_COOKIE['survey_'.$this->survey])) {
    setcookie("survey_".md5($this->survey.SECRET_KEY),md5(time()),time()+60*60*24*365);
  }
}

function checkSurveyCookie() {
  return (isset($_COOKIE['survey_'.md5($this->survey.SECRET_KEY)]) ? true : false);
}

function logUserData($id,$void=false) {
  $_POST = array_map('safeImport',$_POST);
  mysql_query("INSERT INTO ".$this->prefix."users (
               usr_sur_id,
               usr_email,
               usr_name,
               usr_date,
               usr_IP 
               ) VALUES (
               '$id',
               '".$_POST['email']."',
               '".$_POST['name']."',
               '".date("Y-m-d")."',
               '".getRealIPAddr()."'
               )") or die(db_MSG(__FILE__,__LINE__));
}

function addSurveyResponsesToDatabase($session,$survey) {
  for ($i=0; $i<count($_SESSION['session_que_id']); $i++) {
    $count = 0;
    // Check if data is an array or not. Arrays hold multiple data..
    // This won`t apply to text input boxes..
    if (isset($_SESSION['field_'.$_SESSION['session_que_id'][$i]]) && is_array($_SESSION['field_'.$_SESSION['session_que_id'][$i]])) {
      foreach ($_SESSION['field_'.$_SESSION['session_que_id'][$i]] AS $value) {
        // For order of importance add values to text field..
        if ($_SESSION['session_build_type'][$_SESSION['session_que_id'][$i]]==7) {
          mysql_query("INSERT INTO ".$this->prefix."answers (
                       ans_sur_id,
                       ans_que_id,
                       ans_var_id,
                       ans_text,
                       ans_session_id
                       ) VALUES (
                       '$survey',
                       '".(int)$_SESSION['session_que_id'][$i]."',
                       '".(++$count)."',
                       '".safeImport($value)."',
                       '$session'
                       )") or die(db_MSG(__FILE__,__LINE__));
        } else {
          // The value of $value is checked here in case checkboxes were used with the other option..
          // If they were, the checkbox array data could contain text, in which case the import would revert to 0 for int field..
          // We can use 'ctype_digit' to check this array value. If it returns false its text and must go in the 'ans_text' field..
          mysql_query("INSERT INTO ".$this->prefix."answers (
                       ans_sur_id,
                       ans_que_id,
                       ans_var_id,
                       ans_text,
                       ans_session_id
                       ) VALUES (
                       '$survey',
                       '".(int)$_SESSION['session_que_id'][$i]."',
                       '".(ctype_digit($value) ? safeImport($value) : '0')."',
                       '".(!ctype_digit($value) ? safeImport($value) : '')."',
                       '$session'
                       )") or die(db_MSG(__FILE__,__LINE__));
        }
      }
    } else {
	  // Check question type for single/multiple answers..
	  $QUESTION = $this->getQuestion($_SESSION['session_que_id'][$i]);
	  if (in_array($QUESTION->que_answer_type,array(8,9))) {
	    $varID = '0';
	    $text  = (!ctype_digit($_SESSION['field_'.$_SESSION['session_que_id'][$i]]) ? safeImport($_SESSION['field_'.$_SESSION['session_que_id'][$i]]) : '');
	  } else {
	    $varID = (ctype_digit($_SESSION['field_'.$_SESSION['session_que_id'][$i]]) ? $_SESSION['field_'.$_SESSION['session_que_id'][$i]] : '0');
	    $text  = (!ctype_digit($_SESSION['field_'.$_SESSION['session_que_id'][$i]]) ? safeImport($_SESSION['field_'.$_SESSION['session_que_id'][$i]]) : '');
	  }
      // Parse data for single field boxes and text areas..
      if (isset($_SESSION['field_'.$_SESSION['session_que_id'][$i]])) {
        mysql_query("INSERT INTO ".$this->prefix."answers (
                     ans_sur_id,
                     ans_que_id,
                     ans_var_id,
                     ans_text,
                     ans_session_id
                     ) VALUES (
                     '$survey',
                     '".(int)$_SESSION['session_que_id'][$i]."',
                     '{$varID}',
                     '{$text}',
                     '$session'
                     )") or die(db_MSG(__FILE__,__LINE__));
      }
    }
  }
}

function logKeywords($survey) {
  for ($i=0; $i<count($_SESSION['session_que_id']); $i++) {
    $field = '';
    $keys  = '';
    // Only log keyword data from field boxes and other field boxes..
    if (isset($_SESSION['field_'.$_SESSION['session_que_id'][$i]])) {
      // Get keywords for text boxes..
      if (in_array($_SESSION['session_build_type'][$_SESSION['session_que_id'][$i]],array(8,9))) {
        $keys = trim($_SESSION['field_'.$_SESSION['session_que_id'][$i]]);
      }
      // Get text data for radio button other field..
      if (in_array($_SESSION['session_build_type'][$_SESSION['session_que_id'][$i]],array(3))) {
        $keys .= (!ctype_digit($_SESSION['field_'.$_SESSION['session_que_id'][$i]]) ? ' '.trim($_SESSION['field_'.$_SESSION['session_que_id'][$i]]).' ' : '');
      }
      // Get text data for checkbox..
      if (in_array($_SESSION['session_build_type'][$_SESSION['session_que_id'][$i]],array(6))) {
        // Checkboxes are array vars, so get count and subtract 1 for last slot..
        // Then check to see if last slot is text data or not..
        $cnt   = (count($_SESSION['field_'.$_SESSION['session_que_id'][$i]])-1);
        $keys .= (!ctype_digit($_SESSION['field_'.$_SESSION['session_que_id'][$i]][$cnt]) ? ' '.trim($_SESSION['field_'.$_SESSION['session_que_id'][$i]][$cnt]).' ' : '');
      }
      if ($keys) {
        // Strip new line characters from data to remove blank lines..
        $field = str_replace(defineNewline(),'',trim($keys));
        $keys  = '';
      }
    }
    // Only process if field contains data..
    if ($field) {
      // Get common words to skip and read into array..
      $common = file(PATH.'inc/common-words.txt');
      // Clean array if array isn`t empty..
      if (!empty($common)) {
        $common = array_map('trim',$common);
      }
      // Split words from form data...
      $words = explode(" ", $field);
      // Loop and add to database..
      for ($j=0; $j<count($words); $j++) {
        $words[$j] = (get_magic_quotes_gpc() ? stripslashes($words[$j]) : $words[$j]);
        // Omit common words..
        if (!empty($common) && !in_array($words[$j],$common) && strlen($words[$j])>2) {
          mysql_query("INSERT INTO ".$this->prefix."keywords (
                       key_sur_id,
                       key_que_id,
                       key_word,
                       key_date
                       ) VALUES (
                       '$survey',
                       '".(int)$_SESSION['session_que_id'][$i]."',
                       '".safeImport($words[$j])."',
                       '".date("Y-m-d")."'
                       )") or die(db_MSG(__FILE__,__LINE__));
        }
      }
    } 
  }
}

function clearSessionVars() {
  session_unset();
  session_destroy();
  unset($_SESSION);
}

}

?>
