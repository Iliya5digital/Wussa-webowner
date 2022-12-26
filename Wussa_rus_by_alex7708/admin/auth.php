<?

//#############Перевод на русский язык alex7708############################################

//DESCRIPTION:
//This script authenticates the user n checks if the password is correct or not !
//If it is correct then it redirects the administrator to the main panel.
//And also sets the cookie with the name of sabpk containing the password..
//Errors are also checked here but they are handled in the index.php where the login form is shown !
                          
//########################################################################################################

session_start();
include("loadsettings.inc.php");


$password1 = trim($_POST['pass']);
if ($password1 == "") 
{
 echo "<meta http-equiv=\"refresh\" content=\"0; url='index.php?error=empty'\" />";
 die();
}


if ($password == $password1)
{
 $_SESSION["imagehost-admin"] = $password;
 echo "<meta http-equiv=\"refresh\" content=\"0; url='panel.php'\" />";
}
else echo "<meta http-equiv=\"refresh\" content=\"0; url='index.php?error=invalid'\" />";


?>