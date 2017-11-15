<?php

/*---------------------------------------------
  MAIAN SURVEY v1.1
  Written by David Ian Bennett
  E-Mail: N/A
  Website: www.maiansurvey.com
----------------------------------------------*/

class keywords {

var $prefix;

function clearKeywords() {
  mysql_query("DELETE FROM ".$this->prefix."keywords
               WHERE key_sur_id = '".(int)$_GET['survey']."'
               ".(isset($_GET['question']) && ctype_digit($_GET['question']) ? 'AND key_que_id = \''.(int)$_GET['question'].'\'' : '')."
               ".(isset($_GET['from']) &&  $_GET['from'] && isset($_GET['to']) && $_GET['to'] ? 'AND key_date BETWEEN \''.$_GET['from'].'\' AND \''.$_GET['to'].'\'' : '')."
               ") or die(db_MSG(__FILE__,__LINE__));
}

}

?>
