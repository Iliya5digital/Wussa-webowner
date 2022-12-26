<?php
 $page = basename($_SERVER['PHP_SELF']);
?>


<div style="BACKGROUND: #42679c; TEXT-ALIGN: center">
<div class="header-top">

<? if ($session == false) { ?>

<form action="login.php" method="POST">

<table align="right">
<tr>
 <td><font face="arial" size="2" color="white"><b> Логин: <input type="text" name="username" size=18> </td>
 <td>&nbsp;<font face="arial" size="2" color="white"><b> Пароль: <input type="password" name="password" size=18> </td>
 <td><input type="submit" value="Login" name="login"> </td>
 <td width=100> <center><a href="register.php" title="Нажмите здесь чтобы зарегистрироваться!">
 <img src="images/join.gif" border=0 onmouseover="this.src='images/join1.png';" onmouseout="this.src='images/join.gif';">
 </a> </center></td>
</tr>
</table>
</form> 

<? 
} 
else {

echo "<table width=100% style='FONT-SIZE: 14px; COLOR: white'>
       <tr>
         
        <td align=left style='PADDING-TOP: 5px;'>
          <a href='myimages.php'>Мои изображения</a> &nbsp; &nbsp;  | &nbsp; &nbsp; 
          <a href='mygalleries.php'>Мои галереи</a> &nbsp; &nbsp;  | &nbsp; &nbsp;
          <a href='myfavourites.php'>Мои избранные</a>
       </td>

        <td align=right style='PADDING-TOP: 5px;'>
           <b>Добро пожаловать $username ! &nbsp;&nbsp;
           | &nbsp;&nbsp;<a href='account.php?act=logout' style='FONT-SIZE: 14px'>Выйти</a>
           </b></td>
        
       </tr></table>";

}

?>

</div>
</div>



<div style="BACKGROUND: #edf7fd">
<div style="BACKGROUND: #edf7fd; WIDTH: 960px">

 <div style="MARGIN-LEFT: 12px">
    
    <table style="BORDER-COLLAPSE: collapse;"><tr>
     <td> <img src="images/logo.png"></td>
     <td width=25> &nbsp;</td>
     
     <td valign=bottom><div class="header-menu" <? if ($page == "index.php") echo "id=\"current\""; ?> > 
       <a href="index.php"><b>Главная</b></a>
     </div></td> 
     
     <td valign=bottom><div class="header-menu" <? if ($page == "images.php") echo "id=\"current\""; ?> > 
       <a href="images.php"><b>Изображения</b></a>
     </div></td> 
     
     
     <? if ($session == false) { ?>
     <td valign=bottom><div class="header-menu" <? if ($page == "login.php") echo "id=\"current\""; ?> > 
       <a href="login.php"><b>Войти</b></a>
     </div></td> 
      
     <td valign=bottom><div class="header-menu" <? if ($page == "register.php") echo "id=\"current\""; ?> > 
       <a href="register.php"><b>Регистрация</b></a>
     </div></td> 
     
     <? } else { ?>
      
     <td valign=bottom><div class="header-menu" <? if ($page == "account.php") echo "id=\"current\""; ?> > 
       <a href="account.php"><b>Мой аккаунт</b></a>
     </div></td> 
     
     <? } ?>       


        
    </tr>
   </table>

 </div> 

</div>
</div>
