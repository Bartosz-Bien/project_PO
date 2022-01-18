<?php

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
            // echo 'zaplac';
            // uzytkownik podchodzi do pracownika i pyta czy moze zaplacic dlug wzgledem sklepu
            // 1. program sprawdza w bazie dlug uzytkownika (ale tylko firma moze placic po czasie) o tym nip/adresie/etc i wyswietla
            // 2. pracownik wprowadza splacona kwote
            // 3. program odejmuje od dlugu (zmienna w metodzie) kwote i aktualizuje rekord w tabeli 'klienci' o tym id
            // 4. koniec - klient odchodzi

            $mysqli = mysqli_connect("localhost", "root", "", "po");
            $sql = "SELECT * FROM zamowienie";       
            $rez = mysqli_query($mysqli, $sql); 
				
            print '<form style="margin-top: 0%;" method="POST">';
            print '<select style="width: 300px;" name="er">';
            print '<option> -- Wybierz zamówienie z listy -- </option>';
            while ($row = mysqli_fetch_array($rez))
            {
                echo "<option> $row[ID_zamowienia] | $row[ID_klienta_zam] | $row[ID_towaru_zam] | $row[Dlug] </option>";
            }
            print '</select>';	
            //print '<br><br><button style="margin-left: 30%" type="submit" name="save">POTWIERDŹ </button>';
            
            print '<p>Wpisz kwotę do zapłaty:</p>';
            print '<input type="number" name="dl" placeholder="Kwota zaplacona"/><br><br>';
            print '<br><br><input style="margin-left: 25%;" type="submit" name="save"/>';
            print '</form>';
            mysqli_free_result($rez);

            if(isset($_POST['save']))
            {
                $id = $_POST['er'];
                $kwota = $_POST['dl'];
                $id = $id[0];

                $sql_2 = "SELECT Dlug FROM zamowienie WHERE $id=ID_zamowienia";
                $rez_2 = mysqli_query($mysqli, $sql_2); 
                $row_2 = mysqli_fetch_array($rez_2);

                $kwota = $row_2['Dlug'] - $kwota;

                $sql_3 = "UPDATE zamowienie SET Dlug = $kwota WHERE ID_zamowienia=$id";
                mysqli_query($mysqli, $sql_3);
            }
              

        }

        public static function sprawdzenie()
        {                
            $tow = $_GET['pr'];
            $il = $_GET['il'];
            
            $mysqli = mysqli_connect("localhost", "root", "", "po");
            $sql_amount = "SELECT Ilosc from towary WHERE ID_towaru=$il;";
            $amount = mysqli_query($mysqli, $sql_amount); 
            $am = mysqli_fetch_array($amount);
            $am = $am['Ilosc'];

            // echo $am;

            if ($am < $il)
            {
                $link = "zam_sprawdzenie.html?" . "tow=" . $tow . "&il=" . $il . "&a=" . $am;
                header('Location:' . $link);
                return false;
            }
            return true;
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
                 self::sprawdzenie();
                
                $cena = $_GET['dl'];
                $tow = $_GET['pr'];
                $kl = $_GET['id_kl'];
                $il = $_GET['il'];
                echo $il;
                
                $sql_add = "INSERT INTO zamowienie (ID_zamowienia, ID_klienta_zam, ID_towaru_zam, Dlug, Ilosc) VALUES (NULL, $kl, $tow, $cena, $il);";
                mysqli_query($mysqli, $sql_add); 
                
            }


            mysqli_free_result($rez);
        }


        public function otrzymanie_dokumentu_potwierdzajacego() // w czesci pracownika, na kasie, ale klasa klient
        {
            
            print '<form method="POST">';
            print '<p>Numer klienta::</p>';
            print '<input type="number" name="id_kl" placeholder="ID klienta"/><br><br>';
            print '<br><br><input style="margin-left: 25%;" type="submit" name="yes" value="Generuj dokument"/>';
            print '</form>';

            if(isset($_POST['id_kl']))
            {
                $id = $_POST['id_kl'];

                // $nazwa_pl = $id . "_" . date("c");
                // $pl = fopen("$nazwa_pl", "w");

                $nagl = "Nazwa firmy<br>Adres1<br>Adres2<br>=============<br>NIEFISKALNY<br>=============<br><br>";
                echo $nagl;
                // fwrite($pl, $nagl);
                $mysqli = mysqli_connect("localhost", "root", "", "po");
                $sql_echo = "SELECT zamowienie.ID_zamowienia, towary.Nazwa_towaru, zamowienie.Dlug, zamowienie.Ilosc FROM zamowienie INNER JOIN towary ON towary.ID_towaru=zamowienie.ID_towaru_zam WHERE zamowienie.ID_klienta_zam=$id;";
                $cont = mysqli_query($mysqli, $sql_echo); 
                print '<p>ID: Nazwa towaru: Koszt: Ilosc</p>';
                // fwrite($pl, "ID: Nazwa towaru: Koszt: Ilosc");
                while ($row = mysqli_fetch_array($cont))
                {
                    print "<p>$row[ID_zamowienia]: $row[Nazwa_towaru]: $row[Dlug]: $row[Ilosc]</p>";
                    // fwrite($pl, "$row[ID_zamowienia]: $row[Nazwa_towaru]: $row[Dlug]: $row[Ilosc]");
                }
                $ftr = "<br>=============<br>" .  date("c") . "<br>";
                echo $ftr;


            }
        }
    }
?>
