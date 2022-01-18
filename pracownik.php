<?php

session_start(); # if we want a global associative array $_SESSION up and running, we have to include this line at the beginning of a file

#require_once "connect.php";


class Pracownik {
    // Properties
    public static $id;
    public static $imie;
    public static $nazwisko;
  
    // Methods
    function __construct()
    {
        $this->id=$_SESSION['id_pracownika'];
        $this->imie=$_SESSION['imie'];
        $this->nazwisko=$_SESSION['nazwisko'];
    }
    
    function naglowek() { //wyswietla naglowek z danymi zalogowanego pracownika oraz przycisk 'wyloguj'
        echo "<p>Jesteś zalogowany jako ".$this->imie." ".$this->nazwisko.'! 
        [<a href="gra.php" style="color:green">Dostępność</a>] 
        [<a href="delivery_order.php">Zamów dostawę</a>] [<a href="logout.php" style="color:#FF0000">Wyloguj!!</a>]</p>';
    }

    function order() {
echo<<<END
        <br/><br/>
        <h2>Sprawdź dostępność towaru:</h2>

        <form action="order.php" method="post"> <!--data from input will go to order.php -->
        Nazwa towaru:
        <input type="text" name="towar"/>
        <br/><br/>

        <input type="submit" value="Sprawdź!"/>
        </form>
END;
    }

    function sprawdzenie_towaru()
    {
        require_once "connect.php";
        $polaczenie = @new mysqli($host,$db_user,$db_password,$db_name); # symbol '@' mutes info about errors
        #^^^polaczenie is an object, mysqli is a constructor

        if($polaczenie->connect_errno != 0)
        {
            echo "Error: ".$polaczenie->connect_errno . "Description: ".$polaczenie->connect_error;
        }
        else
        {
            $nazwa_towaru = $_POST['towar'];

            $nazwa_towaru = htmlentities($nazwa_towaru, ENT_QUOTES, "UTF-8"); # encje HTML
            
            # $sql = "select * from uzytkownicy where user='$login' and pass='$haslo'";

            # $rezultat is an object
            if($rezultat = @$polaczenie->query(sprintf("select * from towary where Nazwa_towaru='%s'", 
            mysqli_real_escape_string($polaczenie,$nazwa_towaru),
            )))   # query is a method, if sql query is successful, $rezultat is true
            {
                $ile_towarow = $rezultat->num_rows; #num_rows = number of rows; query method returns rows from a table from db
                if($ile_towarow > 0)
                {

                    $wiersz = $rezultat->fetch_assoc(); # fetch_assoc() returns an associative array
                    $this->podsumowanie($nazwa_towaru,$wiersz['Ilosc']);
                    #$_SESSION['id_pracownika'] = $wiersz['id_pracownika'];
                    #$_SESSION['imie'] = $wiersz['imie']; # $_SESSION is a global associative array which enables exchanging variables across different .php files
                    #$_SESSION['nazwisko'] = $wiersz['nazwisko'];
                    

                    unset($_SESSION['blad']); # unset == destroy
                    $rezultat->free_result();
                }
                else
                {
                    echo '<h2>Podsumowanie</h2>';
                    echo '<span style="color:red">Nie ma takiego towaru w bazie!</span>';
                    echo '<br/><br/><a href="index.php">Ponownie sprawdź dostępność towaru</a>';
                    
                }
            }  
            $polaczenie->close();
        }
    }

    function podsumowanie($nazwa_towaru, $ilosc)
    {
echo<<<END
            <h2>Podsumowanie</h2>
            <table>
            <tr>
              <th>Towar</th>
              <th>Ilość</th>
            </tr>
            <tr>
              <td>$nazwa_towaru</td>
              <td>$ilosc</td>
            </tr>
          </table> 
            <br/>
            

            <br/><a href="index.php">Ponownie sprawdź dostępność towaru</a>
END;
    }

    function zamowienie_dostawy_textbox()
    {
        require_once "connect.php";
        $polaczenie = @new mysqli($host,$db_user,$db_password,$db_name); # symbol '@' mutes info about errors
        #^^^polaczenie is an object, mysqli is a constructor

        if($polaczenie->connect_errno != 0)
        {
            echo "Error: ".$polaczenie->connect_errno . "Description: ".$polaczenie->connect_error;
        }
        else
        {
            echo<<<END
            <br/><br/>
            <h2>Wprowadź towar i ilość:</h2>

            <form method="post"> <!--data from input will go to order.php -->
            Nazwa towaru:
            <input type="text" id='towary' name='towary[]'/>
            <br/><br/>
            Ilość:
            <input type="text" id="ilosc" name="ilosc[]" />
            <br/><br/>

            <input type="submit" value="Sprawdź!"/>
            </form>
            END;

            $nazwa_towaru = $_POST['towary'];

            $nazwa_towaru = htmlentities($nazwa_towaru, ENT_QUOTES, "UTF-8"); # encje HTML
            
            # $sql = "select * from uzytkownicy where user='$login' and pass='$haslo'";

            # $rezultat is an object
            if($rezultat = @$polaczenie->query(sprintf("select * from towary where Nazwa_towaru='%s'", 
            mysqli_real_escape_string($polaczenie,$nazwa_towaru),
            )))   # query is a method, if sql query is successful, $rezultat is true
            {
                $ile_towarow = $rezultat->num_rows; #num_rows = number of rows; query method returns rows from a table from db
                if($ile_towarow > 0)
                {

                    $wiersz = $rezultat->fetch_assoc(); # fetch_assoc() returns an associative array
                    echo '<span style="color:green">Prawidłowa nazwa towaru! Dodano do zamówienia!</span>';
                    #$this->podsumowanie($nazwa_towaru,$wiersz['Ilosc']);
                    #$_SESSION['id_pracownika'] = $wiersz['id_pracownika'];
                    #$_SESSION['imie'] = $wiersz['imie']; # $_SESSION is a global associative array which enables exchanging variables across different .php files
                    #$_SESSION['nazwisko'] = $wiersz['nazwisko'];
                    

                    unset($_SESSION['blad']); # unset == destroy
                    $rezultat->free_result();
                }
                else
                {
                    #echo '<h2>Podsumowanie</h2>';
                    echo '<span style="color:red">Nie ma takiego towaru w bazie!</span>';
                    
                    
                }
            }  
            $polaczenie->close();
        }
    }

    function zamowienie_dostawy()
    {
        require_once "connect.php";
        
        $mysqli = mysqli_connect($host,$db_user,$db_password,$db_name);
        $sql = "SELECT ID_towaru, Nazwa_towaru FROM towary WHERE Ilosc < 20";       
        $rez = mysqli_query($mysqli, $sql); 
     
        print '<br/><h3>Zamawianie dostawy</h3><br/>poniżej lista towarów, których ilość jest mniejsza od 20 <br/> <form method="POST">';
        while ($row = mysqli_fetch_array($rez))
        {
            print "<input type='checkbox' id='towary' name='towary[]' value='$row[Nazwa_towaru]' />$row[ID_towaru]: $row[Nazwa_towaru] ";
            print ' <br> Ilość: <input type="text" id="ilosc" name="ilosc[]" /><br><br>';
        }
        print '<br><br><input style="margin-left: 25%;" type="submit" name="save" value="Złóż zamówienie na dostawę"/>';
        print '</form>';
     
        if (isset($_POST['towary'])){
            /*
          $towary_arr = implode(',', $_POST['towary']);
          $towary_il = implode(',', $_POST['ilosc']);
          echo $towary_arr;
          echo "<br/>";
          echo $towary_il;
          */
          echo "<h5>Podsumowanie złożonego zamówienia</h5>";
          for ($x = 0; $x < count($_POST['towary']); $x++) {
            echo $_POST['towary'][$x].":  ";
            echo $_POST['ilosc'][$x]."<br>";
          }     
        }
          
        
     ////////////////////////////////////
        #$this->zamowienie_dostawy_textbox();
     ////////////////////////////////////


        mysqli_free_result($rez);
    }

    
    
  }

?>