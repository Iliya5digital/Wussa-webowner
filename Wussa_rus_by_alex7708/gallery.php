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
        echo "�������� ������!";
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
        echo "��� ������ �������.������� ������ ��� ���������<br><br>";
        echo "<form action='gallery.php' method='POST'>������: <input type='password' name='password' maxlength='30'>";
        echo "<input type='hidden' name='id' value='$id'>";
        echo "&nbsp; &nbsp; <input type='submit' value='���������� �������'></form>";
     }
     else show();

  }
  else
     show();

 }
 else 
   echo "�������� ID!";

}
else
  echo "������� ID ������� ��� ���������!";


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
 
  echo "<center><br><h1>�������: \"$name\"</h1>";
  echo "<br><LABEL id='title'>���:</LABEL> $type<br>";

  if ($number) {
    echo "����� '$number' ����������� � ���� �������.<br><br><br>";    
    echo "<table><tr>";
    $x = -1;
    while ($row = mysql_fetch_array($result)) {

      $x++;
      if (($x % 5) == 0) echo "</tr><tr>";
 
      echo "<td align=center>
            <a href='show-image.php?id={$row['id']}'>
            <img src='thumb.php?id={$row['id']}'> </a> 
            <br><LABEL id='title'>����������:</LABEL> {$row['views']} </td>";

    }
    echo "</tr></table>";
    echo "</center>";
  }
  else
    echo "<br><br><center><LABEL id='title'>��� ����������� � ���� �������!</LABEL></center>";

}


?>
       
<!-- ######################################################################################### -->


<?php  include("footer.php"); ?>


</div>
</center>
</body>
</html>