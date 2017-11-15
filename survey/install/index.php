<?php

/*---------------------------------------------
  MAIAN SURVEY v1.1
  Written by David Ian Bennett
  E-Mail: N/A
  Website: www.maiansurvey.com
----------------------------------------------*/

error_reporting(0);

define ('PATH', dirname(__FILE__).'/');
define ('REL_PATH', '../');

include(PATH.'lang.php');
include(REL_PATH.'inc/functions.php');
include(REL_PATH.'inc/connect.php');

$stage1  = true;
$stage2  = false;
$stage3  = false;
$report  = array();
$table   = array();
$count   = 0;

// Install tables..
if (isset($_POST['one'])) {
 $stage1 = false;
 
 // Install table...answers..
 $query = mysql_query("
 CREATE TABLE ".DB_PREFIX."answers (
  `ans_id` int(10) unsigned NOT NULL auto_increment,
  `ans_sur_id` int(11) NOT NULL default '1',
  `ans_que_id` int(11) NOT NULL default '0',
  `ans_var_id` int(11) NOT NULL default '0',
  `ans_text` longtext default null,
  `ans_session_id` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`ans_id`),
  KEY `ansid` (`ans_sur_id`),
  KEY `ansqid` (`ans_que_id`),
  KEY `ansvid` (`ans_var_id`)
 ) ENGINE=MyISAM DEFAULT CHARSET=utf8
 ");
 
 $report[] = ($query ? $setup9 : $setup10);
 $table[]  = DB_PREFIX."answers";
 
 // Install table...colorschemes..
 $query = mysql_query("
 CREATE TABLE ".DB_PREFIX."colorschemes (
  `csc_id` int(11) NOT NULL auto_increment,
  `csc_title` varchar(255) not null default '',
  `csc_width` int(11) not null default '0',
  `title_background` varchar(255) not null default '',
  `title_color` varchar(255) not null default '',
  `title_font` varchar(255) not null default '',
  `title_size` tinyint(4) not null default '0',
  `question_background` varchar(255) not null default '',
  `question_color` varchar(255) not null default '',
  `question_font` varchar(255) not null default '',
  `question_size` tinyint(4) not null default '0',
  `answer_background` varchar(255) not null default '',
  `answer_color` varchar(255) not null default '',
  `answer_font` varchar(255) not null default '',
  `answer_size` tinyint(4) not null default '0',
  PRIMARY KEY  (`csc_id`)
 ) ENGINE=MyISAM DEFAULT CHARSET=utf8
 ");
 
 $report[] = ($query ? $setup9 : $setup10);
 $table[]  = DB_PREFIX."colorschemes";
 
 // Install table...config..
 $query = mysql_query("
 CREATE TABLE ".DB_PREFIX."config (
  `cfg_id` tinyint(1) NOT NULL default '1',
  `cfg_login` varchar(64) NOT NULL default '',
  `cfg_password` text default null,
  `cfg_wname` text default null,
  `cfg_wemail` varchar(255) NOT NULL default '',
  `cfg_wurl` text default null,
  `cfg_afflink` text default null,
  `smtp` enum('0','1') NOT NULL default '0',
  `smtp_host` varchar(100) NOT NULL default 'localhost',
  `smtp_user` varchar(100) NOT NULL default '',
  `smtp_pass` varchar(100) NOT NULL default '',
  `smtp_port` varchar(100) NOT NULL default '25',
  PRIMARY KEY  (`cfg_id`)
 ) ENGINE=MyISAM DEFAULT CHARSET=utf8
 ");
 
 $report[] = ($query ? $setup9 : $setup10);
 $table[]  = DB_PREFIX."config";
 
 // Install table...keywords..
 $query = mysql_query("
 CREATE TABLE ".DB_PREFIX."keywords (
  `key_id` int(10) unsigned NOT NULL auto_increment,
  `key_sur_id` int(11) NOT NULL default '0',
  `key_que_id` int(11) NOT NULL default '0',
  `key_word` varchar(255) NOT NULL default '',
  `key_date` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`key_id`),
  KEY `kid` (`key_sur_id`),
  KEY `kqid` (`key_que_id`)
 ) ENGINE=MyISAM DEFAULT CHARSET=utf8
 ");
 
 $report[] = ($query ? $setup9 : $setup10);
 $table[]  = DB_PREFIX."keywords";
 
 // Install table...questions..
 $query = mysql_query("
 CREATE TABLE ".DB_PREFIX."questions (
  `que_id` int(11) NOT NULL auto_increment,
  `que_sur_id` int(11) NOT NULL default '0',
  `que_text` text default null,
  `que_help_text` mediumtext default null,
  `que_answer_type` tinyint(4) not null default '0',
  `que_required` tinyint(1) not null default '0',
  `orderBy` int(6) NOT NULL default '0',
  PRIMARY KEY  (`que_id`),
  KEY `qid` (`que_sur_id`)
 ) ENGINE=MyISAM DEFAULT CHARSET=utf8
 ");
 
 $report[] = ($query ? $setup9 : $setup10);
 $table[]  = DB_PREFIX."questions";
 
 // Install table...surveys..
 $query = mysql_query("
 CREATE TABLE ".DB_PREFIX."surveys (
  `sur_id` int(11) NOT NULL auto_increment,
  `sur_title` varchar(255) not null default '',
  `sur_display_type` enum('0','1') NOT NULL default '0',
  `sur_title_should_display` tinyint(1) default '1',
  `sur_captcha` enum('0','1') NOT NULL default '0',
  `sur_submit_text` varchar(50) not null default '',
  `sur_email_request` tinyint(1) default '0',
  `sur_email_request_message` text default null,
  `sur_view_summary` tinyint(1) not null default '1',
  `sur_date_expire` date NOT NULL default '0000-00-00',
  `sur_complete_goto_url` tinyint(4) NOT NULL default '0',
  `sur_complete_url` varchar(255) not null default '',
  `sur_complete_message` text default null,
  `sur_allow_multiple_votes` tinyint(1) not null default '1',
  `sur_notification_email` varchar(255) not null default '',
  `sur_status` tinyint(4) not null default '0',
  `sur_dare_created` datetime NOT NULL default '0000-00-00 00:00:00',
  `sur_color_scheme` tinyint(4) not null default '0',
  `uniCode` char(7) NOT NULL default '',
  `en_keys` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`sur_id`)
 ) ENGINE=MyISAM DEFAULT CHARSET=utf8
 ");
 
 $report[] = ($query ? $setup9 : $setup10);
 $table[]  = DB_PREFIX."surveys";
 
 // Install table...users..
 $query = mysql_query("
 CREATE TABLE ".DB_PREFIX."users (
  `usr_id` int(11) NOT NULL auto_increment,
  `usr_sur_id` int(11) NOT NULL default '0',
  `usr_email` varchar(255) NOT NULL default '',
  `usr_name` varchar(255) NOT NULL default '',
  `usr_date` date NOT NULL default '0000-00-00',
  `usr_IP` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`usr_id`),
  KEY `uid` (`usr_sur_id`)
 ) ENGINE=MyISAM DEFAULT CHARSET=utf8
 ");
 
 $report[] = ($query ? $setup9 : $setup10);
 $table[]  = DB_PREFIX."users";
 
 // Install table...variants..
 $query = mysql_query("
 CREATE TABLE ".DB_PREFIX."variants (
  `var_id` int(11) NOT NULL auto_increment,
  `var_opt_id` int(11) NOT NULL default '0',
  `var_que_id` int(11) NOT NULL default '0',
  `var_text` varchar(255) not null default '',
  PRIMARY KEY  (`var_id`),
  KEY `void` (`var_opt_id`),
  KEY `vqid` (`var_que_id`)
 ) ENGINE=MyISAM DEFAULT CHARSET=utf8
 ");
 
 $report[] = ($query ? $setup9 : $setup10);
 $table[]  = DB_PREFIX."variants";
 
 $stage2 = true;
 
}

// Install data..
if (isset($_POST['two'])) {
  // Insert default schemes..
  mysql_query("INSERT INTO ".DB_PREFIX."colorschemes (`csc_id`, `csc_title`, `csc_width`, `title_background`, `title_color`, `title_font`, `title_size`, `question_background`, `question_color`, `question_font`, `question_size`, `answer_background`, `answer_color`, `answer_font`, `answer_size`) VALUES(1, 'Beautiful Days', 1000, 'CCD8E0', '5A5A43', 'Verdana', 12, 'ABBECA', '5A5A43', 'Verdana', 12, 'CCD8E0', '5A5A43', 'Verdana', 12)") or die(db_MSG(__FILE__,__LINE__));
  mysql_query("INSERT INTO ".DB_PREFIX."colorschemes (`csc_id`, `csc_title`, `csc_width`, `title_background`, `title_color`, `title_font`, `title_size`, `question_background`, `question_color`, `question_font`, `question_size`, `answer_background`, `answer_color`, `answer_font`, `answer_size`) VALUES(2, 'Colourimetry', 1000, '423f3a', 'ffffff', 'Verdana', 16, 'd4d4d4', '423f3a', 'Verdana', 12, '666159', 'd4d4d4', 'Verdana', 12)") or die(db_MSG(__FILE__,__LINE__));
  mysql_query("INSERT INTO ".DB_PREFIX."colorschemes (`csc_id`, `csc_title`, `csc_width`, `title_background`, `title_color`, `title_font`, `title_size`, `question_background`, `question_color`, `question_font`, `question_size`, `answer_background`, `answer_color`, `answer_font`, `answer_size`) VALUES(3, 'Techno', 1000, '0ac8d8', 'ffffff', 'Arial', 12, 'f9f8fd', '333333', 'Arial', 12, 'f6feff', 'b10961', 'Arial', 12)") or die(db_MSG(__FILE__,__LINE__));
  mysql_query("INSERT INTO ".DB_PREFIX."colorschemes (`csc_id`, `csc_title`, `csc_width`, `title_background`, `title_color`, `title_font`, `title_size`, `question_background`, `question_color`, `question_font`, `question_size`, `answer_background`, `answer_color`, `answer_font`, `answer_size`) VALUES(4, 'Dirtylicious', 1000, '2a323d', 'ffffff', 'Arial', 12, '949490', 'f0f0eb', 'Arial', 12, 'fafafa', '555533', 'Arial', 12)") or die(db_MSG(__FILE__,__LINE__));
  mysql_query("INSERT INTO ".DB_PREFIX."colorschemes (`csc_id`, `csc_title`, `csc_width`, `title_background`, `title_color`, `title_font`, `title_size`, `question_background`, `question_color`, `question_font`, `question_size`, `answer_background`, `answer_color`, `answer_font`, `answer_size`) VALUES(5, 'Cartier', 1000, '000000', '778e5a', 'Verdana', 12, '414141', '8aaf55', 'Verdana', 12, '545454', 'd5d2d6', 'Verdana', 12)") or die(db_MSG(__FILE__,__LINE__));
  mysql_query("INSERT INTO ".DB_PREFIX."colorschemes (`csc_id`, `csc_title`, `csc_width`, `title_background`, `title_color`, `title_font`, `title_size`, `question_background`, `question_color`, `question_font`, `question_size`, `answer_background`, `answer_color`, `answer_font`, `answer_size`) VALUES(6, 'Magento', 1000, '02657a', 'fff3bf', 'Verdana', 12, 'ee5e52', 'ffffff', 'Verdana', 12, 'f2f2f2', '002d53', 'Verdana', 12)") or die(db_MSG(__FILE__,__LINE__));
  mysql_query("INSERT INTO ".DB_PREFIX."colorschemes (`csc_id`, `csc_title`, `csc_width`, `title_background`, `title_color`, `title_font`, `title_size`, `question_background`, `question_color`, `question_font`, `question_size`, `answer_background`, `answer_color`, `answer_font`, `answer_size`) VALUES(7, 'Voyager', 1000, '484677', 'ffffff', 'Arial', 12, '364d5d', 'd5d28f', 'Arial', 12, '547c9d', 'ffffff', 'Arial', 12)") or die(db_MSG(__FILE__,__LINE__));
  
  // Insert config data..
  mysql_query("INSERT INTO ".DB_PREFIX."config (`cfg_id`, `cfg_login`, `cfg_password`, `cfg_wname`, `cfg_wemail`, `cfg_wurl`, `cfg_afflink`, `smtp`, `smtp_host`, `smtp_user`, `smtp_pass`, `smtp_port`) VALUES(1, 'admin', '".md5('admin'.SECRET_KEY)."', 'My Survey System', 'you@example.com', 'http://www.example.com/surveys/', '', '0', 'localhost', '', '', '25')") or die(db_MSG(__FILE__,__LINE__));
  
  $stage1 = false;
  $stage2 = false;
  $stage3 = true;
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<head>
<meta http-equiv="content-type" content="text/html; charset=<?php echo $charset; ?>">
<title><?php echo $setup; ?></title>
<link href="stylesheet.css" rel="stylesheet" type="text/css">
<link rel="SHORTCUT ICON" href="favicon.ico">
</head>

<body>
<form method="post" action="index.php">
<div align="center">
<table width="600" cellspacing="0" cellpadding="0" class="mainTable">
<tr>
  <td align="center" class="headCell">- <?php echo $setup; ?> -</td>
</tr>
<?php
if ($stage1)
{
if (function_exists('imagecreatetruecolor')) {
  $GD = gd_info();
}
?>
<tr>
  <td align="center" class="pad"><br><?php echo $setup2; ?><br><br>
  <table width="100%" cellspacing="0" cellpadding="0" class="areaTable">
  <tr>
    <td class="pad" width="60%"><b><?php echo $setup3; ?></b></td>
    <td class="pad" width="40%"><span class="info"><?php echo DB_HOST; ?></span></td>
  </tr>
  <tr>  
    <td class="pad"><b><?php echo $setup4; ?></b></td>
    <td class="pad"><span class="info"><?php echo DB_NAME; ?></span></td>
  </tr>
  <tr>  
    <td class="pad"><b><?php echo $setup5; ?></b></td>
    <td class="pad"><span class="info"><?php echo DB_USER; ?></span></td>
  </tr>
  <tr>  
    <td class="pad"><b><?php echo $setup6; ?></b></td>
    <td class="pad"><span class="info"><?php echo DB_PASS; ?></span></td>
  </tr>
  <tr>  
    <td class="pad"><b><?php echo $setup7; ?></b></td>
    <td class="pad"><span class="info"><?php echo DB_PREFIX; ?></span></td>
  </tr>
  <tr>  
    <td class="pad"><b>Character Set</b></td>
    <td class="pad"><span class="info"><?php echo DB_CHAR_SET; ?></span></td>
  </tr>
  <tr>  
    <td class="pad"><b>Database Locale</b></td>
    <td class="pad"><span class="info"><?php echo DB_LOCALE; ?></span></td>
  </tr>
  </table>
  </td>
</tr>
<tr>
  <td align="center" class="pad" style="padding-top:10px"><?php echo $setup17; ?>:<br><br>
  <table width="100%" cellspacing="0" cellpadding="0" class="areaTable">
  <tr>
    <td class="pad" width="60%"><b><?php echo $setup16; ?></b></td>
    <td class="pad" width="40%"><span class="info">v<?php echo phpversion(); ?> - <b><?php echo (phpversion()>'4.3.0' ? $setup19 : $setup22); ?></b></span></td>
  </tr>
  <tr>
    <td class="pad" width="60%"><b><?php echo $setup15; ?></b></td>
    <td class="pad" width="40%"><span class="info"><?php echo (function_exists('imagecreatetruecolor') ? '<b>'.$setup19.'</b>' : $setup22); ?></span></td>
  </tr>
  </table>
  <?php
  if (phpversion()>=5)
  {
  ?>
  <p class="button"><input class="formButton" name="one" type="submit" value="<?php echo $setup8; ?>" title="<?php echo $setup8; ?>" /></p>
  <?php
  } else {
  ?>
  <p class="button" style="color:red;font-size:16px;margin-top:5px"><b><?php echo $setup23; ?></b></p>
  <?php
  }
  ?>
  </td>
</tr>
<?php
}
if ($stage2 && !$stage1)
{
?>
<tr>
  <td align="center" class="pad"><br><?php echo $setup14; ?><br><br>
  <table width="100%" cellspacing="0" cellpadding="0" class="areaTable">
  <?php
  
  // Show results..
  for ($i=0; $i<count($report); $i++)
  {
  ?>
  <tr>  
    <td class="pad" width="60%"><b><?php echo $table[$i]; ?></b></td>
    <td class="pad" width="40%"><span class="info"><?php echo $report[$i]; ?></span></td>
  </tr>
  <?php
  }
  
  ?>
  </table>
  <?php
  if (array_search($setup10,$report)===FALSE)
  {
  ?>
  <p class="button"><input class="formButton" name="two" type="submit" value="<?php echo $setup12; ?>" title="<?php echo $setup12; ?>" /></p>
  <?php
  }
  else
  {
    echo '<span class="error_info"><br>'.$setup11.'</span>';
  }
  ?>
  </td>
</tr>
<?php
}
if ($stage3 && (!$stage1 && !$stage2))
{
?>
<tr>
  <td align="center" class="pad"><br><?php echo $setup13; ?><br><br>
  </td>
</tr>  
<?php
}
?>
</table>
</div>
</form>
</body>
</html>
