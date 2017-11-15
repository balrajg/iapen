<?php

/*---------------------------------------------
  MAIAN SURVEY v1.1
  Written by David Ian Bennett
  E-Mail: N/A
  Website: www.maiansurvey.com
----------------------------------------------*/

class questions {

var $prefix;

function addQuestion() {
  $vars  = ($_POST['var_text'] ? explode(defineNewline(),$_POST['var_text']) : '');
  $_POST = array_map('safeImport',$_POST);
  mysql_query("INSERT INTO ".$this->prefix."questions (
               que_sur_id,
               que_text,
               que_help_text,
               que_answer_type,
               que_required,
               orderBy
               ) VALUES (
               '".$_POST['survey']."',
               '".$_POST['que_text']."',
               '".$_POST['que_help_text']."',
               '".(isset($_POST['que_answer_type']) ? $_POST['que_answer_type'] : '1')."',
               '".(isset($_POST['que_required']) ? $_POST['que_required'] : '1')."',
               '".$this->getNextOrderTotal()."'
               )") or die(db_MSG(__FILE__,__LINE__));
  $que = mysql_insert_id();
  if (is_array($vars)) {
    $vars = array_map('trim',$vars);
    for ($i=0; $i<count($vars); $i++) {             
      mysql_query("INSERT INTO ".$this->prefix."variants (  
                   var_opt_id,
                   var_que_id,
                   var_text 
                   ) VALUES (
                   '".($i+1)."',
                   '".$que."',
                   '".safeImport($vars[$i])."'
                   )") or die(db_MSG(__FILE__,__LINE__));  
    }
  }       
}

function updateQuestion() {
  $vars = ($_POST['var_text'] ? explode(defineNewline(),$_POST['var_text']) : '');
  if (is_array($vars)) {
    $vars = array_map('trim',$vars);
  }
  $_POST = array_map('safeImport',$_POST);
  mysql_query("UPDATE ".$this->prefix."questions SET
               que_text         = '".$_POST['que_text']."',
               que_help_text    = '".$_POST['que_help_text']."',
               que_answer_type  = '".(isset($_POST['que_answer_type']) ? $_POST['que_answer_type'] : '1')."',
               que_required     = '".(isset($_POST['que_required']) ? $_POST['que_required'] : '1')."'
               WHERE que_id     = '".(int)$_POST['edit']."'
               ") or die(db_MSG(__FILE__,__LINE__));
  if (is_array($vars)) {
    $this->clearVariants($_POST['edit']);
    for ($i=0; $i<count($vars); $i++) {             
      mysql_query("INSERT INTO ".$this->prefix."variants (  
                   var_opt_id,
                   var_que_id,
                   var_text 
                   ) VALUES (
                   '".($i+1)."',
                   '".(int)$_POST['edit']."',
                   '".safeImport($vars[$i])."'
                   )") or die(db_MSG(__FILE__,__LINE__));  
    }
  }                          
}

function deleteQuestion($id) {
  $id = (int)$id;
  mysql_query("DELETE FROM ".$this->prefix."questions 
               WHERE que_id = '$id'
               LIMIT 1
               ") or die(db_MSG(__FILE__,__LINE__));
  mysql_query("DELETE FROM ".$this->prefix."variants 
               WHERE var_que_id = '$id'
               ") or die(db_MSG(__FILE__,__LINE__));                                       
}

function clearVariants($id) {
  $id = (int)$id;
  mysql_query("DELETE FROM ".$this->prefix."variants 
               WHERE var_que_id = '$id'
               ") or die(db_MSG(__FILE__,__LINE__));                                       
}

function getQuestion($id) {
  $id = (int)$id;
  $query = mysql_query("SELECT * FROM ".$this->prefix."questions 
                        WHERE que_id = '$id' LIMIT 1
                        ") or die(db_MSG(__FILE__,__LINE__));
  return mysql_fetch_object($query);
}

function getNextOrderTotal() {
  $query = mysql_query("SELECT count(*) AS q_count FROM ".$this->prefix."questions") or die(db_MSG(__FILE__,__LINE__));
  $row = mysql_fetch_object($query);
  return $row->q_count+1;
}

function updateOrderByOptions() {
  for ($i=0; $i<count($_POST['question']); $i++) {
    mysql_query("UPDATE ".$this->prefix."questions SET
                 orderBy       = '".(int)$_POST['order_by'][$i]."'
                 WHERE que_id  = '".(int)$_POST['question'][$i]."'
                 LIMIT 1
                 ") or die(db_MSG(__FILE__,__LINE__));
  }
}

function getVariants($id) {
  $id     = (int)$id;
  $string = '';
  $query = mysql_query("SELECT * FROM ".$this->prefix."variants 
                        WHERE var_que_id = '$id'
						ORDER BY var_opt_id
                        ") or die(db_MSG(__FILE__,__LINE__));
  while ($row = mysql_fetch_object($query)) {
    $string .= $row->var_text.defineNewline();
  }
  return trim($string);
}

}

?>
