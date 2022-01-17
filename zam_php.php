<?php

    // function pokaz_klient($rez)
    // {
    //     print '<table style="margin-top: 0%; margin-left: 0%; width: 80%" align="center" style="border: 5px solid #006994;border-collapse:collapse;">';
    //     print '<tr style="background-color:#878787";><td style="width:40px;">Id</td><td>NIP</td><td>Nazwa</td><td>Ulica</td><td>Numer domu</td><td>Numer mieszkania</td><td>Kod pocztowy</td><td>Poczta</td><td>Kraj</td></tr>';

    //     while ($newArray = mysqli_fetch_array($rez, MYSQLI_ASSOC))
    //     {
    //         print '<tr>';
    //         print '<td>'; echo $newArray['ID_klienta']; echo " "; print '</td>';
    //         print '<td>'; echo $newArray['NIP']; echo " "; print '</td>';
    //         print '<td>'; echo $newArray['Nazwa']; echo " "; print '</td>';
    //         print '<td>'; echo $newArray['Ulica']; echo " "; print '</td>';
    //         print '<td>'; echo $newArray['Numer_domu']; echo " "; print '</td>';
    //         print '<td>'; echo $newArray['Numer_mieszkania']; echo " "; print '</td>';
    //         print '<td>'; echo $newArray['Kod_pocztowy']; echo " "; print '</td>';
    //         print '<td>'; echo $newArray['Poczta']; echo " "; print '</td>';
    //         print '<td>'; echo $newArray['Kraj']; echo " "; print '</td>';
    //         print '</tr>';
    //     }
    //     print '</table>';
    //     print '<br><br><br><br><br>';
    // }

    class Zamowienie 
    {
        // singleton stuff
        private static $instnces = [];
        public static function get_instance(): Zamowienie
        {
            $cls = static::class;
            if (!isset(self::$instnces[$cls]))
            {
                self::$instnces[$cls] = new static();
            }

            return self::$instnces[$cls];
        }


        public function zaplac() // do implementacji w czesci pracownika - pracownik anuluje dlug, ale klasa zamowienie
        {
            echo 'zaplac';
            // uzytkownik podchodzi do pracownika i pyta czy moze zaplacic dlug wzgledem sklepu
            // 1. program sprawdza w bazie dlug uzytkownika (ale tylko firma moze placic po czasie) o tym nip/adresie/etc i wyswietla
            // 2. pracownik wprowadza splacona kwote
            // 3. program odejmuje od dlugu (zmienna w metodzie) kwote i aktualizuje rekord w tabeli 'klienci' o tym id
            // 4. koniec - klient odchodzi
        }

        public function usun() // powiazane z zaplac()
        {
            // $mysqli = mysqli_connect("localhost", "root", "", "po");					
            // $sql = "SELECT ID_klienta, Nazwa FROM klient ORDER BY Nazwa ASC";					
            // $rez = mysqli_query($mysqli, $sql);
    
            // print '<form style="margin-top: 0%;" method="POST">';
            // print '<select name="er">';
            // print '<option> -- Wybierz konto z listy -- </option>';
            // while ($row = mysqli_fetch_array($rez))
            // {
            //     echo "<option> $row[ID_klienta] | $row[Nazwa] </option>";
            // }
            // print '</select>';	
            // print '<br><br><input style="margin-left: 25%;" type="submit" name="save"/>';
            // print '</form>';
            // mysqli_free_result($rez);

            // if (isset($_POST['save']))
			// {
            //     echo "Usunięto:<br>" . $_POST['er'];

            //     $sql_erase = $_POST['er'];
            //     $sql = "DELETE FROM klient WHERE klient.ID_klienta=$sql_erase[0]*1000+$sql_erase[1]*100+$sql_erase[2]*10+$sql_erase[3]";					
            //     mysqli_query($mysqli, $sql);

            //     header("Refresh:3");
            // }
        }


        public function skompletuj_zamowienie() // NIEEE, pracownik: raczej w czesci klienta - klient podchodzi i z listy wybiera co chce i dodaje do koszyka jakby, potem przy kasie odbiera lub korzysta z wyszukiwarki obiektow na sklepie
        {
            $mysqli = mysqli_connect("localhost", "root", "", "po");
            $sql = "SELECT ID_towaru, Nazwa_towaru FROM towary ORDER BY Nazwa_towaru";       
            $rez = mysqli_query($mysqli, $sql); 

            print '<form method="POST">';
            while ($row = mysqli_fetch_array($rez))
            {
                 print "<input type='radio' id='towary' name='towar' value='$row[ID_towaru]' />$row[ID_towaru]: $row[Nazwa_towaru]<br>";
            }
            
            print '<p> Podaj ilosc:</p>';
            print '<input type="number" name="ilosc" placeholder="Ilość"/><br><br>';
            print '<p> Id klienta:</p>';
            print '<input type="number" name="id_kl" placeholder="ID"/><br><br>';
            print '<br><br><input style="margin-left: 25%;" type="submit" name="save_2"/>';
            print '</form>';                

        
            if(isset($_POST['towar']))
            {
                $towary = $_POST['towar'];
                $sql_2 = "SELECT Cena_sprzedazy_netto_zl FROM towary WHERE ID_towaru = '$towary';";       
                $rez_2 = mysqli_query($mysqli, $sql_2); 
                $row_2 = mysqli_fetch_array($rez_2);
            }


            if(isset($_POST['save_2']))
            {
                $il = $_POST['ilosc'];
                $kl = $_POST['id_kl'];

                $cena = $il * $row_2['Cena_sprzedazy_netto_zl'];

                $sql_dl = "SELECT Dlug FROM Zamowienie WHERE ID_klienta = 1";       
                $rez_dl = mysqli_query($mysqli, $sql_dl); 
                if ($rez_dl == NULL){$rez_dl = 0;}

               print '<form method="GET">';
               print '<p>Numer klienta::</p>';
               print '<input type="number" name="id_kl" placeholder="ID" value="'.$kl.'" readonly/><br><br>';
               print '<p>Wybrana ilosc:</p>';
               print '<input type="number" name="il" placeholder="ID" value="'.$il.'" readonly/><br><br>';
               print '<p>ID towaru:</p>';
               print '<input type="number" name="pr" placeholder="ID" value="'.$towary.'" readonly/><br><br>';
               print '<p>Koszt kupna:</p>';
               print '<input type="number" name="dl" placeholder="ID" value="'.$cena.'" readonly/><br><br>';
               print '<br><br><input style="margin-left: 25%;" type="submit" name="kup"/>';
               print '<br><br><input style="margin-left: 25%;" type="submit" name="no" value="Nie kupuj"/>';
               print '</form>';
            }

            if (isset($_GET['kup']))
            {
                $cena = $_GET['dl'];
                $tow = $_GET['pr'];
                $kl = $_GET['id_kl'];
                $il = $_GET['il'];
                
                $sql_add = "INSERT INTO zamowienie (ID_zamowienia, ID_klienta_zam, ID_towaru_zam, Dlug) VALUES (NULL, $kl, $tow, $cena);";
                mysqli_query($mysqli, $sql_add); 
            }


            mysqli_free_result($rez);
        }

       // public function przejrzyj_wszytskie_towary() // przeniesienie metody do klasy 'towar', ale wywolana w czesci klienta
       // {
       //
       // }

        public function otrzymanie_dokumentu_potwierdzajacego() // w czesci pracownika, na kasie, ale klasa klient
        {

        }
    }
?>
