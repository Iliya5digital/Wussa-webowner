<?php

session_start();
include("loadsettings.inc.php");
include("checkpass.inc.php");

?>



<html>

<body link=brown vlink=brown>


<br>
<font face=arial color="brown"><u><h2><center>
.:: Manage Inactive Accounts / Images ::.
</center></h2></u></font>


<br>

<?php

echo "<font color=red face=verdana size=2>";

if (isset($_GET['act']))
{
   if (trim($_GET['act'] ) == "") die();
   $act = $_GET['act'];
   
   if ($act == "sendwarnings") {
      
       $r = mysql_query("SELECT * FROM `members` WHERE access <= DATE_SUB(CURDATE(),INTERVAL 1 YEAR)");     
       $n = mysql_num_rows($r);
       if (!$n) die();
       
       while ($row = mysql_fetch_array($r)) { 
           $username = $row['username'];
           $id = md5(time() . $username);
           $userid = $row['id'];          
           $date = date("y-m-d");
           
           mysql_query("INSERT INTO `warned-accounts` VALUES('$id', '$userid', '$date')");
           
           $to = $row['email'];
           $subject = "Activate your $webtitle account!";
           $body = "Hello $username, \n\nYour $webtitle account remained inactive for 1 year.\nYou can activate it by going to http://{$website}/activate.php?id=$id \nIf you didn't activate it within 1 week, your account will be deleted permanently along with all your private and public galleries and images. \n\nThanks!\n{$website}";                 
           $headers = "From: $webtitle <{$website}>";                 

           mail ($to, $subject, $body, $headers); 
       }
       echo "Warning emails sent !";
   }
   
   //$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
 
   if ($act == "deleteaccounts") {
      
       $r = mysql_query("SELECT id, userid FROM `warned-accounts` WHERE date <= DATE_SUB(CURDATE(), INTERVAL 7 DAY)");
       $n = mysql_num_rows($r);
       if (!$n) die();

       while ($row = mysql_fetch_array($r) ) {
           $id = $row['userid'];
           
           //DELETE ALL THE MEMBER SINGLE IMAGES
           mysql_query("DELETE FROM `images` WHERE userid = '$id'");
  
           $result = mysql_query("SELECT id, name FROM `galleries` WHERE userid = '$id'");
           $number = mysql_num_rows($result);

           if ($number) {

               //THEN RETRIEVE GALLERIES OF THE MEMBER ONE BY ONE
              while ($row = mysql_fetch_array($result)) {
                   $galleryid = $row['id'];
                   $name = $row['name'];        
 
                   //DELETE ALL THE IMAGES ASSOCIATED WITH THE GALLERY.
                   mysql_query("DELETE FROM `images` WHERE galleryid = '$galleryid'");

                   //THEN FINALLY DELETE THE GALLERY ALSO.
                   mysql_query("DELETE FROM `galleries` WHERE id = '$galleryid'");
              }
           }   

  
           //DELETE THE MEMBER ALSO !
           mysql_query("DELETE FROM `members` WHERE id = '$id'");

           //AND ATLAST DELETE THE REFERENCE FROM THE WARNED-ACCOUNTS TABLE
           mysql_query("DELETE FROM `warned-accounts` WHERE id = '{$row['id']}'");
      }
      
      echo "Inactive warned accounts deleted successfully !";   
  }
   //$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$


  if ($act == "deleteimages") {  
      $q = "DELETE FROM `images` WHERE access <= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)";
      if(!mysql_query($q)) die(mysql_error());

      echo "Inactive images deleted successfully !";

  }

}

//****************************************************************************************************

?>

<font face=verdana size=2 color=purple>


<br><br>
<font color=brown size=3><b>Inactive Images</font>
<hr color=brown><br>


<?php
//**************************************************************************************

$total = 0;

$q = "SELECT id FROM `images` WHERE access <= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)";
if(!($result_set = mysql_query($q))) die(mysql_error());
$number = mysql_num_rows($result_set);
$total = $number;


if ($total) {
  echo "There are '$total' inactive images.";
  echo "&nbsp; || <a href='inactive.php?act=deleteimages'>Delete inactive images</a>"; 
}
else
  echo "There are no inactive images.";




//***************************************************************************

?>


<br><br><br><br>
<font color=brown size=3><b>Inactive Accounts</font>
<hr color=brown><br>


<?php

//****************************************************************************


$r = mysql_query("SELECT * FROM `members` WHERE access <= DATE_SUB(CURDATE(),INTERVAL 1 YEAR)");
$n = mysql_num_rows($r); 

$unwarned = 0;   
 
if ($n) {
  while ($row = mysql_fetch_array($r)) {
     $id = $row['id'];
     $result = mysql_query("SELECT * FROM `warned-accounts` WHERE userid = '$id'");
     $number = mysql_num_rows($result);
     if (!$number) $unwarned++; 
  } 
}


if ($unwarned) {    
  echo "1. There are '$unwarned' inactive accounts.";
  echo "&nbsp; || <a href='inactive.php?act=sendwarnings'>Send warning emails to them</a>"; 
}
else
  echo "1. There are no inactive accounts.";





$r1 = mysql_query("SELECT * FROM `warned-accounts` WHERE date <= DATE_SUB(CURDATE(), INTERVAL 7 DAY)");
$n1 = mysql_num_rows($r1);
 
if ($n1) {
  echo "<br><br>2. There are '$n1' still inactive warned accounts.";
  echo "&nbsp; || <a href='inactive.php?act=deleteaccounts'>Delete warned accounts</a>";
}
else
  echo "<br><br>2. There are no still inactive warned accounts.";


?>


</font>

</body>
</html>


