<?php

//#####################################################################################
 
//This script displays random public images. 

//#####################################################################################


//NUMBER OF RANDOM IMAGES TO SHOW
$images_to_show = 5;
$total = 0;


$q = "SELECT * FROM `images` WHERE (type = 'member-public') OR (type = 'gallery') OR (type = 'public')";
if(!($result_set = mysql_query($q))) die(mysql_error());
$number = mysql_num_rows($result_set);

if ($number) {
  while ($row = mysql_fetch_array($result_set)) 
  {
    if ($row['type'] == "gallery") {  
      $galleryid = $row['galleryid'];
      $result = mysql_query("SELECT type FROM `galleries` WHERE id = '$galleryid'");
      $row1 = mysql_fetch_row($result);
      $a = $row1[0];

      if ($a == "public") {
         $arr[] = $row['id'];
         $total++;
      }
    }
    else {
      $arr[] = $row[0];
      $total++;
    }
  }
}




if ($total) {

  
  //GET RANDOM IMAGES FROM THE ARRAY
  if ($images_to_show > $total) $images_to_show = $total;
  if ($images_to_show == 1)
     $n[] = 0;
  else
     $n = array_rand($arr,$images_to_show);

  echo "</p>
        <table width=100% style=\"border-collapse: collapse\">
        <tr>";
 
  $x = -1;
  for ($i=0; $i < $images_to_show; $i++) {

   $id = $arr[$n[$i]];
   $x++;
   if (($x % 5) == 0) echo "</tr><tr>";

   echo "<td align=center>";
   echo "<a href=\"show-image.php?id=$id\">";
   echo "<img src='thumb.php?id=$id' style=\"opacity: 1;filter:alpha(opacity=100)\"
                   onmouseover=\"this.style.opacity=0.4;this.filters.alpha.opacity=40\"
                   onmouseout=\"this.style.opacity=1;this.filters.alpha.opacity=100\" />";
   echo "</a></td>";   
  }
  echo "</tr></table>";
}
else
  echo "Ќи одного общего изображени€ не было загружено!";



?>