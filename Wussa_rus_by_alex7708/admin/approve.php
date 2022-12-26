<?php

session_start();
include("loadsettings.inc.php");
include("checkpass.inc.php");

?>

<html>

<body link=brown vlink=brown>


<br>
<font face=arial color="brown"><u><h2><center>
.:: Добавить/Удалить изображения ::.
</center></h2></u></font>


<font face=verdana size=2 color=brown>

<br><br>

<?php


function deleteImage($id) {

$result = mysql_query("SELECT image, thumb FROM `images` WHERE id='$id'");
$number = mysql_num_rows($result);
if (!$number) die("Изображения не существует!");

$row = mysql_fetch_array($result);
$image = "../" . $row['image'];
$thumb = "../" . $row['thumb'];

unlink($image);
unlink($thumb);

mysql_query("DELETE FROM `images` WHERE id='$id'");

}





$link = mysql_connect($server, $user, $pass);
if(!mysql_select_db($database)) die(mysql_error());



if (isset($_POST["deleteselected"])) {

    if (isset($_POST["images"])) {
        $images = $_POST["images"];
        
        while (list($index, $id) = each($images)) {
             deleteImage($id);
        }

        echo "Изображение удалено!";
        echo "<br><br><a href=\"approve.php\">Нажмите здесь</a> чтобы вернуться";
     }
     else {
        echo "Выберите изображение для удаления!";
        echo "<br><br><a href=\"approve.php\">Нажмите здесь</a> чтобы вернуться";
     }
 
     echo "<meta http-equiv=\"refresh\" content=\"2; url='approve.php'\" />";
     die();
}




if (isset($_POST["approveselectedsafe"])) {

    if (isset($_POST["images"])) {
        $images = $_POST["images"];

        while (list($index, $id) = each($images)) {
           $q = "UPDATE `images` SET approved = 'true', adult = 'false' WHERE id = '$id'";
           mysql_query($q);
        }

        echo "Изображение добавлено!";
        echo "<br><br><a href=\"approve.php\">Нажмите здесь</a> чтобы вернуться";
     }
     else {
        echo "Выберите изображение для добавления!";
        echo "<br><br><a href=\"approve.php\">Нажмите здесь</a> чтобы вернуться";
     }
 
     echo "<meta http-equiv=\"refresh\" content=\"2; url='approve.php'\" />";
     die();
}



if (isset($_POST["approveselectednotsafe"])) {

    if (isset($_POST["images"])) {
        $images = $_POST["images"];

        while (list($index, $id) = each($images)) {
           $q = "UPDATE `images` SET approved = 'true', adult = 'true' WHERE id = '$id'";
           mysql_query($q);
        }

        echo "Изображения добавлены!";
        echo "<br><br><a href=\"approve.php\">Нажмите здесь</a> чтобы вернуться";
     }
     else {
        echo "Выберите изображения для добавления!";
        echo "<br><br><a href=\"approve.php\">Нажмите здесь</a> чтобы вернуться";
     }
 
     echo "<meta http-equiv=\"refresh\" content=\"2; url='approve.php'\" />";
     die();
}



//************Перевод на русский язык alex7708*********************************************

$total = 0;


$q = "SELECT id, type, ip FROM `images` WHERE approved = 'false' ORDER BY number DESC";
if(!($result_set = mysql_query($q))) die(mysql_error());
$number = mysql_num_rows($result_set);
$total = $number;

if ($number) {
  while ($row = mysql_fetch_row($result_set)) 
  {
     $id[] = $row[0];
     $type[] = $row[1];
     $ip[] = $row[2];
  }
}




if ($total) {
  
  $max_show = 6;
         
  if (isset($_GET["page"]))
    $page = $_GET["page"];   
  else
    $page = 1;


  
 $from2 = $page * $max_show;
 if ($from2 > $total)
 {
     $diff = $total % $max_show;
     $from2 = $total;
     $from1 = $from2 - $diff;
 }     
 else
     $from1 = $from2 - $max_show;


  echo "<b>Всего '$total' неутверждённых изображений.</b><br><br>";
  
  echo "<u>Примечание:</u><br>
        \"<b>общие изображение</b>\" загруженные гостями.<br>
        \"<b>личные изображения</b>\" загруженные пользователями.<br>
        \"<b>галереи</b>\" созданные пользователями.<br><br>";        
 

  echo "Изображения отмеченные как 'Небезопастные' не будут появляться в результатах поиска при 'безопастном поиске'<br><br><br><br>"; 


  echo "<form method='POST' action='approve.php'>";
  echo "<center>
               <input type='submit' value='Удалить выбранные' name='deleteselected'>
               <input type='submit' value='Разрешить выбранные (безопастные)' name='approveselectedsafe'>
               <input type='submit' value='Разрешить выбранные (Небезопастные)' name='approveselectednotsafe'> 
        </center><br>";

  echo "<center><table border=1 bordercolor=purple width=500 style='FONT-SIZE: 12px'><tr align=center>";
  echo "<td>&nbsp;</td>
        <td><b>Изображение</b></td>
        <td><b>Тип</b></td>
        <td><b>IP адрес</b></td>
        </tr>";  
  

  for ($i=$from1; $i < $from2; $i++) {
    
    $type1 = $type[$i];
    $id1 = $id[$i];
    $ip1 = $ip[$i];

    echo "<tr align=center>";
    echo "<td><input type='checkbox' name='images[]' value='$id1'>
          </td>"; 
    echo "<td><a href='../show-image.php?id={$id1}' target='_blank'>";
    echo "<img src='../thumb.php?id={$id1}' border=0>";
    echo "</a></td>";
      
    echo "<td> $type1 image </td>";
    echo "<td> $ip1 </td>";
    
    echo "</tr>";
  
  }

  echo "</form></table>";





  //SHOW THE NEXT AND PREVIOUS LINKS IN A TABLE (IF REQUIRED)
  echo "<br><br><table width='100%'><tr>";
  echo "<td align='right' width='50%'>&nbsp;";

  if ($from1 > 0)
  {
     $previous = $page - 1;
     echo "<a href='approve.php?page=$previous'><< Предыдущая</a>";
  } echo "</td>";    
    

  echo "<td align=left width=50%>&nbsp;&nbsp;&nbsp;";
  if ($from2 < $total)
  {
     $next = $page + 1;
     echo "<a href='approve.php?page=$next'>Следующая >></a>";
  } echo "</td></tr></table>";



}
else
  echo "<b>Не подтверждённых изображений нет!</b>";


?>



</font>

</body>
</html>
