<?php

session_start(); # if we want a global associative array $_SESSION up and running, we have to include this line at the beginning of a file

if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == true)
{
    header('Location: gra.php'); # go to gra.php , it is not an instant redirection to gra.php, that's why we have 'exit()' below
    exit();
}

?>

<!doctype html>
<html>
     <head>
          <meta charset="UTF-8" />
          <title>Strona główna</title>
     </head>
     <body>

        Strona logowania dla pracowników <br/><br/>

        <form action="zaloguj.php" method="post"> <!-- input from this form goes to zaloguj.php -->

            Login: <br/> <input type="text" name="login" /> <br/>
            Hasło: <br/> <input type="password" name="haslo" /> <br/><br/>
            <input type="submit" value="Zaloguj się" />

        </form>

         <?php

            if(isset($_SESSION['blad'])) echo $_SESSION['blad'];            

         ?>
     </body>
</html>