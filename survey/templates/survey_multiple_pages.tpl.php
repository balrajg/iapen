<form method="post" action="index.php">
<p><input type="hidden" name="question" value="<?php echo $this->QUESTION_ID; ?>" /></p>
<?php echo $this->TITLE; ?>
<div class="question"><?php echo $this->QUESTION; ?><?php echo $this->HELP; ?></div>
<?php echo $this->ERROR; ?>
<div class="answer">
<?php echo $this->ANSWER; ?>
</div>
