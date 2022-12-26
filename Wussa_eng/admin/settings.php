<?php

session_start();
include("loadsettings.inc.php");
include("checkpass.inc.php");

?>

<html>

<body link=brown vlink=brown>


<br>
<font face="arial" color="brown"><u><h2><center>
.:: Settings ::.
</center></h2></u></font>


<br>


<font color=brown face=verdana size=2>
<br>


<?php 

if (isset($_POST["savesettings"])) {

  $password = htmlspecialchars(trim($_POST["password"]));
  $website =  htmlspecialchars(trim($_POST["website"]));
  $title =  htmlspecialchars(trim($_POST["title"]));
  $description =  htmlspecialchars(trim($_POST["description"]));
  $keywords =  htmlspecialchars(trim($_POST["keywords"]));

  $maxsizeguest = trim($_POST["maxsizeguest"]);
  $maxsizemember = trim($_POST["maxsizemember"]);

  $watermark = $_POST["watermark"];

  //Remove the end slash if found
  if (substr($website, strlen($website) - 1) == "/")
     $website = substr($website,0, strlen($website) - 1);
  

  if (($password != "") AND ($website != "") AND ($title != "") AND ($description != "") AND ($keywords != "") AND 
       ($maxsizeguest != "") AND ($maxsizemember != "")) {        
              
     if ((is_numeric($maxsizeguest)) AND (is_numeric($maxsizemember))) {
     
         mysql_query("UPDATE `settings` SET password='$password',
                                            website='$website', 
                                            title='$title', 
                                            description='$description',
                                            keywords='$keywords',
                                            maxsizeguest='$maxsizeguest',
                                            maxsizemember='$maxsizemember',
                                            watermark='$watermark'");

        $_SESSION["imagehost-admin"] = $password; 
        echo "<b><h4>Settings saved !</h4></b>";
    }
    else 
        echo "<h4>Please enter numeric values in 'Max Image Size' fields.</h4>";
  }
  else
    echo "<h4>Please fill in all the fields first</h4>";


  echo "<br><br>";

}


?>  
 


<form method="POST" action="settings.php">

<table style="FONT-SIZE: 12px; COLOR: brown;">

<tr> <td>Admin Password: </td> <td> <input type="text" size="30" name="password" maxlength="20" value="<? echo $password; ?>"> </td></tr>
<tr> <td>URL of script: </td> <td> <input type="text" size="30" name="website" maxlength="250" value="<? echo $website; ?>"> </td></tr>
<tr> <td>Site Name: </td> <td> <input type="text" name="title" size="30" maxlength="250" value="<? echo $webtitle; ?>"> </td></tr>
<tr> <td>Meta Description: </td> <td> <input type="text" name="description" size="30" maxlength="250" value="<? echo $description; ?>"> </td></tr>
<tr> <td>Meta Keywords: </td> <td> <input type="text" size="30" name="keywords" maxlength="250" value="<? echo $keywords; ?>"> </td></tr>

<tr> <td>Max Image Size [guest]: </td> <td> <input type="text" name="maxsizeguest" size="30" maxlength="1" value="<? echo $maxsizeguest; ?>"> </td></tr>
<tr> <td>Max Image Size [member]: </td> <td> <input type="text" name="maxsizemember" size="30" maxlength="1" value="<? echo $maxsizemember; ?>"> </td></tr>

<tr> <td>Enable Watermark: </td> <td> <input type='radio' name='watermark' value='true' checked> Yes &nbsp; &nbsp;
                                      <input type='radio' name='watermark' value='false'> No   </td>
                                  <td><b>Note: Watermark do not affect private images. </b></tr>

<tr> <td> </td> <td> <input type="submit" value="Save Settings" name="savesettings"> </td></tr>

</table>
</form>


</font>


</body>
</html>


