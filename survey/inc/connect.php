<?php

/*---------------------------------------------
  MAIAN SURVEY v1.1
  Written by David Ian Bennett
  E-Mail: N/A
  Website: www.maiansurvey.com
----------------------------------------------*/

/*---------------------------------------------
  DATABASE CONNECTION
  Specify your connection details
-----------------------------------------------*/

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'survey_test');
define('DB_PREFIX', 'msv_');
define('DB_CHAR_SET', 'utf8'); // Character encoding set..
define('DB_LOCALE', 'en_GB'); // Locale..

/*-------------------------------------------------------------------------------------------------
  COOKIE NAME
  Should be changed for security.
---------------------------------------------------------------------------------------------------*/ 

define('COOKIE_NAME', 'msv_cookie');

/*-------------------------------------------------------------------------------------------------
  SECRET KEY (OR SALT)
  For security. Should be a long random string of numbers, letters and special characters
---------------------------------------------------------------------------------------------------*/ 

define('SECRET_KEY', 'hfgfyf[]f[9874hg36g88sgsfdt00kfte');

/*-------------------------------------------------------------------------------------------------
   TIMEZONE. LEAVE BLANK TO AUTO DETECT SERVER TIMEZONE.
   For manual entry, must be valid timezone. Examples:
   
   define('TIMEZONE', 'Europe/London');
   define('TIMEZONE', 'Asia/Hong_Kong');
   
   For valid timezones see: http://www.php.net/manual/en/timezones.php
   
   If left blank, gets value from:
   http://www.php.net/manual/en/function.date-default-timezone-get.php
---------------------------------------------------------------------------------------------------*/ 

define('TIMEZONE', '');




//================================
// DO NOT EDIT BELOW THIS LINE
//================================

$connect = @mysql_connect(DB_HOST,DB_USER,DB_PASS);
if (!$connect) {
	die (db_MSG(__FILE__,__LINE__));
}
@mysql_select_db(DB_NAME,$connect) or die (db_MSG(__FILE__,__LINE__));
if ($connect) {
  @mysql_query("SET CHARACTER SET '".DB_CHAR_SET."'");
  @mysql_query("SET NAMES '".DB_CHAR_SET."'");
  @mysql_query("SET lc_time_names = '".DB_LOCALE."'");
}

?>
