<?php

/*---------------------------------------------
  MAIAN SURVEY v1.1
  Written by David Ian Bennett
  E-Mail: N/A
  Website: www.maiansurvey.com
----------------------------------------------*/

class webSurveyResults extends webSurvey {

function showQuestionSurveyResults($type,$id,$other,$viewall,$viewall2,$msg1,$msg2) {
  $string    = '';
  $QUESTION  = $this->getQuestion($id);
  $SURVEY    = $this->loadSurvey();
  $COLOR     = $this->loadColorScheme($SURVEY->sur_color_scheme);
  $count     = 0;
  
  switch ($QUESTION->que_answer_type) {
    // Single choice answer..vertical..radio buttons..variants..
    case '1':
    case '2':
    case '3':
    case '4':
    case '5':
    case '6':
    $query = mysql_query("SELECT * FROM ".$this->prefix."variants 
                          WHERE var_que_id = '$id'
                          ") or die(db_MSG(__FILE__,__LINE__));
    if (mysql_num_rows($query)>0) {
      while ($row = mysql_fetch_object($query)) {
        $string .= str_replace(array('{variant}','{percentage}','{b}','{bar}'),array($this->cleanData(trim($row->var_text)),$this->calculateAnswerPercentage($id,$row->var_opt_id),(++$count==mysql_num_rows($query) && !in_array($QUESTION->que_answer_type,array(3,6)) ? 'b' : ''),$this->progressBar($this->calculateAnswerPercentage($id,$row->var_opt_id,false,true))),file_get_contents(PATH.'templates/html/result_type_options.tpl'));
      }
    }
    if ($QUESTION->que_answer_type==3 || $QUESTION->que_answer_type==6) {
      $string .= str_replace(array('{variant}','{percentage}','{b}','{bar}'),array('<a href="results.php?survey='.(isset($_GET['survey']) && $_GET['survey']>32 ? $_GET['survey'] : $this->survey).'&amp;other='.$id.'" title="'.$msg1.'">'.$other.'</a>',$this->calculateAnswerPercentage($id,0,true),'b',$this->progressBar($this->calculateAnswerPercentage($id,0,false,true))),file_get_contents(PATH.'templates/html/result_type_options.tpl'));
    }
    break;
    // Order of importance..
    case '7':
    $query = mysql_query("SELECT ans_var_id,ans_que_id,COUNT(*) AS v_count,SUM(ans_text) AS s_count FROM ".$this->prefix."answers 
                          WHERE ans_que_id = '$id'
                          GROUP BY 1 ORDER BY 4 DESC
                          ") or die(db_MSG(__FILE__,__LINE__));
    if (mysql_num_rows($query)>0) {
      while ($row = mysql_fetch_object($query)) {
        // Get amount of answers for this question..
        $dis         = $this->getDistinctAnswers($row->ans_que_id,$row->ans_var_id);
        // Now calculate the maximum total for this answer..
        $max         = $this->getVariantCount($row->ans_que_id)*$dis;
        // Load results var into array..
        $var         = $this->loadResultsVariant($row->ans_var_id,$row->ans_que_id);
        // Number formatting...count & percentage..
        $percentage  = number_format($row->s_count/$max*100,1).'% ('.$row->s_count.'/'.($max).')';
        $raw         = number_format($row->s_count/$max*100,1);
        $string      .= str_replace(array('{variant}','{percentage}','{b}','{bar}'),array($this->cleanData(trim($var->var_text)),$percentage,(++$count==mysql_num_rows($query) && !in_array($QUESTION->que_answer_type,array(3,6)) ? 'b' : ''),$this->progressBar($raw)),file_get_contents(PATH.'templates/html/result_type_options.tpl'));
      }
    }
    break;
    // Text Answer..single line..form box...multiple lines..textarea..
    case '8':
    case '9':
    $query = mysql_query("SELECT * FROM ".$this->prefix."answers 
                          WHERE ans_que_id  = '$id'
                          AND ans_text     != ''
                          ") or die(db_MSG(__FILE__,__LINE__));
    if (mysql_num_rows($query)>0) {
      $row = mysql_fetch_object($query);
      if ($row->ans_text) {
        $string = str_replace(array('{variant}'),array('<a href="results.php?survey='.(isset($_GET['survey']) && $_GET['survey']>32 ? $_GET['survey'] : $this->survey).'&amp;other='.$id.'" title="'.$msg2.'">'.$viewall.'</a>'),file_get_contents(PATH.'templates/html/result_type_boxes.tpl'));
      } else {
        $string = $viewall2;
      }
    } else {
      $string = $viewall2;
    }
    break;
  }
  
  return trim($string);
}

function calculateAnswerPercentage($question,$variant,$other=false,$raw=false) {
  $sur = $this->loadSurvey();
  // Firstly, we need to find out how many times answers appear for this question..
  $query = mysql_query("SELECT count(*) AS a_count FROM ".$this->prefix."answers 
                        WHERE ans_que_id  = '$question' 
                        AND ans_sur_id    = '".$sur->sur_id."'
                        ") or die(db_MSG(__FILE__,__LINE__));
  $count = mysql_fetch_object($query);
  // Now set the maximum amount..this is 100%..
  $MAX = $count->a_count;
  // Now find out how many times this variant has been specified as an answer to this question..
  $query2 = mysql_query("SELECT count(*) AS v_count FROM ".$this->prefix."answers 
                         WHERE ans_que_id  = '$question' 
                         AND ans_var_id    = '$variant' 
                         AND ans_sur_id    = '".$sur->sur_id."'
                         ") or die(db_MSG(__FILE__,__LINE__));
  $count2 = mysql_fetch_object($query2);
  // Set the count for this variant..
  $VAR_COUNT = $count2->v_count;
  // Return percentage and amount of votes..
  // Percentage shown as 1 decimal place..
  // For raw data, no symbol..
  if ($raw) { 
    return ($VAR_COUNT>0 && $MAX>0 ? ($VAR_COUNT/$MAX * 100) : '0');
  } else {
    if ($VAR_COUNT>0 && $MAX>0) {
      $percentage = ($VAR_COUNT/$MAX * 100);
      return number_format($percentage,1).'% ('.number_format($VAR_COUNT).')';
    } else {
      return '0% (0)';
    }
  }
}

function progressBar($perc) {
  $perc = ceil($perc);
  return str_replace(array('{width}','{style}'),array($perc,($perc==0 ? ' style="background:none"' : '')),file_get_contents(PATH.'templates/html/progress_bar_results.tpl'));
}

function cleanData($data) {
  return (get_magic_quotes_gpc() ? stripslashes($data) : $data);
}

}

?>