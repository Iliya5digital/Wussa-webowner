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
</head>


<body link=#336699 vlink=#336699 alink=#336699>
<?php include("header.php"); ?>

<center>
<div class="content-container">


<!-- ######################################################################################### -->


<?php

if ($session == true)
{ 

   if (isset($_GET["act"])) {
       $act = $_GET["act"];     

       if (isset($_GET["id"]))
          $id = trim($_GET["id"]);
       else
          die();

     
      //DELETE AN IMAGE FROM FAVOURITES
      if ($act == "delete") {
     
          mysql_query("DELETE FROM `favourites` WHERE (id = '$id') AND (userid = '$userid')");
          echo "Изображение удалено из избранных !";
          echo "<br><br><a href=\"myfavourites.php\">Нажмите здесь</a> чтобы вернуться назад";
                  
      }
   }
   else {
 
   
           $max_show = 6;
           $total = 0;           

           if (isset($_GET["page"]))
               $page = $_GET["page"];   
           else
               $page = 1;   


           echo "<center>";
           echo "<br><h1>Избранные изображения</h1><br>";

    
           $q = "SELECT id, imageid FROM `favourites` WHERE userid = '$userid' ORDER BY id DESC";
           if(!($result_set = mysql_query($q))) die(mysql_error());
           $number = mysql_num_rows($result_set);
           
           
           if ($number) { 
            
              while ($row = mysql_fetch_array($result_set)) {
                  $id = $row['imageid'];
                  $idfavourite[] = $row['id'];

                  $r = mysql_query("SELECT * FROM `images` WHERE id = '$id'");
                  $n = mysql_num_rows($r);
                  
                  if ($n) { 
                      $row1 = mysql_fetch_array($r);
                      $ids[] = $row1['id'];  
                      $details[] = $row1['details'];   
                      $views[] = $row1['views']; 
                      $date[] = $row1['date']; 
                      $type[] = $row1['type'];
                      $total++; 
                  }     
              }           

    
              $from2 = $page * $max_show;
              if ($from2 > $total)
              {
                 $diff = $total % $max_show;
                 $from2 = $total;
                 $from1 = $from2 - $diff;
              }     
              else
                 $from1 = $from2 - $max_show;
         
      
              

              if ($total) {

                echo "<table border=2 bordercolor=\"#b1ddf6\" style=\"border-collapse: collapse; FONT-SIZE: 16px\" width=900>";
                echo "<tr height=40 bgcolor=\"#F0F8FF\">
                     <td><center><b>Изображение</b></center></td>";
                echo "<td><center><b>Детали</b></center></td>";
                echo "<td><center><b>Просмотры</b></center></td>";
                echo "<td><center><b>Дата</b></center></td>";
                echo "<td><center><b>Действие</b></center></td>";
                echo "</tr>"; 
  
          

              
               //NOW PRINT THE RECORDS IN THE REQUIRED RANGE
               for ($i=$from1; $i < $from2; $i++)
               {
                  echo "<tr align=center>";
                  $id = $ids[$i];
                  echo "<td> <a href=\"show-image.php?id=$id\"><img src=\"thumb.php?id=$id\"></a> </td>";
                  echo "<td width=180> {$details[$i]}</td>";
                  echo "<td> {$views[$i]} </td>";
                  echo "<td> {$date[$i]}  </td>";
                 
                  echo "<td>";
                  echo "<a href=\"myfavourites.php?id={$idfavourite[$i]}&act=delete\">Удалить</a>";
                  echo "</td></tr>";
               }               
             
               echo "</table></center></form>"; 
             
               //SHOW THE NEXT AND PREVIOUS LINKS IN A TABLE (IF REQUIRED)
               echo "<table width='100%'><tr>";
               echo "<td align='right' width='50%'>&nbsp;";

               if ($from1 > 0)
               {
                  $previous = $page - 1;
                  echo "<a href='myfavourites.php?page=$previous'><< Предыдущая</a>";
               } echo "</td>";    
    

               echo "<td align=left width=50%>&nbsp;&nbsp;&nbsp;";
               if ($from2 < $total)
               {
                  $next = $page + 1;
                  echo "<a href='myfavourites.php?page=$next'>Следующая >></a>";
               } echo "</td></tr></table>";
        
             }
             else
               echo "<br><center>Вы ещё не добавили ни одного изображения в избранные!</center>";     

          }
          else
             echo "<br><center>Вы ещё не добавили ни одного изображения в избранные!</center>";        
     
    }
             
    echo "<br><br><center><a href='account.php'>Мой аккаунт</a></center>";     
     
    
}
else
  echo "Вы должны войти прежде,чем смотреть свой аккаунт.<br><a href=\"login.php\">Нажмите здесь</a> чтобы войти.";




function deleteImage($id) {

global $userid;

$result = mysql_query("SELECT image, thumb FROM `images` WHERE (id='$id') AND (userid='$userid')");
$number = mysql_num_rows($result);
if (!$number) die("Изображения не существует.");

$row = mysql_fetch_array($result);
$image = $row['image'];
$thumb = $row['thumb'];

unlink($image);
unlink($thumb);

mysql_query("DELETE FROM `images` WHERE (id='$id') AND (userid='$userid')");

}

?>


       
<!-- ######################################################################################### -->          
<?php  include("footer.php"); ?>


</div>
</center>
</body>
</html>





