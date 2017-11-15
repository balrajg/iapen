<?php
if (!defined('INC')) { die('Error! You don`t have permission to view this file!'); }
include(PATH.'classes/questions.php');
?>
<div style="padding:5px;background:#FAFAFA">
<div id="print_top">
<p>
<span style="display:block;color:#666;margin-bottom:3px">
<?php
echo '<u>'.$msg_script18.'</u>: '.cleanDataEnt($_GET['search']);
?>
</span>
<?php
$SURVEY = $SVY->getSurvey((int)$_GET['survey']);
echo cleanDataEnt($SURVEY->sur_title);
?>
<span style="display:block;color:#666;font-size:12px;margin-top:3px">
<?php
if (isset($_GET['question']) && ctype_digit($_GET['question'])) {
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
<p style="text-align:right;padding:0 10px 5px 0"><a href="javascript:window.print()"><img style="border:0" src="templates/img/print.gif" alt="<?php echo cleanDataEnt($msg_script19); ?>" title="<?php echo cleanDataEnt($msg_script19); ?>" /></a></p>
</div>

<?php
$q_search_count = mysql_query("SELECT count(*) AS s_count FROM ".DB_PREFIX."answers
                               WHERE ans_sur_id = '".(int)$_GET['survey']."'
                               ".(isset($_GET['question']) && ctype_digit($_GET['question']) ? 'AND ans_que_id = \''.(int)$_GET['question'].'\'' : '')."
                               AND ans_text LIKE '%".safeImport($_GET['search'])."%'
                               ORDER BY ans_var_id
                               ") or die(db_MSG(__FILE__,__LINE__));
$SCOUNT = mysql_fetch_object($q_search_count);
                               
$q_search = mysql_query("SELECT * FROM ".DB_PREFIX."answers
                         WHERE ans_sur_id = '".(int)$_GET['survey']."'
                         ".(isset($_GET['question']) && ctype_digit($_GET['question']) ? 'AND ans_que_id = \''.(int)$_GET['question'].'\'' : '')."
                         AND ans_text LIKE '%".safeImport($_GET['search'])."%'
                         ORDER BY ans_var_id
                         LIMIT $limitvalue,".DATA_PER_PAGE."
                         ") or die(db_MSG(__FILE__,__LINE__));
if (mysql_num_rows($q_search)>0) {
  while ($SEARCH = mysql_fetch_object($q_search)) {
  // Find/replace options for text...
  $find     = array(strtolower($_GET['search']),strtoupper($_GET['search']),$_GET['search']);
  $replace  = array('<span class="highlight">'.cleanDataEnt(strtolower($_GET['search'])).'</span>',
                    '<span class="highlight">'.cleanDataEnt(strtoupper($_GET['search'])).'</span>',
                    '<span class="highlight">'.cleanDataEnt($_GET['search']).'</span>'
                    );
  ?>
  <div class="print_screen">
  <?php
  if (!isset($_GET['question']) || (isset($_GET['question']) && $_GET['question']=='all')) {
  $QTN          = new questions();
  $QTN->prefix  = DB_PREFIX;
  $QUESTION = $QTN->getQuestion($SEARCH->ans_que_id);
  ?>
  <p class="search_question"><?php echo '<u>'.cleanDataEnt($QUESTION->que_text); ?></u></p>
  <?php
  }
  ?>
  <p class="search_answer">&quot;<?php echo str_replace($find,$replace,nl2br(cleanDataEnt(trim($SEARCH->ans_text)))); ?>&quot;</p>
  </div>
  <?php
  }
  ?>
  <div class="search_pages">
  <?php
  echo page_numbers($SCOUNT->s_count,$limit,$page);
  ?>
  </div>
  <?php
} else {
?>
<div class="print_screen">
<p style="padding:0;text-align:center"><?php echo str_replace("{keyword}",cleanDataEnt($_GET['search']),$msg_keywords16); ?></p>
</div>
<?php
}
?>
</div>
