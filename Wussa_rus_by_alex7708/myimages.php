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


<body link=#336699 vlink=#336699 alink=#336699>
<?php include("header.php"); ?>

<center>
<div class="content-container">


<!-- ######################################################################################### -->


<?php

if ($session == true)
{ 
   $show = true;
   
   if (isset($_POST["changetags"])) {
       
     $show = false;
     $id = $_POST["id"];
     $tags = $_POST["tags"];

     if ($tags != "") {
        if ($id != "") {
         
            if(mysql_query("UPDATE `images` SET tags='$tags' WHERE (id='$id') AND (userid='$userid')")) {
                echo "���� ����������� ���� ��������!";
                echo "<br><br><a href=\"myimages.php\">������� �����</a> ����� ���������";
            }
            else
                echo "���� ����������� �� ����� ���� ��������!";
         }
     }
     else {
        echo "������� ����!"; 
        echo "<br><br><a href=\"myimages.php\">������� �����</a> ����� ���������";
     }
  }



   if (isset($_POST["deleteselected"])) {
       
     $show = false;
     
     if (isset($_POST["images"])) {
        $images = $_POST["images"];
      
        while (list($index, $id) = each($images)) {
           deleteImage($id);
        } 
        
        echo "����������� �������!";
        echo "<br><br><a href=\"myimages.php\">������� �����</a> ����� ���������";
     }
     else {
        echo "�������� ����������� ��� ��������!";
        echo "<br><br><a href=\"myimages.php\">������� �����</a> ����� ���������";
     }
      
   }


   
   if (isset($_POST["moveselected"])) {
       
     $show = false;
     
     if (isset($_POST["images"])) {
        $images = $_POST["images"];
        $galleryid = $_POST["galleryid"];
      
        while (list($index, $id) = each($images)) {
           $r = mysql_query("UPDATE `images` SET galleryid = '$galleryid', userid = '-1', type = 'gallery'
                             WHERE (id='$id') AND (userid='$userid')");
        }
        echo "����������� ����������!";
        echo "<br><br><a href=\"myimages.php\">������� �����</a> ����� ���������";
     }
     else {
        echo "�������� ����������� ��� ����������� !";
        echo "<br><br><a href=\"myimages.php\">������� �����</a> ����� ���������";
     }
      
   }
    


    
   //*********************************************************************************************************
   
   if (isset($_GET["act"])) {
    $act = $_GET["act"];     

    if (isset($_GET["id"]))
       $id = trim($_GET["id"]);
    else
       die();

 
    
    if ($act == "delete") {
     
        deleteImage($id);     
        echo "����������� �������!";
        echo "<br><br><a href=\"myimages.php\">������� �����</a> ����� ���������";
                   
    }

 
    if ($act == "makeprivate") {
        
            if(mysql_query("UPDATE `images` SET type='member-private' WHERE (id='$id') AND (userid='$userid')")) {
                echo "������ �����������!";
                echo "<br><br><a href=\"myimages.php\">������� �����</a> ����� ���������";
            }
            else
                echo "����������� �� ����� ���� ������!";
    }


    if ($act == "makepublic") {
        
            if(mysql_query("UPDATE `images` SET type='member-public' WHERE (id='$id') AND (userid='$userid')")) {
                echo "����� �����������!";
                echo "<br><br><a href=\"myimages.php\">������� �����</a> ����� ���������";
            }
            else
                echo "����������� �� ����� ���� �����!";
    }
    


    if ($act == "changetags") {
        
          echo "<form method='POST' action='myimages.php'>";
          echo "<br>������� ����� ���� �����������:<br><input type='text' name='tags' size=40 maxlength=250>";
          echo "&nbsp; &nbsp; <input type='submit' value='Change' name='changetags'>";
          echo "<input type='hidden' name='id' value='$id'></form>";
          echo "<br><br><a href=\"myimages.php\">������� �����</a> ����� ���������";
    }



    //$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
    }
    else { 

       if ($show == true) {
    
           $max_show = 5;
         
           if (isset($_GET["page"]))
               $page = $_GET["page"];   
           else
               $page = 1;   

    
           $q = "SELECT id, details, views, date, type FROM `images` WHERE userid = '$userid' ORDER BY number DESC";
           if(!($result_set = mysql_query($q))) die(mysql_error());
           $number1 = mysql_num_rows($result_set);


           if ($number1) {
    
              $from2 = $page * $max_show;
              if ($from2 > $number1)
              {
                 $diff = $number1 % $max_show;
                 $from2 = $number1;
                 $from1 = $from2 - $diff;
              }     
              else
                 $from1 = $from2 - $max_show;
         
      
              echo "<center>";
              echo "<br><h1>��� �����������</h1><br><br>";
              echo "<form method='POST' action='myimages.php'>";
              
              echo "<input type='submit' name='deleteselected' value='������� ��������� �����������'>";

              $result_set1 = mysql_query("SELECT id, name FROM `galleries` WHERE userid = '$userid'");
              $nn = mysql_num_rows($result_set1);

              if ($nn) {
                  
                  echo "&nbsp; &nbsp; &nbsp; &nbsp;";
                  echo "<LABEL id='message'>����������� ��������� ����������� � �������:</LABEL></td>
                          <select name='galleryid'>";

                   while ($row = mysql_fetch_array($result_set1))
                        echo "<option value={$row['id']}>{$row['name']}</option>";

                   echo "</select>&nbsp;<input type='submit' name='moveselected' value='Move'>";
              }
 
              echo "<br><br><br>"; 
              echo "<table border=2 bordercolor=\"#b1ddf6\" style=\"border-collapse: collapse; FONT-SIZE: 16px\" width=900>";
              echo "<tr height=40 bgcolor=\"#F0F8FF\">
                    <td>&nbsp;</td> 
                    <td><center><b>�����������</b></center></td>";
              echo "<td><center><b>������</b></center></td>";
              echo "<td><center><b>���������</b></center></td>";
              echo "<td><center><b>����</b></center></td>";
              echo "<td><center><b>���</b></center></td>";
              echo "<td><center><b>��������</b></center></td>";
              echo "</tr>"; 
  

              while ($row = mysql_fetch_array($result_set))
              {
                  $ids[] = $row['id'];  
                  $details[] = $row['details'];   
                  $views[] = $row['views']; 
                  $date[] = $row['date']; 
                  $type[] = $row['type'];
              }    

              
              //NOW PRINT THE RECORDS IN THE REQUIRED RANGE
              for ($i=$from1; $i < $from2; $i++)
              {
                 echo "<tr align=center>";
                 $id = $ids[$i];
                 echo "<td> <input type='checkbox' name='images[]' value='$id'> </td>";
                 echo "<td> <a href=\"show-image.php?id=$id\"><img src=\"thumb.php?id=$id\"></a> </td>";
                 echo "<td width=180> {$details[$i]}</td>";
                 echo "<td> {$views[$i]} </td>";
                 echo "<td> {$date[$i]}  </td>";
                 echo "<td>";
             
                 if ($type[$i] == "member-public") 
                    echo "�����";
                 else
                    echo "������";   
 
                 echo "</td>";
                 echo "<td>";
                     
                     if ($type[$i] == "member-public")  
                       echo "<a href=\"myimages.php?id=$id&act=makeprivate\">������� ������</a>";
                     else
                       echo "<a href=\"myimages.php?id=$id&act=makepublic\">������� �����</a>";

                     echo "&nbsp; | &nbsp;<a href=\"myimages.php?id=$id&act=changetags\">�������� ����</a>";
                     echo "&nbsp; | &nbsp;<a href=\"myimages.php?id=$id&act=delete\">�������</a>";
                 
                 echo "</td></tr>";
              }               
             
              echo "</table></center></form>"; 
             
              //SHOW THE NEXT AND PREVIOUS LINKS IN A TABLE (IF REQUIRED)
              echo "<table width='100%'><tr>";
              echo "<td align='right' width='50%'>&nbsp;";

             if ($from1 > 0)
             {
                 $previous = $page - 1;
                 echo "<a href='myimages.php?page=$previous'><< ����������</a>";
             } echo "</td>";    
    

             echo "<td align=left width=50%>&nbsp;&nbsp;&nbsp;";
             if ($from2 < $number1)
             {
                 $next = $page + 1;
                 echo "<a href='myimages.php?page=$next'>��������� >></a>";
             } echo "</td></tr></table>";
             
          }
          else
             echo "<br><center>�� ������ ����������� �� ���� ���������!</center>";        
                  
            echo "<br><br><center><a href='index.php'><img src='images/upload.png' border=0></a></center><br>";
            echo "<br><br><center><a href='account.php'>��������� � ��� �������</a></center>";     

       } 
      
   }
    //$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$ 
 
       
}
else
  echo "�� ������ �����,����� ������������� ���� �������.<br><a href=\"login.php\">������� �����</a> ����� �����.";




function deleteImage($id) {

global $userid;

$result = mysql_query("SELECT image, thumb FROM `images` WHERE (id='$id') AND (userid='$userid')");
$number = mysql_num_rows($result);
if (!$number) die("����������� �� ����������!");

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





