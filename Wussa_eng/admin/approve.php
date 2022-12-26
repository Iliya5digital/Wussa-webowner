<?php

session_start();
include("loadsettings.inc.php");
include("checkpass.inc.php");

?>

<html>

<body link=brown vlink=brown>


<br>
<font face=arial color="brown"><u><h2><center>
.:: Approve / Delete Images ::.
</center></h2></u></font>


<font face=verdana size=2 color=brown>

<br><br>

<?php


function deleteImage($id) {

$result = mysql_query("SELECT image, thumb FROM `images` WHERE id='$id'");
$number = mysql_num_rows($result);
if (!$number) die("Sorry ! The image you specified does not exists.");

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

        echo "The images were deleted successfully !";
        echo "<br><br><a href=\"approve.php\">Click here</a> to go back";
     }
     else {
        echo "Please select some images to delete first !";
        echo "<br><br><a href=\"approve.php\">Click here</a> to go back";
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

        echo "The images were approved !";
        echo "<br><br><a href=\"approve.php\">Click here</a> to go back";
     }
     else {
        echo "Please select some images to approve first !";
        echo "<br><br><a href=\"approve.php\">Click here</a> to go back";
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

        echo "The images were approved !";
        echo "<br><br><a href=\"approve.php\">Click here</a> to go back";
     }
     else {
        echo "Please select some images to approve first !";
        echo "<br><br><a href=\"approve.php\">Click here</a> to go back";
     }
 
     echo "<meta http-equiv=\"refresh\" content=\"2; url='approve.php'\" />";
     die();
}



//*****************************************************************************************************

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


  echo "<b>There are '$total' unapproved images.</b><br><br>";
  
  echo "<u>Note:</u><br>
        \"<b>public images</b>\" are images uploaded by unregistered guests.<br>
        \"<b>member images</b>\" are single public or private images uploaded by members.<br>
        \"<b>gallery images</b>\" are gallery images uploaded by members.<br><br>";        
 

  echo "Images marked 'Not Safe' will not appear in search results when 'Safe Search' in ON<br><br><br><br>"; 


  echo "<form method='POST' action='approve.php'>";
  echo "<center>
               <input type='submit' value='Delete Selected' name='deleteselected'>
               <input type='submit' value='Approve Selected (Mark Safe)' name='approveselectedsafe'>
               <input type='submit' value='Approve Selected (Not Safe)' name='approveselectednotsafe'> 
        </center><br>";

  echo "<center><table border=1 bordercolor=purple width=500 style='FONT-SIZE: 12px'><tr align=center>";
  echo "<td>&nbsp;</td>
        <td><b>Image</b></td>
        <td><b>Type</b></td>
        <td><b>IP Address</b></td>
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
     echo "<a href='approve.php?page=$previous'><< Previous Page</a>";
  } echo "</td>";    
    

  echo "<td align=left width=50%>&nbsp;&nbsp;&nbsp;";
  if ($from2 < $total)
  {
     $next = $page + 1;
     echo "<a href='approve.php?page=$next'>Next Page >></a>";
  } echo "</td></tr></table>";



}
else
  echo "<b>No unapproved images were found !</b>";


?>



</font>

</body>
</html>
