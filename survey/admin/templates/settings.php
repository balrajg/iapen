<?php
if (!defined('INC')) { die('Error! You don`t have permission to view this file!'); }
?>		
		
		<div class="content">

			<h1><?php echo $msg_header8; ?></h1>
			
      <p><?php echo $msg_settings; ?></p>
      
      <form method="post" action="index.php?cmd=settings">
      <input type="hidden" name="process" value="1" />
      
      <div class="formOptionWrap">
      <label class="first"><?php echo $msg_settings2; ?>:</label>
      <input type="text" class="box" name="cfg_wname" value="<?php echo (isset($_POST['cfg_wname']) ? cleanDataEnt($_POST['cfg_wname']) : cleanDataEnt($SETTINGS->cfg_wname)); ?>" />
      <?php echo (isset($N_ERROR) ? '<span class="error">'.$N_ERROR.'</span>' : ''); ?>
      </div>
      
      <div class="formOptionWrap">
      <label><?php echo $msg_settings3; ?>:</label>
      <input type="text" class="box" name="cfg_wemail" value="<?php echo (isset($_POST['cfg_wemail']) ? cleanDataEnt($_POST['cfg_wemail']) : cleanDataEnt($SETTINGS->cfg_wemail)); ?>" />
      <?php echo (isset($E_ERROR) ? '<span class="error">'.$E_ERROR.'</span>' : ''); ?>
      </div>
      
      <div class="formOptionWrap">
      <label><?php echo $msg_settings4; ?>:</label>
      <input type="text" class="box" name="cfg_wurl" value="<?php echo (isset($_POST['cfg_wurl']) ? cleanDataEnt($_POST['cfg_wurl']) : cleanDataEnt($SETTINGS->cfg_wurl)); ?>" /> <?php echo toolTip($msg_javascript2,$msg_javascript3); ?>
      <?php echo (isset($U_ERROR) ? '<span class="error">'.$U_ERROR.'</span>' : ''); ?>
      </div>
      
      <div class="formOptionWrap">
      <label><?php echo $msg_settings14; ?>:</label>
      <input type="text" class="box" name="cfg_afflink" value="<?php echo (isset($_POST['cfg_afflink']) ? cleanDataEnt($_POST['cfg_afflink']) : cleanDataEnt($SETTINGS->cfg_afflink)); ?>" /> <?php echo toolTip($msg_javascript2,$msg_javascript18); ?>
      </div>
      
      <div class="formOptionWrap">
      <label><?php echo $msg_settings9; ?>:</label>
      <?php echo $msg_script4; ?> <input type="radio" name="smtp" value="1"<?php echo (isset($_POST['smtp']) && $_POST['smtp']  ? ' checked="checked"' : (!isset($_POST['smtp']) && $SETTINGS->smtp ? ' checked="checked"' : '')); ?> /> <?php echo $msg_script5; ?> <input type="radio" name="smtp" value="0"<?php echo (isset($_POST['smtp']) && !$_POST['smtp'] ? ' checked="checked"' : (!isset($_POST['smtp']) && !$SETTINGS->smtp ? ' checked="checked"' : '')); ?> /> <?php echo toolTip($msg_javascript2,$msg_javascript8); ?>
      </div>
      
      <div class="formOptionWrap">
      <label><?php echo $msg_settings10; ?>:</label>
      <input type="text" class="box" name="smtp_host" value="<?php echo (isset($_POST['smtp_host']) ? cleanDataEnt($_POST['smtp_host']) : cleanDataEnt($SETTINGS->smtp_host)); ?>" />
      </div>
      
      <div class="formOptionWrap">
      <label><?php echo $msg_settings11; ?>:</label>
      <input type="text" class="box" name="smtp_user" value="<?php echo (isset($_POST['smtp_user']) ? cleanDataEnt($_POST['smtp_user']) : cleanDataEnt($SETTINGS->smtp_user)); ?>" />
      </div>
      
      <div class="formOptionWrap">
      <label><?php echo $msg_settings12; ?>:</label>
      <input type="password" class="box" name="smtp_pass" value="<?php echo (isset($_POST['smtp_pass']) ? cleanDataEnt($_POST['smtp_pass']) : cleanDataEnt($SETTINGS->smtp_pass)); ?>" />
      </div>
      
      <div class="formOptionWrap">
      <label><?php echo $msg_settings13; ?>:</label>
      <input type="text" class="box" name="smtp_port" value="<?php echo (isset($_POST['smtp_port']) ? cleanDataEnt($_POST['smtp_port']) : cleanDataEnt($SETTINGS->smtp_port)); ?>" style="width:20%" /> 
      
      </div>
      
      <br />
      <input type="submit" class="button" value="<?php echo cleanDataEnt($msg_settings5); ?>" title="<?php echo cleanDataEnt($msg_settings5); ?>" />
      
      </form>

		</div>

		<div class="sidenav">
		
		  <h2><?php echo $msg_home7; ?></h2>
			<ul>
				<li><a href="index.php?cmd=create-survey" title="<?php echo cleanDataEnt($msg_survey2); ?>"><img src="templates/img/links/create.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_survey2; ?></a></li>
				<li><a href="index.php?cmd=create-colour-scheme" title="<?php echo cleanDataEnt($msg_colours2); ?>"><img src="templates/img/links/new-color-scheme.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_colours2; ?></a></li>
				<li><a href="../docs/setup/index.html" title="<?php echo cleanDataEnt($msg_home6); ?>" target="_blank"><img src="templates/img/links/docs.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_home6; ?></a></li>
			</ul>
		
		</div>

		
