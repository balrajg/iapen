<?php
if (!defined('INC')) { die('Error! You don`t have permission to view this file!'); }
?>		
		
		<div class="content">

			<h1><?php echo $msg_header5; ?> (<?php echo rowCount('colorschemes'); ?>)</h1>
			
      <p><?php echo $msg_colours; ?></p>
      
      <?php
      $q_colors = mysql_query("SELECT * FROM ".DB_PREFIX."colorschemes
                               ORDER BY csc_title
                               LIMIT $limitvalue,".DATA_PER_PAGE."
                               ") or die(db_MSG(__FILE__,__LINE__));
      
      while ($COLORS = mysql_fetch_object($q_colors)) {
      ?>
      <table width="100%" cellspacing="0" cellpadding="0" class="table">
      <tr>
        <td style="width:80%;padding:5px"><?php echo cleanDataEnt($COLORS->csc_title); ?></td>
        <td style="width:20%;text-align:center;padding:5px"><a rel="ibox" href="index.php?cmd=colours&amp;preview=<?php echo $COLORS->csc_id; ?>" title="<?php echo cleanDataEnt($msg_script13); ?>: <?php echo cleanDataEnt($COLORS->csc_title); ?>"><img class="img_option" src="templates/img/preview.gif" alt="<?php echo cleanDataEnt($msg_script13); ?>" title="<?php echo cleanDataEnt($msg_script13); ?>" /></a> <a href="index.php?cmd=edit-colour-scheme&amp;edit=<?php echo $COLORS->csc_id; ?>"><img class="img_option" src="templates/img/edit.gif" alt="<?php echo cleanDataEnt($msg_script9); ?>" title="<?php echo cleanDataEnt($msg_script9); ?>" /></a> <a href="index.php?cmd=colours&amp;delete=<?php echo $COLORS->csc_id; ?>" onclick="return delete_confirm('<?php echo $msg_javascript; ?>')"><img class="img_option" src="templates/img/delete.gif" alt="<?php echo cleanDataEnt($msg_script10); ?>" title="<?php echo cleanDataEnt($msg_script10); ?>" /></a></td>
      </tr>
      </table>
      <?php
      }
      
      if (mysql_num_rows($q_colors)>0) {
        echo page_numbers(rowCount('colorschemes'),$limit,$page);
      } else {
      ?>
      <code><?php echo $msg_colours16; ?></code>
      <?php
      }
      
      ?>
      
		</div>

		<div class="sidenav">

			<h2><?php echo $msg_script12; ?></h2>
			<ul>
				<li><a href="index.php?cmd=create-colour-scheme" title="<?php echo cleanDataEnt($msg_colours2); ?>"><img src="templates/img/links/new-color-scheme.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_colours2; ?></a></li>
			</ul>

		</div>

		
