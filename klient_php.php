<?php

<<<<<<< Updated upstream
    function zwroc_id_klienta()
    {
        // tu jest zapytanie w bazie danych, ktore zwroci id klienta, potem w pliku .php obok tworzy sie obiekt klasy 'klient_ind/firma' o tych polach, co ma ten rekord w bazie
        return $id;
=======
    // function zwroc_id_klienta()
    // {
    //     // tu jest zapytanie w bazie danych, ktore zwroci id klienta, potem w pliku .php obok tworzy sie obiekt klasy 'klient_ind/firma' o tych polach, co ma ten rekord w bazie
    //     return $id;
    // }

    function pokaz_klient($rez)
    {
        print '<table style="margin-top: 0%; margin-left: 0%; width: 80%" align="center" style="border: 5px solid #006994;border-collapse:collapse;">';
        print '<tr style="background-color:#878787";><td style="width:40px;">Id</td><td>NIP</td><td>Nazwa</td><td>Ulica</td><td>Numer domu</td><td>Numer mieszkania</td><td>Kod pocztowy</td><td>Poczta</td><td>Kraj</td></tr>';

        while ($newArray = mysqli_fetch_array($rez, MYSQLI_ASSOC))
        {
            print '<tr>';
            print '<td>'; echo $newArray['ID_klienta']; echo " "; print '</td>';
            print '<td>'; echo $newArray['NIP']; echo " "; print '</td>';
            print '<td>'; echo $newArray['Nazwa']; echo " "; print '</td>';
            print '<td>'; echo $newArray['Ulica']; echo " "; print '</td>';
            print '<td>'; echo $newArray['Numer_domu']; echo " "; print '</td>';
            print '<td>'; echo $newArray['Numer_mieszkania']; echo " "; print '</td>';
            print '<td>'; echo $newArray['Kod_pocztowy']; echo " "; print '</td>';
            print '<td>'; echo $newArray['Poczta']; echo " "; print '</td>';
            print '<td>'; echo $newArray['Kraj']; echo " "; print '</td>';
            print '</tr>';
        }
        print '</table>';
        print '<br><br><br><br><br>';
>>>>>>> Stashed changes
    }

    class Klient // po kliencie dziedzicza klasy 'firma' i 'klient indywidulany'
    {
<<<<<<< Updated upstream
        protected $adres;
=======
        // singleton stuff
        private static $instnces = [];
        public static function get_instance(): Klient
        {
            $cls = static::class;
            if (!isset(self::$instnces[$cls]))
            {
                self::$instnces[$cls] = new static();
            }

            return self::$instnces[$cls];
        }

        // my fields
        protected static $adres;


        // my methods
        // public function dodaj_do_bazy() zrealizowane poniżej
        // {

        // }
>>>>>>> Stashed changes

        public function zaplac() // do implementacji w czesci pracownika - pracownik anuluje dlug, ale klasa klient
        {
            echo 'zaplac';
            // uzytkownik podchodzi do pracownika i pyta czy moze zaplacic dlug wzgledem sklepu
            // 1. program sprawdza w bazie dlug uzytkownika (ale tylko firma moze placic po czasie) o tym nip/adresie/etc i wyswietla
            // 2. pracownik wprowadza splacona kwote
            // 3. program odejmuje od dlugu (zmienna w metodzie) kwote i aktualizuje rekord w tabeli 'klienci' o tym id
            // 4. koniec - klient odchodzi
        }

<<<<<<< Updated upstream
        public function czy_w_bazie() // czy jest sens tej metody? moze lista rozwijalna, wyszukiwarka sql %like%, etc
        {

=======
        public function czy_w_bazie() //  moze lista rozwijalna - nie, wyszukiwarka sql %like% - ok, etc
        {            
            $fraza = $_POST['szuk'];
            
            $mysqli = mysqli_connect("localhost", "root", "", "po");
            $sql = "SELECT *
                    FROM klient     
                    WHERE klient.Nazwa LIKE '%$fraza%'
                    ORDER BY klient.Nazwa ASC";

            $rez = mysqli_query($mysqli, $sql);				
            pokaz_klient($rez);
            mysqli_free_result($rez);				
            mysqli_close($mysqli);	
        }

        public function usun()
        {
            $mysqli = mysqli_connect("localhost", "root", "", "po");					
            $sql = "SELECT ID_klienta, Nazwa FROM klient ORDER BY Nazwa ASC";					
            $rez = mysqli_query($mysqli, $sql);
    
            print '<form style="margin-top: 0%;" method="POST">';
            print '<select name="er">';
            print '<option> -- Wybierz czytelnika z listy -- </option>';
            while ($row = mysqli_fetch_array($rez))
            {
                echo "<option> $row[ID_klienta] | $row[Nazwa] </option>";
            }
            print '</select>';	
            print '<br><br><input style="margin-left: 25%;" type="submit" name="save"/>';
            print '</form>';
            mysqli_free_result($rez);

            if (isset($_POST['save']))
			{
                echo "Usunięto:<br>" . $_POST['er'];

                $sql_erase = $_POST['er'];
                $sql = "DELETE FROM klient WHERE klient.ID_klienta=$sql_erase[0]*1000+$sql_erase[1]*100+$sql_erase[2]*10+$sql_erase[3]";					
                mysqli_query($mysqli, $sql);

                header("Refresh:3");
            }
>>>>>>> Stashed changes
        }

        public function skompletuj_zamowienie() // raczej w czesci klienta - klient podchodzi i z listy wybiera co chce i dodaje do koszyka jakby, potem przy kasie odbiera lub korzysta z wyszukiwarki obiektow na sklepie
        {

        }

       // public function przejrzyj_wszytskie_towary() // przeniesienie metody do klasy 'towar', ale wywolana w czesci klienta
       // {
       //
       // }

        public function otrzymanie_dokumentu_potwierdzajacego() // w czesci pracownika, na kasie, ale klasa klient
        {

        }
<<<<<<< Updated upstream



    }

=======
    }

    class Klient_indywidualny extends Klient
    {
        private static $imie;
        private static $nazwisko;   
        
        function dodaj()
        {
            // dodanie do bazy
            $nazwa = $_POST['imie'] . " " . $_POST['nazwisko'];
            $ulica = $_POST['ulica'];
            $nr_domu = $_POST['nr_domu'];
            $nr_mieszk = $_POST['nr_miesz'];
            $kod = $_POST['kod'];
            $poczta = $_POST['poczta'];
            $kraj = $_POST['kraj'];

            $mysqli = mysqli_connect("localhost", "root", "", "po");
            $sql = "INSERT INTO `klient` (`ID_klienta`, `NIP`, `Nazwa`, `Ulica`, `Numer_domu`, `Numer_mieszkania`, `Kod_pocztowy`, `Poczta`, `Kraj`)
                    VALUES (NULL, 0, '$nazwa', '$ulica', '$nr_domu', '$nr_mieszk', '$kod', '$poczta', '$kraj');";       
            $rez = mysqli_query($mysqli, $sql); 
        }

        function form()
        {
          print '<form method="POST">';
            print '<input type="text" name="imie" placeholder="Imię"/><br><br>';
            print '<input type="text" name="nazwisko" placeholder ="Nazwisko"/><br><br>';
            print '<input type="text" name="ulica" placeholder ="Ulica"/><br><br>';
            print '<input type="text" name="nr_domu" placeholder ="Numer domu"/><br><br>';
            print '<input type="text" name="nr_miesz" placeholder ="Numer mieszkania"/><br><br>';
            print '<input type="text" name="kod" placeholder ="Kod pocztowy"/><br><br>';
            print '<input type="text" name="poczta" placeholder ="Poczta"/><br><br>';
            print '<input type="text" name="kraj" placeholder ="Kraj"/><br><br>';
            print '<input style="margin-left: 10%;" type="submit" name="submit_ind"/>';
          print '</form>';
        }
    }

    class Firma extends Klient
    {
        private static $nip;
        private static $nazwa_firmy;

        function dodaj()
        {
            // dodanie do bazy
            $nip = $_POST['nip'];
            $nazwa = $_POST['nazwa'];
            $ulica = $_POST['ulica'];
            $nr_domu = $_POST['nr_domu'];
            $nr_mieszk = $_POST['nr_miesz'];
            $kod = $_POST['kod'];
            $poczta = $_POST['poczta'];
            $kraj = $_POST['kraj'];

            $mysqli = mysqli_connect("localhost", "root", "", "po");
            $sql = "INSERT INTO `klient` (`ID_klienta`, `NIP`, `Nazwa`, `Ulica`, `Numer_domu`, `Numer_mieszkania`, `Kod_pocztowy`, `Poczta`, `Kraj`)
                    VALUES (NULL, $nip, '$nazwa', '$ulica', '$nr_domu', '$nr_mieszk', '$kod', '$poczta', '$kraj');";       
            $rez = mysqli_query($mysqli, $sql); 
        }

        function form()
        {
          print '<form action="#" method="POST">';
            print '<input type="text" name="nip" placeholder="NIP"/><br><br>';
            print '<textarea name="nazwa" rows="5" cols="40" placeholder ="Nazwa firmy"></textarea><br><br>';
            print '<input type="text" name="ulica" placeholder ="Ulica"/><br><br>';
            print '<input type="text" name="nr_domu" placeholder ="Numer domu"/><br><br>';
            print '<input type="text" name="nr_miesz" placeholder ="Numer mieszkania"/><br><br>';
            print '<input type="text" name="kod" placeholder ="Kod pocztowy"/><br><br>';
            print '<input type="text" name="poczta" placeholder ="Poczta"/><br><br>';
            print '<input type="text" name="kraj" placeholder ="Kraj"/><br><br>';
            print '<input style="margin-left: 10%;" type="submit" name="submit_fir"/>';
          print '</form>';
        }
    }
>>>>>>> Stashed changes

?>