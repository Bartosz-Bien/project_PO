<HTML>
  <HEAD>
    <TITLE>
      Klient
    </TITLE>
  </HEAD>

  <BODY>

    <?php
      include 'klient_php.php';

      //jesli klient jest dowolny - anonimowy
      $obj = new Klient();

      // jesli klient ma byc okreslony, choc w tym pliku to raczej niepotrzebne, chyba ze klient chce sprawdzic stan konta, potrzebne to w czesci pracownika
      // gdzie jest placenie za towar, faktura, dodanie klienta i usuniecie, tam musi byc konkretny klient
      $id = zwroc_id_klienta();
      $obj = new Klient($id); // przemyslec jeszcze konstruktor

      // po stworzeniu obiektu, wywolywane potrzebne metody, przeplataja sie z print''; z kodem html w srodku
    ?>

  </BODY>
</HTML>