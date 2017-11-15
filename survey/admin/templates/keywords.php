<?php
if (!defined('INC')) { die('Error! You don`t have permission to view this file!'); }
?>		
		
		<div class="content">
  <script type="text/javascript">
  //<![CDATA[
  $(function() {
   $('#from').datepicker({
    changeMonth: true,
    changeYear: true,
    monthNamesShort: <?php echo trim($msg_javascript19); ?>,
    dayNamesMin: <?php echo trim($msg_javascript20); ?>,
    firstDay: 0,
    dateFormat: 'yy-mm-dd'
   });
  });
  $(function() {
   $('#to').datepicker({
    changeMonth: true,
    changeYear: true,
    monthNamesShort: <?php echo trim($msg_javascript19); ?>,
    dayNamesMin: <?php echo trim($msg_javascript20); ?>,
    firstDay: 0,
    dateFormat: 'yy-mm-dd'
   });
  });
  //]]>
  </script>
			<?php
      // Hide filter options?
      if (!isset($_SESSION['hide_filter'])) {
      ?> 
      <h1><?php echo $msg_survey52; ?></h1>
			
      <p><?php echo $msg_keywords; ?></p>
      <form method="get" action="index.php">
      <input type="hidden" name="cmd" value="keywords" />
      <input type="hidden" name="survey" value="<?php echo (int)$_GET['survey']; ?>" />
      
      <div class="formOptionWrap">
      <label class="first"><?php echo $msg_keywords2; ?>:</label>
      <select name="question">
      <option value="all"><?php echo $msg_keywords4; ?></option>
      <?php
      $q_questions = mysql_query("SELECT * FROM ".DB_PREFIX."questions
                                  WHERE que_sur_id = '".(int)$_GET['survey']."'
                                  ORDER BY orderBy
                                  ") or die(db_MSG(__FILE__,__LINE__));
      
      while ($QUESTIONS = mysql_fetch_object($q_questions)) {
      ?>
      <option value="<?php echo $QUESTIONS->que_id; ?>"<?php echo (isset($_GET['question']) && $_GET['question']==$QUESTIONS->que_id ? ' selected="selected"' : ''); ?>><?php echo (strlen($QUESTIONS->que_text)>68 ? substr(cleanDataEnt($QUESTIONS->que_text),0,65).'...' : cleanDataEnt($QUESTIONS->que_text)); ?></option>
      <?php
      }
      ?>
      </select>
      </div>
      
      <div class="formOptionWrap">
      <label class="first"><?php echo $msg_keywords3; ?>:</label>
      <input type="text" class="box" name="from" id="from" value="<?php echo (isset($_GET['from']) ? cleanDataEnt($_GET['from']) : ''); ?>" style="width:15%" />
      <input type="text" class="box" name="to" id="to" value="<?php echo (isset($_GET['to']) ? cleanDataEnt($_GET['to']) : ''); ?>" style="width:15%" />
      </div>
      <br />
      <input type="submit" class="button" value="<?php echo cleanDataEnt($msg_keywords7); ?>" title="<?php echo cleanDataEnt($msg_keywords7); ?>" />
      </form>
      <?php
      }
      ?>
      <h1><?php echo (!isset($_SESSION['hide_filter']) ? '<br />' : ''); ?><?php echo $msg_keywords10; ?></h1>
      <p><?php echo $msg_keywords11; ?></p>
      <?php
      $q_keys_count = mysql_query("SELECT DISTINCT(key_word) FROM ".DB_PREFIX."keywords
                                   WHERE key_sur_id = '".(int)$_GET['survey']."'
                                   ".(isset($_GET['question']) && ctype_digit($_GET['question']) ? 'AND key_que_id = \''.(int)$_GET['question'].'\'' : '')."
                                   ".(isset($_GET['from']) &&  $_GET['from'] && isset($_GET['to']) && $_GET['to'] ? 'AND key_date BETWEEN \''.$_GET['from'].'\' AND \''.$_GET['to'].'\'' : '')."
                                   ORDER BY key_word
                                   ") or die(db_MSG(__FILE__,__LINE__));
      if (mysql_num_rows($q_keys_count)>0) {    
      $q_keys = mysql_query("SELECT DISTINCT(key_word),key_word,key_que_id,key_sur_id,count(*) AS k_count FROM ".DB_PREFIX."keywords
                             WHERE key_sur_id = '".(int)$_GET['survey']."'
                             ".(isset($_GET['question']) && ctype_digit($_GET['question']) ? 'AND key_que_id = \''.(int)$_GET['question'].'\'' : '')."
                             ".(isset($_GET['from']) &&  $_GET['from'] && isset($_GET['to']) && $_GET['to'] ? 'AND key_date BETWEEN \''.$_GET['from'].'\' AND \''.$_GET['to'].'\'' : '')."
                             GROUP BY 1 ORDER BY k_count DESC
                             LIMIT $limitvalue,".DATA_PER_PAGE."
                             ") or die(db_MSG(__FILE__,__LINE__));
      if (mysql_num_rows($q_keys)>0) {
        ?>
        <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
          <td class="keyHead" style="width:40%"><?php echo $msg_keywords13; ?></td>
          <td class="keyHead" style="width:30%">&nbsp;</td>
          <td class="keyHead" style="width:15%;border-right:1px solid #abbeca;text-align:center"><?php echo $msg_keywords14; ?></td>
          <td class="keyHead" style="width:15%;text-align:center"><?php echo $msg_keywords15; ?></td>
        </tr>
        </table>
        <?php
        while ($KEYS = mysql_fetch_object($q_keys)) {
        ?>
        <div class="keyWrap">
        <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
          <td style="width:40%"><a href="index.php?cmd=keywords&amp;survey=<?php echo $KEYS->key_sur_id; ?>&amp;search=<?php echo str_replace('.','',cleanDataEnt($KEYS->key_word)); ?><?php echo (isset($_GET['question']) ? '&amp;question='.cleanDataEnt($_GET['question']) : '').(isset($_GET['from']) ? '&amp;from='.$_GET['from'] : '').(isset($_GET['to']) ? '&amp;to='.$_GET['to'] : ''); ?>" title="<?php echo str_replace('.','',cleanDataEnt($KEYS->key_word)); ?>" rel="ibox"><?php echo str_replace('.','',cleanDataEnt($KEYS->key_word)); ?></a></td>
          <td style="width:30%"></td>
          <td style="width:15%;text-align:center"><b><?php echo number_format($KEYS->k_count); ?></b></td>
          <td style="width:15%;text-align:center"><?php echo number_format($KEYS->k_count/mysql_num_rows($q_keys_count)*100,2); ?>%</td>
        </tr>
        </table>
        </div>
        <?php
        }
        echo page_numbers(mysql_num_rows($q_keys_count),$limit,$page);
        ?>
        <p>&nbsp;</p>
        <?php
      } else {
      ?>
      <code><?php echo $msg_keywords12; ?></code>
      <?php
      }
      } else {
      ?>
      <code><?php echo $msg_keywords12; ?></code>
      <?php
      }
      
      ?>

		</div>

		<div class="sidenav">
		  <h2><?php echo $msg_script12; ?></h2>
			<ul>
				<li><a href="index.php?cmd=keywords&amp;survey=<?php echo (int)$_GET['survey']; ?>&amp;clear=1<?php echo (isset($_GET['question']) ? '&amp;question='.cleanDataEnt($_GET['question']) : '').(isset($_GET['from']) ? '&amp;from='.$_GET['from'] : '').(isset($_GET['to']) ? '&amp;to='.$_GET['to'] : ''); ?>" title="<?php echo cleanDataEnt($msg_keywords5); ?>" onclick="return delete_confirm('<?php echo $msg_javascript12; ?>')"><img src="templates/img/links/clearkeys.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_keywords5; ?></a></li>
				<li><a href="index.php?cmd=keywords&amp;survey=<?php echo (int)$_GET['survey']; ?>&amp;print=1<?php echo (isset($_GET['question']) ? '&amp;question='.cleanDataEnt($_GET['question']) : '').(isset($_GET['from']) ? '&amp;from='.$_GET['from'] : '').(isset($_GET['to']) ? '&amp;to='.$_GET['to'] : ''); ?>" rel="ibox" title="<?php echo cleanDataEnt($msg_keywords6); ?>"><img src="templates/img/links/print.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_keywords6; ?></a></li>
				<li><a href="index.php?cmd=keywords&amp;survey=<?php echo (int)$_GET['survey']; ?>&amp;<?php echo (!isset($_SESSION['hide_filter']) ? 'hide' : 'show'); ?>=1<?php echo (isset($_GET['question']) ? '&amp;question='.cleanDataEnt($_GET['question']) : '').(isset($_GET['from']) ? '&amp;from='.$_GET['from'] : '').(isset($_GET['to']) ? '&amp;to='.$_GET['to'] : ''); ?>" title="<?php echo cleanDataEnt((!isset($_SESSION['hide_filter']) ? $msg_keywords8 : $msg_keywords9)); ?>"><img src="templates/img/links/<?php echo (!isset($_SESSION['hide_filter']) ? 'hide' : 'show'); ?>.gif" alt="" title="" />&nbsp;&nbsp;<?php echo (!isset($_SESSION['hide_filter']) ? $msg_keywords8 : $msg_keywords9); ?></a></li>
				<li><a href="index.php?cmd=questions&amp;survey=<?php echo (int)$_GET['survey']; ?>" title="<?php echo cleanDataEnt($msg_survey38); ?>"><img src="templates/img/links/questions.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_survey38; ?></a></li>
			  <li><a href="index.php?cmd=contacts&amp;survey=<?php echo (int)$_GET['survey']; ?>" title="<?php echo cleanDataEnt($msg_survey51); ?>"><img src="templates/img/links/contacts.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_survey51; ?></a></li>
		</ul>
		<h2><?php echo $msg_question29; ?></h2>
		<?php
		if (isset($_GET['survey'])) {
    $sur = rowData('surveys',' WHERE sur_id = \''.(int)$_GET['survey'].'\'');
    ?>
		<span class="informationBox"><?php echo cleanDataEnt($sur->sur_title); ?></span>
		<?php
		}
		?>
    </div>

		
