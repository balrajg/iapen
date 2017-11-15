<?php

/*---------------------------------------------
  MAIAN SURVEY v1.1
  Written by David Ian Bennett
  E-Mail: N/A
  Website: www.maiansurvey.com
----------------------------------------------*/

include(PATH.'classes/class.phpmailer.php');

class mailClass {

var $vars = array();
var $smtp_host;
var $smtp_port;
var $smtp_user;
var $smtp_pass;
var $smtp;
var $html = false; // Set to true to use HTML in e-mail templates

function cleanData($data) {
  return (get_magic_quotes_gpc() ? stripslashes($data) : $data);
}

function convertChar($data) {
  $find    = array('&#039;','&quot;','&amp;','&lt;','&gt;');
  $replace = array('\'','"','&','<','>');

  return str_replace($find,$replace,$data);
}

function addTag($placeholder,$data) {
  $this->vars[$placeholder] = $data;
}

function clearVars() {
  $this->vars = array();
}

function convertTags($data) {
  if (!empty($this->vars)) {
    foreach ($this->vars AS $tags => $value) {
      $data = str_replace($tags,$value,$data);
    }
  }

  return trim($data);
}

function mailHeaders($name,$email) {
  global $mail_charset;
  if ($this->html) {
    $headers  = "Content-type: text/html; charset=".$mail_charset."\r\n";
    $headers .= "From: \"".$this->injectionCleaner($name)."\" <".$email.">\n";
  } else {
    $headers  = "Content-type: text/plain; charset=".$mail_charset."\r\n";
	$headers .= "From: \"".$this->injectionCleaner($name)."\" <".$email.">\n";
  }
  $headers .= "X-Sender: \"".$this->injectionCleaner($name)."\" <".$email.">\n";
  $headers .= "X-Mailer: PHP\n";
  $headers .= "X-Priority: 3\n";
  $headers .= "X-Sender-IP: ".$_SERVER['REMOTE_ADDR']."\n";
  $headers .= "Return-Path: \"".$this->injectionCleaner($name)."\" <".$email.">\n";
  $headers .= "Reply-To: \"".$this->injectionCleaner($name)."\" <".$email.">\n";

  return $headers;
}

function injectionCleaner($data) {
  $find     = array(
   "\r",
   "\n",
   "%0a",
   "%0d",
   "content-type:",
   "Content-Type:",
   "BCC:",
   "CC:",
   "TO:",
   "bcc:",
   "to:",
   "cc:"
   );

  $replace  = array();

  return str_replace($find,$replace,$data);
}

function template($file) {
  if (!function_exists('file_get_contents')) {
    echo '<b>Error!! PHPv4.3 or higher is required for processing to function correctly!</b><br><br>';
    echo 'Your version is: v'.phpversion();
    exit;
  }

  $email_string = file_get_contents($file);

  if ($email_string) {
    return $this->convertTags(trim($email_string));
  } else {
    die("An error occured opening the <b>'$file'</b> file. Check that this file exists in the 'templates/email/' folder!");
  }
}

function sendMail($addresses,$from_name,$from_email,$subject,$msg,$email=true) {
  if ($email) {
    if ($this->smtp) {
      $MAILER = new PHPMailer();
      
      $MAILER->IsSMTP();
      $MAILER->IsHTML($this->html);
      $MAILER->Port         = $this->smtp_port;
      $MAILER->Host         = $this->smtp_host;
      $MAILER->SMTPAuth     = ($this->smtp_user && $this->smtp_pass ? true : false);
      $MAILER->Username     = $this->smtp_user;
      $MAILER->Password     = $this->smtp_pass;
      $MAILER->From         = $from_email;
      $MAILER->FromName     = $this->convertChar($this->cleanData($this->injectionCleaner($from_name)));
      if (is_array($addresses)) {
        foreach ($addresses AS $to_email) {
          $MAILER->AddAddress($to_email, $this->convertChar($this->cleanData($this->injectionCleaner($to_email))));
        }
      } else {
        $MAILER->AddAddress($addresses, $this->convertChar($this->cleanData($this->injectionCleaner($addresses))));
      }
      $MAILER->WordWrap     = 1000;
      $MAILER->CharSet      = 'utf-8';
      $MAILER->ContentType  = (SET_HTML ? 'text/html' : 'text/plain');
      $MAILER->Subject      = $this->convertChar($this->cleanData($subject));
      $MAILER->Body         = $this->convertChar($this->cleanData($msg));
      $MAILER->Send();
    } else {
      mail((is_array($addresses) ? implode(',',$addresses) : $addresses), 
           $this->convertChar($this->cleanData($subject)), 
           $this->convertChar($this->cleanData($msg)), 
           $this->mailHeaders($this->cleanData($this->convertChar($from_name)),$from_email)
           );
    }
  }
}

}

?>
