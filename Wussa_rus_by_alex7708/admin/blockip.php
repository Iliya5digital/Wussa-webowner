<?php

session_start();
include("loadsettings.inc.php");
include("checkpass.inc.php");

?>

<html>

<body link=brown vlink=brown>


<br>
<font face="arial" color="brown"><u><h2><center>
.:: Блокирование IP ::.
</center></h2></u></font>


<br>


<font color=brown face=verdana size=2>
<br>


<?php 

if (isset($_GET["delete"])) {

 if ($_GET["delete"] == "") die();
 $id = $_GET["delete"];
 
 mysql_query("DELETE FROM `blockedip` WHERE id = '$id'");
 echo "<b>IP адрес удалён из списка</b>";
}



if (isset($_POST["blockip"])) {

  if ($_POST["ip"] == "") die();
  $ip = $_POST["ip"];

  mysql_query("INSERT INTO `blockedip` (ip) VALUES ('$ip')");
  echo "<b>IP адрес добавлен в список забаненных</b>";
}
  





echo "<form method='POST' action='blockip.php'>
      Блокировать IP: &nbsp; <input type='text' maxlength='20' name='ip'> &nbsp; &nbsp;
      <input type='submit' name='blockip' value='Заблокировать'></form><br><br>";



$result = mysql_query("SELECT * FROM `blockedip`");
$number = mysql_num_rows($result);


if ($number) {
   
   echo "<h4>Заблокированные IP: </h4>";
   echo "<ul>";
   
   while (($r = mysql_fetch_array($result))) {
     $id = $r['id'];
     $ip = $r['ip'];
    
      echo "<li> $ip &nbsp; &nbsp; <a href='blockip.php?delete=$id'>Удалить</a>"; 
   }   
   echo "</ul>";
}
else
   echo "<b>Ни одного заблокированного IP нет!</b>";


?>  
 



</font>
</body>
</html>



