<?php

session_start();
include("loadsettings.inc.php");
include("checkpass.inc.php");

?>

<html>

<body link=brown vlink=brown>


<br>
<font face="arial" color="brown"><u><h2><center>
.:: Настройки ::.
</center></h2></u></font>


<br>


<font color=brown face=verdana size=2>
<br>


<?php 

if (isset($_POST["savesettings"])) {

  $password = htmlspecialchars(trim($_POST["password"]));
  $website =  htmlspecialchars(trim($_POST["website"]));
  $title =  htmlspecialchars(trim($_POST["title"]));
  $description =  htmlspecialchars(trim($_POST["description"]));
  $keywords =  htmlspecialchars(trim($_POST["keywords"]));

  $maxsizeguest = trim($_POST["maxsizeguest"]);
  $maxsizemember = trim($_POST["maxsizemember"]);

  $watermark = $_POST["watermark"];

  //Remove the end slash if found
  if (substr($website, strlen($website) - 1) == "/")
     $website = substr($website,0, strlen($website) - 1);
  

  if (($password != "") AND ($website != "") AND ($title != "") AND ($description != "") AND ($keywords != "") AND 
       ($maxsizeguest != "") AND ($maxsizemember != "")) {        
              
     if ((is_numeric($maxsizeguest)) AND (is_numeric($maxsizemember))) {
     
         mysql_query("UPDATE `settings` SET password='$password',
                                            website='$website', 
                                            title='$title', 
                                            description='$description',
                                            keywords='$keywords',
                                            maxsizeguest='$maxsizeguest',
                                            maxsizemember='$maxsizemember',
                                            watermark='$watermark'");

        $_SESSION["imagehost-admin"] = $password; 
        echo "<b><h4>Настройки сохранены!</h4></b>";
    }
    else 
        echo "<h4>Введите 'Максимальный размер изображения'.</h4>";
  }
  else
    echo "<h4>Заполните все поля!</h4>";


  echo "<br><br>";

}


?>  
 


<form method="POST" action="settings.php">

<table style="FONT-SIZE: 12px; COLOR: brown;">

<tr> <td>Пароль администратора: </td> <td> <input type="text" size="30" name="password" maxlength="20" value="<? echo $password; ?>"> </td></tr>
<tr> <td>Адрес хостинга/скрипта: </td> <td> <input type="text" size="30" name="website" maxlength="250" value="<? echo $website; ?>"> </td></tr>
<tr> <td>Название сайта: </td> <td> <input type="text" name="title" size="30" maxlength="250" value="<? echo $webtitle; ?>"> </td></tr>
<tr> <td>Описание: </td> <td> <input type="text" name="description" size="30" maxlength="250" value="<? echo $description; ?>"> </td></tr>
<tr> <td>Ключевое слово: </td> <td> <input type="text" size="30" name="keywords" maxlength="250" value="<? echo $keywords; ?>"> </td></tr>

<tr> <td>Максимальный размер изображения [гость]: </td> <td> <input type="text" name="maxsizeguest" size="30" maxlength="1" value="<? echo $maxsizeguest; ?>"> </td></tr>
<tr> <td>Максимальный размер изображения [пользователь]: </td> <td> <input type="text" name="maxsizemember" size="30" maxlength="1" value="<? echo $maxsizemember; ?>"> </td></tr>

<tr> <td>Включить фирменный знак: </td> <td> <input type='radio' name='watermark' value='true' checked> Да &nbsp; &nbsp;
                                      <input type='radio' name='watermark' value='false'> Нет   </td>
                                  <td><b>Примечание: Не применимо к личным изображениям! </b></tr>

<tr> <td> </td> <td> <input type="submit" value="Сохранить настройки" name="savesettings"> </td></tr>

</table>
</form>


</font>


</body>
</html>


