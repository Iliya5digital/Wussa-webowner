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

</head>

<body>

<?php

if (isset($_GET["id"])) {

 $imageid = trim($_GET['id']);
 if ($imageid == "") die();
  
 $path = "show-image.php?id=" . $imageid;
 $link = mysql_connect($server, $user, $pass);
 if(!mysql_select_db($database)) die(mysql_error());
 
 $result = mysql_query("SELECT id FROM `report` WHERE imageid = '$imageid'");
 $number = mysql_num_rows($result); 
  
 if (!$number) {
     mysql_query("INSERT INTO `report` (imageid) VALUES('$imageid')");
 } 

 echo "<script language=\"JavaScript\">
       alert('Thanks for reporting the image.. We will soon review it !');
       window.location.href='$path';
       </script>";
} 

?>


</body>
</html>
