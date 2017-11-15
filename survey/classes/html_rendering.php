<?php

/*---------------------------------------------
  MAIAN SURVEY v1.1
  Written by David Ian Bennett
  E-Mail: N/A
  Website: www.maiansurvey.com
----------------------------------------------*/

class htmlObject extends webSurvey {

var $prefix;

function textarea($name,$value) {
  return str_replace(array('{name}','{value}'),array($name,$value),file_get_contents(PATH.'templates/html/textarea.tpl'));
}

function formBox($name,$value) {
  return str_replace(array('{name}','{value}'),array($name,$value),file_get_contents(PATH.'templates/html/text_box.tpl'));
}

function otherFormBox($text,$name,$value) {
  return str_replace(array('{text}','{name}','{value}'),array($text,$name,(!is_array($value) ? $value : '')),file_get_contents(PATH.'templates/html/other_box.tpl'));
}

function select($name,$options,$choose) {
  return str_replace(array('{name}','{options}','{choose}'),array($name,$options,$choose),file_get_contents(PATH.'templates/html/select.tpl'));
}

function checkBox($name,$value,$checked,$option) {
  return str_replace(array('{name}','{value}','{checked}','{option}'),array($name,$value,$checked,$option),file_get_contents(PATH.'templates/html/checkbox.tpl'));
}

function radioButton($name,$value,$checked,$option) {
  return str_replace(array('{name}','{value}','{checked}','{option}'),array($name,$value,$checked,$option),file_get_contents(PATH.'templates/html/radio_button.tpl'));
}

function selectOptions($value,$selected) {
  return str_replace(array('{value}','{selected}'),array($value,$selected),file_get_contents(PATH.'templates/html/select_option.tpl'));
}

function renderHTML($id,$other) {
  $string    = '';
  $QUESTION  = $this->getQuestion($id);
  
  // Variants..
  $VARIANTS  = $this->getVariants($id);
  
  // If we edit a question, clear session vars so the post vars take over..
  // If we don`t do this, session vars will overwrite post vars if post vars are removed...
  // Confused? Me too...:p
  if (isset($_POST['question'])) {
    if (isset($_SESSION['field_'.$id])) {
      unset($_SESSION['field_'.$id]);
    }
  }
  
  // Same as above for single page survey..
  if (isset($_POST['field_'.$id])) {
    unset($_SESSION['field_'.$id]);
  }
  
  // Which html object are we rendering..
  // $QUESTION->que_answer_type
  switch ($QUESTION->que_answer_type) {
    // Single choice answer..vertical..radio buttons..variants..
    case '1':
    if (!empty($VARIANTS)) {
      for ($i=0; $i<count($VARIANTS); $i++) {
        $checked = '';
        if (isset($_POST['field_'.$id]) && $_POST['field_'.$id]==($i+1)) {
          $checked = 'checked="checked"';
        }
        if (!isset($_POST['field_'.$id]) && isset($_SESSION['field_'.$id]) && $checked=='' && $_SESSION['field_'.$id]==($i+1)) {
          $checked = 'checked="checked"';
        }
        $string .= $this->radioButton('field_'.$id,($i+1),$checked,$VARIANTS[$i]).($i!=(count($VARIANTS)-1) ? '<br />' : '').defineNewline();
      }
    }
    break;
    // Single Choice Answer..horizontal..radio buttons..variants
    case '2':
    if (!empty($VARIANTS)) {
      for ($i=0; $i<count($VARIANTS); $i++) {
        $checked = '';
        if (isset($_POST['field_'.$id]) && $_POST['field_'.$id]==($i+1)) {
          $checked = 'checked="checked"';
        }
        if (!isset($_POST['field_'.$id]) && isset($_SESSION['field_'.$id]) && $checked=='' && $_SESSION['field_'.$id]==($i+1)) {
          $checked = 'checked="checked"';
        }
        $string .= $this->radioButton('field_'.$id,($i+1),$checked,$VARIANTS[$i]).defineNewline();
      }
    }
    break;
    // Single Choice Answer with Other Option..radio buttons..variants
    case '3':
    if (!empty($VARIANTS)) {
      for ($i=0; $i<count($VARIANTS); $i++) {
        $checked = '';
        if (isset($_POST['field_'.$id]) && $_POST['field_'.$id]==($i+1)) {
          $checked = 'checked="checked"';
        }
        if (!isset($_POST['field_'.$id]) && isset($_SESSION['field_'.$id]) && $checked=='' && $_SESSION['field_'.$id]==($i+1)) {
          $checked = 'checked="checked"';
        }
        $string .= $this->radioButton('field_'.$id,($i+1),$checked,$VARIANTS[$i]).($i!=(count($VARIANTS)-1) ? '<br />' : '<br /><br />').defineNewline();
      }
      $o_value = (isset($_POST['field_other_'.$id]) ? cleanDataEnt($_POST['field_other_'.$id]) : (isset($_SESSION['field_'.$id]) ? cleanDataEnt($_SESSION['field_'.$id]) : ''));
      $string .= $this->otherFormBox($other,'field_other_'.$id,$o_value).defineNewline();
    }
    break;
    // Multiple Choice Answer..vertical..checkboxes..variants..
    case '4':
    if (!empty($VARIANTS)) {
      for ($i=0; $i<count($VARIANTS); $i++) {
        $checked = '';
        if (isset($_POST['field_'.$id]) && is_array($_POST['field_'.$id]) && in_array(($i+1),$_POST['field_'.$id])) {
          $checked = 'checked="checked"';
        }
        if (!isset($_POST['field_'.$id]) && isset($_SESSION['field_'.$id]) && is_array($_SESSION['field_'.$id]) && in_array(($i+1),$_SESSION['field_'.$id]) && $checked=='') {
          $checked = 'checked="checked"';
        }
        $string .= $this->checkbox('field_'.$id,($i+1),$checked,$VARIANTS[$i]).($i!=(count($VARIANTS)-1) ? '<br />' : '').defineNewline();
      }
    }
    break;
    // Multiple Choice Answer..horizontal..checkboxes..variants..
    case '5':
    if (!empty($VARIANTS)) {
      for ($i=0; $i<count($VARIANTS); $i++) {
        $checked = '';
        if (isset($_POST['field_'.$id]) && is_array($_POST['field_'.$id]) && in_array(($i+1),$_POST['field_'.$id])) {
          $checked = 'checked="checked"';
        }
        if (!isset($_POST['field_'.$id]) && isset($_SESSION['field_'.$id]) && is_array($_SESSION['field_'.$id]) && in_array(($i+1),$_SESSION['field_'.$id]) && $checked=='') {
          $checked = 'checked="checked"';
        }
        $string .= $this->checkbox('field_'.$id,($i+1),$checked,$VARIANTS[$i]).defineNewline();
      }
    }
    break;
    // Multiple Choice Answer with Other Option..variants
    case '6':
    if (!empty($VARIANTS)) {
      for ($i=0; $i<count($VARIANTS); $i++) {
        $checked = '';
        if (isset($_POST['field_'.$id]) && is_array($_POST['field_'.$id]) && in_array(($i+1),$_POST['field_'.$id])) {
          $checked = 'checked="checked"';
        }
        if (!isset($_POST['field_'.$id]) && isset($_SESSION['field_'.$id]) && is_array($_SESSION['field_'.$id]) && in_array(($i+1),$_SESSION['field_'.$id]) && $checked=='') {
          $checked = 'checked="checked"';
        }
        $string .= $this->checkbox('field_'.$id,($i+1),$checked,$VARIANTS[$i]).($i!=(count($VARIANTS)-1) ? '<br />' : '<br /><br />').defineNewline();
      }
      $o_value = (isset($_POST['field_other_'.$id]) ? cleanDataEnt($_POST['field_other_'.$id]) : (isset($_SESSION['field_'.$id]) ? cleanDataEnt($_SESSION['field_'.$id]) : ''));
      $string .= $this->otherFormBox($other,'field_other_'.$id,$o_value).defineNewline();
    }
    break;
    // Order of Importance.. select..variants..
    case '7':
    if (!empty($VARIANTS)) {
      for ($i=0; $i<count($VARIANTS); $i++) {
        $select = '';
        for ($j=1; $j<count($VARIANTS)+1; $j++) {
          $selected = '';
          if (isset($_POST['field_'.$id]) && $_POST['field_'.$id][$i]==$j) {
            $selected = 'selected="selected"';
          }
          if (!isset($_POST['field_'.$id]) && isset($_SESSION['field_'.$id]) && $selected=='' && $_SESSION['field_'.$id][$i]==$j) {
            $selected = 'selected="selected"';
          }
          $select .= $this->selectOptions($j,$selected);
        }
        $string .= $this->select('field_'.$id,$select,$VARIANTS[$i]).($i!=(count($VARIANTS)-1) ? '<br />' : '').defineNewline();
      }
    }
    break;
    // Text Answer..single line..form box
    case '8':
    $value = (isset($_POST['field_'.$id]) ? cleanDataEnt($_POST['field_'.$id]) : (isset($_SESSION['field_'.$id]) ? cleanDataEnt($_SESSION['field_'.$id]) : ''));
    $string = $this->formBox('field_'.$id,$value).defineNewline();
    break;
    // Text Answer..multiple lines..textarea..
    case '9':
    $value = (isset($_POST['field_'.$id]) ? cleanDataEnt($_POST['field_'.$id]) : (isset($_SESSION['field_'.$id]) ? cleanDataEnt($_SESSION['field_'.$id]) : ''));
    $string = $this->textarea('field_'.$id,$value).defineNewline();
    break;
  }
  
  return trim($string);
}

function getVariants($id) {
  $string = array();
  $id     = (int)$id;
  $query = mysql_query("SELECT * FROM ".$this->prefix."variants 
                        WHERE var_que_id = '$id'
                        ORDER BY var_opt_id
                        ") or die(db_MSG(__FILE__,__LINE__));
  while ($row = mysql_fetch_object($query)) {
    $string[] = trim($row->var_text);
  }
  return $string;
}

function loadDefaultColorScheme() {
  return array('csc_width'            => '850',
               'title_background'     => 'fff',
               'title_color'          => '000',
               'title_font'           => 'verdana',
               'title_size'           => '12',
               'question_background'  => 'fff',
               'question_color'       => '000',
               'question_font'        => 'verdana',
               'question_size'        => '12',
               'answer_background'    => 'fff',
               'answer_color'         => '000',
               'answer_font'          => 'verdana',
               'answer_size'          => '12'
  );
}

}

?>
