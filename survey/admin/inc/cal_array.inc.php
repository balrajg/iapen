<?php

/*---------------------------------------------
  MAIAN SURVEY v1.1
  Written by David Ian Bennett
  E-Mail: N/A
  Website: www.maiansurvey.com
----------------------------------------------*/

$years = array();
$days  = array();

for ($i=1; $i<32; $i++) {
  $days[] = (strlen($i)<2 ? '0'.$i : $i);
}
              
$months = array(
 '01' => $msg_calendar,
 '02' => $msg_calendar2,
 '03' => $msg_calendar3,
 '04' => $msg_calendar4,
 '05' => $msg_calendar5,
 '06' => $msg_calendar6,
 '07' => $msg_calendar7,
 '08' => $msg_calendar8,
 '09' => $msg_calendar9,
 '10' => $msg_calendar10,
 '11' => $msg_calendar11,
 '12' => $msg_calendar12
);
                
for ($i=date("Y"); $i<date("Y")+5; $i++) {
  $years[] = $i;
}
               
?>
