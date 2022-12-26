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


<body link=#336699 vlink=#336699 alink=#336699>
<?php include("header.php"); ?>

<center>
<div class="content-container">
   

<!-- ############################################################################################### --> 
     
<center><h1>Password Recovery Form</h1></center>


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
            echo "Sorry ! No account with the specified username or email exists";
            showForm();
        }
        else {
            $r = mysql_fetch_array($result_set);
            $email1 = $r['email'];
            $username = $r['username'];
            $password = $r['password'];
            $userpass = $r['userpass'];            

            $to = $email1;
            $subject = "$webtitle - Password Recovery";
            $body = "Hello $username, \n\nYou requested for your $webtitle account password recovery.\nYour registration information is shown below:\n\nUser: $username\nPass: $password\nUser Pass: $userpass \n\nThanks!\n{$website}";                 
            $headers = "From: $webtitle <{$website}>";                 
             
            
            if (mail ($to, $subject, $body, $headers)) 
               echo "An email has been sent with your password to the email address you specified during registration.";
            else 
            {  echo "Sorry ! The password recovery email could not be sent due to some reason."; showForm(); }
            
        }
   }
   else
   {  echo "Please give a username or email atleast !"; showForm(); }
}
else
{
 if ($session == false)
    showForm();
 else
   echo "Sorry ! You are already logged in.";
}

?>
</LABEL>




<? function showForm() { ?>


<form method="POST" action="forgot.php">

<table>
<tr>
  <td><LABEL id="title">Username: </LABEL></td> <td> <input type="text" maxlength=30 size=30 name="username"> </td>
</tr>
<tr>
  <td>&nbsp;</td><td><b><LABEL id="text">OR</LABEL></b></td>
</tr>
<tr>
  <td><LABEL id="title">Email: </LABEL></td> <td> <input type="text" maxlength=30 size=30 name="email"> </td>
</tr>
<tr>
  <td>&nbsp;</td> <td><br><input type="submit" value="Recover" name='forgot'></td>
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