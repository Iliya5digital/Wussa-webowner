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

<title><? echo $webtitle; ?> - ������� �����������</title>
<link rel="stylesheet" href="style.css" type="text/css" />

<meta name="description" content="<? echo $description; ?>" />
<meta name="keywords" content="<? echo $keywords; ?>" />

</head>


<body link=#336699 vlink=#336699 alink=#336699>
<?php include("header.php"); ?>

<center>
<div class="content-container">
   

<!-- ############################################################################################### --> 
     
<center><h1>�������������� ������</h1></center>


<LABEL id="message">  
<?php

if (isset($_POST["forgot"]))  {
   $username = htmlspecialchars(trim($_POST["username"]));
   $email = htmlspecialchars(trim($_POST["email"]));
   
   if (($username != "") || ($email != ""))
   {
        if ($username != "")
             $q = "SELECT * FROM `members` WHERE username = '$username'";
        else
             $q = "SELECT * FROM `members` WHERE email = '$email'";
             

        if(!($result_set = mysql_query($q))) die(mysql_error());
        $number = mysql_num_rows($result_set);

        if (!$number) {
            echo "�������� � ����� ������� ��� e-mail �� ����������!";
            showForm();
        }
        else {
            $r = mysql_fetch_array($result_set);
            $email1 = $r['email'];
            $username = $r['username'];
            $password = $r['password'];
            $userpass = $r['userpass'];            

            $to = $email1;
            $subject = "$webtitle - �������������� ������";
            $body = "������ $username, \n\ned for your $webtitle account password recovery.\nYour registration information is shown below:\n\nUser: $username\nPass: $password\nUser Pass: $userpass \n\nThanks!\n{$website}";                 
            $headers = "From: $webtitle <{$website}>";                 
             
            
            if (mail ($to, $subject, $body, $headers)) 
               echo "������ � ����������� � ������ ���� ����������!";
            else 
            {  echo "������ �� ����� ���� ����������!"; showForm(); }
            
        }
   }
   else
   {  echo "������� ����� ��� e-mail!"; showForm(); }
}
else
{
 if ($session == false)
    showForm();
 else
   echo "�� ��� �����!";
}

?>
</LABEL>




<? function showForm() { ?>


<form method="POST" action="forgot.php">

<table>
<tr>
  <td><LABEL id="title">�����: </LABEL></td> <td> <input type="text" maxlength=30 size=30 name="username"> </td>
</tr>
<tr>
  <td>&nbsp;</td><td><b><LABEL id="text">���</LABEL></b></td>
</tr>
<tr>
  <td><LABEL id="title">Email: </LABEL></td> <td> <input type="text" maxlength=30 size=30 name="email"> </td>
</tr>
<tr>
  <td>&nbsp;</td> <td><br><input type="submit" value="������������" name='forgot'></td>
</tr>
</table>

</form>

<? } ?>


        
<!-- ############################################################################################### -->
 



<?php  include("footer.php"); ?>


</div>
</center>
</body>
</html>