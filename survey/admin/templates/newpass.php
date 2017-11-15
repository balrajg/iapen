<?php
if (!defined('INC')) { die('Error! You don`t have permission to view this file!'); }
?>		
		
		<div class="content">
      <?php
      if (isset($SENT)) {
      ?>
      <h1><?php echo $msg_login10; ?></h1>
			
      <p><?php echo str_replace("{email}",$_POST['email'],$msg_login11); ?></p>
      <?php
      } else {
      ?>
			<h1><?php echo $msg_login7; ?></h1>
			
      <p><?php echo $msg_login8; ?></p>
      
      <form method="post" action="index.php?cmd=newpass">
      <input type="hidden" name="process" value="1" />
      
      <div class="formOptionWrap">
      <label class="first"><?php echo $msg_login3; ?>:</label>
      <input type="text" class="box" name="user" value="<?php echo (isset($_POST['user']) ? cleanDataEnt($_POST['user']) : ''); ?>" />
      <?php echo (isset($U_ERROR) ? '<span class="error">'.$U_ERROR.'</span>' : ''); ?>
      </div>
      
      <div class="formOptionWrap">
      <label><?php echo $msg_login9; ?>:</label>
      <input type="text" class="box" name="email" value="<?php echo (isset($_POST['email']) ? cleanDataEnt($_POST['email']) : ''); ?>" />
      <?php echo (isset($E_ERROR) ? '<span class="error">'.$E_ERROR.'</span>' : ''); ?>
      </div>
      
      <br />
      <input type="submit" class="button" value="<?php echo cleanDataEnt($msg_login7); ?>" title="<?php echo cleanDataEnt($msg_login7); ?>" />
      
      </form>
      <?php
      }
      ?>

		</div>

		<div class="sidenav">

			<h2><?php echo $msg_script12; ?></h2>
			<ul>
				<li><a href="index.php?cmd=login" title="<?php echo cleanDataEnt($msg_login); ?>"><img src="templates/img/links/newpass.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_login; ?></a></li>
			</ul>

		</div>

		
