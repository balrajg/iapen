<?php
if (!defined('INC')) { die('Error! You don`t have permission to view this file!'); }
?>		
		
		<div class="content">

			<h1><?php echo $msg_colours2; ?></h1>
			
      <p><?php echo $msg_colours3; ?></p>
      
      <form method="post" action="index.php?cmd=create-colour-scheme">
      <input type="hidden" name="process" value="1" />
      
      <div class="formOptionWrap">
      <label class="first"><?php echo $msg_colours5; ?>:</label>
      <input type="text" class="box" name="csc_title" value="<?php echo (isset($_POST['csc_title']) ? cleanDataEnt($_POST['csc_title']) : ''); ?>" maxlength="255" />
      <?php echo (isset($T_ERROR) ? '<span class="error">'.$T_ERROR.'</span>' : ''); ?>
      </div>
      
      <div class="formOptionWrap">
      <label><?php echo $msg_colours6; ?>:</label>
      <input type="text" class="box" name="csc_width" value="<?php echo (isset($_POST['csc_width']) ? cleanDataEnt($_POST['csc_width']) : ''); ?>" maxlength="4" style="width:10%" />
      </div>
      
      <div class="formOptionWrap">
      <label><?php echo $msg_colours7; ?>:</label>
      <table width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td style="width:30%;vertical-align:top">
        <span class="color_option"><?php echo $msg_colours11; ?></span>
        <input type="text" class="box" name="title_background" value="<?php echo (isset($_POST['title_background']) ? cleanDataEnt($_POST['title_background']) : ''); ?>" /> <img style="cursor:pointer" onclick="showColorPicker(this,document.forms[0].title_background)" src="templates/img/color.gif" alt="<?php echo cleanDataEnt($msg_colours15); ?>" title="<?php echo cleanDataEnt($msg_colours15); ?>" />
        </td>
        <td style="width:30%;vertical-align:top">
        <span class="color_option"><?php echo $msg_colours12; ?></span>
        <input type="text" class="box" name="title_color" value="<?php echo (isset($_POST['title_color']) ? cleanDataEnt($_POST['title_color']) : ''); ?>" /> <img style="cursor:pointer" onclick="showColorPicker(this,document.forms[0].title_color)" src="templates/img/color.gif" alt="<?php echo cleanDataEnt($msg_colours15); ?>" title="<?php echo cleanDataEnt($msg_colours15); ?>" />
        </td>
        <td style="width:30%;vertical-align:top">
        <span class="color_option"><?php echo $msg_colours13; ?></span>
        <select name="title_font">
        <?php
        foreach ($fonts AS $f) {
        ?>
        <option<?php echo (isset($_POST['title_font']) && $_POST['title_font']==$f ? ' selected="selected"' : ''); ?>><?php echo $f; ?></option>
        <?php
        }
        ?>
        </select>
        </td>
        <td style="width:10%;vertical-align:top">
        <span class="color_option"><?php echo $msg_colours14; ?></span>
        <select name="title_size">
        <?php
        foreach ($font_sizes AS $s) {
        ?>
        <option<?php echo (isset($_POST['title_size']) && $_POST['title_size']==$s ? ' selected="selected"' : ''); ?>><?php echo $s; ?></option>
        <?php
        }
        ?>
        </select>
        </td>
      </tr>
      </table>
      </div>
      
      <div class="formOptionWrap">
      <label><?php echo $msg_colours8; ?>:</label>
      <table width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td style="width:30%;vertical-align:top">
        <span class="color_option"><?php echo $msg_colours11; ?></span>
        <input type="text" class="box" name="question_background" value="<?php echo (isset($_POST['question_background']) ? cleanDataEnt($_POST['question_background']) : ''); ?>" /> <img style="cursor:pointer" onclick="showColorPicker(this,document.forms[0].question_background)" src="templates/img/color.gif" alt="<?php echo cleanDataEnt($msg_colours15); ?>" title="<?php echo cleanDataEnt($msg_colours15); ?>" />
        </td>
        <td style="width:30%;vertical-align:top">
        <span class="color_option"><?php echo $msg_colours12; ?></span>
        <input type="text" class="box" name="question_color" value="<?php echo (isset($_POST['question_color']) ? cleanDataEnt($_POST['question_color']) : ''); ?>" /> <img style="cursor:pointer" onclick="showColorPicker(this,document.forms[0].question_color)" src="templates/img/color.gif" alt="<?php echo cleanDataEnt($msg_colours15); ?>" title="<?php echo cleanDataEnt($msg_colours15); ?>" />
        </td>
        <td style="width:30%;vertical-align:top">
        <span class="color_option"><?php echo $msg_colours13; ?></span>
        <select name="question_font">
        <?php
        foreach ($fonts AS $f) {
        ?>
        <option<?php echo (isset($_POST['question_font']) && $_POST['question_font']==$f ? ' selected="selected"' : ''); ?>><?php echo $f; ?></option>
        <?php
        }
        ?>
        </select>
        </td>
        <td style="width:10%;vertical-align:top">
        <span class="color_option"><?php echo $msg_colours14; ?></span>
        <select name="question_size">
        <?php
        foreach ($font_sizes AS $s) {
        ?>
        <option<?php echo (isset($_POST['question_size']) && $_POST['question_size']==$s ? ' selected="selected"' : ''); ?>><?php echo $s; ?></option>
        <?php
        }
        ?>
        </select>
        </td>
      </tr>
      </table>
      </div>
      
      <div class="formOptionWrap">
      <label><?php echo $msg_colours9; ?>:</label>
      <table width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td style="width:30%;vertical-align:top">
        <span class="color_option"><?php echo $msg_colours11; ?></span>
        <input type="text" class="box" name="answer_background" value="<?php echo (isset($_POST['answer_background']) ? cleanDataEnt($_POST['answer_background']) : ''); ?>" /> <img style="cursor:pointer" onclick="showColorPicker(this,document.forms[0].answer_background)" src="templates/img/color.gif" alt="<?php echo cleanDataEnt($msg_colours15); ?>" title="<?php echo cleanDataEnt($msg_colours15); ?>" />
        </td>
        <td style="width:30%;vertical-align:top">
        <span class="color_option"><?php echo $msg_colours12; ?></span>
        <input type="text" class="box" name="answer_color" value="<?php echo (isset($_POST['answer_color']) ? cleanDataEnt($_POST['answer_color']) : ''); ?>" /> <img style="cursor:pointer" onclick="showColorPicker(this,document.forms[0].answer_color)" src="templates/img/color.gif" alt="<?php echo cleanDataEnt($msg_colours15); ?>" title="<?php echo cleanDataEnt($msg_colours15); ?>" />
        </td>
        <td style="width:30%;vertical-align:top">
        <span class="color_option"><?php echo $msg_colours13; ?></span>
        <select name="answer_font">
        <?php
        foreach ($fonts AS $f) {
        ?>
        <option<?php echo (isset($_POST['answer_font']) && $_POST['answer_font']==$f ? ' selected="selected"' : ''); ?>><?php echo $f; ?></option>
        <?php
        }
        ?>
        </select>
        </td>
        <td style="width:10%;vertical-align:top">
        <span class="color_option"><?php echo $msg_colours14; ?></span>
        <select name="answer_size">
        <?php
        foreach ($font_sizes AS $s) {
        ?>
        <option<?php echo (isset($_POST['answer_size']) && $_POST['answer_size']==$s ? ' selected="selected"' : ''); ?>><?php echo $s; ?></option>
        <?php
        }
        ?></select>
        </td>
      </tr>
      </table>
      </div>
      
      <br />
      <input type="submit" class="button" value="<?php echo cleanDataEnt($msg_colours2); ?>" title="<?php echo cleanDataEnt($msg_colours2); ?>" />
      
      </form>

		</div>

		<div class="sidenav">

			<h2><?php echo $msg_script12; ?></h2>
			<ul>
				<li><a href="index.php?cmd=colours" title="<?php echo cleanDataEnt($msg_colours4); ?>"><img src="templates/img/links/view.gif" alt="" title="" />&nbsp;&nbsp;<?php echo $msg_colours4; ?></a></li>
			</ul>

		</div>

		
