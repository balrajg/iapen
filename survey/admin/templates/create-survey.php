<?php
if (!defined('INC')) { die('Error! You don`t have permission to view this file!'); }
include(PATH.'inc/cal_array.inc.php');
?>		
		
		<div class="content">
		  <?php
		  if (isset($CREATED)) {
		  ?>
		  <h1><?php echo $msg_survey28; ?></h1>
			
      <p><?php echo $msg_survey29; ?></p>
      
      <code><img src="templates/img/links/questions.gif" alt="" title="" /> <a href="index.php?cmd=questions&amp;survey=<?php echo mysql_insert_id(); ?>" title="<?php echo cleanDataEnt($msg_survey30); ?>"><?php echo $msg_survey30; ?></a></code>
      <code><img src="templates/img/links/create.gif" alt="" title="" /> <a href="index.php?cmd=create-survey" title="<?php echo cleanDataEnt($msg_survey31); ?>"><?php echo $msg_survey31; ?></a></code>
      <?php
      } else
		  {
      ?>
			<h1><?php echo $msg_survey2; ?></h1>
			
      <p><?php echo $msg_survey5; ?></p>
      
      <form method="post" action="index.php?cmd=create-survey">
      <input type="hidden" name="process" value="1" />
      
      <div class="formOptionWrap">
      <label class="first"><?php echo $msg_survey6; ?>:</label>
      <input type="text" class="box" name="sur_title" value="<?php echo (isset($_POST['sur_title']) ? cleanDataEnt($_POST['sur_title']) : ''); ?>" maxlength="255" />
      <?php echo (isset($T_ERROR) ? '<span class="error">'.$T_ERROR.'</span>' : ''); ?>
      </div>
      
      <div class="formOptionWrap">
      <label><?php echo $msg_survey48; ?>:</label>
      <?php echo $msg_survey49; ?> <input type="radio" name="sur_display_type" value="1"<?php echo (isset($_POST['sur_display_type']) && $_POST['sur_display_type'] ? ' checked="checked"' : (!isset($_POST['sur_display_type']) ? ' checked="checked"' : '')); ?> /> <?php echo $msg_survey50; ?> <input type="radio" name="sur_display_type" value="0"<?php echo (isset($_POST['sur_display_type']) && !$_POST['sur_display_type'] ? ' checked="checked"' : ''); ?> /> <?php echo toolTip($msg_javascript2,$msg_javascript10); ?>
      </div>
      
      <div class="formOptionWrap">
      <label><?php echo $msg_survey54; ?>:</label>
      <?php echo $msg_script4; ?> <input type="radio" name="sur_captcha" value="1"<?php echo (isset($_POST['sur_captcha']) && $_POST['sur_captcha'] ? ' checked="checked"' : ''); ?> /> <?php echo $msg_script5; ?> <input type="radio" name="sur_captcha" value="0"<?php echo (isset($_POST['sur_captcha']) && !$_POST['sur_captcha'] ? ' checked="checked"' : (!isset($_POST['sur_captcha']) ? ' checked="checked"' : '')); ?> /> <?php echo toolTip($msg_javascript2,$msg_javascript14); ?>
      </div>
      
      <div class="formOptionWrap">
      <label><?php echo $msg_survey7; ?>:</label>
      <?php echo $msg_script4; ?> <input type="radio" name="sur_title_should_display" value="1"<?php echo (isset($_POST['sur_title_should_display']) && $_POST['sur_title_should_display'] ? ' checked="checked"' : (!isset($_POST['sur_title_should_display']) ? ' checked="checked"' : '')); ?> /> <?php echo $msg_script5; ?> <input type="radio" name="sur_title_should_display" value="0"<?php echo (isset($_POST['sur_title_should_display']) && !$_POST['sur_title_should_display'] ? ' checked="checked"' : ''); ?> />
      </div>
      
      <div class="formOptionWrap">
      <label><?php echo $msg_survey8; ?>:</label>
      <select name="sur_color_scheme">
      <?php
      $q_colors = mysql_query("SELECT * FROM ".DB_PREFIX."colorschemes
                               ORDER BY csc_title
                               ") or die(db_MSG(__FILE__,__LINE__));
      
      while ($COLORS = mysql_fetch_object($q_colors)) {
      ?>
      <option value="<?php echo $COLORS->csc_id; ?>"<?php echo (isset($_POST['sur_color_scheme']) && $_POST['sur_color_scheme']==$COLORS->csc_id ? ' selected="selected"' : ''); ?>><?php echo cleanDataEnt($COLORS->csc_title); ?></option>
      <?php
      }
      ?>
      </select>
      </div>
      
      <div class="formOptionWrap">
      <label><?php echo $msg_survey10; ?>:</label>
      <?php echo $msg_script4; ?> <input type="radio" name="sur_email_request" value="1"<?php echo (isset($_POST['sur_email_request']) && $_POST['sur_email_request'] ? ' checked="checked"' : (!isset($_POST['sur_email_request']) ? ' checked="checked"' : '')); ?> /> <?php echo $msg_script5; ?> <input type="radio" name="sur_email_request" value="0"<?php echo (isset($_POST['sur_email_request']) && !$_POST['sur_email_request'] ? ' checked="checked"' : ''); ?> />
      <span class="color_option"><?php echo $msg_survey11; ?></span>
      <textarea name="sur_email_request_message" rows="4" cols="20"><?php echo (isset($_POST['sur_email_request_message']) ? cleanDataEnt($_POST['sur_email_request_message']) : ''); ?></textarea>
      </div>
      
      <div class="formOptionWrap">
      <label><?php echo $msg_survey12; ?>:</label>
      <?php echo $msg_script4; ?> <input type="radio" name="sur_view_summary" value="1"<?php echo (isset($_POST['sur_view_summary']) && $_POST['sur_view_summary'] ? ' checked="checked"' : ''); ?> /> <?php echo $msg_script5; ?> <input type="radio" name="sur_view_summary" value="0"<?php echo (isset($_POST['sur_view_summary']) && !$_POST['sur_view_summary'] ? ' checked="checked"' : (!isset($_POST['sur_view_summary']) ? ' checked="checked"' : '')); ?> />
      </div> 
       
      <div class="formOptionWrap"> 
      <label><?php echo $msg_survey13; ?>:</label>
      <select name="day">
      <option value="0">--</option>
      <?php

      foreach ($days as $s_days) {
        echo '<option value="'.$s_days.'"'.(isset($_POST['day']) && $_POST['day']==$s_days ? ' selected="selected"' : '').'>'.$s_days.'</option>'."\n";
      }

      ?>
      </select>
      <select name="month">
      <option value="0">--</option>
      <?php

      foreach ($months as $s_months => $s_months_value) {
        echo '<option value="'.$s_months.'"'.(isset($_POST['month']) && $_POST['month']==$s_months ? ' selected="selected"' : '').'>'.$s_months_value.'</option>'."\n";
      }
        
      ?>
      </select>
      <select name="year">
      <option value="0">--</option>
      <?php

      foreach ($years as $s_years) {
        echo '<option value="'.$s_years.'"'.(isset($_POST['year']) && $_POST['year']==$s_years ? ' selected="selected"' : '').'>'.$s_years.'</option>'."\n";
      }

      ?>
      </select>
      <?php echo (isset($E_ERROR) ? '<span class="error">'.$E_ERROR.'</span>' : ''); ?>
      </div>
      
      <div class="formOptionWrap">
      <label><?php echo $msg_survey14; ?>:</label>
      <?php echo $msg_survey20; ?> <input type="radio" name="sur_complete_goto_url" value="1"<?php echo (isset($_POST['sur_complete_goto_url']) && $_POST['sur_complete_goto_url'] ? ' checked="checked"' : (!isset($_POST['sur_complete_goto_url']) ? ' checked="checked"' : '')); ?> /> <?php echo $msg_survey21; ?> <input type="radio" name="sur_complete_goto_url" value="0"<?php echo (isset($_POST['sur_complete_goto_url']) && !$_POST['sur_complete_goto_url'] ? ' checked="checked"' : ''); ?> /> <?php echo toolTip($msg_javascript2,$msg_javascript5); ?>
      <span class="color_option"><?php echo $msg_survey15; ?></span>
      <input type="text" class="box" name="sur_complete_url" value="<?php echo (isset($_POST['sur_complete_url']) ? cleanDataEnt($_POST['sur_complete_url']) : 'http://'); ?>" />
      <span class="color_option"><?php echo $msg_survey16; ?></span>
      <textarea name="sur_complete_message" rows="4" cols="20"><?php echo (isset($_POST['sur_complete_message']) ? cleanDataEnt($_POST['sur_complete_message']) : ''); ?></textarea>
      </div>
      
      <div class="formOptionWrap">
      <label><?php echo $msg_survey17; ?>:</label>
      <?php echo $msg_script4; ?> <input type="radio" name="sur_allow_multiple_votes" value="1"<?php echo (isset($_POST['sur_allow_multiple_votes']) && $_POST['sur_allow_multiple_votes'] ? ' checked="checked"' : ''); ?> /> <?php echo $msg_script5; ?> <input type="radio" name="sur_allow_multiple_votes" value="0"<?php echo (isset($_POST['sur_allow_multiple_votes']) && !$_POST['sur_allow_multiple_votes'] ? ' checked="checked"' : (!isset($_POST['sur_allow_multiple_votes']) ? ' checked="checked"' : '')); ?> /> <?php echo toolTip($msg_javascript2,$msg_javascript6); ?>
      </div> 
      
      <div class="formOptionWrap">
      <label class="first"><?php echo $msg_survey18; ?>:</label>
      <input type="text" class="box" name="sur_notification_email" value="<?php echo (isset($_POST['sur_notification_email']) ? cleanDataEnt($_POST['sur_notification_email']) : ''); ?>" /> <?php echo toolTip($msg_javascript2,$msg_javascript7); ?>
      </div>
      
      <div class="formOptionWrap">
      <label><?php echo $msg_survey53; ?>:</label>
      <?php echo $msg_script4; ?> <input type="radio" name="en_keys" value="1"<?php echo (isset($_POST['en_keys']) && $_POST['en_keys'] ? ' checked="checked"' : ''); ?> /> <?php echo $msg_script5; ?> <input type="radio" name="en_keys" value="0"<?php echo (isset($_POST['en_keys']) && !$_POST['en_keys'] ? ' checked="checked"' : (!isset($_POST['en_keys']) ? ' checked="checked"' : '')); ?> /> <?php echo toolTip($msg_javascript2,$msg_javascript13); ?>
      </div>
      
      <div class="formOptionWrap">
      <label><?php echo $msg_survey22; ?>:</label>
      <?php echo $msg_script4; ?> <input type="radio" name="sur_status" value="1"<?php echo (isset($_POST['sur_status']) && $_POST['sur_status'] ? ' checked="checked"' : (!isset($_POST['sur_status']) ? ' checked="checked"' : '')); ?> /> <?php echo $msg_script5; ?> <input type="radio" name="sur_status" value="0"<?php echo (isset($_POST['sur_status']) && !$_POST['sur_status'] ? ' checked="checked"' : ''); ?> />
      </div>
      
      <br /><input type="submit" class="button" value="<?php echo cleanDataEnt($msg_survey2); ?>" title="<?php echo cleanDataEnt($msg_survey2); ?>" />
      
      </form>
      <?php
      }
      ?>

		</div>
		

		<div class="sidenav">

			<h2><?php echo $msg_script12; ?></h2>
			<ul>
				<li><a href="index.php?cmd=surveys" title="<?php echo cleanDataEnt($msg_survey4); ?>"><img src="templates/img/links/view.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_survey4; ?></a></li>
			</ul>

		</div>

		
