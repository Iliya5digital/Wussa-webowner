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
</head>

<body>

<?php

if (isset($_POST["emailImage"])) {
 $to = trim($_POST["email"]);
 $id = $_POST['id'];

 $path = "{$website}/show-image.php?id=$id"; 

 if ($to == "") 
    echo "<script language=\"JavaScript\">alert('������� e-mail!');</script>";
 else {
    $headers = "��: $webtitle <{$website}>\r\nContent-type: text/html"; 
    $body = "<HTML><BODY>
             <br><center><h1>$webtitle - ������� �����������!</h1><br><br>
             <a href=\"$path\"><img src=\"{$website}/thumb.php?id=$id\"></a>  
             <br><br><br><LABEL id='title'>������ �� �����������:</LABEL><br>$path
             <br><br>
             <LABEL id='title'>$webtitle</LABEL> -
             <LABEL id='text'> Free Image Hosting &amp; Sharing Service</LABEL>
             </center></BODY></HTML>";  

    if (mail($to, "$webtitle - Image Link", $body, $headers)) 
       echo "<script language=\"JavaScript\">alert('Email Sent !');</script>"; 
    else
       echo "<script language=\"JavaScript\">alert('������ �� ����� ���� ����������!');</script>";
 }
} 

//GO BACK
echo "<script language=\"JavaScript\">window.location.href='$path'; </script>";

?>


</body>
</html>