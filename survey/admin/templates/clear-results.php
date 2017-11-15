<?php
if (!defined('INC')) { die('Error! You don`t have permission to view this file!'); }
?>		
		
		<div class="content">

			<h1><?php echo $msg_survey55; ?></h1>
			
      <code><?php echo $msg_survey56; ?></code>
      <code><img src="templates/img/links/back.gif" alt="" title="" /> <a href="index.php?cmd=surveys" title="<?php echo cleanDataEnt($msg_survey34); ?>"><?php echo $msg_survey34; ?></a></code>

		</div>

		<div class="sidenav">

			<h2><?php echo $msg_survey33; 
      $sur = rowData('surveys',' WHERE sur_id = \''.(int)$_GET['survey'].'\'');
      ?></h2>
			<ul>
				<li><a href="index.php?cmd=copy-survey&amp;copy=<?php echo $_GET['survey']; ?>" title="<?php echo cleanDataEnt($msg_survey35); ?>"><img src="templates/img/links/copy.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_survey35; ?></a></li>
				<li><a href="../results.php?survey=21232f297a57a5a743894a0e4a801fc3-<?php echo $sur->uniCode; ?>" title="<?php echo cleanDataEnt($msg_survey36); ?>" target="_blank"><img src="templates/img/links/preview.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_survey36; ?></a></li>
				<li><a href="index.php?cmd=questions&amp;survey=<?php echo $_GET['survey']; ?>" title="<?php echo cleanDataEnt($msg_survey38); ?>"><img src="templates/img/links/questions.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_survey38; ?></a></li>
				<li><a href="index.php?cmd=contacts&amp;survey=<?php echo $_GET['survey']; ?>" title="<?php echo cleanDataEnt($msg_survey51); ?>"><img src="templates/img/links/contacts.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_survey51; ?></a></li>
				<li><a href="index.php?cmd=keywords&amp;survey=<?php echo $_GET['survey']; ?>" title="<?php echo cleanDataEnt($msg_survey52); ?>"><img src="templates/img/links/keywords.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_survey52; ?></a></li>
			</ul>
		</div>

		
