<?php
if (!defined('INC')) { die('Error! You don`t have permission to view this file!'); }
?>
<style type="text/css">
.title {
  background-color:#<?php echo $PREVIEW->title_background; ?>;
	 color:#<?php echo $PREVIEW->title_color; ?>;
	 font-family:<?php echo $PREVIEW->title_font; ?>;
	 font-size:<?php echo $PREVIEW->title_size; ?>px;
	 padding:5px;
	 text-align:left;
	 margin-bottom:2px;
	 font-weight:bold;
}
.question {
	 background-color:#<?php echo $PREVIEW->question_background; ?>;
	 color:#<?php echo $PREVIEW->question_color; ?>;
	 font-family:<?php echo $PREVIEW->question_font; ?>;
	 font-size:<?php echo $PREVIEW->question_size; ?>px;
	 padding:5px;
	 text-align:left;
	 margin-bottom:2px;
}
.answer {
	 background-color:#<?php echo $PREVIEW->answer_background; ?>;
	 color:#<?php echo $PREVIEW->answer_color; ?>;
	 font-family:<?php echo $PREVIEW->answer_font; ?>;
	 font-size:<?php echo $PREVIEW->answer_size; ?>px;
	 padding:5px;
	 text-align:left;
	 margin-bottom:2px;	
}
</style>

<div style="padding:5px;background:#FAFAFA">

<div class="title"><?php echo $msg_preview; ?></div>
<div class="question">1. <?php echo $msg_preview2; ?></div>
<div class="answer">
<input type="radio" name="demo" value="1" /> <?php echo $msg_preview3; ?><br />
<input type="radio" name="demo" value="2" /> <?php echo $msg_preview4; ?><br />
<input type="radio" name="demo" value="3" /> <?php echo $msg_preview3; ?>
</div>
<div class="question">2. <?php echo $msg_preview2; ?></div>
<div class="answer">
<input type="radio" name="demo" value="1" /> <?php echo $msg_preview3; ?><br />
<input type="radio" name="demo" value="2" /> <?php echo $msg_preview4; ?><br />
<input type="radio" name="demo" value="3" /> <?php echo $msg_preview3; ?>
</div>

</div>
