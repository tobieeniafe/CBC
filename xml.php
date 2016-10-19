

<!-- =========== SCRIPT TO CONVERT DATA FROM DATA BASE TO XML FORMAT ================
 -->


<?php  
include_once 'dbconnect.php';

$root_element = 'monthly'; 

$sql = "SELECT * FROM events_meetings";

$result = mysqli_query($conn,$sql);
if (!$result) {
    die('Invalid query: ' . mysqli_error($conn));
}

if(mysqli_num_rows($result)>0)
{
   
   $xml = "<$root_element>";
   

      while($row = mysqli_fetch_array($result , MYSQLI_ASSOC))
      {
            $xml .= "<event>";
            $xml .= "<id>{$row['id']}</id>";
            $xml .= "<name>{$row['event_title']}</name>";
            $xml .= "<startdate>{$row['date_from']}</startdate>";
            $xml .= "<enddate>{$row['date_to']}</enddate>";
            $xml .= "<starttime>{$row['start_time']}</starttime>";
            $xml .= "<endtime>{$row['finish_time']}</endtime>";
            $xml .= "<color>{$row['color']}</color>";
            $xml .= "<url></url>";
            $xml .= "</event>";

      }

   $xml .= "</$root_element>";

}
else{
   die("No result found in table");
}

 
//output
//echo $xml;
 
   // clean tags
   $xml =str_replace('<![CDATA[','',$xml);
   $xml = str_replace(']]>','',$xml);
   // store in a file
   $file = fopen('events.xml','w');
   fwrite($file, $xml);
   fclose($file); 




// function to add cdata tags
function cdata($x){ return "<![CDATA[".$x."]]>";}

?>

