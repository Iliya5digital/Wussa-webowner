<?php

if (isset($_SESSION["imagehost-admin"])) {
  
  $password1 = $_SESSION["imagehost-admin"];
  if ($password != $password1) {
    session_destroy();
    die("Вы должны войти!");
  }

}
else
  die("Вы должны войти!");


?>
  