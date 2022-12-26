<html>

<head>
   <title>ADMINISTRATION PANEL</title>
</head>

<body background="back.jpg">


<?php

 
if (isset($_GET["error"]) )
   showLoginForm($_GET["error"]);
else
   showLoginForm();


 
 function showLoginForm($error = "")
 {

   echo   "<font face=arial>"; 
   echo   "<center><h2>.:: Administration Panel ::.</h2></center></font><br><br>";
 
   if ($error == "empty")
    echo  "<b><font color=blue face=arial>Error: Please enter a password first.</font></b><br><br>"  ;
   if ($error == "invalid")
    echo  "<b><font color=blue face=arial>Error: Sorry ! The password you entered is wrong. Please try again.</font></b><br><br>" ;
 
   echo   "<form method=\"POST\" action=\"auth.php\">";
   echo   "<font face=arial size=4 color=brown>";
   echo   "Enter Password: &nbsp;<input type=password name=\"pass\" size=20>";
   echo   "&nbsp; &nbsp; <input type=submit size=20 value=\"Enter Administration Panel\">";
   echo   "</font></form>";
}

?>



</body>
</html>
