<div class="question"><?php echo $this->HEADING; ?></div>
<?php echo $this->MESSAGE; ?>
<?php echo $this->ERROR; ?>
<form method="post" action="index.php">
<input type="hidden" name="process_email" value="1" />
<div class="question">
 <label><?php echo $this->NAME; ?></label>
 <input type="text" name="name" class="box" value="<?php echo $this->N_VALUE; ?>" />
 <label><?php echo $this->EMAIL; ?>:</label>
 <input type="text" name="email" class="box" value="<?php echo $this->E_VALUE; ?>" />
</div>
