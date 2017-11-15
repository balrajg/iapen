<?php
if (!defined('INC')) {
  exit;
} 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="application/xhtml+xml; charset=<?php echo $msg_charset; ?>"/>
<link rel="stylesheet" type="text/css" href="stylesheet.css" media="screen" />
<script type="text/javascript" src="templates/js/overlib.js"><!-- overLIB (c) Erik Bosrup --></script>
<script type="text/javascript" src="templates/js/js_code.js"></script>
<script type="text/javascript" src="templates/js/jquery.js"></script>
<script type="text/javascript" src="templates/js/ibox.js"></script>
<script type="text/javascript" src="templates/js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="jquery-ui.css" />
<?php
// Only load for colour pages..
if ($cmd=='colours' || $cmd=='create-colour-scheme' || $cmd=='edit-colour-scheme') {
?>
<link rel="stylesheet" type="text/css" href="picker.css" media="screen"/>
<script type="text/javascript" src="templates/js/color_picker.js"></script>
<?php
}
?>
<link rel="SHORTCUT ICON" href="favicon.ico" />
<title><?php echo cleanDataEnt($title); ?></title>
</head>

<body<?php echo ($cmd=='login' ? ' onload="$(\'#user\').focus()"' : ''); ?>>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>

<div id="wrapper">
<?php
if (isset($_SESSION['wpp_session']) || isset($_COOKIE[COOKIE_NAME])) {
?>
<div class="header">
  <p><?php echo $msg_script.' - '.$msg_header; ?></p>
</div>
<?php
}
?>
<div class="container">	
   <?php
		 if (isset($_SESSION['wpp_session']) || isset($_COOKIE[COOKIE_NAME])) {
		 ?>
	  <div class="navigation">
	  
		  <a href="index.php" title="<?php echo cleanDataEnt($msg_header2); ?>"><?php echo $msg_header2; ?></a>
		  <a href="index.php?cmd=settings" title="<?php echo cleanDataEnt($msg_header8); ?>"><?php echo $msg_header8; ?></a>
		  <a href="index.php?cmd=surveys" title="<?php echo cleanDataEnt($msg_header4); ?>"><?php echo $msg_header4; ?></a>
		  <a href="index.php?cmd=colours" title="<?php echo cleanDataEnt($msg_header5); ?>"><?php echo $msg_header5; ?></a>
		  <a href="index.php?cmd=pass" title="<?php echo cleanDataEnt($msg_header6); ?>"><?php echo $msg_header6; ?></a>
		  <a href="index.php?cmd=logout" title="<?php echo cleanDataEnt($msg_header3); ?>" onclick="return delete_confirm('<?php echo $msg_javascript16; ?>')"><?php echo $msg_header3; ?></a>
   
   </div>
   <?php
   }
   ?>	
	<div class="main"<?php echo (isset($_SESSION['wpp_session']) || isset($_COOKIE[COOKIE_NAME]) ? '' : ' style="border-top:0"'); ?>>
