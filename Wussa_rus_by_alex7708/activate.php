<?php

//#####################################################################################
 
//This script activates the warned user account. 

//#####################################################################################


echo "<font size=2 color=purple face=verdana>";

if (!isset($_GET["id"])) die("�� �� ������ ���� ������������!");
$id = trim($_GET["id"]);
if ($id == "") die("�� �� ������ ���� ������������!");


include("db-info.php");
$link = mysql_connect($server, $user, $pass);
if(!mysql_select_db($database)) die(mysql_error());

$r = mysql_query("SELECT * FROM `warned-accounts` WHERE id = '$id'");
$n = mysql_num_rows($r);
if (!$n) die("�������� ID!");

$row = mysql_fetch_array($r);
$date = date("y-m-d");
$userid = $row['userid'];


mysql_query("DELETE FROM `warned-accounts` WHERE id = '$id'");
mysql_query("UPDATE `members` SET access = '$date' WHERE id = '$userid'");

echo "������� �����������!<br>
      <a href='login.php'>������� �����</a> ����� �����";

echo "</b></font>";

?>

