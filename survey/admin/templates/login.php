<?php
if (!defined('INC')) { die('Error! You don`t have permission to view this file!'); }
?>		
		
		<div class="content">

			<h1><?php echo $msg_login; ?></h1>
			
      <p><?php echo $msg_login2; ?></p>
      
      <form method="post" name="form" action="index.php?cmd=login">
      <input type="hidden" name="process" value="1" />
      
      <div class="formOptionWrap">
      <label class="first"><?php echo $msg_login3; ?>:</label>
      <input type="text" class="box" name="user" id="user" value="<?php echo (isset($_POST['user']) ? cleanDataEnt($_POST['user']) : ''); ?>" />
      <?php echo (isset($U_ERROR) ? '<span class="error">'.$U_ERROR.'</span>' : ''); ?>
      </div>
      
      <div class="formOptionWrap">
      <label><?php echo $msg_login4; ?>:</label>
      <input type="password" class="box" name="pass" value="<?php echo (isset($_POST['pass']) ? cleanDataEnt($_POST['pass']) : ''); ?>" />
      <?php echo (isset($P_ERROR) ? '<span class="error">'.$P_ERROR.'</span>' : ''); ?>
      </div>
      
      <?php
      /* Uncomment for remember me option on login..
      ?>
      <div class="formOptionWrap">
      <label><?php echo $msg_login14; ?>:</label>
      <input type="checkbox" name="cookie" value="1"<?php echo (isset($_POST['cookie']) ? ' checked="checked"' : ''); ?>/> <?php echo toolTip($msg_javascript2,$msg_javascript9,false,'RIGHT'); ?>
      </div>
      <?php
      */
      ?>
      
      <br />
      <input type="submit" class="button" value="<?php echo cleanDataEnt($msg_login5); ?>" title="<?php echo cleanDataEnt($msg_login5); ?>" />
      
      </form>

		</div>

		<div class="sidenav">

			<h2><?php echo $msg_script12; ?></h2>
			<ul>
				<li><a href="index.php?cmd=newpass" title="<?php echo cleanDataEnt($msg_login6); ?>"><img src="templates/img/links/newpass.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_login6; ?></a></li>
			</ul>

		</div>

		
