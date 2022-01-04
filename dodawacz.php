<?php
// nie dodawac tego pliku do koncowego programu, to tylko jedna z funkcjonalnosci, bedzie w pliku z klasa "towar"

function opis() // metodyka DRY
{
    print '<div style="margin-top:-22%;">';
    print '<p>Nazwa towaru </p>';
    print '<p>Ilosc        </p>';
    print '<p>Jednostka m. </p>';
    print '<p>Zakup netto  </p>';
    print '<p>Marża        </p>';
    print '<p>Podatek      </p>';
    print '</div>';
}


if (!(isset ($_GET['submit'])) And !(isset ($_GET['submit_2'])))
{
    print '<form style="margin-left: 10%;" action="#" method="get">';
    print '<input style="width: 200px;" type="text" name="Nazwa_towaru" placeholder="Nazwa towaru"/><br><br>';
    print '<input style="width: 200px;" type="number" step="0.001" min = 0 name="Ilosc" placeholder ="Ilość"/><br><br>';

    // =================================
    // lista rozwijalna dla jednstki miary
    $mysqli = mysqli_connect("localhost", "root", "", "sklad_budowlany");	
    $sql = "SELECT * FROM jednostki_miary";					
    $rez = mysqli_query($mysqli, $sql);
        print '<select style="width: 200px;" name="J_M">';
        print '<option> -- Wybierz jednostkę -- </option>';
        while ($row = mysqli_fetch_array($rez))
        {
            echo "<option> $row[ID_jednostki]. $row[Nazwa_jednostki_miary] ($row[Skrot_jednostki_miary])</option>";
        }
        print '</select><br><br>';
    mysqli_free_result($rez);	
    // ==================================
    print '<input style="width: 200px;" type="number" step="0.01" min = 0 name="Zakup_netto" placeholder ="Cena zakupu (netto)"/><br><br>';
    print '<input style="width: 200px;" type="number" step="0.01" min = 0 name="Marza" placeholder ="Marża [%]"/><br><br>';
    print '<input style="width: 200px;" type="number" min = 0 name="Podatek" placeholder ="Podatek [%]"/><br><br>';
    print '<br><br><input type="submit" name="submit"/>';
    print '</form>';

    // opis na lewo od forma
    print '<div style="margin-top: 3%;">';
    opis();
    print '</div>';
}

if (isset ($_GET['submit']))
{
    // (marza/100) = 1 - zakup/sprzedaz
    // zakup/sprzedaz = 1 - (marza/100)
    // sprzedaz = zakup / (1 - (marza/100))
    // 33 / (1 - 0,26) = 33 / 0,74 = 44,59...... OK
    $nazwa_towaru = $_GET['Nazwa_towaru'];
    $ilosc = $_GET['Ilosc'];
    $cena_netto_zakupu = $_GET['Zakup_netto'];
    $marza = $_GET['Marza'];
    $podatek = $_GET['Podatek'];
    $jednostka_miary = $_GET['J_M'];
    $cena_brutto_sprzedazy = ($cena_netto_zakupu / (1 - ($marza / 100))) * (1 + ($podatek / 100));

    print '<p>Cena brutto sprzedaży wyliczona:</p>';
    print '<p>' . $cena_brutto_sprzedazy . '</p>';
    print '<p>Wpisz swoją cenę brutto sprzedaży:</p>';
    
}

if (isset ($_GET['submit']))
{
    print '<form style="margin-left: 10%;" action="#" method="get">';
    print '<input type="text" name="Nazwa_towaru" value="'.$nazwa_towaru.'" readonly/><br><br>';
    print '<input type="number" name="Ilosc" value="'.$ilosc.'" readonly/><br><br>';
    print '<input type="text" name="J_M" value="'.$jednostka_miary.'" readonly/><br><br>';
    print '<input type="number" name="Zakup_netto" value="'.$cena_netto_zakupu.'" readonly/><br><br>';
    print '<input type="number" name="Marza" value="'.$marza.'" readonly/><br><br>';
    print '<input type="number" name="Podatek" value="'.$podatek.'" readonly/><br><br>';
    print '<input style="width: 200px;" type="number" step="0.01" min = 0 name="Sprzedaz_brutto" placeholder="Nowa cena brutto sprzedaży"/><br><br>';
    print '<br><br><input type="submit" name="submit_2"/>';
    print '</form>';
    opis();
}

if (isset ($_GET['submit_2']))
{
    $nazwa_towaru = $_GET['Nazwa_towaru'];
    $ilosc = $_GET['Ilosc'];
    $cena_netto_zakupu = $_GET['Zakup_netto'];
    $marza = $_GET['Marza'];
    $podatek = $_GET['Podatek'];
    $cena_brutto_sprzedazy = $_GET['Sprzedaz_brutto'];
    $jednostka_miary = $_GET['J_M'][0]*10 + $_GET['J_M'][1]; // uwaga na id
    $cena_netto_sprzedazy = $cena_brutto_sprzedazy / (1 + ($podatek / 100));
    $cena_netto_sprzedazy = round($cena_netto_sprzedazy, 2);

    // dodanie do bazy
    $mysqli = mysqli_connect("localhost", "root", "", "sklad_budowlany");	
    $sql = "INSERT INTO towary 
            (ID_towaru, Nazwa_towaru, Ilosc, J_m, Cena_zakupu_zl, Marza, Cena_sprzedazy_netto_zl, Cena_sprzedazy_brutto_zl, Podatek)
            VALUES
            (NULL, '$nazwa_towaru', $ilosc, $jednostka_miary, $cena_netto_zakupu, $marza, $cena_netto_sprzedazy, $cena_brutto_sprzedazy, $podatek)";					
    $rez = mysqli_query($mysqli, $sql);
    //mysqli_free_result($rez);	

   
    // info dla pracownika o dodaniu 
    print '<p>Dodano towar o nazwie ' . $nazwa_towaru . '<br>w ilości ' . $ilosc . '<br>w cenie netto zakupu ' . $cena_netto_zakupu . '<br>o marży ' . $marza . '<br> i podatku ' . $podatek . '</p>';
    print '<p>Uzupełniono o<br>cenę sprzedaży netto ' . $cena_netto_sprzedazy . '<br>cenę sprzedaży brutto ' . $cena_brutto_sprzedazy . '</p>';
    print '<p>ID jednostki: ' . $jednostka_miary . '</p>';

    // powrot i kolejna do dodania
    print '<br><br><a href="dodawacz.php">Powrót</a>';
}

?>