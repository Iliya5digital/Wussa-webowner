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

<title><? echo $webtitle; ?> - �����</title>
<link rel="stylesheet" href="style.css" type="text/css" />

<meta name="description" content="<? echo $description; ?>" />
<meta name="keywords" content="<? echo $keywords; ?>" />

</head>


<body link=#336699 vlink=#336699 alink=#336699>
<?php include("header.php"); ?>

<center>
<div class="content-container">

<center><h1></h1></center>
<br>
   
    
<?php

if (isset($_POST["username"]))  {

   $username = htmlspecialchars(trim($_POST["username"]));
   $password = htmlspecialchars(trim($_POST["password"]));
   
   echo "<br />";    
   if (($username != "") && ($password != ""))
   {
        $q = "SELECT username FROM `members` WHERE (username = '$username') and (password = '$password')";
        if(!($result_set = mysql_query($q))) die(mysql_error());
        $number = mysql_num_rows($result_set);
 
        if (!$number) {
            echo "������ ������������ �� ����������,���� ������ �� ����������."; 
            showForm();
        } 
        else {
            $date = date("y-m-d");
            mysql_query("UPDATE `members` SET access = '$date' WHERE username = '$username'"); 
            $_SESSION["imagehost-user"] = $username;
            $_SESSION["imagehost-pass"] = $password;
            echo "<b>�� �����.</b> <br><br>�� ����� ������ ���������� � ���� ������ ����������.
                  <br> 
                 <a href=\"account.php\">������� �����</a> ��� ����� � ������ ����������.";
            echo "<meta http-equiv=\"refresh\" content=\"3; url='account.php'\" />";
        }
   }
   else
     { echo "���� �� ���������!"; showForm(); }
}
else
{
  if ($session == false)
    showForm();
  else
    echo "�� ��� �����!";
}


?>




<? function showForm() { ?>


<form method="POST" action="login.php" name="myForm">

<table>
<tr>
  <td><LABEL id="title">�����: </td> <td> <input type="text" maxlength=30 size=30 name="username"> </td>
</tr>
<tr>
  <td><LABEL id="title">������: </td> <td> <input type="password" maxlength=30 size=30 name="password"> </td>
</tr>
<tr>
  <td>&nbsp;</td> <td><br> <a href=#><img src="images/login.png" border=0 onclick="myForm.submit();"></a> </td>
</tr>
</table>

</form>
<br><br>

<LABEL id="text">
<b>������ ������?</b> <a href="forgot.php">������� �����</a>
<br><br>
</LABEL>

<? } ?>



<?php  include("footer.php"); ?>


</div>
</center>


</body>


</html>