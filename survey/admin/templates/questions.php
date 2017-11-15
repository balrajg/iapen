<?php
if (!defined('INC')) { die('Error! You don`t have permission to view this file!'); }
?>		
		
		<div class="content">

			<h1><?php echo $msg_question.' ('.rowCount('questions',' WHERE que_sur_id = \''.(int)$_GET['survey'].'\'').')'; ?></h1>
			
      <p><?php echo $msg_question2; ?></p>
      
      <form method="post" action="index.php?cmd=questions">
      <input type="hidden" name="order" value="1" />
      <input type="hidden" name="survey" value="<?php echo (int)$_GET['survey']; ?>" />
      <?php
      $q_questions = mysql_query("SELECT * FROM ".DB_PREFIX."questions
                                  WHERE que_sur_id = '".(int)$_GET['survey']."'
                                  ORDER BY orderBy
                                  LIMIT $limitvalue,".DATA_PER_PAGE."
                                  ") or die(db_MSG(__FILE__,__LINE__));
      
      while ($QUESTIONS = mysql_fetch_object($q_questions)) {
      ?>
      <input type="hidden" name="question[]" value="<?php echo $QUESTIONS->que_id; ?>" />
      <table width="100%" cellspacing="0" cellpadding="0" class="table">
      <tr>
        <td style="width:10%;text-align:left;padding:5px"><select onchange="this.form.submit()" style="border:1px solid #EEEEEE;padding:0" name="order_by[]">
        <?php
        for ($i=1; $i<rowCount('questions',' WHERE que_sur_id = \''.(int)$_GET['survey'].'\'')+1; $i++) {
        ?>
        <option style="padding-left:3px"<?php echo ($QUESTIONS->orderBy==$i ? ' selected="selected"' : ''); ?>><?php echo $i; ?></option>
        <?php
        }
        ?>
        </select></td> 
        <td style="width:75%;padding:5px;text-align:left"><?php echo cleanDataEnt($QUESTIONS->que_text); ?></td>
        <td style="width:15%;text-align:right;padding:5px"><a href="index.php?cmd=edit-question&amp;edit=<?php echo $QUESTIONS->que_id; ?>"><img class="img_option" src="templates/img/edit.gif" alt="<?php echo cleanDataEnt($msg_script9); ?>" title="<?php echo cleanDataEnt($msg_script9); ?>" /></a> <a href="index.php?cmd=questions&amp;survey=<?php echo (int)$_GET['survey']; ?>&amp;delete=<?php echo $QUESTIONS->que_id; ?>" onclick="return delete_confirm('<?php echo $msg_javascript; ?>')"><img class="img_option" src="templates/img/delete.gif" alt="<?php echo cleanDataEnt($msg_script10); ?>" title="<?php echo cleanDataEnt($msg_script10); ?>" /></a></td>
      </tr>
      </table>
      <?php
      }
      
      if (mysql_num_rows($q_questions)>0) {
        echo page_numbers(rowCount('questions',' WHERE que_sur_id = \''.(int)$_GET['survey'].'\''),$limit,$page);
      } else {
      ?>
      <code><?php echo $msg_question4; ?></code>
      <?php
      }
      
      ?>
      </form>
		</div>

		<div class="sidenav">
      
      <h2><?php echo $msg_script12; ?></h2>
			<ul>
				<li><a href="index.php?cmd=add-question&amp;survey=<?php echo (int)$_GET['survey']; ?>" title="<?php echo cleanDataEnt($msg_question3); ?>"><img src="templates/img/links/questions.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_question3; ?></a></li>
			  <li><a href="index.php?cmd=surveys" title="<?php echo cleanDataEnt($msg_survey4); ?>"><img src="templates/img/links/view.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_survey4; ?></a></li>
			</ul>
		</div>

		
