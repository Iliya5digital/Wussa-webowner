<?php
 session_start();
 
 include("db-info.php");
 $link = mysql_connect($server, $user, $pass);
 if(!mysql_select_db($database)) die(mysql_error());

 include("session.inc.php");
 include("loadsettings.inc.php");
?>



<html>

<head>

<title><? echo $webtitle; ?> - Free Image Hosting</title>
<link rel="stylesheet" href="style.css" type="text/css" />

<meta name="description" content="<? echo $description; ?>" />
<meta name="keywords" content="<? echo $keywords; ?>" />

</head>


<body link="#336699" vlink="#336699" alink="#336699">
<?php include("header.php"); ?>

<center>
<div class="content-container">
<br>

<!-- ######################################################################################### -->

         
<?php

if ($session == true)
{ 
         
   //*********************************************************************************************************
    
   if (isset($_GET["act"])) {
      $act = $_GET["act"];
       
 
       if ($act == "logout") {
          session_destroy();      
          echo "You are signed out completely.";
          echo "<br /><br /><a href='index.php'>Click here</a> to goto the main page";
          echo "<meta http-equiv=\"refresh\" content=\"2; url='index.php'\" />"; 
       } 
       
       
   //***********************************************************************************************************
   }
   else {

      echo "<center><h1>Members Area</h1></center>";
      echo "<font color=#233c9b size=3><center><b>";    
           

      if (isset($_POST["newpass"])) {
          $oldpass = trim($_POST["oldpass"]);
          $newpass = trim($_POST["newpass"]);
          $userpass = trim($_POST["userpass"]);
          
          echo "<br />"; 
          if (($oldpass != "") and ($newpass != "") and ($userpass != "")) {
              if (strlen($newpass) > 5) {
                  $r = mysql_query("SELECT * FROM `members` WHERE (id = '$userid') AND (password = '$oldpass')");
                  $n = mysql_num_rows($r);
                   
                  if ($n) {
                     if (mysql_query("UPDATE `members` SET password = '$newpass', userpass = '$userpass' WHERE id = '$userid'"))
                     {
                         echo "Your password was changed successfully !";
                         $_SESSION["imagehost-pass"] = $newpass;
                     } 
                     else
                        echo "Sorry ! The password could not be changed due to some reason.";                  
 
                  }
                  else
                     echo "Sorry ! Your old password is wrong.";
              }
              else
                  echo "Sorry ! Your new password is smaller than 6 characters.";
          }
          else
              echo "Please fill in all the fields first !";
      }      
 

      echo "</font></center></b>";
     
      echo "<br /><center><a href='#' 
               onclick=\"getElementById('privatepass').style.display='block';\">
               <img src='images/view_private.png' border=0></a><br>";

      echo "<div class='PrivatePassBox' id='privatepass'>
               <img src='images/help.gif' border=0> &nbsp; 
               Your password to view private images is \"$userpass\"<br><br>
               <a href='#' onclick=\"getElementById('privatepass').style.display='none'\">Hide Window</a>
            </div>";


      echo "<br><br><table align=center style=\"BORDER: #b1ddf6 2px solid; BACKGROUND: #edf7fd\" width=400>
            <tr align=center>
              <td width=100><a href='myimages.php'><img src='images\images.jpg'></a></td>
              
              <td>  
               <table width=250><tr>
                  <td valign=top style=\"BORDER-BOTTOM: #42679c 1px dashed; PADDING-BOTTOM: 5px\">
                     <a href='myimages.php'>My Images</a>
                  </td>
               </tr><tr height=50>
                  <td><LABEL id='text'>Manage your public and private images</LABEL></td>
               </tr></table>
            
              </td>
            </tr> 
            </table>";
      
          
      echo "<br><br><table align=center style=\"BORDER: #b1ddf6 2px solid; BACKGROUND: #edf7fd\" width=400>
            <tr align=center>
              <td width=100><a href='mygalleries.php'><img src='images\gallery.jpg'></a></td>
              
              <td>  
               <table width=250><tr>
                  <td valign=top style=\"BORDER-BOTTOM: #42679c 1px dashed; PADDING-BOTTOM: 5px\">
                     <a href='mygalleries.php'>My galleries</a>
                  </td>
               </tr><tr height=50>
                  <td><LABEL id='text'>Create, edit and delete public and private galleries</LABEL></td>
               </tr></table>
            
              </td>
            </tr> 
            </table>";
  
      

      echo "<br><br><table align=center style=\"BORDER: #b1ddf6 2px solid; BACKGROUND: #edf7fd\" width=400>
            <tr align=center>
              <td width=100><a href='myfavourites.php'><img src='images\myfavourites.png'></a></td>
              
              <td>  
               <table width=250><tr>
                  <td valign=top style=\"BORDER-BOTTOM: #42679c 1px dashed; PADDING-BOTTOM: 5px\">
                     <a href='myfavourites.php'>My Favourite Images</a>
                  </td>
               </tr><tr height=50>
                  <td><LABEL id='text'>View and manage your favourite images.</LABEL></td>
               </tr></table>
            
              </td>
            </tr> 
            </table>";


      echo "<br><br><a href='index.php'><img src='images/upload.png' border=0></a></center>";

      echo "<br><br><hr color=#b1ddf6><br><table align=center><tr><td height=30 valign=top><h2>Change Password:</h2></td></tr>";
      echo "<tr><td><form method=POST action='account.php' name='myForm'><font size=2>Old Password:</td>
            <td><input type=password name='oldpass' size=28></td></tr>
            <tr><td><font size=2>New Password:</td><td><input type=password name='newpass' size=28></td></tr>
            <tr><td><font size=2>User Password:</td><td><input type=password name='userpass' size=28></td></tr>
            <tr><td>&nbsp;</td><td>&nbsp;<a href=#><img src='images/save_changes.png' border=0 onclick='myForm.submit();'></a>
            </td></tr>
            <tr><td>&nbsp; &nbsp; &nbsp;</td></tr></form></table>";

   } 


}
else
  echo "You must sign-in first in order to view your account.<br><a href=\"login.php\">Click here</a> to login.";


?>

       
<!-- ######################################################################################### -->          
   
 

<?php  include("footer.php"); ?>


</div>
</center>
</body>
</html>