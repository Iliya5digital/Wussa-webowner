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

 $imageid = trim($_GET['id']);
 if ($imageid == "") die();
 if ($session == false) die();
 
 $path = "show-image.php?id=" . $imageid;
 $link = mysql_connect($server, $user, $pass);
 if(!mysql_select_db($database)) die(mysql_error());
 
 $result = mysql_query("SELECT id FROM `favourites` WHERE (imageid = '$imageid') AND (userid = '$userid')");
 $number = mysql_num_rows($result);
  
 if (!$number) {
     mysql_query("INSERT INTO `favourites` (imageid, userid) VALUES('$imageid', '$userid')");
 } 

 echo "<script language=\"JavaScript\">
       alert('Изображение добавлено в избранные!');
       window.location.href='$path';
       </script>";
} 

?>


</body>
</html>
