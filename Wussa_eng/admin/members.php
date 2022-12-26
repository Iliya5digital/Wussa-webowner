<?php

session_start();
include("loadsettings.inc.php");
include("checkpass.inc.php");

?>



<html>

<body link=brown vlink=brown>


<br>
<font face=arial color="brown"><u><h2><center>
.:: Manage Members ::.
</center></h2></u></font>


<font face=verdana size=4 color=brown>

<br>

<?php

$link = mysql_connect($server, $user, $pass);
if(!mysql_select_db($database)) die(mysql_error());


echo "<font size=2>";

if (isset($_POST['member'])) {
   $member = $_POST['member'];
   if (trim($member) == "") die("Please enter a username to view first !");
   
   $result_set = mysql_query("SELECT * FROM `members` WHERE username = '$member'");
   $n = mysql_num_rows($result_set);
   
   if ($n) {
   
     $r = mysql_fetch_array($result_set);

     echo "<table width=100% style='FONT-SIZE: 12px'><tr height=50>";
     echo "<td> <b><u>Username</u></b></td> 
           <td> <b><u>Password</u></b></td>
           <td> <b><u>User Password</u></b></td>
           <td> <b><u>Email</u></b></td>
           <td> <b><u>Action</u></b></td></tr>";

       echo "<tr>";  
       echo "<td>{$r['username']}</td> 
        <td> {$r['password']}</td>  
        <td> {$r['userpass']}</td>
        <td> {$r['email']}</td>
        <td>  <a href=\"members.php?delete={$r['id']}\">Delete</a></b></td>";
       echo "</tr></table>";
       echo "<center><br><br><a href='members.php'>Go back</a></center>";
       die();
   }   
   else
       echo "<b>Sorry ! The username was not found.</b>";

   echo "<br><br>";

}


//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$


if (isset($_GET["delete"])) {
  
  $id = $_GET["delete"];

  //DELETE ALL THE MEMBER SINGLE IMAGES
  mysql_query("DELETE FROM `images` WHERE userid = '$id'");
  
  $result = mysql_query("SELECT id, name FROM `galleries` WHERE userid = '$id'");
  $number = mysql_num_rows($result);

  if ($number) {

     //THEN RETRIEVE GALLERIES OF THE MEMBER ONE BY ONE
     while ($row = mysql_fetch_array($result)) {
        $galleryid = $row['id'];
        $name = $row['name'];        
 
        //DELETE ALL THE IMAGES ASSOCIATED WITH THE GALLERY.
        mysql_query("DELETE FROM `images` WHERE galleryid = '$galleryid'");

        //THEN FINALLY DELETE THE GALLERY ALSO.
        mysql_query("DELETE FROM `galleries` WHERE id = '$galleryid'");
        
        echo "Gallery '$name' deleted. <br>";

     }
  }   

  
  //AND ATLAST DELETE THE MEMBER ALSO !
  if(mysql_query("DELETE FROM `members` WHERE id = '$id'"))
      echo "<b>Member deleted successfully !</b>";
  else
      echo "<b>The member could not be deleted due to some reason !</b>";
  
  echo "<br><br>";
}

//*******************************************************************************
echo "</font>";


echo "<br><br>";

echo "<center><form action='members.php' method='POST'>";
echo "Enter Username: <input type=text name='member' size=40>";
echo "&nbsp; &nbsp;<input type=submit value='View Details'></form></font></center><br>";

echo "<font size=2 face=arial color=maroon>";

$q = "SELECT * FROM `members` ORDER BY id DESC";
if(!($result_set = mysql_query($q))) die(mysql_error());
$number = mysql_num_rows($result_set);



if ($number) {

  while ($row = mysql_fetch_array($result_set)) 
  {
     $mid[] = $row['id'];
     $musername[] = $row['username'];
     $mpassword[] = $row['password'];
     $muserpass[] = $row['userpass'];
     $memail[] = $row['email'];
     
  }

  
  $max_show = 3;
         
  if (isset($_GET["page"]))
     $page = $_GET["page"];   
  else
     $page = 1;


  
  $from2 = $page * $max_show;
  if ($from2 > $number)
  {
      $diff = $number % $max_show;
      $from2 = $number;
      $from1 = $from2 - $diff;
  }     
  else
      $from1 = $from2 - $max_show;


  echo "<table width=100% style='FONT-SIZE: 12px;'><tr height=50>";
  echo "<td> <b><u>Username</u></b></td> 
        <td> <b><u>Password</u></b></td>  
        <td> <b><u>User Password</u></b></td>
        <td> <b><u>Email</u></b></td>
        <td> <b><u>Action</u></b></td></tr>";


  for ($i=$from1; $i < $from2; $i++) {
     
       echo "<tr>";  
       echo "<td>{$musername[$i]}</td>
        <td> {$mpassword[$i]}</td>
        <td> {$muserpass[$i]}</td>
        <td> {$memail[$i]}</td>
        <td>  <a href=\"members.php?delete={$mid[$i]}\">Delete</a></b></td>";
       echo "</tr>";        

  }

  echo "</tr></table>";
  
  

  //SHOW THE NEXT AND PREVIOUS LINKS IN A TABLE (IF REQUIRED)
  echo "<br><br><table width='100%'><tr>";
  echo "<td align='right' width='50%'>&nbsp;";

  if ($from1 > 0)
  {
     $previous = $page - 1;
     echo "<a href='members.php?page=$previous'><< Previous Page</a>";
  } echo "</td>";


  echo "<td align=left width=50%>&nbsp;&nbsp;&nbsp;";
  if ($from2 < $number)
  {
     $next = $page + 1;
     echo "<a href='members.php?page=$next'>Next Page >></a>";
  } echo "</td></tr></table>";

  
  
}
else 
  echo "No user has joined yet.";

?>

<br><br>


</font>

</body>
</html>




