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
          <style>
                table, th, td {
                    border: 1px solid white;
                    border-collapse: collapse;
                }
                th, td {
                    background-color: #96D4D4;
                }
          </style>
     </head>
     <body>
        <?php

            $pracownik = new Pracownik();

            $pracownik->naglowek();
            
            $pracownik->sprawdzenie_towaru();

            #echo '<h2>Coś jest nie tak</h2>';
            #$towar = $_POST['towar'];
  /*          
echo<<<END
            <h2>Podsumowanie</h2>
            <table>
            <tr>
              <th>Towar</th>
              <th>Ilość</th>
            </tr>
            <tr>
              <td>$towar</td>
              <td>ILOSCCCC</td>
            </tr>
          </table> 
            <br/>
            

            <br/><a href="index.php">Ponownie sprawdź dostępność towaru</a>
END;  */
        ?>
     </body>
</html>