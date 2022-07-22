<!doctype html>
<html>
     <head>
          <meta charset="UTF-8" />
          <title>Hurtownia</title>
     </head>
     <body>

        <h1>Zamówienie online</h1>
        <form action="order.php" method="post"> <!--data from input will go to order.php -->
            Ile pączków (0.99 PLN/szt):
            <input type="text" name="paczkow"/>
            <br/><br/>
            Ile grzebieni (1.29 PLN/szt):
            <input type="text" name="grzebieni"/>
            <br/><br/>
            <input type="submit" value="Wyślij"/>
        </form>

         <?php

            /*
            $imie = "Joanna";

            echo '<br><br>'."$imie, witaj na stronie!";
            echo $imie.', welcome to our website!';
            echo $imie.", welcome to our website!";

            echo "Hello world!";
            */
         ?>
     </body>
</html>