<?php
if (!defined('INC')) { die('Error! You don`t have permission to view this file!'); }
?>		
		
		<div class="content">

			<h1><?php echo str_replace("{software}",$msg_script,$msg_home); ?></h1>
			
      <p><?php echo $msg_home2; ?></p>

		</div>

		<div class="sidenav">

			<h2><?php echo $msg_home3; ?></h2>
			<ul>
				<li><a href="index.php?cmd=surveys"><?php echo str_replace("{count}",rowCount('surveys'),$msg_home4); ?></a></li>
				<li><a href="index.php?cmd=surveys"><?php echo str_replace("{count}",rowCount('questions'),$msg_home8); ?></a></li>
				<li><a href="index.php?cmd=colours"><?php echo str_replace("{count}",rowCount('colorschemes'),$msg_home5); ?></a></li>
				<li><a href="index.php?cmd=contacts"><?php echo str_replace("{count}",rowCount('users'),$msg_home9); ?></a></li>
			</ul>
      
      <h2><?php echo $msg_home7; ?></h2>
			<ul>
				<li><a href="index.php?cmd=create-survey" title="<?php echo cleanDataEnt($msg_survey2); ?>"><img src="templates/img/links/create.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_survey2; ?></a></li>
				<li><a href="index.php?cmd=create-colour-scheme" title="<?php echo cleanDataEnt($msg_colours2); ?>"><img src="templates/img/links/new-color-scheme.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_colours2; ?></a></li>
				<li><a href="../docs/setup/index.html" title="<?php echo cleanDataEnt($msg_home6); ?>" target="_blank"><img src="templates/img/links/docs.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_home6; ?></a></li>
			</ul>

		</div>

		
