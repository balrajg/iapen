<?php
if (!defined('INC')) { die('Error! You don`t have permission to view this file!'); }
?>		
		
		<div class="content">
      <?php
      if (isset($CHANGED)) {
      ?>
      <h1><?php echo $msg_pass8; ?></h1>
			
      <p><?php echo str_replace(array('{username}','{password}'),array(cleanDataEnt($_POST['user']),cleanDataEnt($_POST['new1'])),$msg_pass9); ?></p>
      <?php
      } else {
      ?>
			<h1><?php echo $msg_header6; ?></h1>
			
      <p><?php echo $msg_pass; ?></p>
      
      <form method="post" action="index.php?cmd=pass">
      <input type="hidden" name="process" value="1" />
      
      <div class="formOptionWrap">
      <label class="first"><?php echo $msg_pass11; ?>:</label>
      <input type="text" class="box" name="user" value="<?php echo (isset($_POST['user']) ? cleanDataEnt($_POST['user']) : cleanDataEnt($SETTINGS->cfg_login)); ?>" />
      </div>
      
      <div class="formOptionWrap">
      <label class="first"><?php echo $msg_pass2; ?>:</label>
      <input type="text" class="box" name="old" value="<?php echo (isset($_POST['old']) ? cleanDataEnt($_POST['old']) : ''); ?>" />
      <?php echo (isset($O_ERROR) ? '<span class="error">'.$O_ERROR.'</span>' : ''); ?>
      </div>
      
      <div class="formOptionWrap">
      <label><?php echo $msg_pass3; ?>:</label>
      <input type="password" class="box" name="new1" value="<?php echo (isset($_POST['new1']) ? cleanDataEnt($_POST['new1']) : ''); ?>" />
      <?php echo (isset($N_ERROR) ? '<span class="error">'.$N_ERROR.'</span>' : ''); ?>
      </div>
      
      <div class="formOptionWrap">
      <label><?php echo $msg_pass4; ?>:</label>
      <input type="password" class="box" name="new2" value="<?php echo (isset($_POST['new2']) ? cleanDataEnt($_POST['new2']) : ''); ?>" />
      <?php echo (isset($N2_ERROR) ? '<span class="error">'.$N2_ERROR.'</span>' : ''); ?>
      </div>
      
      <br />
      <input type="submit" class="button" value="<?php echo cleanDataEnt($msg_header6); ?>" title="<?php echo cleanDataEnt($msg_header6); ?>" />
      
      </form>
     <?php
     }
     ?>
		</div>

		<div class="sidenav">

			<h2><?php echo $msg_home7; ?></h2>
			<ul>
				<li><a href="index.php?cmd=create-survey" title="<?php echo cleanDataEnt($msg_survey2); ?>"><img src="templates/img/links/create.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_survey2; ?></a></li>
				<li><a href="index.php?cmd=create-colour-scheme" title="<?php echo cleanDataEnt($msg_colours2); ?>"><img src="templates/img/links/new-color-scheme.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_colours2; ?></a></li>
				<li><a href="../docs/setup/index.html" title="<?php echo cleanDataEnt($msg_home6); ?>" target="_blank"><img src="templates/img/links/docs.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_home6; ?></a></li>
			</ul>

		</div>

		
