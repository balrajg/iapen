<?php
if (!defined('INC')) { die('Error! You don`t have permission to view this file!'); }
?>		
		
		<div class="content">

			<h1><?php echo $msg_contacts9; ?></h1>
			
      <code><?php echo $msg_contacts10; ?></code>
      <code><img src="templates/img/links/back.gif" alt="" title="" /> <a href="index.php?cmd=contacts&amp;survey=<?php echo (int)$_GET['survey']; ?>" title="<?php echo cleanDataEnt($msg_script20); ?>"><?php echo $msg_script20; ?></a></code>

		</div>

		<div class="sidenav">
		  <h2><?php echo $msg_script12; ?></h2>
			<ul>
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

		
