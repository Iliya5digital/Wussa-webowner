<?php
 
  //#####################################################################################

  //This script displays the thumbnail. 

  //#####################################################################################
   
 
  $str = file_get_contents("db-info.php");

  $str = str_replace("<?", "", $str);
  $str = str_replace("?>", "", $str);

  eval($str); 

  //********************************************************


    if ((isset($_GET["id"])) && (trim($_GET["id"]) != ""))
       $id = $_GET["id"];
    else
       showUnknown();


    $link = mysql_connect($server, $user, $pass);
    if(!mysql_select_db($database)) die(mysql_error());
         
    $q = "SELECT thumb FROM `images` WHERE id = '$id'";
    if(!($result_set = mysql_query($q))) die(mysql_error());
    $number = mysql_num_rows($result_set);
      

    if ($number)
    {
      $row = mysql_fetch_row($result_set);
      header("Content-type: image/jpeg");  
      readFile($row[0]);
    }
    else
      showUnknown();

   
   function showUnknown() {
      header("Content-type: image/gif");  
      readFile("error.gif");
   }


?>




