<?php
if (!defined('INC')) { die('Error! You don`t have permission to view this file!'); }
$rowCountSurveys = rowCount('surveys');
?>		
		
		<div class="content">

			<h1><?php echo (isset($_SESSION['loadOptions']) ? $msg_survey33 : $msg_header4.' ('.$rowCountSurveys.')'); ?></h1>
			
      <p><?php echo (isset($_SESSION['loadOptions']) ? $msg_survey39 : $msg_survey); ?></p>
      
      <?php
      $q_surveys = mysql_query("SELECT * FROM ".DB_PREFIX."surveys
                               ".(isset($_SESSION['loadOptions']) ? 'WHERE sur_id = \''.(int)$_SESSION['loadOptions'].'\'' : '')."
                               ORDER BY sur_title
                               LIMIT $limitvalue,".DATA_PER_PAGE."
                               ") or die(db_MSG(__FILE__,__LINE__));
      
      while ($SURVEYS = mysql_fetch_object($q_surveys)) {
      ?>
      <table width="100%" cellspacing="0" cellpadding="0" class="table">
      <tr>
        <td style="width:75%;padding:5px"><b><u><?php echo cleanDataEnt($SURVEYS->sur_title); ?></u></b><br /><?php echo $msg_survey47; ?>: <b><?php echo $SURVEYS->uniCode; ?></b> <?php echo toolTip($msg_javascript4,$SETTINGS->cfg_wurl.'index.php?survey='.$SURVEYS->uniCode,$msg_survey9,'CENTER','600'); ?></td>
        <td style="width:25%;text-align:center;padding:5px;vertical-align_top"><a target="_blank" href="index.php?cmd=surveys&amp;preview=<?php echo md5($SETTINGS->cfg_login); ?>-<?php echo $SURVEYS->uniCode; ?><?php echo (isset($_SESSION['loadOptions']) ? '&amp;reload=1' : ''); ?>" title="<?php echo cleanDataEnt($msg_script13); ?>: <?php echo cleanDataEnt($SURVEYS->sur_title); ?>"><img class="img_option" src="templates/img/preview.gif" alt="<?php echo cleanDataEnt($msg_script13); ?>" title="<?php echo cleanDataEnt($msg_script13); ?>" /></a> <a href="index.php?cmd=edit-survey&amp;edit=<?php echo $SURVEYS->sur_id; ?><?php echo (isset($_SESSION['loadOptions']) ? '&amp;reload=1' : ''); ?>"><img class="img_option" src="templates/img/edit.gif" alt="<?php echo cleanDataEnt($msg_script9); ?>" title="<?php echo cleanDataEnt($msg_script9); ?>" /></a> <a href="index.php?cmd=surveys&amp;options=<?php echo $SURVEYS->sur_id; ?>" title="<?php echo cleanDataEnt($msg_survey32); ?>: <?php echo cleanDataEnt($SURVEYS->sur_title); ?>"><img class="img_option" src="templates/img/options.gif" alt="<?php echo cleanDataEnt($msg_survey32); ?>" title="<?php echo cleanDataEnt($msg_survey32); ?>" /></a> <a href="index.php?cmd=surveys&amp;delete=<?php echo $SURVEYS->sur_id; ?>" onclick="return delete_confirm('<?php echo $msg_javascript; ?>')"><img class="img_option" src="templates/img/delete.gif" alt="<?php echo cleanDataEnt($msg_script10); ?>" title="<?php echo cleanDataEnt($msg_script10); ?>" /></a></td>
      </tr>
      <tr>
        <td colspan="2" style="text-align:left;padding:10px;background:#f7f7f2;border-top:1px solid #eaeada"><?php echo $msg_question; ?>: <a href="index.php?cmd=questions&amp;survey=<?php echo $SURVEYS->sur_id; ?>" title="<?php echo cleanDataEnt($msg_question); ?>"><span class="surround"><?php echo rowCount('questions',' WHERE que_sur_id = \''.$SURVEYS->sur_id.'\''); ?></span></a> <?php echo $msg_survey57; ?>: <a href="../results.php?survey=<?php echo md5($SETTINGS->cfg_login); ?>-<?php echo $SURVEYS->uniCode; ?>" onclick="window.open(this);return false;" title="<?php echo cleanDataEnt($msg_survey57); ?>"><span class="surround"><?php echo rowCount('answers',' WHERE ans_sur_id = \''.$SURVEYS->sur_id.'\' GROUP BY 1 ORDER BY 2','DISTINCT(ans_session_id),count(*) AS r_count',true); ?></span></a> <?php echo $msg_survey58; ?>: <a href="index.php?cmd=contacts&amp;survey=<?php echo $SURVEYS->sur_id; ?>" title="<?php echo cleanDataEnt($msg_survey58); ?>"><span class="surround"><?php echo rowCount('users',' WHERE usr_sur_id = \''.$SURVEYS->sur_id.'\''); ?></span></a></td>
      </tr>
      </table>
      <?php
      }
      
      if (mysql_num_rows($q_surveys)>0) {
        if (isset($_SESSION['loadOptions'])) {
        ?>
        <code><img src="templates/img/links/back.gif" alt="" title="" /> <a href="index.php?cmd=surveys" title="<?php echo cleanDataEnt($msg_survey34); ?>"><?php echo $msg_survey34; ?></a></code>
        <?php
        } else {
          echo page_numbers($rowCountSurveys,$limit,$page);
        }
      } else {
      ?>
      <code><?php echo $msg_survey3; ?></code>
      <?php
      }
      
      ?>

		</div>

		<div class="sidenav">
      
      <?php
      if (isset($_SESSION['loadOptions'])) {
      $sur = rowData('surveys',' WHERE sur_id = \''.(int)$_SESSION['loadOptions'].'\'');
      ?>
      <h2><?php echo $msg_survey33; ?></h2>
			<ul>
				<li><a href="index.php?cmd=copy-survey&amp;copy=<?php echo $_SESSION['loadOptions']; ?>" title="<?php echo cleanDataEnt($msg_survey35); ?>"><img src="templates/img/links/copy.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_survey35; ?></a></li>
				<li><a href="../results.php?survey=<?php echo md5($SETTINGS->cfg_login); ?>-<?php echo $sur->uniCode; ?>" title="<?php echo cleanDataEnt($msg_survey36); ?>" onclick="window.open(this);return false;"><img src="templates/img/links/preview.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_survey36; ?></a></li>
				<li><a href="index.php?cmd=clear-results&amp;survey=<?php echo $_SESSION['loadOptions']; ?>" title="<?php echo cleanDataEnt($msg_survey37); ?>" onclick="return delete_confirm('<?php echo $msg_javascript15; ?>')"><img src="templates/img/links/clear.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_survey37; ?></a></li>
				<li><a href="index.php?cmd=questions&amp;survey=<?php echo $_SESSION['loadOptions']; ?>" title="<?php echo cleanDataEnt($msg_survey38); ?>"><img src="templates/img/links/questions.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_survey38; ?></a></li>
				<li><a href="index.php?cmd=contacts&amp;survey=<?php echo $_SESSION['loadOptions']; ?>" title="<?php echo cleanDataEnt($msg_survey51); ?>"><img src="templates/img/links/contacts.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_survey51; ?></a></li>
				<li><a href="index.php?cmd=keywords&amp;survey=<?php echo $_SESSION['loadOptions']; ?>" title="<?php echo cleanDataEnt($msg_survey52); ?>"><img src="templates/img/links/keywords.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_survey52; ?></a></li>
			</ul>
      <?php
      } else {
      ?>
			<h2><?php echo $msg_script12; ?></h2>
			<ul>
				<li><a href="index.php?cmd=create-survey" title="<?php echo cleanDataEnt($msg_survey2); ?>"><img src="templates/img/links/create.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_survey2; ?></a></li>
			</ul>
      <?php
      }
      ?>
		</div>

		
