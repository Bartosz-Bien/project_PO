<?php

session_start(); # if we want a global associative array $_SESSION up and running, we have to include this line at the beginning of a file

if(!isset($_SESSION['zalogowany']))
{
    header('Location: index.php');
    exit();
}

include 'pracownik.php';

?>

<!doctype html>
<html>
     <head>
          <meta charset="UTF-8" />
          <title>Hurtownia</title>
     </head>
     <body>


         <?php
            $pracownik = new Pracownik();
            
            $pracownik->naglowek();

            $pracownik->order();
         ?>
        

     </body>
</html>