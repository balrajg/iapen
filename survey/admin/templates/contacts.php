<?php
if (!defined('INC')) { die('Error! You don`t have permission to view this file!'); }
?>		
		
		<div class="content">

			<h1><?php echo $msg_survey51; ?></h1>
			
      <p><?php echo $msg_contacts; ?></p>
      
      <form method="post" action="index.php?cmd=contacts">
      <input type="hidden" name="process" value="1" />
      
      <div class="formOptionWrap">
      <label><?php echo $msg_contacts3; ?>:</label>
      <select name="survey[]" multiple="multiple">
      <option value="all"<?php echo (!isset($_GET['survey']) ? ' selected="selected"' : ''); ?>><?php echo $msg_contacts2; ?></option>
      <?php
      $q_surveys = mysql_query("SELECT * FROM ".DB_PREFIX."surveys
                                ORDER BY sur_title
                                ") or die(db_MSG(__FILE__,__LINE__));
      
      while ($SURVEYS = mysql_fetch_object($q_surveys)) {
      ?>
      <option value="<?php echo $SURVEYS->sur_id; ?>"<?php echo (isset($_GET['survey']) && $_GET['survey']==$SURVEYS->sur_id ? ' selected="selected"' : ''); ?>><?php echo cleanDataEnt($SURVEYS->sur_title); ?></option>
      <?php
      }
      ?>
      </select>
      </div>
      
      <div class="formOptionWrap">
      <label class="first"><?php echo $msg_contacts4; ?>:</label>
      <input type="text" class="box" name="seperator" value="<?php echo (isset($_POST['seperator']) ? cleanDataEnt($_POST['seperator']) : ','); ?>" maxlength="1" style="width:5%" />
      <?php echo (isset($T_ERROR) ? '<span class="error">'.$T_ERROR.'</span>' : ''); ?>
      </div>
      
      <br /><input type="submit" class="button" value="<?php echo cleanDataEnt($msg_contacts5); ?>" title="<?php echo cleanDataEnt($msg_contacts5); ?>" />
      </form>

		</div>

		<div class="sidenav">
		<h2><?php echo $msg_survey33; ?></h2>
		<?php
		if (isset($_GET['survey'])) {
    $sur = rowData('surveys',' WHERE sur_id = \''.(int)$_GET['survey'].'\'');
    ?>
    <ul>
			<li><a href="index.php?cmd=contacts&amp;survey=<?php echo (int)$_GET['survey']; ?>&amp;clear=1" title="<?php echo cleanDataEnt($msg_contacts8); ?>" onclick="return delete_confirm('<?php echo $msg_javascript17; ?>')"><img src="templates/img/links/clearkeys.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_contacts8; ?></a></li>
			<li><a href="index.php?cmd=surveys" title="<?php echo cleanDataEnt($msg_survey4); ?>"><img src="templates/img/links/view.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_survey4; ?></a></li>
			<li><a href="index.php?cmd=copy-survey&amp;copy=<?php echo (int)$_GET['survey']; ?>" title="<?php echo cleanDataEnt($msg_survey35); ?>"><img src="templates/img/links/copy.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_survey35; ?></a></li>
			<li><a href="index.php?cmd=questions&amp;survey=<?php echo (int)$_GET['survey']; ?>" title="<?php echo cleanDataEnt($msg_survey38); ?>"><img src="templates/img/links/questions.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_survey38; ?></a></li>
			<li><a href="index.php?cmd=keywords&amp;survey=<?php echo (int)$_GET['survey']; ?>" title="<?php echo cleanDataEnt($msg_survey52); ?>"><img src="templates/img/links/keywords.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_survey52; ?></a></li>
		</ul>
		<h2><?php echo $msg_question29; ?></h2>
		<span class="informationBox"><?php echo cleanDataEnt($sur->sur_title); ?></span>
		<?php
    } else {
    ?>
    <ul>
			<li><a href="index.php?cmd=create-survey" title="<?php echo cleanDataEnt($msg_survey2); ?>"><img src="templates/img/links/create.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_survey2; ?></a></li>
		  <li><a href="index.php?cmd=create-colour-scheme" title="<?php echo cleanDataEnt($msg_colours2); ?>"><img src="templates/img/links/new-color-scheme.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_colours2; ?></a></li>
		</ul>
		<?php	
    }
    ?>	
    </div>

		
