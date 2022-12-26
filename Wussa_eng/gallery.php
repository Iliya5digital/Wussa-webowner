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
   
 
<!-- ######################################################################################### --> 


<?php


if (isset($_POST["password"]))  {

  $id = $_POST["id"];
        
  $q = "SELECT * FROM `galleries` WHERE id = '$id'";
  if(!($result_set = mysql_query($q))) die(mysql_error());
  $number = mysql_num_rows($result_set);
  
  if ($number) {

     $row = mysql_fetch_array($result_set);
  
     $imguserid = $row['userid'];
     $r = mysql_query("SELECT userpass FROM `members` WHERE id = '$imguserid'");   
     $row1 = mysql_fetch_row($r);
     $userpass = $row1[0];

     if ($_POST["password"] != $userpass)
        echo "Sorry ! You have specified an invalid password.";
     else {
        show();
        $_SESSION['gallery' . $id] = "true";
     }
          
  }

}
else  {  //*******************************************************************************************

if ((isset($_GET["id"])) && (trim($_GET["id"]) != "")) {

 $id = $_GET["id"];
        
 $q = "SELECT * FROM `galleries` WHERE id = '$id'";
 if(!($result_set = mysql_query($q))) die(mysql_error());
 $number = mysql_num_rows($result_set);

 if ($number) {
  $row = mysql_fetch_array($result_set);
  
  if ($row['type'] == "private") {
  
     if ($row['userid'] != $userid) {
        echo "This gallery is private. Please enter the password in order to view it<br><br>";
        echo "<form action='gallery.php' method='POST'>Password: <input type='password' name='password' maxlength='30'>";
        echo "<input type='hidden' name='id' value='$id'>";
        echo "&nbsp; &nbsp; <input type='submit' value='View Gallery'></form>";
     }
     else show();

  }
  else
     show();

 }
 else 
   echo "Sorry ! You have specified an invalid id.";

}
else
  echo "Please specify a gallery id to show !";


} //ENDING ELSE OF if(isset($_POST["password"]))



//*************************************************************************************************************

function show() {

  global $id;
  $result = mysql_query("SELECT * FROM `galleries` WHERE id = '$id'");
  $row1 = mysql_fetch_array($result);
  $type = $row1['type'];
  $name = $row1['name'];

  $result = mysql_query("SELECT * FROM `images` WHERE galleryid = '$id'");
  $number = mysql_num_rows($result);   
 
  echo "<center><br><h1>Gallery: \"$name\"</h1>";
  echo "<br><LABEL id='title'>Type:</LABEL> $type<br>";

  if ($number) {
    echo "There are '$number' images in this gallery.<br><br><br>";    
    echo "<table><tr>";
    $x = -1;
    while ($row = mysql_fetch_array($result)) {

      $x++;
      if (($x % 5) == 0) echo "</tr><tr>";
 
      echo "<td align=center>
            <a href='show-image.php?id={$row['id']}'>
            <img src='thumb.php?id={$row['id']}'> </a> 
            <br><LABEL id='title'>Views:</LABEL> {$row['views']} </td>";

    }
    echo "</tr></table>";
    echo "</center>";
  }
  else
    echo "<br><br><center><LABEL id='title'>There are no images in this gallery !</LABEL></center>";

}


?>
       
<!-- ######################################################################################### -->


<?php  include("footer.php"); ?>


</div>
</center>
</body>
</html>