<?php

/*---------------------------------------------
  MAIAN SURVEY v1.1
  Written by David Ian Bennett
  E-Mail: N/A
  Website: www.maiansurvey.com
----------------------------------------------*/

class programSettings {

var $prefix;

function updateSettings () {
  $_POST = array_map('safeImport',$_POST);
  mysql_query("UPDATE ".$this->prefix."config SET
               cfg_wname    = '".$_POST['cfg_wname']."',
               cfg_wemail   = '".$_POST['cfg_wemail']."',
               cfg_wurl     = '".$_POST['cfg_wurl']."',
               cfg_afflink  = '".$_POST['cfg_afflink']."',
               smtp         = '".(isset($_POST['smtp']) ? $_POST['smtp'] : '0')."',
               smtp_host    = '".$_POST['smtp_host']."',
               smtp_user    = '".$_POST['smtp_user']."',
               smtp_pass    = '".$_POST['smtp_pass']."',
               smtp_port    = '".$_POST['smtp_port']."'
               LIMIT 1
               ") or die(db_MSG(__FILE__,__LINE__));
}

function loadSettings () {
  $query = mysql_query("SELECT * FROM ".$this->prefix."config LIMIT 1") or die(db_MSG(__FILE__,__LINE__));
  return mysql_fetch_object($query);
}

function updatePassword($pass) {
  mysql_query("UPDATE ".$this->prefix."config SET
               cfg_login     = '".safeImport($_POST['user'])."',
               cfg_password  = '".md5($pass.SECRET_KEY)."'
               LIMIT 1
               ") or die(db_MSG(__FILE__,__LINE__));
}

function importFileCSV($name,$email,$seperator,$id,$msg) {
  $string = $name.$seperator.$email.defineNewline();
  $query = mysql_query("SELECT * FROM ".$this->prefix."users
                        ".($id!='all' ? 
                        'WHERE usr_sur_id IN('.$id.')' 
                        : 
                        ''
                        )."
                        ORDER BY usr_name
                        ") or die(db_MSG(__FILE__,__LINE__));
  while ($row = mysql_fetch_object($query)) {
    // For safety, lets enclose username in quotes to prevent invalid import..
    $string .= '"'.$row->usr_name.'"'.$seperator.$row->usr_email.defineNewline();
  }
  // Set file name..
  $file = PATH.'export/csv_import.csv';    
  // Check csv folder exists and is writeable..                               
  if (is_dir(PATH.'export/') && is_writeable(PATH.'export/')) {
    // Create file for download..
    $fp = fopen($file, 'ab');
    if ($fp) {
      fwrite($fp,trim($string));
      fclose($fp);
    }
    unset($string);
    // Fixes some issues in IE..
    if(ini_get('zlib.output_compression')) {
      ini_set('zlib.output_compression', 'Off');
    }
    // Download file..
    header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
    header('Pragma: public');
	   header('Expires: 0');
	   header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	   header('Cache-Control: private',false);
	   header('Content-Type: '.get_mime_type());
	   header('Content-Disposition: attachment; filename='.basename($file).';');
	   header('Content-Transfer-Encoding: binary');
	   header('Content-Length: '.filesize($file));
	   @ob_end_flush();
	   readfile($file);
	   // Delete download file..
    if (file_exists($file)) {
      @unlink($file);
    }
  } else {
    echo '
    <script type="text/javascript">
    //<![CDATA[
    $(document).ready(function() {
      alert(\''.htmlspecialchars($msg).'\');
    });
    //]]>
    </script>
    ';
  }
}

}

?>
