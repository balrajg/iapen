<?php

/*---------------------------------------------
  MAIAN SURVEY v1.1
  Written by David Ian Bennett
  E-Mail: N/A
  Website: www.maiansurvey.com
----------------------------------------------*/

// Is webmaster logged in..
function isSessionActive($login=false) {
  global $database;
  if ($login) {
    if (isset($_SESSION['wpp_session']) || isset($_COOKIE[COOKIE_NAME])) {
      if (isset($_COOKIE[COOKIE_NAME])) {
        if ($_COOKIE[COOKIE_NAME]!=md5(SECRET_KEY)) {
          header("Location: index.php?cmd=login");
          exit;
        }
      }
      header("Location: index.php");
      exit;
    }
  } else {
    if (!isset($_SESSION['wpp_session']) && !isset($_COOKIE[COOKIE_NAME])) {
      header("Location: index.php?cmd=login");
      exit;
    }
  }
}

// Get last question..
function getLastQuestion($id) {
  global $database;
  $id    = (int)$id;
  $query = mysql_query("SELECT que_id FROM ".DB_PREFIX."questions WHERE que_sur_id = '$id' ORDER BY que_id DESC LIMIT 1") or die(db_MSG(__FILE__,__LINE__));
  $row   = mysql_fetch_object($query);
  return $row->que_id;
}

// Get data based on query..
function rowData($table,$query='') {
  global $database;
  $query = mysql_query("SELECT * FROM ".DB_PREFIX.$table.$query."") or die(db_MSG(__FILE__,__LINE__));
  return mysql_fetch_object($query);
}

// Table count..
function rowCount($table,$query='',$row='count(*) AS r_count',$num=false) {
  global $database;
  $count = mysql_query("SELECT ".$row." FROM ".DB_PREFIX.$table.$query."") or die(db_MSG(__FILE__,__LINE__));
  if ($num) {
    return mysql_num_rows($count);
  } else {
    $COUNT = mysql_fetch_object($count);
    return $COUNT->r_count;
  }
}

// Page numbers..
function page_numbers($count,$limit,$page,$stringVar='page',$show=15) {
  global $msg_script7,$msg_script8;
  $PaginateIt = new PaginateIt();
  $PaginateIt->SetCurrentPage($page);
  $PaginateIt->SetItemCount($count);
  $PaginateIt->SetItemsPerPage($limit);
  $PaginateIt->SetLinksToDisplay($show);
  $PaginateIt->SetQueryStringVar($stringVar);
  $PaginateIt->SetLinksFormat('&laquo; '.$msg_script7,
               ' &bull; ',
               $msg_script8.' &raquo;'
               );
  return '<div id="pages">'.$PaginateIt->GetPageLinks().'</div>';
}

// Return overlib tooltip
function toolTip($msg,$msg2,$text=false,$align='CENTER',$width='400') {
  return ($text ? '(' : '').'<a href="javascript:void(0);" onclick="return overlib(\''.htmlspecialchars($msg2).'\', STICKY, CAPTION, \''.htmlspecialchars($msg).'\', '.$align.',ol_width=\''.$width.'\');" onmouseout="nd();">'.($text ? $text : '<img style="border:0;vertical-align:middle" src="templates/img/help.gif" alt="" title="" />').'</a>'.($text ? ')' : '');
}

?>
