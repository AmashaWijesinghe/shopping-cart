<?php

@include 'config.php';

session_start();

if(!isset($_SESSION['user_name'])){
   header('location:login.php');
}



?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>admin</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>



   <?php include 'head.php'; ?>

   <h3 style="font-size: 150px;color:darkblue;text-align:center" >WELCOME</h3>

    <script src="script.js"></script>

  </body>
</html>
