<?php
if (!defined('INC')) { die('Error! You don`t have permission to view this file!'); }
?>
<div style="padding:5px;background:#FAFAFA">

<div class="formOptionWrap">
  <b><?php echo $msg_question12; ?></b><br /><br />
  <input type="radio" name="name" value="1" /> <?php echo $msg_help; ?>1<br />
  <input type="radio" name="name" value="2" /> <?php echo $msg_help; ?>2<br />
  <input type="radio" name="name" value="3" /> <?php echo $msg_help; ?>3
</div>

<div class="formOptionWrap">
  <b><?php echo $msg_question13; ?></b><br /><br />
  <input type="radio" name="name" value="1" /> <?php echo $msg_help; ?>1
  <input type="radio" name="name" value="2" /> <?php echo $msg_help; ?>2
  <input type="radio" name="name" value="3" /> <?php echo $msg_help; ?>3
</div>

<div class="formOptionWrap">
  <b><?php echo $msg_question14; ?></b><br /><br />
  <input type="radio" name="name" value="1" /> <?php echo $msg_help; ?>1<br />
  <input type="radio" name="name" value="2" /> <?php echo $msg_help; ?>2<br />
  <input type="radio" name="name" value="3" /> <?php echo $msg_help; ?>3<br />
  <?php echo $msg_help2; ?><br />
  <input type="text" name="box" class="box" />
</div>

<div class="formOptionWrap">
  <b><?php echo $msg_question15; ?></b><br /><br />
  <input type="checkbox" name="name[]" value="1" /> <?php echo $msg_help; ?>1<br />
  <input type="checkbox" name="name[]" value="2" /> <?php echo $msg_help; ?>2<br />
  <input type="checkbox" name="name[]" value="3" /> <?php echo $msg_help; ?>3
  Info here..
</div>

<div class="formOptionWrap">
  <b><?php echo $msg_question16; ?></b><br /><br />
  <input type="checkbox" name="name[]" value="1" /> <?php echo $msg_help; ?>1
  <input type="checkbox" name="name[]" value="2" /> <?php echo $msg_help; ?>2
  <input type="checkbox" name="name[]" value="3" /> <?php echo $msg_help; ?>3
</div>

<div class="formOptionWrap">
  <b><?php echo $msg_question17; ?></b><br /><br />
  <input type="checkbox" name="name[]" value="1" /> <?php echo $msg_help; ?>1<br />
  <input type="checkbox" name="name[]" value="2" /> <?php echo $msg_help; ?>2<br />
  <input type="checkbox" name="name[]" value="3" /> <?php echo $msg_help; ?>3<br />
  <?php echo $msg_help2; ?><br />
  <input type="text" name="box" class="box" />
</div>

<div class="formOptionWrap">
  <b><?php echo $msg_question18; ?></b><br /><br />
  <select name="name"><option>1</option><option>2</option><option>3</option></select> <?php echo $msg_help; ?>1<br />
  <select name="name"><option>1</option><option>2</option><option>3</option></select> <?php echo $msg_help; ?>2<br />
  <select name="name"><option>1</option><option>2</option><option>3</option></select> <?php echo $msg_help; ?>3
</div>

<div class="formOptionWrap">
  <b><?php echo $msg_question19; ?></b><br />
  <input type="text" name="box" class="box" />
</div>

<div class="formOptionWrap">
  <b><?php echo $msg_question20; ?></b><br />
  <textarea name="name" rows="4" cols="20"></textarea>
</div>

</div>
