<html>

<head>
   <title>Панель администратора</title>
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
   echo   "<center><h2>.:: Панель администратора ::.</h2></center></font><br><br>";
 
   if ($error == "empty")
    echo  "<b><font color=blue face=arial>Введите пароль!</font></b><br><br>"  ;
   if ($error == "invalid")
    echo  "<b><font color=blue face=arial>Неверный пароль!</font></b><br><br>" ;
 
   echo   "<form method=\"POST\" action=\"auth.php\">";
   echo   "<font face=arial size=4 color=brown>";
   echo   "Пароль: &nbsp;<input type=password name=\"pass\" size=20>";
   echo   "&nbsp; &nbsp; <input type=submit size=20 value=\"Войти в панель администратора\">";
   echo   "</font></form>";
}

?>



</body>
</html>
