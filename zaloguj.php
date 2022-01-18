<?php

session_start(); # if we want a global associative array $_SESSION up and running, we have to include this line at the beginning of a file

if(!isset($_POST['login']) || !isset($_POST['haslo']))
{
    header('Location: index.php');
    exit();
}

require_once "connect.php";

$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name); # symbol '@' mutes info about errors
#^^^polaczenie is an object, mysqli is a constructor

if($polaczenie->connect_errno != 0)
{
    echo "Error: ".$polaczenie->connect_errno . "Description: ".$polaczenie->connect_error;
}
else
{
    $login = $_POST['login'];
    $haslo = $_POST['haslo'];

    $login = htmlentities($login, ENT_QUOTES, "UTF-8"); # encje HTML
    $haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8");


    # $sql = "select * from uzytkownicy where user='$login' and pass='$haslo'";

    # $rezultat is an object
    if($rezultat = @$polaczenie->query(sprintf("select * from pracownicy where login='%s' and haslo='%s'", 
    mysqli_real_escape_string($polaczenie,$login),
    mysqli_real_escape_string($polaczenie,$haslo))))   # query is a method, if sql query is successful, $rezultat is true
    {
        $ilu_userow = $rezultat->num_rows; #num_rows = number of rows; query method returns rows from a table from db
        if($ilu_userow > 0)
        {
            $_SESSION['zalogowany'] = true;

            $wiersz = $rezultat->fetch_assoc(); # fetch_assoc() returns an associative array
            $_SESSION['id_pracownika'] = $wiersz['id_pracownika'];
            $_SESSION['imie'] = $wiersz['imie']; # $_SESSION is a global associative array which enables exchanging variables across different .php files
            $_SESSION['nazwisko'] = $wiersz['nazwisko'];
            

            unset($_SESSION['blad']); # unset == destroy
            $rezultat->free_result();
            header('Location: gra.php');
        }
        else
        {
            $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
            header('Location: index.php'); # we come back here to homepage
        }
    }
    $polaczenie->close();
}

?>