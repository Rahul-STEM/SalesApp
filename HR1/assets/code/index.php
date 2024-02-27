<?php  
   session_start();  
   include_once ("class.php");  
   $user = new User;  
   $id = $_SESSION['id'];  
   if (!$user->session()){  
      header("location:login.php");  
   }  
   if (isset($_REQUEST['q'])){  
      $user->logout();  
      header("location:login.php");  
   }  
?>  
    <html>  
  
    <head>  
        <title>Dashboard</title>  
        <link rel="stylesheet" href="style.css" />  
    </head>  
  
    <body>  
        <div class="form">  
            <h1>Welcome <?php $user->fullname($id);?></h1>  
            <p align="right"><a href="?q=logout">LOGOUT</a></p>  
        </div>  
    </body>  
  
    </html> 