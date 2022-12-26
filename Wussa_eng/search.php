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

<title><? echo $webtitle; ?> - Free Image Hosting</title>
<link rel="stylesheet" href="style.css" type="text/css" />

<meta name="description" content="<? echo $description; ?>" />
<meta name="keywords" content="<? echo $keywords; ?>" />

</head>


<body link=#336699 vlink=#336699 alink=#336699>
<?php include("header.php"); ?>

<center>
<div class="content-container">
   
<!-- ################################################################################################## -->

<br><img src="images/images.gif" align=left hspace=10 height=25>
&nbsp; &nbsp;<a href="images.php" style="FONT-SIZE: 18px">Newest</a>&nbsp; &nbsp; |
&nbsp; &nbsp;<a href="popular.php" style="FONT-SIZE: 18px">Most Popular</a>&nbsp; &nbsp; |
&nbsp; &nbsp;<a href="search.php" style="FONT-SIZE: 18px">Search</a>&nbsp; &nbsp;
<br><br><br>
 


<?php

echo "<center>";
echo "<form method=\"GET\" action='search.php'>";
echo "<table width=100% bgcolor='#edf7fd' style=\"BORDER: #b1ddf6 2px solid;\">";
echo "<tr height=40 align=center><td>";
echo "<LABEL id='title'>Search: </LABEL>&nbsp;<input type='text' name='query' maxlength='100'>";
echo "&nbsp; &nbsp;<input type='submit' value='Search'>";
echo "</td></tr>
      
      <tr align=center><td>
        <LABEL id='title'>Search By: </LABEL>&nbsp; &nbsp;
        <input type='radio' name='opt' value='tags' CHECKED> &nbsp; Tags
        <input type='radio' name='opt' value='gallery'> &nbsp; Gallery
      </td></tr> ";
            
echo  "<tr align=center><td>";
       
       if ($session == true) {
         echo "<input type='checkbox' name='safe' value='true' checked> Enable Safe Search";
       }else {
         echo "Safe Search is 'On'. You must login in order to turn it off.";
       }       

echo "</td></tr></table>";       
echo "</form></center>";

echo "<br><br>";

//*************************************************************************************************


function showGalleryImage($id) {

//GET THUMBNAIL OF THE LAST IMAGE IN THE GALLERY.
$r = mysql_query("SELECT id FROM `images` WHERE galleryid = '$id' ORDER BY number DESC LIMIT 1");

if (!mysql_num_rows($r))
  echo "<a href='gallery.php?id=$id'><img src='gallery.gif' border=0></a>";
else {  
  $row = mysql_fetch_array($r);
  $imageid = $row['id'];
  echo "<a href='gallery.php?id=$id'><img src='thumb.php?id=$imageid' border=0></a>";
}

}



if (isset($_GET["query"])) {

  $query = $_GET["query"];
  $opt = $_GET["opt"];

  $max_show = 10;
  $total = 0;
  $found = 0;

  $safe = true;  
 
  if ($session == true) {
    if (isset($_GET["safe"])) 
      $safe = true;
    else
      $safe = false;
  }
  else
      $safe = true;
     


  if (isset($_GET["page"]))
      $page = $_GET["page"];   
  else
      $page = 1;
  

                
  if ($query != "") {
          
     if ($opt == "tags") {
     
         if ($safe == true)        
           $q = "SELECT * FROM `images` WHERE ((type = 'member-public') OR (type = 'gallery') OR (type = 'public')) AND (adult = 'false')";
         else
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
                    $id[] = $row['id'];
                    $tags[] = $row['tags'];
                    $total++;
                 }
               }
               else {
                 $id[] = $row[0];
                 $tags[] = $row['tags'];
                 $total++;
               }
            }
          }



           if ($total) {
    
              $found = 0;

              for ($i=0; $i < $total; $i++)
              {
                 if (stristr($tags[$i], $query) != "") {
                   $id1[] = $id[$i];
                   $found++;
                 }
              }


             $from2 = $page *  $max_show;
             if ($from2 > $found)
             {
                 $diff = $found % $max_show;
                 $from2 = $found;
                 $from1 = $from2 - $diff;
             }
             else
                 $from1 = $from2 - $max_show;

           
           
           
              if ($found != 0) {

                echo "<center><b>Search Completed:</b> Your search for '$query' returned $found results !<br><b>Page : $page</b><br><br><br>";
                echo "<table><tr>";

                  //NOW PRINT THE RECORDS IN THE REQUIRED RANGE
                  for ($i=$from1; $i < $from2; $i++)
                  {
                    if (($i % 5) == 0) echo "</tr><tr>";
                    $idTemp = $id1[$i];
                    echo "<td align=center width=180> <a href=\"show-image.php?id=$idTemp\"><img src=\"thumb.php?id=$idTemp\"></a>";
                    echo "</td>";

                  }

                  echo "</tr></table></center>";
              }


          }
          
     
      } //$opt end  

      //##########################################################################################################      

      if ($opt == "gallery") {

           //GET ALL THE GALLERIES IN AN ARRAY
           $total = 0;
           $q = "SELECT id, name FROM `galleries` WHERE type = 'public'";
           if(!($result_set = mysql_query($q))) die(mysql_error());
           $number = mysql_num_rows($result_set);
           $total = $total + $number;

           if ($number) {
             while ($row = mysql_fetch_array($result_set))
             {
               $id[] = $row['id'];
               $name[] = $row['name'];
             }
           }


           if ($total) {
    
              $found = 0;
              for ($i=0; $i < $total; $i++)
              {
                 $t = $name[$i];
                 if (stristr($t, $query) != "") {
                   $id1[] = $id[$i];
                   $name1[] = $name[$i];
                   $found++;
                 }
              }


             $from2 = $page *  $max_show;
             if ($from2 > $found)
             {
                $diff = $found % $max_show;
                $from2 = $found;
                $from1 = $from2 - $diff;
             }
             else
                $from1 = $from2 - $max_show;
                


             if ($found != 0) {

                echo "<center><b>Search Completed:</b> Your search for '$query' returned $found results !<br><b>Page : $page</b><br><br><br>";
                echo "<table><tr>";

                  $x = -1;
                  //NOW PRINT THE RECORDS IN THE REQUIRED RANGE
                  for ($i=$from1; $i < $from2; $i++)
                  {
                       $x++;
                       if (($x % 4) == 0) echo "</tr><tr>";
                      
                       echo "<td align=center width=400 valign=top>";
                       showGalleryImage($id1[$i]);
                        
                       echo "<br><br>{$name1[$i]} </td>";

                  }

                  echo "</tr></table></center>";
              }

                
                
        }
        else
             echo "There are no public galleries to search !";
                 
      }



  //**************************************************************************************************************
   
    if ($found) {

         //SHOW THE NEXT AND PREVIOUS LINKS IN A TABLE (IF REQUIRED)
         echo "<br><br><table width='100%'><tr>";
         echo "<td align='right' width='50%'>&nbsp;";

         if ($from1 > 0)
         {
              $previous = $page - 1;
              echo "<a href='search.php?query=$query&opt=$opt&page=$previous'><< Previous Page</a>";
         } echo "</td>";    
    

         echo "<td align=left width=50%>&nbsp;&nbsp;&nbsp;";
         if ($from2 < $found)
         {
              $next = $page + 1;
              echo "<a href='search.php?query=$query&opt=$opt&page=$next'>Next Page >></a>";
         } echo "</td></tr></table>";
             

   }//$found !=0
   else
         echo "<center>Sorry ! Your search for '$query' returned no results.</center>";        
 
 

 }
  else
    echo "<center>Please enter some text to search.</center>";

}



?>





<!-- ################################################################################################## -->


<?php  include("footer.php"); ?>


</div>
</center>
</body>
</html>

