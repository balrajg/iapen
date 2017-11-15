<?php

/*---------------------------------------------
  MAIAN SURVEY v1.1
  Written by David Ian Bennett
  E-Mail: N/A
  Website: www.maiansurvey.com
----------------------------------------------*/

class colorSchemer {

var $prefix;

function addScheme () {
  $_POST = array_map('safeImport',$_POST);
  mysql_query("INSERT INTO ".$this->prefix."colorschemes (
               csc_title,
               csc_width,
               title_background,
               title_color,
               title_font,
               title_size,
               question_background,
               question_color,
               question_font,
               question_size,
               answer_background,
               answer_color,
               answer_font,
               answer_size
               ) VALUES (
               '".$_POST['csc_title']."',
               '".($_POST['csc_width'] ? $_POST['csc_width'] : '600')."',
               '".$_POST['title_background']."',
               '".$_POST['title_color']."',
               '".$_POST['title_font']."',
               '".$_POST['title_size']."',
               '".$_POST['question_background']."',
               '".$_POST['question_color']."',
               '".$_POST['question_font']."',
               '".$_POST['question_size']."',
               '".$_POST['answer_background']."',
               '".$_POST['answer_color']."',
               '".$_POST['answer_font']."',
               '".$_POST['answer_size']."'
               )") or die(db_MSG(__FILE__,__LINE__));
}

function updateScheme () {
  $_POST = array_map('safeImport',$_POST);
  mysql_query("UPDATE ".$this->prefix."colorschemes SET
               csc_title            = '".$_POST['csc_title']."',
               csc_width            = '".($_POST['csc_width'] ? $_POST['csc_width'] : '600')."',
               title_background     = '".$_POST['title_background']."',
               title_color          = '".$_POST['title_color']."',
               title_font           = '".$_POST['title_font']."',
               title_size           = '".$_POST['title_size']."',
               question_background  = '".$_POST['question_background']."',
               question_color       = '".$_POST['question_color']."',
               question_font        = '".$_POST['question_font']."',
               question_size        = '".$_POST['question_size']."',
               answer_background    = '".$_POST['answer_background']."',
               answer_color         = '".$_POST['answer_color']."',
               answer_font          = '".$_POST['answer_font']."',
               answer_size          = '".$_POST['answer_size']."'
               WHERE csc_id         = '".(int)$_POST['edit']."'
               LIMIT 1
               ") or die(db_MSG(__FILE__,__LINE__));
}

function deleteScheme ($id) {
  $id = (int)$id;
  mysql_query("DELETE FROM ".$this->prefix."colorschemes 
               WHERE csc_id = '$id' LIMIT 1
               ") or die(db_MSG(__FILE__,__LINE__));
}

function getScheme ($id) {
  $id = (int)$id;
  $query = mysql_query("SELECT * FROM ".$this->prefix."colorschemes 
                        WHERE csc_id = '$id' LIMIT 1
                        ") or die(db_MSG(__FILE__,__LINE__));
  return mysql_fetch_object($query);
}

function checkTitle ($title,$id='') {
  $query = mysql_query("SELECT * FROM ".$this->prefix."colorschemes 
                        WHERE csc_title = '".safeImport($title)."'
                        ".($id ? 'AND csc_id != \''.(int)$id.'\'' : '')."
                        LIMIT 1
                        ") or die(db_MSG(__FILE__,__LINE__));
  return (mysql_num_rows($query)>0 ? true : false);
}

}

?>
