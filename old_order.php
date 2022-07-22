<!doctype html>
<html>
     <head>
          <meta charset="UTF-8" />
          <title>Hurtownia</title>
     </head>
     <body>
        <?php

            $paczki = $_POST['paczkow'];
            $grzebienie = $_POST['grzebieni'];
echo<<<END
            <h2>Podsumowanie</h2>
            Pączek $paczki
            <br/>
            Grzebień $grzebienie

            <br/><a href="index.php">Powrót do strony głównej</a>
END;
        ?>
     </body>
</html>