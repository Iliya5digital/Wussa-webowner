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

<title><? echo $webtitle; ?> - Хостинг изображений</title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>

<body>

<?php

if (isset($_GET["id"])) {

 $id = trim($_GET['id']);
 if ($id == "") die();
 if ($session == false) die();

 //CONNECT 
 $link = mysql_connect($server, $user, $pass);
 if(!mysql_select_db($database)) die(mysql_error());
 

 //GET THE IMAGEID FOR WHICH THE COMMENT IS.
 $result = mysql_query("SELECT imageid FROM `comments` WHERE id = '$id'");
 $number = mysql_num_rows($result);
 
 if ($number) {
     $row = mysql_fetch_row($result);
     $imageid = $row[0];
 }
 else die();


 //CHECK IF THAT IMAGE IS OWNED BY THIS MEMBER OR NOT
 $result = mysql_query("SELECT userid FROM `images` WHERE id = '$imageid'");
 $number = mysql_num_rows($result);
 
 if ($number) {
     $row = mysql_fetch_row($result);
     $userid1 = $row[0];
     if ($userid1 == -1) die();
     if ($userid != $userid1) die();
 }
 else die();

 $path = "show-image.php?id=" . $imageid;
  
 //THEN FINALLY DELETE THE COMMENT. 
 mysql_query("DELETE FROM `comments` WHERE id = '$id'");

 //GO BACK
 echo "<meta http-equiv=\"refresh\" content=\"0; url='$path'\" />";

} 

?>


</body>
</html>
