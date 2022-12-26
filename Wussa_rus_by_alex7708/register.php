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

<meta name="description" content="<? echo $description; ?>" />
<meta name="keywords" content="<? echo $keywords; ?>" />

</head>


<body link=#336699 vlink=#336699 alink=#336699>
<?php include("header.php"); ?>

<center>
<div class="content-container">
   
 
<!-- ################################################################################################# -->

<br>
<LABEL id="message" style="COLOR: maroon">
<?php

if (isset($_POST["username"]))  {
   $username = htmlspecialchars(trim($_POST["username"]));
   $password = htmlspecialchars(trim($_POST["password"]));
   $password1 = htmlspecialchars(trim($_POST["password1"]));
   $userpass = htmlspecialchars(trim($_POST["userpass"]));
   $email = htmlspecialchars(trim($_POST["email"]));    
   
   echo "<br>";
   
 if (isset($_POST["agree"])) {

   if (($username != "") && ($password != "") && ($password1 != "") && ($email != ""))
   {
      if ((strlen($password) > 5) && (strlen($userpass) > 5))  {
         
         if ($password == $password1) 
         {
             $q = "SELECT username FROM `members` WHERE (username = '$username') or (email = '$email')";
             if(!($result_set = mysql_query($q))) die(mysql_error());
             $number = mysql_num_rows($result_set);

             if ($number) {
                 echo "Такой логин или e-mail уже используются!<br><br>"; 
                 showForm();
             }
             else {
                 $q = "INSERT INTO `members` (username, password, userpass, email) VALUES('$username', '$password', '$userpass', '$email')"; 
                 $result_set = mysql_query($q);
                 
                 $to = $email;
                 $subject = "Добро пожаловать $webtitle !";
                 $body = "Привет $username, \n\nСпасибо за регистрация на $webtitle !\n\nЭто сообщение содержит регистрационную информацию.\nВаш логин & пароль \n\nЛогин: $username\nПароль: $password\nUser Pass: $userpass \n\nСпасибо!\n{$website}";                 
                 $headers = "От: $webtitle <{$website}>";                 

                 if(mail ($to, $subject, $body, $headers)) {
                     echo "Ваш аккаунт создан.  
                         <br><a href=\"login.php\">Нажмите здесь</a> чтобы войти.";
                 }                 
                 else
                   echo "Ваш аккаунт создан.<br>Sorry ! E-mail не может быть отправлен!";
                 
                 $invite = $_POST["invite"]; 
                 for ($i=0; $i < 5; $i++) {
                    if (trim($invite[$i]) != "") {   
                        $to = $invite[$i];
                        $subject = "$webtitle Invitation";
                        $features = "Upload multiple pictures at one time\nCreate public and private galleries\nTheir dedicated servers host your images\nLink your photos in websites, email, blogs\nRegister an account to manage your files\nAdd tags to each of your photos\nUpload private images with password\nShare your images with friends and family";
 
                        $body = "Hello ! \n\nI have just joined $webtitle .\nIt provides free image hosting service with a whole bunch of features!\n\nFeatures:\n{$features}\n\nSo what are you waiting for?\nGoto $website and join instantly.\n\nThanks,\n$username";
                        $headers = "От: $username <$email>";                 
                       
                        mail($to, $subject, $body, $headers);
                    }    
                 }         

             }
         }
         else 
            { echo "Неверный пароль!<br><br>"; showForm();}       
     }
     else
        { echo "Минимальная длина пароля 6 знаков!<br><br>"; showForm(); } 
   }
   else
     { echo "Заполните все поля!<br><br>"; showForm(); }    
}
else
{ echo "Вы должны принять <a href='terms.php'>Правила</a>
       для продолжения регистрации.<br><br>"; showForm(); }


}
else
{
   if ($session == false)
      showForm();
   else
      echo "Вы уже зарегистрированы!";
}


//**********************************************************************************************************
?>
</LABEL>


<? function showForm() { ?>

<div>

<table>
<tr>
<td width=600 valign=top>

<form method="POST" action="register.php" name="myForm">

<h1>Присоединяйтесь!</h1>

<LABEL id="text">Используйте верный e-mail адрес!</LABEL>
<br><br><br>

<table>
<tr>
  <td><LABEL id="title">Логин: </td> <td> <input type="text" maxlength=30 size=30 name="username"> </td>
</tr>
<tr>
  <td><LABEL id="title">Пароль: </td> <td> <input type="password" maxlength=30 size=30 name="password"> </td>
</tr>
<tr>
  <td><LABEL id="title">Подтверждение пароля:  </td> <td> <input type="password" maxlength=30 size=30 name="password1"> </td>
</tr>
<tr>
  <td>&nbsp;</td> <td><br> (Пароль пользователей для доступа к личным изображениям)</td>
</tr>
<tr>
  <td><LABEL id="title">Пароль пользователя:  </td> <td> <input type="password" maxlength=30 size=30 name="userpass"> </td>
</tr>
<tr>
  <td><LABEL id="title">Email-ID: </td> <td> <input type="text" maxlength=40 size=30 name="email"> </td>
</tr>

<tr>
  <td>&nbsp;</td> <td> </td>
</tr>


<tr>
  <td><h2>Отправить приглашение:</h2> </td> <td> </td>
</tr>

<tr>
  <td><LABEL id="title">Email 1:</td> <td> <input type="text" maxlength=40 size=30 name="invite[]">  </td>
</tr>

<tr>
  <td><LABEL id="title">Email 2:</td> <td> <input type="text" maxlength=40 size=30 name="invite[]">  </td>
</tr>

<tr>
  <td><LABEL id="title">Email 3:</td> <td> <input type="text" maxlength=40 size=30 name="invite[]">  </td>
</tr>

<tr>
  <td><LABEL id="title">Email 4:</td> <td> <input type="text" maxlength=40 size=30 name="invite[]">  </td>
</tr>

<tr>
  <td><LABEL id="title">Email 5:</td> <td> <input type="text" maxlength=40 size=30 name="invite[]">  </td>
</tr>


<tr>
  <td></td>
  <td><br><input type="checkbox" name="agree"> &nbsp; Вы должны принять <a href="terms.php">Правила</a>.</td>
</tr>



<tr>
  <td></td>
  <td> <br><a href=#><img src="images/joinnow.png" border=0 onclick="myForm.submit();"></a></td>
</tr>
</table>

</form>
<br><br>



</td>

<td valign=top>
<br>
<h2>Зачем регистрироваться?</h2>
<LABEL id='title'>Регистрация бесплатна и занимает всего 30 секунд!<br>Вы получите доступ к следующим функциям:</LABEL>
<br><br>

<ul>
 <li>Загрузка личных изображений
 <li>Создание общих и личных галерей
 <li>Добавлять изображения в избранные
 <li>Оставлять комментарии к изображениям
 <li>Управлять своими изображениями
</ul>




</td>
</tr></table>

</div>



<? } ?>

<!-- ################################################################################################# -->
 


<?php  include("footer.php"); ?>


</div>
</center>
</body>
</html>