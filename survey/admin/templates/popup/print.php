<?php
if (!defined('INC')) { die('Error! You don`t have permission to view this file!'); }

$q_keys = mysql_query("SELECT DISTINCT(key_word),key_word,key_que_id,key_sur_id,count(*) AS k_count FROM ".DB_PREFIX."keywords
                       WHERE key_sur_id = '".(int)$_GET['survey']."'
                       ".(isset($_GET['question']) && ctype_digit($_GET['question']) ? 'AND key_que_id = \''.(int)$_GET['question'].'\'' : '')."
                       ".(isset($_GET['from']) &&  $_GET['from'] && isset($_GET['to']) && $_GET['to'] ? 'AND key_date BETWEEN \''.$_GET['from'].'\' AND \''.$_GET['to'].'\'' : '')."
                       GROUP BY 1 ORDER BY k_count DESC
                       ") or die(db_MSG(__FILE__,__LINE__));
?>
<div style="padding:5px;background:#FAFAFA">
<div id="print_top">
<p>
<?php
$SURVEY = $SVY->getSurvey((int)$_GET['survey']);
echo cleanDataEnt($SURVEY->sur_title);
?>
<span style="display:block;color:#666;font-size:12px;margin-top:3px">
<?php
if (isset($_GET['question']) && ctype_digit($_GET['question'])) {
  include(PATH.'classes/questions.php');
  $QTN          = new questions();
  $QTN->prefix  = DB_PREFIX;
  $QUESTION     = $QTN->getQuestion((int)$_GET['question']);
  echo 'Q: '.cleanDataEnt($QUESTION->que_text);
} else {
  echo $msg_keywords4;
}
if (isset($_GET['from']) &&  $_GET['from'] && isset($_GET['to']) && $_GET['to']) {
?>
<span style="display:block;margin-top:3px;font-size:11px;font-weight:normal">
<?php
echo '('.$_GET['from'].' - '.$_GET['to'].')';
?>
</span>
<?php
}
?>
</span>
</p>
</div>
<div id="print_screen">
<table width="100%" cellspacing="2" cellpadding="0">
<tr>
<?php
if (mysql_num_rows($q_keys)>0) {
  while ($KEYS = mysql_fetch_object($q_keys)) {
    $run = ++$count;
    echo '<td style="text-align:left;vertical-align:top;width:'.round(100/3).'%"><b>'.str_replace('.','',cleanDataEnt($KEYS->key_word)).'</b> <span style="font-size:11px;color:#666">('.number_format($KEYS->k_count).' - '.number_format($KEYS->k_count/mysql_num_rows($q_keys)*100,2).'%)</span></td>'."\n";
    if ($run%3==0) {
     echo ($run!=mysql_num_rows($q_keys) ? '</tr>'."\n" : '');
     echo ($run!=mysql_num_rows($q_keys) ? '<tr>'."\n" : '');
    }
  }
}
?>
</tr>
</table>
</div>
</div>
